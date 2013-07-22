<?php

	/* application settings */
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', true); // currently set for debugging
	date_default_timezone_set('America/Los_Angeles');
	set_include_path('../classes/');
	
	/* applictaion constants */
	// db
	define( 'PDO_CONNECTION_SETTINGS', 'mysql:host=localhost;dbname=spotless_kixeye' );
	define( 'PDO_USER_NAME', 'spotless_spot' );
	define( 'PDO_PASSWORD', 'ghW8@1hT' );
	// fb
	define( 'FB_APP_ID', '126767144061773' );
	define( 'FB_APP_SECRET', '21db65a65e204cca7b5afcbad91fea59' );
	// REST
	define( 'APP_SECRET', '21db65a65e204cca7b5afcbad91fea59' );
	
?>