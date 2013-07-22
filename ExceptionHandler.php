<?php

	// uncaught exception handler
	set_exception_handler(function ($exception) {
		if (ini_get('display_errors') == true) {
			echo '<pre>';
			echo "<strong>Uncaught Exception</strong>\n";
			echo 'Message: ' . $exception->getMessage() . "\n";
			echo 'File: ' . $exception->getFile() . "\n";
			echo 'Line: ' . $exception->getLine() . "\n";
			echo "Trace:\n";
			echo $exception->getTraceAsString();
			echo '</pre>';
		}
		exit;
	});
?>