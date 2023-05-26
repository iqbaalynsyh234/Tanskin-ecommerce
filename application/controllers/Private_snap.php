<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Private_snap extends CI_Controller {

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


	public function __construct()
    {
        parent::__construct();
		$this->load->library(array('xendit','session'));
		$this->xendit->config($params);
		$this->load->helper('form','url','function');
		$this->load->model(array('checkout/payment-method'));	
    }

  
    public function token($noorder)
    {
		date_default_timezone_set('Asia/Jakarta');
		
		$data_pembelian = $this->db->get_where('private_order', array('order_number' => $noorder))->row_array();
		$data_item      = $this->db->get_where('private_order_list', array('order_number' => $noorder))->result_array();

		$transaction_details = array(
			'order_id'     => time(),
			'gross_amount' => $data_pembelian['total'],
		);

		$item1_details = array();
		foreach ($data_item as $key => $items) {
			$item1_details[] = array(
				'id'       => $items['id_product'],
				'price'    => $items['harga_jual'],
				'quantity' => $items['qty'],
				'name'     => $items['item_name']
			);
		}

			$item1_details[] = array(
				'id'       => 'D1',
				'price'    => $data_pembelian['unic_code'],
				'quantity' => 1,
				'name'     => "Kode Pembayaran"
			);

			$item1_details[] = array(
				'id'       => 'D2',
				'price'    => $data_pembelian['cost'],
				'quantity' => 1,
				'name'     => "Pengiriman"
			);


		// Optional
		$item_details = $item1_details;
		$billing_area  = $this->m_checkout->get_address($data_pembelian['id_destination'])->row_array();

		// Optional
		$billing_address = array(
		  'first_name'    => $data_pembelian['nama'],
		  'last_name'     => " ",
		  'address'       => $data_pembelian['alamat'],
		  'city'          => ucwords(strtolower($billing_area['kabupaten'])),
		  'postal_code'   => $data_pembelian['zip'],
		  'phone'         => $data_pembelian['telepon'],
		  'country_code'  => 'IDN'
		);

		$shipping_address = array(
		  'first_name'    => $data_pembelian['nama'],
		  'last_name'     => " ",
		  'address'       => $data_pembelian['alamat'],
		  'city'          => ucwords(strtolower($billing_area['kabupaten'])),
		  'postal_code'   => $data_pembelian['zip'],
		  'phone'         => $data_pembelian['telepon'],
		  'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
		  'first_name'    => $data_pembelian['nama'],
		  'last_name'     => "",
		  'email'         => $data_pembelian['email'],
		  'phone'         => $data_pembelian['telepon'],
		  'billing_address'  => $billing_address,
		  'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit'       => 'minute', 
			'duration'   => 2
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

    public function finish($order_number)
    {
    	date_default_timezone_set('Asia/Jakarta');
		if($this->input->post('result_data')){
			$result         = json_decode($this->input->post('result_data'));
			$data_pembelian = $this->db->get_where('private_order', array('order_number' => $order_number))->row_array();

			$noorder        = $this->m_checkout->no_transaksi();
			$code           = $data_pembelian['unic_code'];
			$cost           = $data_pembelian['cost'];
			$subt           = $data_pembelian['total'];
			
			$id_users       = 0;			
			$voucher        = '';
		

			$area 	   = $data_pembelian['id_destination'];
			$namakirim = $data_pembelian['nama'];
			$alamat    = $data_pembelian['alamat'];
			$telpon    = $data_pembelian['telepon'];
			$postcode  = $data_pembelian['zip'];


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
				'Email'              => $data_pembelian['email'],
				'OrdersDate'         => date('Y-m-d H:i:s'),
				'OrderStatus'        => $OrderStatus,
				'BillName'           => $namakirim,
				'BillAddress'        => $alamat,
				'BillAddress2'       => $area,
				'BillPhone'          => $telpon,
				'BillPostcode'       => $postcode,
				'ShipName'           => $namakirim,
				'ShipAddress'        => $alamat,
				'ShipAddress2'       => $area,
				'ShipPostcode'       => $postcode,
				'ShipPhone'          => $telpon,
				'PaymentMet'         => $result->payment_type,
				'ShippingMet'        => $data_pembelian['pengiriman'],
				'ShippingCost'       => $cost,
				'UnikCode'           => $code,
				'Subtotal'           => $subt,
				'total_weight'       => $data_pembelian['total_weight'],
				'total_qty'          => $data_pembelian['total_qty'],
				'total_value'        => $data_pembelian['total'],
				'voucher'            => $voucher,
				'transaction_status' => $result->transaction_status,
				'transaction_time'   => $result->transaction_time,
				'order_id'           => $result->order_id,
				'status_message'     => $result->status_message,
				'payment_type'       => $result->payment_type, 
				'pdf'                => $result->pdf_url
				);

			$data_item      = $this->db->select('pl.*, p.barcode, p.ItemCode')->join('product_map_stock p', 'p.ID_ms = pl.id_ms', 'LEFT')
			->get_where('private_order_list pl', array('order_number' => $order_number))->result_array();
			foreach ($data_item as $key => $items) {
				$map = $this->db->get_where('product_map', array('barcode' => $items['barcode']))->row_array();
				$datalist = array(
					'lastIns'   => date('Y-m-d H:i:s'),
					'NO_orders' => $noorder,
					'ID_items'  => $items['id_product'],
					'barcode'   => $items['barcode'],
					'id_map'    => $map['ID_map'],
					'ItemCode'  => $items['ItemCode'],
					'ItemName'  => $items['item_name'],
					'color'     => $items['color'],
					'size'      => $items['size'],
					'ItemPrice' => $items['harga'],
					'Disc'      => $items['disc'],
					'qty'       => $items['qty'],
					'PriceSell' => $items['harga_jual'],
					'Total'     => $items['total']
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

		    }

			$insertorder = $this->db->insert('orders', $dataorder);
			
			if($insertorder){
				$this->db->update('private_order', array('token' => '', 'bayar' => date('Y-m-d H:i:s')), array('order_number' => $order_number));
				redirect(base_url().'shop/order-detail/'.$noorder);
			}else{
				$this->session->set_flashdata('alert_errors', 'Terjadi kesalahan koneksi, mohon ulangi lagi!');
				redirect(base_url().'shop/pembayaran/'.$data_pembelian['token']);
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
