<!doctype html>
<html lang="en">
<?php
include_once('dvrgoals.php');
$data = DVRGoals::getData(); 
$gamecount = 0;
$output = array();
foreach ($data as $origin => $games) {
	foreach ($games as $game) {
		$game['goals'] = $game['home']['score'] + $game['away']['score'];
		$game['id'] = $gamecount;
		if ($game['status'] == 'Upcoming') {
			$output['upcoming'][] = $game;
		} else {
			if ($game['goals'] == 0) {
				$output['nogoals'][] = $game;
			} else {
				$output['goals'][] = $game;
			}
		}
		$gamecount++;
	}
}
?>
<head>

	<meta charset="utf-8" />
	<title>DVR Goals - no scores, just the goals</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<!-- Bootstrap styles -->
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="screen" />

	<!-- DVR Goals styles -->
    <link rel="stylesheet" href="css/dvrgoals.css" type="text/css" media="screen" />

</head>

<body>
<div class="container padded5">
	<div class="row center">
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#" style="padding-top: 0px; padding-bottom: 0px;" id="logo"><img src="img/dvrgoals_logo.png" style="width: 48px; height: 48px;"></a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li><a href="#goals" class="link" data-link="goals">Goals</a></li>
		        <li><a href="#nogoals" class="link" data-link="nogoals">No Goals</a></li>
		        <li><a href="#upcoming" class="link" data-link="upcoming">Upcoming</a></li>
		      </ul>
		      <!--
		      <form class="navbar-form navbar-right" role="search">
		        <div class="form-group">
		          <input type="text" class="form-control filterContent" placeholder="Search" data-element="tr" name="display">
		        </div>
		      </form>
		      -->
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-12 center">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- DVRGoals Ad Campaign -->
			<ins class="adsbygoogle"
			     style="display:block"
			     data-ad-client="ca-pub-2382003441171908"
			     data-ad-slot="5326318277"
			     data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-12 well" id="display">
			<table class="table table-striped" id="goals">
				<caption>Games with goals scored</caption>
				<?php if (!empty($output['goals'])) { ?>
				<thead>
					<tr>
						<th>Status</th>
						<th>Home</th>
						<th>Away</th>
						<th>Goals</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($output['goals'] as $g) { ?>
					<tr>
						<td><?php echo $g['status']; ?></td>
						<td><?php echo $g['home']['name']; ?></td>
						<td><?php echo $g['away']['name']; ?></td>
						<td><span class="click" data-id="<?php echo $g['id']; ?>">click</span><span class="goals" data-id="<?php echo $g['id']; ?>"><?php echo $g['goals']; ?></span></td>
					</tr>
				<?php } ?>
				</tbody>
				<?php } else { ?>
				<tbody>
					<tr>
						<td>No games available</td>
					</tr>
				</tbody>
				<?php } ?>
			</table>
			<table class="table table-striped" id="nogoals">
				<caption>Games with no goals scored</caption>
				<?php if (!empty($output['nogoals'])) { ?>
				<thead>
					<tr>
						<th>Status</th>
						<th>Home</th>
						<th>Away</th>
						<th>Goals</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($output['nogoals'] as $g) { ?>
					<tr>
						<td><?php echo $g['status']; ?></td>
						<td><?php echo $g['home']['name']; ?></td>
						<td><?php echo $g['away']['name']; ?></td>
						<td>Bore draw</td>
					</tr>
				<?php } ?>
				</tbody>
				<?php } else { ?>
				<tbody>
					<tr>
						<td>No games available</td>
					</tr>
				</tbody>
				<?php } ?>
			</table>
			<table class="table table-striped" id="upcoming">
				<caption>Upcoming Games</caption>
				<?php if (!empty($output['upcoming'])) { ?>
				<thead>
					<tr>
						<th>Team 1</th>
						<th>Team 2</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($output['upcoming'] as $g) { ?>
					<tr>
						<td><?php echo $g['home']['name']; ?></td>
						<td><?php echo $g['away']['name']; ?></td>
						<td><?php echo $g['date']; ?></td>
					</tr>
				<?php } ?>
				</tbody>
				<?php } else { ?>
				<tbody>
					<tr>
						<td>No games available</td>
					</tr>
				</tbody>
				<?php } ?>
			</table>
		</div>
	</div>
</div>

<!-- Load javascripts after page has loaded -->

<!-- JQuery 2.2.0 minified -->
<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>

<!-- Twitter Bootstrap 3 -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<!-- DVR Goals -->
<script type="text/javascript" src="js/dvrgoals.js"></script>

<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43959921-5', 'auto');
  ga('send', 'pageview');

</script>
</body>

</html>