<?php
	namespace Cryptonat;

	interface HandlerInterface {
		/**
			* Install Utopia Client Handler

			* @param UtopiaLib\Client $client - client handler object
			* @return void
		*/
		public function setUtopiaClient($client = null);
		
		/**
			* Check the status of an activated or created voucher

			* @param string $referenceNumber - financial event link id
			* @return array - voucher information
		*/
		public function checkVoucherStatus($referenceNumber = ''): array;
		
		/**
			* Find out the amount of a created or activated voucher

			* @param string $referenceNumber - financial event link id
			* @return float - voucher amount
		*/
		public function getVoucherAmount($referenceNumber = ''): float;
		
		/**
			* Create a voucher and get status information

			* @param float $amount - voucher amount
			* @return array - voucher information
		*/
		public function createVoucher($amount = 1): array;
		
		/**
			* Find out the amount of commission for creating a voucher

			* @param float $voucher_amount - voucher amount
			* @return float - amount of commission for creating a voucher
		*/
		public function getNetFee($voucher_amount = 1): float;
		
		/**
			* transfer of a voucher activation request to a Utopia client

			* @param string $voucher_code - utopia voucher code (string)
			* @throws InvalidArgumentException
			* @return the status of the request ("done", "pending", "error")
		*/
		public function activateVoucher($voucher_code): array;
	}
	