<!doctype html>
<html lang="en">
<?php
include_once('dvrgoals.php');
?>
<head>

	<meta charset="utf-8" />
	<title>DVR Goals - no scores, just the goals</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<!-- Bootstrap styles loaded first so don't override 1140 grid -->
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" media="screen" />

	<!-- 1140px Grid styles for IE -->
	<!--[if lte IE 9]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" /><![endif]-->

	<!-- The 1140px Grid - http://cssgrid.net/ -->
	<link rel="stylesheet" href="css/1140.css" type="text/css" media="screen" />
	
	<!-- DVR Goals styles -->
    <link rel="stylesheet" href="css/dvrgoals.css" type="text/css" media="screen" />

</head>

<body>

<div class="container padded5">
	<div class="row center border-bottom">
		<h1>- DVR Goals -</h1>
		<p class="good">This site answers the simple question, "Were there goals scored in this match?"</p>
		<p class="good">We don't give away the score but clicking on YES will tell you how many total goals were scored in the match.</p>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="onecol"></div>
		<div class="tencol center">
			<?php 
				$data = DVRGoals::getData(); 
				$gamecount = 1;
				foreach ($data as $origin => $games) {
					foreach ($games as $game) { 
						$goals = $game['home']['score'] + $game['away']['score'];
						?>
						<div class="game">
							<table class="gameTable">
								<tr>
									<td colspan="2" class="gameStatus">
										<?php echo $game['status'];  if ($game['status'] == 'Upcoming') { echo " - " . $game['date']; } ?>
									</td>
								</tr>
								<tr>
									<td class="gameTeams">
										<span class="gameTeam"><?php echo $game['home']['name']; ?></span>
										<span class="vs">vs.</span>
										<span class="gameTeam"><?php echo $game['away']['name']; ?></span>
									</td>
									<td class="gameScores <?php echo ($goals > 0) ? 'statusPass' : 'statusFail'; ?>">
										<a class="gameScore" data-id="<?php echo $gamecount; ?>"><span class="full100"><?php echo ($goals > 0) ? "YES" : "NO"; ?></span></a>
										<a class="gameGoals" data-id="<?php echo $gamecount; ?>"><span class="full100">Goals: <?php echo $goals; ?></span></a>
									</td>
								</tr>
							</table>
						</div>
				<?php $gamecount++;
					}
				} ?>
		</div>
		<div class="onecol last"></div>
	</div>
</div>

<!-- Load javascripts after page has loaded -->

<!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
<script type="text/javascript" src="js/css3-mediaqueries.js"></script>

<!-- JQuery 1.8.2 minified -->
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>

<!-- Twitter Bootstrap -->
<script type="text/javascript" src="js/bootstrap.js"></script>

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