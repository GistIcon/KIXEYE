<?php

	require( '../Settings.php' );
	require( '../Autoloader.php' );
	require( '../ExceptionHandler.php' );
	
	$response = new stdClass();
	$response->errorCode = '0';
	
	$facebook_signed_request = new FacebookSignedRequest( $_REQUEST['signed_request'] );
	
	if ( !$facebook_signed_request->isValid() ) { // is it even necessary to check facebook signed request validity since we are signing the request as a whole ourselves?
		$response->errorCode = '1';
		$response->errorString = 'Invalid Facebook signed request.';
	} else {
		if ( !$facebook_signed_request->isSignedIn() ) {
			$response->errorCode = '2';
			$response->errorString = 'User not signed in.';
		} else {
			$data_store = new DataStore( PDO_CONNECTION_SETTINGS, PDO_USER_NAME, PDO_PASSWORD );
			$user = new User( $facebook_signed_request->userID(), $data_store );
			// operation determined by request method and available parameters
			if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
				if ( isset( $_REQUEST['score'] ) ) {
					// check secondary signature to prevent cheating
					// should probably copy $_REQUEST, remove signature, then concat sorted by keys to uniformly generate the signed request payload
					$signed_request = new SignedRequest( $_REQUEST['signature'], $_REQUEST['signed_request'] . $_REQUEST['score'] );
					if ( $signed_request->isValid() ) {
						$user->addScore( $_REQUEST['score'] );
					} else {
						$response->errorCode = '5';
						$response->errorString = 'Invalid signed request.';
					}
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