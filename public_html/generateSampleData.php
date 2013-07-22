<?php

	require( '../Settings.php' );
	require( '../Autoloader.php' );
	require( '../ExceptionHandler.php' );
	
	echo 'Building sample data.<br />';
	
	$data_store = new DataStore( PDO_CONNECTION_SETTINGS, PDO_USER_NAME, PDO_PASSWORD );
	$sample_data_generator = new SampleDataGenerator( $data_store );
	$sample_data_generator->clearAllData();
	$sample_data_generator->generateOneMillionRecords();
	
	echo 'Finished.';
?>