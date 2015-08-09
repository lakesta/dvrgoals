<?php
class DVRGoals {
	public static function getData() {
		$urls = array(
			'euro' => 'http://espnfc.com/bottomline/scores/scores?scoresSource=euro',
			'uk' => 'http://espnfc.com/bottomline/scores/scores?scoresSource=uk',
		);

		$results = array();
		foreach ($urls as $origin => $url) {
			$results[] = DVRGoals::customGet($url);
		}
		
		$data = array();
		foreach ($results as $result) {
			$data[] = DVRGoals::parseResult($result);
		}

		return $data;

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
					'header' => "User-Agent: " . "RESTClient" . "\r\n"
				)
			);
			$context = stream_context_create($opts);
			$fp = fopen($url, 'r', false, $context);
			$result = fpassthru($fp);
			fclose($fp);
		}
		return $result;
	}// end function customURL


	public static function parseResult($result) {
		$rawscores = array();
		$games = array();

		parse_str($result, $rawscores);
		
		foreach ($rawscores as $k => $v) {
			if (preg_match('/_s_left(\d+)/', $k, $matches) ) {
				
				$team1 = array('name' => '', 'score' => 0, 'found' => false);
				$team2 = array('name' => '', 'score' => 0, 'found' => false);
				$status = '';

				/*
string 'Deportivo La Coru&#241;a v Barcelona (4:00 PM ET)' (length=49)
 */

				$v_array = explode(" ", $v);
				foreach ($v_array as $x) {
					if ($x == '-') {
						continue;
					}

					if ($x == 'v'){
						$team1['found'] = true;
						continue;
					}

					if (strpos($x, '(') !== false) {
						$team2['found'] = true;
						$x = preg_replace('~\(~', '', $x);
						$x = preg_replace('~\)~', '', $x);
						$status = $x;
						continue;
					}

					if ($team1['found'] && $team2['found']) {
						$x = preg_replace('~\(~', '', $x);
						$x = preg_replace('~\)~', '', $x);
						$status .= ' ' . $x;
						continue;
					}

					if (!is_numeric($x)){
						if (!$team1['found']){
							if ($team1['name'] != '') {
								$team1['name'] .= ' ' . $x;
							} else {
								$team1['name'] = $x;
							}
						} else {
							if ($team2['name'] != '') {
								$team2['name'] .= ' ' . $x;
							} else {
								$team2['name'] = $x;
							}
						}
					} else {
						if (!$team1['found']){
							$team1['score'] = (int)$x;
							$team1['found'] = true;
						} else {
							$team2['score'] = (int)$x;
							$team1['found'] = true;
						}
					}
				}

				$games[] = array('home' => $team1, 'away' => $team2, 'status' => $status);

			}
		}

		return $games;
	}
}
