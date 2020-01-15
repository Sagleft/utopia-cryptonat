<?php
	require_once __DIR__ . '/../vendor/autoload.php';
	
	$cryptonat = new Cryptonat\Handler();
	$status_success = $cryptonat->createTestClient();
	if(!$status_success) {
		exit($cryptonat->last_error);
	}

	$voucher_amount = 0.1; //CRP
	$result = $cryptonat->createVoucher($voucher_amount);
	echo json_encode($result);
	