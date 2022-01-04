# Utopia Cryptonat

Crypton Donation Library (Utopia Ecosystem)

## Installation with Composer

```bash
composer require sagleft/utopia-cryptonat
```

Usage
-------

An instance of the Cryptonat\Handler object is created based on [UtopiaLib\Client](https://github.com/Sagleft/utopialib-php):

```php
$cryptonat = new Cryptonat\Handler($client);
```

or

```php
$cryptonat = new Cryptonat\Handler();
$cryptonat->setUtopiaClient($client);
```

Then try activating the voucher:

```php
$voucher_code = 'UTP-P3FH-OJQZ-7XWI-CAVT-LYDW';
$result = $cryptonat->activateVoucher($voucher_code);
echo json_encode($result);
```

response example:

```json
{
	"status": "pending",
	"referenceNumber": "367404A95932624C284B16AF1C1EDF1BB0F9CDCA1CC5136B167378BBF933FAD8",
	"amount": 0
}
```

check voucher status by reference number:

``
$referenceNumber = '367404A95932624C284B16AF1C1EDF1BB0F9CDCA1CC5136B167378BBF933FAD8';
$result = $cryptonat->checkVoucherStatus($referenceNumber);
echo json_encode($result);
``

response example:

```json
{
	"status": "done",
	"created": "2020-01-14T13:18:21.232",
	"amount": 2,
	"comments": "",
	"direction": 1,
	"trid": "0ZWTT62Z4DO51"
}
```

![scheme](https://github.com/Sagleft/utopia-cryptonat/raw/master/img/voucher_activation.png)

License
-------

Utopia Cryptonat is licensed under [The MIT License](LICENSE).

---

![image](https://github.com/Sagleft/Sagleft/raw/master/image.png)

### :globe_with_meridians: [Telegram канал](https://t.me/+VIvd8j6xvm9iMzhi)
