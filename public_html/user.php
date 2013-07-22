<?php

	require( '../Settings.php' );
	require( '../Autoloader.php' );
	require( '../ExceptionHandler.php' );
	
	$response = new stdClass();
	$response->errorCode = '0';
	
	$signed_request = new SignedRequest( $_REQUEST['signed_request'] );
	
	if ( !$signed_request->isValid() ) {
		$response->errorCode = '1';
		$response->errorString = 'Invalid signed request.';
	} else {
		if ( !$signed_request->isSignedIn() ) {
			$response->errorCode = '2';
			$response->errorString = 'User not signed in.';
		} else {
			$data_store = new DataStore( PDO_CONNECTION_SETTINGS, PDO_USER_NAME, PDO_PASSWORD );
			$user = new User( $signed_request->userID(), $data_store );
			// operation determined by request method and available parameters
			if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
				if ( isset( $_REQUEST['score'] ) ) {
					$user->addScore( $_REQUEST['score'] );
				} else {
					$response->errorCode = '3';
					$response->errorString = 'Invalid request structure.';
				}
			} else {
				$response->errorCode = '4';
				$response->errorString = 'Invalid request method.';
			}
		}
	}
	
	exit( json_encode( $response ) );
?>