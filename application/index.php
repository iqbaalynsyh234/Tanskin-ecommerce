<?php

/**
 * InvoiceExample.php
 * php version 7.2.0
 *
 * @category Example
 * @package  Xendit/Examples
 * @author   Hendry <hendry@xendit.co>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://api.xendit.co
 */

use Xendit\Xendit;

require "vendor/autoload.php";

Xendit::setApiKey("xnd_production_0fe7ZApI47qHxBMYkQZq8r8sGISgzCFhjdInJ3Vma9ZMfgG4vMTA2lNArdWM3");

$params = [
    "external_id" => "demo_147580196270",
    "payer_email" => "sample_email@xendit.co",
    "description" => "Tanskin Toner",
    "amount" => 7000,
];

$createInvoice = \Xendit\Invoice::create($params);
print_r($createInvoice);

$id = $createInvoice["id"];

$getInvoice = \Xendit\Invoice::retrieve($id);
print_r($getInvoice);
