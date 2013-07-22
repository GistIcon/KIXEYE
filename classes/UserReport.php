<?php

	class UserReport {
		
		protected $dataStore;
		
		public function __construct( $data_store ) {
			$this->dataStore = $data_store;
		}
		
		public function summary() {
			$query = 'SELECT'
				.' COUNT( users.ID ) AS totalPlayers,'
				.' SUM( CASE WHEN users.lastPlayed = ? THEN 1 ELSE 0 END ) AS totalPlayedToday'
				.' FROM users'
				.' WHERE 1';
			return $this->dataStore->queryRowPrepared( $query, array( date( 'Y-m-d' ) ) );
		}
		
		public function topHighScores() {
			$query =  $this->dataStore->limitQuery( 'SELECT'
				.' users.facebookID,'
				.' MAX( userScores.score ) AS topScore'
				.' FROM users'
				.' LEFT JOIN userScores ON users.facebookID = userScores.userFacebookID'
				.' WHERE 1'
				.' GROUP BY users.facebookID'
				.' ORDER BY topScore DESC', 10 );
			return $this->dataStore->queryPrepared( $query, array() );
		}
		
		public function topImprovedScores() {
			$query = $this->dataStore->limitQuery( 'SELECT'
				.' users.facebookID,'
				.' MAX( CASE WHEN userScores.date BETWEEN ? AND ? THEN userScores.score ELSE 0 END ) AS thisWeeksTopScore,'
				.' MAX( CASE WHEN userScores.date BETWEEN ? AND ? THEN userScores.score ELSE 0 END ) AS lastWeeksTopScore,'
				.' MAX( CASE WHEN userScores.date BETWEEN ? AND ? THEN userScores.score ELSE 0 END ) - MAX( CASE WHEN userScores.date BETWEEN ? AND ? THEN userScores.score ELSE 0 END ) AS topScoreImprovement'
				.' FROM users'
				.' LEFT JOIN userScores ON users.facebookID = userScores.userFacebookID'
				.' WHERE 1'
				.' GROUP BY users.facebookID'
				.' ORDER BY topScoreImprovement DESC', 10 );
			$this_sunday = strtotime( 'This Sunday' );
			return $this->dataStore->queryPrepared( $query, array(
				date( 'Y-m-d', strtotime( '-1 week', $this_sunday ) ),
				date( 'Y-m-d', $this_sunday ),
				date( 'Y-m-d', strtotime( '-2 weeks', $this_sunday ) ),
				date( 'Y-m-d', strtotime( '-1 week', $this_sunday ) ),
				date( 'Y-m-d', strtotime( '-1 week', $this_sunday ) ),
				date( 'Y-m-d', $this_sunday ),
				date( 'Y-m-d', strtotime( '-2 weeks', $this_sunday ) ),
				date( 'Y-m-d', strtotime( '-1 week', $this_sunday ) )
			) );
		}
	}
?>