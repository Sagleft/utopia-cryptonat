<?php
	require_once __DIR__ . '/../vendor/autoload.php';

	$cryptonat = new Cryptonat\Handler();
	$status_success = $cryptonat->createTestClient();
	if(!$status_success) {
		exit($cryptonat->last_error);
	}

	$referenceNumber = getenv('reference_number');
	$result = $cryptonat->checkVoucherStatus($referenceNumber);
	echo json_encode($result);
