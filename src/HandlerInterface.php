<?php
	namespace Cryptonat;

	interface HandlerInterface {
		/**
			* transfer of a voucher activation request to a Utopia client

			* @param string $voucher_code - utopia voucher code (string)
			* @throws InvalidArgumentException
			* @return the status of the request ("done", "pending", "error")
		*/
		public function activateVoucher($voucher_code): array;
	}
	