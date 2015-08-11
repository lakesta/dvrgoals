<?php
date_default_timezone_set('America/Chicago');

require 'vendor/autoload.php';
use GuzzleHttp\Client;

class DVRGoals {
	public static function getData() {
		$client = new Client();
		$urls = array(
			'yesterday' => 'http://api.football-data.org/alpha/fixtures?timeFrame=p1',
			'todayNtomorrow' => 'http://api.football-data.org/alpha/fixtures?timeFrame=n1'
		);

		$results = array();
		foreach ($urls as $origin => $url) {
			$header = array('headers' => array('X-Auth-Token' => 'd7acbdacc9fb44b992ea28ccb4fc2886'));
			$response = $client->get($url, $header);
			$results[] = json_decode($response->getBody());
		}
		
		$data = array();
		foreach ($results as $result) {
			$data[] = DVRGoals::parseResult($result);
		}

		return $data;

	}

	public static function parseResult($result) {
		$rawscores = array();
		$games = array();
		
		foreach ($result->fixtures as $k => $v) {

			$team1 = array(
				'name' => $v->homeTeamName,
				'score' => ($v->result->goalsHomeTeam >= 0) ? (int)$v->result->goalsHomeTeam : 0,
				'found' => true
			);

			$team2 = array(
				'name' => $v->awayTeamName,
				'score' => ($v->result->goalsAwayTeam >= 0) ? (int)$v->result->goalsAwayTeam : 0,
				'found' => true
			);

			$status = ($v->status == "TIMED") ? "Upcoming" : "Completed";

			$date = date("l, F jS, Y @ g:i A", strtotime($v->date));

			$games[] = array('home' => $team1, 'away' => $team2, 'status' => $status, 'date' => $date);
		}

		return $games;
	}

	// Return URL results via cURL or fopen
	public static function customGet($url) {
		$with_curl = false;
		if (function_exists("curl_init"))
			$with_curl = true;

		$result = "";

		if ($with_curl) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
			curl_setopt($curl, CURLOPT_USERAGENT, "RESTClient");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			$result = curl_exec($curl);
			
			$curl_info = curl_getinfo($curl);
			
			curl_close($curl);
		} else {
			$opts = array(
				'http' => array (
					'method' => 'GET', 
					'header' => "X-Auth-Token: d7acbdacc9fb44b992ea28ccb4fc2886",
				)
			);
			$context = stream_context_create($opts);
			$result = file_get_contents($url, false, $context);
		}

		return $result;
	}// end function customURL
}
