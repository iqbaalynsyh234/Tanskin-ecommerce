<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '../libraries/xendit-php/autoload.php';

use Xendit\Xendit;

class InvoiceController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Set your Xendit API key
        Xendit::setApiKey(''); // Replace with your Xendit API key
    }

    public function index()
    {
        $this->load->view('checkout/payment-method');
    }

    // Add your invoice generation and URL construction logic here

    public function generateInvoice() {
        // Retrieve the invoice data from your database or other sources
        $externalId = '233341'; // Replace with your own external ID for the invoice
        $amount = 100000; // Replace with the invoice amount in the smallest currency unit
        $payerEmail = 'customer@example.com'; // Replace with the customer's email address
        $description = 'Invoice Payment'; // Replace with a description of the invoice
    
        try {
            // Create the invoice using the Xendit API
            $invoice = \Xendit\Invoice::create([
                'external_id' => $externalId,
                'amount' => $amount,
                'payer_email' => $payerEmail,
                'description' => $description,
            ]);
    
            // Retrieve the invoice ID from the response
            $invoiceId = $invoice['id'];
    
            // Construct the Xendit invoice URL
            $invoiceUrl = "https://checkout.xendit.co/web/invoice?invoice_id=$invoiceId";
    
            // Redirect the user to the Xendit invoice URL
            redirect($invoiceUrl);
        } catch (\Xendit\Exceptions\ApiException $e) {
            // Handle API error
            echo 'Error: ' . $e->getMessage();
        } catch (\Xendit\Exceptions\XenditException $e) {
            // Handle Xendit-specific error
            echo 'Error: ' . $e->getMessage();
        } catch (Exception $e) {
            // Handle other errors
            echo 'Error: ' . $e->getMessage();
        }
    }

}
