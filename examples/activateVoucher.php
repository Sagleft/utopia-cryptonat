<?php
	require_once __DIR__ . '/../vendor/autoload.php';

	$cryptonat = new Cryptonat\Handler();
	//or use: new Cryptonat\Handler($client);
	$status_success = $cryptonat->createTestClient();
	if(!$status_success) {
		exit($cryptonat->last_error);
	}

	$voucher_code = getenv('voucher_code');
	$result = $cryptonat->activateVoucher($voucher_code);
	echo json_encode($result);
