<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Xendit\Xendit;

class VirtualAccount extends CI_Controller{

    public function index()
    {
        $this->load->view('checkout_snap');
    }

    public function pembayaran()
    {
        $paymenth = $this->input->post("paymeth");
        $bankCode = $this->input->post("bank_code");
        $name = $this->input->post("name");

        Xendit::setApiKey("xnd_production_0fe7ZApI47qHxBMYkQZq8r8sGISgzCFhjdInJ3Vma9ZMfgG4vMTA2lNArdWM3");

        $params = [
            "external_id" => $extId,
            "bank_code" => $bankCode,
            "name" => $name
        ];

        $createVA = \Xendit\VirtualAccounts::create($params);
        var_dump($createVA);
    }
}