<?php
	namespace Cryptonat;

	class Handler implements HandlerInterface {
		//string
		public $last_error = '';
		//UtopiaLib\Client object
		protected $client = null;
		protected $default_voucherData = [
			'status'    => 'pending',
			'created'   => '',
			'amount'    => 0,
			'comments'  => '',
			'direction' => 1,
			'trid'      => '',
			'error'     => ''
		];
		protected $default_activationData = [
			'status'          => 'pending',
			'referenceNumber' => '',
			'amount'          => 0
		];
		
		public function __construct($fromUtopiaClient = null) {
			if($fromUtopiaClient != null) {
				$this->setUtopiaClient($fromUtopiaClient);
			}
		}
		
		public function setUtopiaClient($client = null) {
			//TODO: check type_of UtopiaLib\Client
			$this->client = &$client;
		}
		
		public function activateVoucher($voucher_code = ''): array {
			//TODO: error status
			//TODO: throw error
			//TODO: check voucher code format
			$referenceNumber = $this->client->useVoucher($voucher_code);
			$voucher_data = $this->checkVoucherStatus($referenceNumber);
			
			//TODO: make the code beautiful
			$activation_data = $this->default_activationData;
			$activation_data['status'] = $voucher_data['status'];
			$activation_data['amount'] = $voucher_data['amount'];
			$activation_data['referenceNumber'] = $referenceNumber;
			return $activation_data;
		}
		
		public function checkVoucherStatus($referenceNumber = ''): array {
			$voucher_data = $this->default_voucherData;
			
			$result = $this->client->getFinanceHistory('ALL_VOUCHERS', $referenceNumber);
			if($result == []) {
				$voucher_data['status'] = 'rejected';
				return $voucher_data;
			}
			
			$voucher_findata = $result[0];
			$voucher_data['created']   = $voucher_findata['created'];
			$voucher_data['amount']    = $voucher_findata['amount'];
			$voucher_data['comments']  = $voucher_findata['comments'];
			$voucher_data['direction'] = $voucher_findata['direction'];
			$voucher_data['trid']      = $voucher_findata['id'];
			
			if($voucher_findata['state'] == -1 || $voucher_findata['state'] == '-1') {
				$voucher_data['status'] = 'pending';
				return $voucher_data;
			}
			
			if($voucher_findata['state'] == 0 || $voucher_findata['state'] == '0') {
				$voucher_data['status'] = 'done';
			}
			return $voucher_data;
		}
		
		public function getVoucherAmount($referenceNumber = ''): float {
			$result = $this->client->getFinanceHistory('ALL_VOUCHERS', $referenceNumber);
			if($result == []) {
				return 0;
			}
			$voucher_findata = $result[0];
			return $voucher_findata['amount'];
		}
		
		public function createTestClient(): bool {
			$dotenv = \Dotenv\Dotenv::create(__DIR__ . "/../examples/");
			$dotenv->load();
			
			$this->client = new \UtopiaLib\Client(
				getenv('client_token'),
				getenv('client_host'),
				getenv('client_port')
			);
			if(! $this->client->checkClientConnection()) {
				$this->last_error = 'Failed to connect to Utopia client using test data';
				return false;
			} else {
				return true;
			}
		}
		
		public function createVoucher($amount = 1): array {
			$status_data = $this->default_activationData;
			
			//check balance
			$client_balance = $this->client->getBalance();
			if($amount > $client_balance) {
				$status_data['status'] = 'error';
				$status_data['error'] = 'Not enough balance to create a voucher';
				return $status_data;
			}
			
			//create voucher
			$status_data['referenceNumber'] = $this->client->createVoucher($amount);
			if($status_data['referenceNumber'] == '') {
				//check errors
				$status_data['status'] = 'error';
				$status_data['error'] = $this->client->error;
			}
			return $status_data;
		}
		
		public function getNetFee($voucher_amount) {
			//TODO: take data from the client?
			return $voucher_amount * 0.0015;
		}
	}
	