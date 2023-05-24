<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Snap extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    //setting_value('xendit server key')
	public function __construct()
    {
        parent::__construct();
		$this->load->library(array('xendit','session','cart'));
		$this->xendit->config($params);
		$this->apiKey = $apiKey;
		$this->load->helper('form','url','function');
		$this->load->model(array('checkout/m_checkout'));	
    }

	public function makeRequest($url, $data)
    {
        $ch = curl_init();
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->apiKey . ':')
        );
        
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data)
        );
        
        curl_setopt_array($ch, $options);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        // You can handle the response and HTTP status code here according to your application's logic
        // For example:
        if ($httpCode === 200) {
            // Successful request
            return json_decode($response, true);
        } else {
            // Error handling
            return false;
        }
    }

  
    public function token()
    {
		date_default_timezone_set('Asia/Jakarta');
		$ses_pembelian = $this->session->userdata();
		// Required
		$transaction_details = array(
		  'order_id' => time(),
		  'gross_amount' => $ses_pembelian['midtrans_subtotal'], // no decimal allowed for creditcard
		);

		$item1_details = array();
		foreach ($this->cart->contents() as $items){
			$item1_details[] = array(
				'id'       => $items['id_map'],
				'price'    => $items['price'],
				'quantity' => $items['qty'],
				'name'     =>  substr($items['name'], 0, 20).'...'
			);
		}

			$item1_details[] = array(
				'id'       => 'D1',
				'price'    => $ses_pembelian['midtrans_kodepembayaran'],
				'quantity' => 1,
				'name'     => "Kode Pembayaran"
			);

			$item1_details[] = array(
				'id'       => 'D2',
				'price'    => $ses_pembelian['midtrans_cost'],
				'quantity' => 1,
				'name'     => "Pengiriman"
			);

			if($this->session->has_userdata('potongan_belanja')){
				$item1_details[] = array(
					'id'       => 'D3',
					'price'    => -$ses_pembelian['midtrans_disc'],
					'quantity' => 1,
					'name'     => "Voucher (".$this->session->userdata('voucher').")"
				);
			}

		// Optional
		$item_details = $item1_details;
		$billing_area  = $this->m_checkout->get_address($ses_pembelian['cBillArea'])->row_array();

		// Optional
		$billing_address = array(
		  'first_name'    => $ses_pembelian['cBillName'],
		  'last_name'     => " ",
		  'address'       => $ses_pembelian['cBillAddress'],
		  'city'          => ucwords(strtolower($billing_area['kabupaten'])),
		  'postal_code'   => $ses_pembelian['cBillPostcode'],
		  'phone'         => $ses_pembelian['cBillPhone'],
		  'country_code'  => 'IDN'
		);

		if($this->session->has_userdata('ship_area')){
			$shipping_area = $this->m_checkout->get_address($ses_pembelian['ship_area'])->row_array();
    		$shipping_address = array(
			  'first_name'    => $ses_pembelian['ship_name'],
			  'last_name'     => "",
			  'address'       => $ses_pembelian['ship_addr'],
			  'city'          => ucwords(strtolower($shipping_area['kabupaten'])),
			  'postal_code'   => $ses_pembelian['ship_post'],
			  'phone'         => $ses_pembelian['ship_telp'],
			  'country_code'  => 'IDN'
			);
    	}else{
    		$shipping_address = array(
			  'first_name'    => $ses_pembelian['cBillName'],
			  'last_name'     => " ",
			  'address'       => $ses_pembelian['cBillAddress'],
			  'city'          => $billing_area['kabupaten'],
			  'postal_code'   => $ses_pembelian['cBillPostcode'],
			  'phone'         => $ses_pembelian['cBillPhone'],
			  'country_code'  => 'IDN'
			);
    	}

		// Optional
		$customer_details = array(
		  'first_name'    => $ses_pembelian['cBillName'],
		  'last_name'     => "",
		  'email'         => $ses_pembelian['cEmail'],
		  'phone'         => $ses_pembelian['cBillPhone'],
		  'billing_address'  => $billing_address,
		  'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
             'start_time' => date("Y-m-d H:i:s O",$time),
             ' unit' => 'minute', 
             'duration'  => 2
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );
        
		error_log(json_encode($transaction_data));
		$snapToken = $this->xendit->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }

    public function finish()
    {
    	date_default_timezone_set('Asia/Jakarta');
		if($this->input->post('result_data')){
			$result  = json_decode($this->input->post('result_data'));
			$ses_pembelian = $this->session->userdata();

			$noorder = $this->m_checkout->no_transaksi();
			$code    = $ses_pembelian['midtrans_kodepembayaran'];
			$cost    = $ses_pembelian['midtrans_cost_real'];
			$subt    = $ses_pembelian['midtrans_subtotal'];

			if($this->session->userdata('login') == true){
				$id_users = $this->session->userdata('id');
			}else{
				$id_users = 0;
			}

			
			$voucher = ($this->session->has_userdata('voucher')) ? $ses_pembelian['voucher'] : '';
		

			if($this->session->has_userdata('ship_area')){
				$area      = $this->session->userdata('ship_area');
				$namakirim = $this->session->userdata('ship_name');
				$alamat    = $this->session->userdata('ship_addr');
				$telpon    = $this->session->userdata('ship_telp');
				$postcode  = $this->session->userdata('ship_post');
			}else{
				$area 	   = $this->session->userdata('cBillArea');
				$namakirim = $this->session->userdata('cBillName');
				$alamat    = $this->session->userdata('cBillAddress');
				$telpon    = $this->session->userdata('cBillPhone');
				$postcode  = $this->session->userdata('cBillPostcode');
			}

			switch($result->transaction_status){
				case "capture"    : $OrderStatus = 2; break;
				case "settlement" : $OrderStatus = 2; break;
				case "pending"    : $OrderStatus = 1; break;
				case "deny"       : $OrderStatus = 0; break;
			}

			if($result->transaction_status == 'capture'){
				if ($result->payment_type == 'credit_card'){
					if($result->fraud_status == 'challenge'){
						$OrderStatus = 1;
				    } 
				    elseif($result->fraud_status == 'accept') {
				    	$OrderStatus = 2;
				    }
				    else{
				    	$OrderStatus = 0;
				    }
				}
			}

			$dataorder = array( 
				'No_Orders'          => $noorder,
				'ID_users'           => $id_users,
				'Email'              => $this->session->userdata('cEmail'),
				'OrdersDate'         => date('Y-m-d H:i:s'),
				'OrderStatus'        => $OrderStatus,
				'BillName'           => $this->session->userdata('cBillName'),
				'BillAddress'        => $this->session->userdata('cBillAddress'),
				'BillAddress2'       => $this->session->userdata('cBillArea'),
				'BillPhone'          => $this->session->userdata('cBillPhone'),
				'BillPostcode'       => $this->session->userdata('cBillPostcode'),
				'ShipName'           => $namakirim,
				'ShipAddress'        => $alamat,
				'ShipAddress2'       => $area,
				'ShipPostcode'       => $postcode,
				'ShipPhone'          => $telpon,
				'PaymentMet'         => $result->payment_type,
				'ShippingMet'        => $this->session->userdata('ship_ship'),
				'ShippingCost'       => $cost,
				'UnikCode'           => $code,
				'Subtotal'           => $subt,
				'total_weight'       => total_weight_cart(),
				'total_qty'          => $this->cart->total_items(),
				'total_value'        => $this->cart->total(),
				'voucher'            => $voucher,
				'discount_voucher'   => $ses_pembelian['midtrans_vouc_disc'],
				'voucher_type'       => $ses_pembelian['midtrans_vouc_type'],
				'transaction_status' => $result->transaction_status,
				'transaction_time'   => $result->transaction_time,
				'order_id'           => $result->order_id,
				'status_message'     => $result->status_message,
				'payment_type'       => $result->payment_type, 
				'pdf'                => $result->pdf_url
				);

			foreach ($this->cart->contents() as $items):
				$subtotallist = $items['qty']*$items['price'];
				$datalist = array(
					'lastIns'   => date('Y-m-d H:i:s'),
					'NO_orders' => $noorder,
					'ID_items'  => $items['id'],
					'barcode'   => $items['barcode'],
					'id_map'    => $items['id_map'],
					'ItemCode'  => $items['code'],
					'ItemName'  => $items['name'],
					'color'     => $items['color'],
					'size'      => $items['size'],
					'ItemPrice' => $items['price2'],
					'Disc'      => $items['discount'],
					'qty'       => $items['qty'],
					'PriceSell' => $items['price'],
					'Total'     => $subtotallist
				);
				
				$this->db->insert('orders_list', $datalist);

				$where = array(
					'barcode' => $items['barcode']
				);
				if(!empty($items['size'])){
					$where['size'] = $items['size'];
				}
				if(!empty($items['color'])){
					$where['color'] = $items['color'];
				}

				$itemstock = $this->db->get_where("product_map_stock", $where)->row_array();

				$this->db->update("product_map_stock", array("stock" => $itemstock['stock'] - $items['qty']), array("ID_ms" => $itemstock['ID_ms']));

		    endforeach;



			$insertorder = $this->db->insert('orders', $dataorder);
			
			if($insertorder){
				$array_items = array( 
				'ship_name', 
				'ship_addr', 
				'ship_area', 
				'ship_post', 
				'ship_telp',
				'ship_ship',
				'cEmail',
				'cBillName',
				'cBillAddress',
				'cBillArea',
				'cBillPhone',
				'cBillPostcode',
				'costship',
		        'voucher',
		        'potongan_belanja',
		        'potongan_ongkir',
		        'potongan_session',
				'midtrans_kodepembayaran',
		        'midtrans_cost',
		        'midtrans_subtotal',
		        'midtrans_disc',
		        'midtrans_cost_real',
		        'midtrans_vouc_disc', 
		        'midtrans_vouc_type'
				);
				$this->session->unset_userdata($array_items);
				$this->cart->destroy();
				redirect(base_url().'shop/order-detail/'.$noorder);
				// pre($result);
			}else{
				$this->session->set_flashdata('alert_errors', 'Terjadi kesalahan koneksi, mohon ulangi lagi!');
				redirect(base_url().'shop/cart');
			}
			
		}else{
			show_404();
		}

    }

    public function unfinish()
	{
		echo 'unfinish';
	}

	public function error()
	{
		echo 'error';
	}
}
