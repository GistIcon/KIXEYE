<?php

	require( '../Settings.php' );
	require( '../Autoloader.php' );
	require( '../ExceptionHandler.php' );
	
	$data_store = new DataStore( PDO_CONNECTION_SETTINGS, PDO_USER_NAME, PDO_PASSWORD );
	$user_report = new UserReport( $data_store );
	
	$summaryRecord = $user_report->summary();
	$topHighScores = $user_report->topHighScores();
	$topImprovedScores = $user_report->topImprovedScores();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body>
		<h1>User Report</h1>
		
		<h3>Summary</h3>
		<p>
			Total Players: <?= number_format( $summaryRecord['totalPlayers'] ) ?><br />
			Total Played Today: <?= number_format( $summaryRecord['totalPlayedToday'] ) ?>
		</p>
		<h3>Top Ten High Scores</h3>
		<table>
			<thead>
				<tr>
					<th>Facebook ID</th>
					<th>Top Score</th>
				<tr>
			</thead>
			<tbody>
				<? while ( $row = $topHighScores->fetch() ) : ?>
					<tr>
						<th><?= $row['facebookID'] ?></th>
						<th><?= number_format( $row['topScore'] ) ?></th>
					</tr>
				<? endwhile ?>
			</tbody>
		</table>
		<h3>Top Ten Improved Players</h3>
		<table>
			<thead>
				<tr>
					<th>Facebook ID</th>
					<th>This Week's Top Score</th>
					<th>Last Week's Top Score</th>
					<th>Top Score Improvement</th>
				<tr>
			</thead>
			<tbody>
				<? while ( $row = $topImprovedScores->fetch() ) : ?>
					<tr>
						<th><?= $row['facebookID'] ?></th>
						<th><?= number_format( $row['thisWeeksTopScore'] ) ?></th>
						<th><?= number_format( $row['lastWeeksTopScore'] ) ?></th>
						<th><?= number_format( $row['topScoreImprovement'] ) ?></th>
					</tr>
				<? endwhile ?>
			</tbody>
		</table>
	</body>
</html>