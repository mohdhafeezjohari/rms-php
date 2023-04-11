# rms-php

Run this command to install the library

```
composer require rms/apiclient
```

## Basic Usage

Create payment form

```php
<?php

require_once 'vendor/autoload.php';

use RMS\ApiClient;

$ApiClient = new ApiClient();
$ApiClient->setMerchantId("xxx");
$ApiClient->setAmount("1.10");
$ApiClient->setCurrency("MYR");
$ApiClient->setVerifyKey("xxx");
$ApiClient->setOrderId("DEMO12345");
$ApiClient->setBillName("xxx");
$ApiClient->setBillEmail("xxx@DOMAIN.COM");
$ApiClient->setBillMobile("0149998765");
$ApiClient->setBillDesc("xxx");
$ApiClient->setReturnUrl("xxx");
$ApiClient->setCallbackUrl("xxx");
$ApiClient->setEnvironment("SANDBOX"); //optional for sandbox
$ApiClient->configureVcode();

$paymentform = $ApiClient->paymentViaHostedPage("PAYNOW"); //PAYNOW is value at payment button
echo $paymentform;

```
