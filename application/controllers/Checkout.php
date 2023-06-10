<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Checkout extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library(array('session', 'cart'));
		$this->load->model(array('checkout/m_checkout', 'shop/m_shop'));
	}

	public function index(){
		if($this->cart->total_items() > 0){
			if($this->session->userdata('login') == false){
				$data['province'] = $this->m_checkout->get_destination('propinsi');
				$this->render_page('checkout/member', $data);
			}else{
				$iduser   = $this->session->userdata('id');
				$userdata = $this->m_checkout->get_users('id', $iduser)->row();
				$sesscostumer = array(
					'cEmail'        => $userdata->email,
					'cBillName'     => $userdata->first_name.' '.$userdata->last_name,
					'cBillAddress'  => $userdata->address,
					'cBillArea'     => $userdata->area,
					'cBillPhone'    => $userdata->phone,
					'cBillPostcode' => $userdata->postcode
					);
				$this->session->set_userdata($sesscostumer);
				redirect(base_url().'checkout/shipping-method');
			}
		}else{
			redirect(base_url().'shop/cart');
		}
	}
	public function shipping_method(){
		$data['province'] = $this->m_checkout->get_destination('propinsi');
		if(($this->session->userdata('login') == true) AND (empty($this->session->userdata('cBillAddress')))){
			$this->render_page('checkout/shipping2', $data);
		}else{
			$area = $this->session->userdata('cBillArea');
			$data['address'] = $this->m_checkout->get_address($area);

			if($this->session->has_userdata('ship_area')){
				$data['shipaddres'] = $this->m_checkout->get_address($this->session->userdata('ship_area'))->row();
			}
			if($data['address']->num_rows() > 0 ){

				$jne          = $data['address']->row_array();

				$this->load->library('jne');
				$method = 'POST';
				$action = 'pricedev';
				$header = array('Content-Type:application/x-www-form-urlencoded', 'User-Agent:'.get_user_agent());
				$parameter = array(
					'username' => setting_value('JNE_API_USERNAME'),
					'api_key'  => setting_value('JNE_API_PASSWORD'),
					'from'     => 'CGK10000',
					'thru'     => $jne['tariff_jne_code'],
					'weight'   => total_weight_cart()
			    );
			    $result = $this->jne->request($action, $method, $header, $parameter);

			    if(!empty($result['price'])){
			    	$data['next'] = true;
			    }else{
			    	$data['next'] = false;
			    }

				$this->render_page('checkout/shipping', $data);
			}else{
				redirect(base_url().'checkout');
			}
		}
	}

	public function data_checkout(){
		date_default_timezone_set('Asia/Jakarta');
		if($this->input->post('pagedata') == 'login'){
			$logemail = $this->input->post('lemail');
			$logpassw = md5($this->input->post('lpassw'));
			$cekuser = $this->m_checkout->get_users('email', $logemail);
			if($cekuser->num_rows() > 0){
				if (password_verify($logpassw, $cekuser->row()->password)) {
					$update          = array('modified'=>date('Y-m-d H:i:s'));
					$where           = "id='".$cekuser->row()->id."'";
					$updateuser      = $this->db->update('users', $update, $where);
					$session_admin = array(
					'id'         => $cekuser->row()->id,
					'fname'      => $cekuser->row()->first_name,
					'email'      => $cekuser->row()->email,
					'login'      => true
				    );
				    $sesscostumer = array(
							'cEmail'        => $cekuser->row()->email,
							'cBillName'     => $cekuser->row()->first_name.' '.$cekuser->row()->last_name,
							'cBillAddress'  => $cekuser->row()->address,
							'cBillArea'     => $cekuser->row()->area,
							'cBillPhone'    => $cekuser->row()->phone,
							'cBillPostcode' => $cekuser->row()->postcode,
					);
				    $this->session->set_userdata($session_admin);
				    $this->session->set_userdata($sesscostumer);
				    $json['status']  = 1;
				    $json['loc']     = base_url().'checkout/shipping-method/';
					$json['message'] = '';
				} else {
				    $json['status']  = 0;
					$json['message'] = '<div class="alert alert-danger" role="alert">Password salah</div>';
				}
			}else{
				$json['status']  = 0;
				$json['message'] = '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>';
			}
			echo json_encode($json);
		}
		if($this->input->post('pagedata') == 'register'){
			$name  = $this->input->post('cname');
			$email = $this->input->post('cemail');
			$addre = $this->input->post('caddress');
			$area  = $this->input->post('csubdist');
			$post  = $this->input->post('cpost');
			$phone = $this->input->post('cphone');
			$detim = date('Y-m-d H:i:s');

			if($this->input->post('iregis') != null){
			$cekuser = $this->m_checkout->get_users('email', $email);
			if($cekuser->num_rows() == 0){
				if($this->input->post('cpass') == $this->input->post('crpass')){
					$passwithsalt = password_hash(md5($this->input->post('cpass')), PASSWORD_DEFAULT);
					$datauser     = array(
						'oauth_provider' => 'website',
						'password'   => $passwithsalt,
						'first_name' => $name,
						'email'      => $email,
						'address'    => $addre,
						'area'       => $area,
						'postcode'   => $post,
						'phone'      => $phone,
						'created'    => $detim,
						'modified'   => $detim
						);
					$register = $this->db->insert('users', $datauser);
					if($register){ 
						$id = $this->db->insert_id();
						$session_admin = array(
						'id'         => $id,
						'fname'      => $name,
						'email'      => $email,
						'login'      => true
					    );
					    $this->session->set_userdata($session_admin);
						$sesscostumer = array(
							'cEmail'        => $email,
							'cBillName'     => $name,
							'cBillAddress'  => $addre,
							'cBillArea'     => $area,
							'cBillPhone'    => $phone,
							'cBillPostcode' => $post,
							);
						$this->session->set_userdata($sesscostumer);
						$json['status']  = 1;
						$json['loc']     = base_url().'checkout/shipping-method/';
						$json['message'] = '<div class="alert alert-success" role="alert">daftar jadi member</div>';
					}else{ 
						$json['status']  = 0;
						$json['message'] = '<div class="alert alert-danger" role="alert">gagal daftar</div>';
					}
				}else{
					$json['status']  = 0;
					$json['message'] = '<div class="alert alert-danger" role="alert">password berbeda</div>';
				}
			}else{
				$json['status']  = 0;
				$json['message'] = '<div class="alert alert-danger" role="alert">users telah terdaftar sebelumnya</div>';
			}
			}else{
				$sesscostumer = array(
					'cEmail'        => $email,
					'cBillName'     => $name,
					'cBillAddress'  => $addre,
					'cBillArea'     => $area,
					'cBillPhone'    => $phone,
					'cBillPostcode' => $post,
					'login'	        => false
					);
				$this->session->set_userdata($sesscostumer);
					$json['status']  = 1;
					$json['loc']     = base_url().'checkout/shipping-method/';
			}
			echo json_encode($json);
		}
	}

	public function data_customer(){
		if($this->input->post('buildbill')){
			$addre = $this->input->post('caddress');
			$area  = $this->input->post('csubdist');
			$post  = $this->input->post('cpost');
			$phone = $this->input->post('cphone');
			$datacustomer = array(
				'address'  => $addre,
				'area'     => $area,
				'postcode' => $post,
				'phone'    => $phone
				);
			$where = array( 'id' => $this->session->userdata('id') );
			$inputdata = $this->db->update('users', $datacustomer, $where);
			if($inputdata){
				$sesscostumer = array(
					'cEmail'        => $this->session->userdata('email'),
					'cBillName'     => $this->session->userdata('fname'),
					'cBillAddress'  => $addre,
					'cBillArea'     => $area,
					'cBillPhone'    => $phone,
					'cBillPostcode' => $post
					);
				$this->session->set_userdata($sesscostumer);
				redirect(base_url().'checkout/shipping-method');
			}else{
				redirect(base_url().'checkout/shipping-method');
			}
		}else{
			show_404();
		}
	}

	public function getcity(){
		if(IS_AJAX){
			$prov = $this->input->post('prov');
			$cari = $this->m_checkout->get_destination_bycity($prov);
			if(count($cari) > 0){
				$json['status'] = 1;
				$json['data'] = '<option selected="selected" value="">-- choose a city --</option>';
				foreach ($cari as $key => $city) {
					$json['data'] .= '<option value="'.$city['kabupaten'].'">'.ucwords(strtolower($city['kabupaten'])).'</option>';
				}
			}else{
				$json['status'] = 0;
			}
			echo json_encode($json);
		}else{
			show_404();
		}
	}

	public function getdistrict(){
		if(IS_AJAX){
			$prov = $this->input->post('prov');
			$city = $this->input->post('city');
			$cari = $this->m_checkout->get_destination_bydistrict($prov, $city);
			if(count($cari) > 0){
				$json['status'] = 1;
				$json['data'] = '<option selected="selected" value="">-- choose a district --</option>';
				foreach ($cari as $city => $kab) {
					$json['data'] .= '<option value="'.$kab['kecamatan'].'">'.ucwords(strtolower($kab['kecamatan'])).'</option>';
				}
			}else{
				$json['status'] = 0;
			}
			echo json_encode($json);
		}else{
			show_404();
		}
	}

	public function getsubdistrict(){
		if(IS_AJAX){
			$prov     = $this->input->post('prov');
			$city     = $this->input->post('city');
			$district = $this->input->post('district');
			
			$cari     = $this->m_checkout->get_destination_bysubdistrict($prov, $city, $district);
			$json['data'] = '';
			if(count($cari) > 0){
				$json['status'] = 1;
				if(count($cari) == 1){
					$json['status'] = 2;
				}else{
					$json['data'] .= '<option value="">-- choose a district --</option>';
				}
				foreach ($cari as $city => $sub) {
					$json['selected'] = $sub['ID'];
					$autoselected = (count($cari) == 1) ? 'selected' : '';
					$json['data'] .= '<option value="'.$sub['ID'].'" data-zip="'.$sub['zip'].'" '.$autoselected.'>'.ucwords(strtolower($sub['desa'])).'</option>';
				}
			}else{
				$json['status'] = 0;
			}
			echo json_encode($json);
		}else{
			show_404();
		}
	}

	public function getdoldcost($dataarea){
		if($this->session->has_userdata('cBillArea')){
			$area 		  = $dataarea;
			$jne          = $this->m_checkout->get_address($area)->row_array();

			$this->load->library('jne');

			$method = 'POST';
			$action = 'pricedev';
			$header = array('Content-Type:application/x-www-form-urlencoded', 'User-Agent:'.get_user_agent());
			$parameter = array(
				'username' => setting_value('JNE_API_USERNAME'),
				'api_key'  => setting_value('JNE_API_PASSWORD'),
				'from'     => 'CGK10000',
				'thru'     => $jne['tariff_jne_code'],
				'weight'   => total_weight_cart()
		    );

		    $shipoption = '';

			$result = $this->jne->request($action, $method, $header, $parameter);
			if(!empty($result['price'])){
				$jne_tariff = $result;
				$shipoption .= '<option value="">Pilih Pengiriman</option>';
				$ses_service = ($this->session->has_userdata('ship_ship')) ? str_replace(array("<", "&lt;"), "",$this->session->userdata('ship_ship')) : ""; 
				foreach ($jne_tariff['price'] as $key => $value) {
					$ser_display = str_replace("<", "", $value['service_display']);
					$selected = ($ses_service == $ser_display) ? 'selected' : '';
					$estimasi = ($value['etd_from'] != $value['etd_thru']) ? 'Estimasi Tiba '.$value['etd_from'].' - '.$value['etd_thru'].' '.$value['times'] : '';
					if($value['service_display'] == 'YES'){
						$estimasi = 'Estimasi Tiba Besok';
					}
	                $shipoption .= '<option '.$selected.' value="'.$ser_display.'" data-cost="'.$value['price'].'">'.$value['service_display'].' (Rp'.rupiah($value['price']).') '.$estimasi.'</option>';
	            }
			}else{
				$shipoption .= '<option selected>'.$result['error'].'</option>';
			}

			echo $shipoption;
		}
	}

	public function getdnewcost(){
		if(IS_AJAX){
			$area         = $this->input->post('area');
			$jne          = $this->m_checkout->get_address($area)->row_array();

			$this->load->library('jne');

			$method = 'POST';
			$action = 'pricedev';
			$header = array('Content-Type:application/x-www-form-urlencoded', 'User-Agent:'.get_user_agent());
			$parameter = array(
				'username' => setting_value('JNE_API_USERNAME'),
				'api_key'  => setting_value('JNE_API_PASSWORD'),
				'from'     => 'CGK10000',
				'thru'     => $jne['tariff_jne_code'],
				'weight'   => total_weight_cart()
		    );

		    $shipoption = '';
		    $result = $this->jne->request($action, $method, $header, $parameter);
		    if(!empty($result['price'])){
		    	$json['next'] = 1;
		    	$jne_tariff = $result;
		    	$shipoption .= '<option value="">Pilih Pengiriman</option>';
				foreach ($jne_tariff['price'] as $key => $value) {
					$estimasi = ($value['etd_from'] != $value['etd_thru']) ? 'Estimasi Tiba '.$value['etd_from'].' - '.$value['etd_thru'].' '.$value['times'] : '';
					if($value['service_display'] == 'YES'){
						$estimasi = 'Estimasi Tiba Besok';
					}
	                $shipoption .= '<option value="'.$value['service_display'].'" data-cost="'.$value['price'].'">'.$value['service_display'].' (Rp'.rupiah($value['price']).') '.$estimasi.'</option>';
	            }
		    }else{
		    	$json['next'] = 0;
		    	$shipoption .= '<option selected>'.$result['error'].'</option>';
		    }


			$json['status'] = 1;
			$json['data'] = $shipoption;
			echo json_encode($json);
		}else{
			show_404();
		}
	}

	function jne_tariff($jnecodedestination, $weight = 1){
		$this->load->library('jne');

		$method = 'POST';
		$action = 'pricedev';
		$header = array('Content-Type:application/x-www-form-urlencoded', 'User-Agent:'.get_user_agent());
		$parameter = array(
			'username' => setting_value('JNE_API_USERNAME'),
			'api_key'  => setting_value('JNE_API_PASSWORD'),
			'from'     => 'CGK10000',
			'thru'     => $jnecodedestination,
			'weight'   => $weight
		);

		$result = $this->jne->request($action, $method, $header, $parameter);
		return $result;
	}

	public function payment_method(){
		if($this->session->has_userdata('ship_area')){
			$area = $this->session->userdata('ship_area');
		}else{
			$area = $this->session->userdata('cBillArea');
		}
		if($this->session->has_userdata('cBillArea') || $this->session->has_userdata('ship_area')){

			$data['shipaddres'] = $this->m_checkout->get_address($area)->row();

			$stocklist = array();
			$data['dataalert']    = array();
			foreach ($this->cart->contents() as $items):

				$itemstock = $this->db->get_where("product_map_stock", array("barcode" => $items['barcode']))->row_array();
				$res = ($itemstock['stock'] > 0) ? "in stock" : "out of stock";
				array_push($stocklist, $res);
				if($res == "out of stock"){
					$data['dataalert'][] = array(
						'name'  => $items['name'].' ('.$items['colorname'].')',
						'stock' => "out of stock"
					);
				}
			endforeach;
			// pre($data['dataalert']);

			if(in_array("out of stock", $stocklist, false)){
				$data['buybutton'] = "disabled";
			}else{
				$data['buybutton'] = "";
			}	

			$this->render_page('checkout/payment', $data);
		}else{
			redirect(base_url().'checkout');
		}
	}

	function getcheckouturl(){
       
		$amount = $this->input->post('amount');
        $externalId = $this->input->post('external_id');
        $curl = curl_init();
        
		 /*PROSES XENDIT*/
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.xendit.co/v2/invoices',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
				"external_id": "'.$externalId.'",
				"amount": '.floatval($amount).',
				"payer_email": "iqbalalyansyah3@gmail.com",
				"description": "Payment Tanskin.id"
			}',
		     CURLOPT_USERPWD => 'xnd_production_0fe7ZApI47qHxBMYkQZq8r8sGISgzCFhjdInJ3Vma9ZMfgG4vMTA2lNArdWM3:',
			 CURLOPT_HTTPHEADER => array(
			  'Content-Type: application/json'
			),
		 ));
		  
		  $response = curl_exec($curl);
		  
		  curl_close($curl);
		  $responseDecoded = json_decode($response, true);
          $checkoutUrl =  $responseDecoded['invoice_url'];
          header('Location: '.$checkoutUrl);

	 }

	function data_shipping(){
		if($this->input->post('shipping_page')){

			if($this->cart->total() >= (int)setting_value('min_pembelanjaan')){
				$cost = (int)$this->input->post('shipping_cost');
				$max  = (int)setting_value('max_potongan');
				$potongan = ($cost > $max) ? $max : $cost;
			}else{
				$potongan = 0;
			}

			$datashipping = array( 
				'cost_session' => $this->input->post('shipping_cost'),
				'potongan_session' => $potongan
				);
			$this->session->set_userdata($datashipping);

			if($this->input->post('othershipping') == true){
				$datadropship = array( 
				'ship_name' => $this->input->post('sip_name'), 
				'ship_addr' => $this->input->post('sip_address'), 
				'ship_area' => $this->input->post('sip_subdist'), 
				'ship_post' => $this->input->post('sip_post'), 
				'ship_telp' => $this->input->post('sip_phone'),
				'ship_ship' => $this->input->post('sip_cost'),
				);
			}else{
				$datadropship = array( 
				'ship_ship' => $this->input->post('bill_cost')
				);
				$array_items = array( 
				'ship_name', 
				'ship_addr', 
				'ship_area', 
				'ship_post', 
				'ship_telp'
				);
				$this->session->unset_userdata($array_items);
			}
			$this->session->set_userdata($datadropship);

			redirect(base_url().'checkout/payment-method');
		}else{
			show_404();
		}
	}

	public function FinishPayment(){
		$this->load->view('finish/finish.php');
	}

	function loadorder(){

		$dataload = '';
		 if($this->cart->total_items() > 0){ 
		 	if(($this->session->userdata('login') == true) AND (empty($this->session->userdata('cBillAddress')))){
		 		$cost = 0;
		 	}else{
			 // if(!empty($this->session->userdata('cost_session'))){	
				 // if($this->session->has_userdata('ship_area')){
				 // 	$area = $this->session->userdata('ship_area');
				 // }else{
				 // 	$area = $this->session->userdata('cBillArea');
				 // }
				 // $jne    = $this->m_checkout->get_address($area)->row_array();
				 // $return = $this->jne_tariff($jne['tariff_jne_code'], total_weight_cart());
				 // if(!empty($return['price'])){
				 // 	$cost = 0;
				 // 	foreach ($return['price'] as $key => $value) {
				 // 		$tariff = (strtolower($value['service_display']) == strtolower($this->session->userdata('ship_ship'))) ? $value['price'] : 0;
				 // 		$cost = $cost + $tariff;
				 // 	}
				 // }else{
				 // 	$cost = 0;
				 // }
			 // }else{
			 // 	 $cost = 0;
			 // }
			 $cost = (!empty($this->session->userdata('cost_session'))) ? $this->session->userdata('cost_session') : 0;
			}
			 if($this->uri->segment(3) == 'payment-method'){
			 	$digits  = 3;
				$randnum = rand(pow(10, $digits-1), pow(10, $digits)-1);
				$randnum = ($this->session->has_userdata('midtrans_kodepembayaran') && $this->session->userdata('midtrans_kodepembayaran') > 0) ? $this->session->userdata('midtrans_kodepembayaran') : $randnum;
			 }else{
				$randnum = 0;
			 }

			 $total_belanja = $this->cart->total();

			 $potongan_session = ($this->session->has_userdata('potongan_session')) ? $this->session->userdata('potongan_session') : 0;
			 $discount_voucher =  $potongan_session;
			 $vou_type = 1;
			 if($this->session->has_userdata('voucher')){
			 	$potongan_session = ($this->session->has_userdata('potongan_ongkir')) ? $this->session->userdata('potongan_ongkir') : 0;
			 	$total_belanja    = ($this->session->has_userdata('potongan_belanja')) ? $this->cart->total() - $this->session->userdata('potongan_belanja') : $this->cart->total();
			 	$discount_voucher = ($this->session->has_userdata('potongan_ongkir')) ? $this->session->userdata('potongan_ongkir') : $this->session->userdata('potongan_belanja');
			 	$vou_type         = ($this->session->has_userdata('potongan_ongkir')) ? 1 : 2;
			 }

			 $this->session->set_userdata('costship', $cost);
			 $totalcost   = $cost-$potongan_session;
			 $totalamount = $totalcost+$randnum+$total_belanja;
			 $datapay = array(
				'midtrans_kodepembayaran' => $randnum,
				'midtrans_cost'           => $totalcost,
				'midtrans_cost_real'      => $cost,
				'midtrans_vouc_disc'      => $discount_voucher,
				'midtrans_vouc_type'      => $vou_type,
				'midtrans_disc'           => $this->session->userdata('potongan_belanja'),
				'midtrans_subtotal'       => $totalamount
		      );
		      $this->session->set_userdata($datapay);

		 $dataload .= '<div class="box-cart-head">
		            <h1><b>Detail Order</b> ( <span>'.$this->cart->total_items().'</span> item(s) )<small>* All the prices are in IDR</small></h1>
		        </div>
		        <div class="box-cart-body">
		        '.$datapay['midtrans_disc'].'
		        <table class="table-item-list">
		            <thead>
		                <tr>
		                <th>Item</th>
		                <th>Qty</th>
		                <th>Total</th>
		                </tr>
		            </thead>
		            <tbody>';
		          
		            foreach ($this->cart->contents() as $items):
		          	$sizeName = $this->db->get_where('size', array('ID_Size' => $items['size']))->row_array();
		            $dataload .= '<tr><td>'.$items['name'].'</br>';
		            if($sizeName){
			            $dataload .= '<span>size:'.$sizeName['Size'].'</span>';
			        }
		            $dataload .= '</td>
		                <td>'.$items['qty'].' x '.rupiah($items['price']).'</td>
		                <td>'.rupiah($items['qty']*$items['price']).'</td>
		                </tr>';
		            endforeach;
		            $dataload .= '</tbody>
		            <tfoot>
		                <tr><th colspan="3" class="one-border"></th></tr>
		                <tr><th colspan="3" height="5px"></th></tr>

		                <tr>
		                <th colspan="2" class="text-right">Subtotal</th>
		                <th class="text-right"><span class="subtotalprice">'.rupiah($this->cart->total()).'</span></th>
		                </tr>
		                <tr>
		                <th colspan="2" class="text-right">Shipping</th>
		                <th class="text-right"><span class="costshipping priceformat">'.rupiah($cost).'</span></th>
		                </tr>';
		                $potongan = ($potongan_session > 0) ? '' : 'hide';
		                $dataload .= '<tr id="potongan-pengiriman" class="'.$potongan.'">
		                <th colspan="2" class="text-right">Free Shipping</th>
		                <th class="text-right red">-<span class="freeshipping priceformat">'.rupiah($potongan_session).'</span></th>
		                </tr>';
		                if($this->session->has_userdata('potongan_belanja')){
		                	$dataload .= '<tr>
			                <th colspan="2" class="text-right">Discount</th>
			                <th class="text-right red">-<span>'.rupiah($this->session->userdata('potongan_belanja')).'</span></th>
			                </tr>';
		                }
		                if($this->uri->segment(3) == 'payment-method'):
		                	

		                	$dataload .= '<tr>
		                <th colspan="2" class="text-right">Kode Pembayaran</th>
		                <th class="text-right"><span>'.rupiah($randnum).'</span>
		                </th>
		                </tr>';
		                endif;
		                if($this->session->userdata('login') == true && $this->uri->segment(3) != 'payment-method'):
		                $dataload .= '<tr>
		                <th colspan="3">';
		                    if($this->session->has_userdata('voucher')){
		                    	$dataload .='<label><a href="javascript:void(0);">Voucher Code</a></label>
		                    	<div class="input-group" style="width: 100%">
			                    <input type="text" class="form-control" value="'.$this->session->userdata('voucher').'">
			                    <span class="input-group-btn">
			                    <button type="button" id="vou-del" class="btn btn-danger btn-flat">Delete voucher</button>
			                    </span>
			                    </div>';
		                    }else{
			                    $dataload .='<label><a href="javascript:void(0);" class="have-voucher">Have voucher code ?</a></label>
			                    <div class="input-group hidden yes-i-have-vou" style="width: 100%">
			                    <input type="text" class="form-control value--vou" value="">
			                    <span class="input-group-btn">
			                    <button type="button" id="vou-sub" class="btn btn-info btn-flat">Use the voucher</button>
			                    </span>
			                    </div> 
			                    <label id="value--vou-error" class="error" for="value--vou"></label>'; 
		                    }
		                $dataload .='</th>
		                </tr>';
		                endif;
		                $dataload .= '<tr><th colspan="3" class="one-border"></th></tr>
		                <tr><th colspan="3" height="5px"></th></tr>
		                <tr>
		                <th colspan="2">Total</th>
		                <th class="text-right">IDR <span class="totalprice priceformat">'.rupiah($totalamount).'</span></th>
		                </tr>
		       
		            </tfoot>
		        </table>
		        </div>';
		        echo $dataload;
		}

	}

	// voucher checked
	function getwhatis(){
		if(IS_AJAX){
			if($this->session->userdata('login') == true){
			$idcusto = $this->session->userdata('id');
			$vou     = $this->m_shop->check_voucher();
				if($vou->num_rows() > 0){
					$vou = $vou->row_array();
					if($vou['usage_vou'] > 0){
						if($this->cart->total() >= $vou['min_amount']){
							$this->session->set_userdata('voucher', $vou['vou_code']);
							if($vou['vou_for'] == 1){ //shipping
								$this->session->set_userdata('potongan_ongkir', $vou['Disc']);
							}else{
								//total belanja
								$this->session->set_userdata('potongan_belanja', $vou['Disc']);
							}
							$json['status']  = 1;
						}else{
							$json['message'] = 'Minimal pembelanjaan Rp.'.rupiah($vou['min_amount']);
							$json['status']  = 0;
						}
					}else{
						$json['message'] = 'Maaf, Kuota Voucher sudah habis.';
						$json['status']  = 0;
					}
				}else{
					$cek_gift = $this->m_shop->check_voucher_gift();
					if($cek_gift->num_rows() > 0){
						$row_gift = $cek_gift->row_array();
						$this->session->set_userdata('voucher', $row_gift['voucher_code']);
						$this->session->set_userdata('potongan_belanja', $row_gift['voucher_value']);
						$json['status']  = 1;
					}
					else{
						$json['message'] = 'Voucher sudah tidak berlaku.';
						$json['status']  = 0;
					}
				}

			}else{
				$json['message'] = 'Login dahulu untuk memakai Voucher ini.';
				$json['status']  = 0;
			}
			echo json_encode($json);
		}else{
			show_404();
		}
	}

	function delete_voucher(){
		$voucher_session = array(
			'voucher', 'potongan_ongkir', 'potongan_belanja'
		);
		$this->session->unset_userdata($voucher_session);
		redirect(base_url('checkout/shipping-method'));
	}

	function created_shipping(){
		if($this->input->post('shipping_cost')){
			if($this->cart->total() >= (int)setting_value('min_pembelanjaan')){
				$cost = (int)$this->input->post('shipping_cost');
				$max  = (int)setting_value('max_potongan');
				$potongan = ($cost > $max) ? $max : $cost;
			}else{
				$potongan = 0;
			}

			$datashipping = array( 
				'cost_session'     => $this->input->post('shipping_cost'),
				'ship_ship'        => $this->input->post('meth'),
				'potongan_session' => $potongan
				);
			$this->session->set_userdata($datashipping);
		}
	}

	function created_dropship(){
		if(IS_AJAX){
			if($this->cart->total() >= (int)setting_value('min_pembelanjaan')){
				$cost = (int)$this->input->post('shipping_costnew');
				$max  = (int)setting_value('max_potongan');
				$potongan = ($cost > $max) ? $max : $cost;
			}else{
				$potongan = 0;
			}

			$datashipping = array( 
				'cost_session'     => $this->input->post('shipping_costnew'),
				'potongan_session' => $potongan,
				'ship_name'        => $this->input->post('sip_name'), 
				'ship_addr'        => $this->input->post('sip_address'), 
				'ship_area'        => ($this->input->post('sip_subdist'))? $this->input->post('sip_subdist') : $this->session->userdata('ship_area'), 
				'ship_post'        => $this->input->post('sip_post'), 
				'ship_telp'        => $this->input->post('sip_phone'),
				'ship_ship'        => $this->input->post('sip_cost'),
				);
			if($this->session->has_userdata('ship_area')){
				foreach ($datashipping as $key => $value) {
					$this->session->set_userdata($key, $value);
				}
			}else{
				$this->session->set_userdata($datashipping);
			}
			return $datashipping;
		}
	}



	function confirm_order(){
	// 	date_default_timezone_set('Asia/Jakarta');
	// 	if($this->input->post('confirm')){
	// 		$noorder = $this->m_checkout->no_transaksi();
	// 		$code    = $this->input->post('kodepembayaran');
	// 		$cost    = $this->input->post('cost');
	// 		$subt    = $this->input->post('subtotal');
	// 		if($this->session->userdata('login') == true){
	// 			$id_users = $this->session->userdata('id');
	// 		}else{
	// 			$id_users = 0;
	// 		}

	// 		if($this->session->has_userdata('ship_area')){
	// 			$area      = $this->session->userdata('ship_area');
	// 			$namakirim = $this->session->userdata('ship_name');
	// 			$alamat    = $this->session->userdata('ship_addr');
	// 			$telpon    = $this->session->userdata('ship_telp');
	// 			$postcode  = $this->session->userdata('ship_post');
	// 		}else{
	// 			$area 	   = $this->session->userdata('cBillArea');
	// 			$namakirim = $this->session->userdata('cBillName');
	// 			$alamat    = $this->session->userdata('cBillAddress');
	// 			$telpon    = $this->session->userdata('cBillPhone');
	// 			$postcode  = $this->session->userdata('cBillPostcode');
	// 		}

	// 		$dataorder = array( 
	// 			'No_Orders'    => $noorder,
	// 			'ID_users'     => $id_users,
	// 			'Email'        => $this->session->userdata('cEmail'),
	// 			'OrdersDate'   => date('Y-m-d H:i:s'),
	// 			'OrderStatus'  => '1',
	// 			'BillName'     => $this->session->userdata('cBillName'),
	// 			'BillAddress'  => $this->session->userdata('cBillAddress'),
	// 			'BillAddress2' => $this->session->userdata('cBillArea'),
	// 			'BillPhone'    => $this->session->userdata('cBillPhone'),
	// 			'BillPostcode' => $this->session->userdata('cBillPostcode'),
	// 			'ShipName'     => $namakirim,
	// 			'ShipAddress'  => $alamat,
	// 			'ShipAddress2' => $area,
	// 			'ShipPostcode' => $postcode,
	// 			'ShipPhone'    => $telpon,
	// 			'PaymentMet'   => $this->session->userdata('payment_sess'),
	// 			'ShippingMet'  => $this->session->userdata('ship_ship'),
	// 			'ShippingCost' => $cost,
	// 			'UnikCode'     => $code,
	// 			'Subtotal'     => $subt
	// 			);

	// 		foreach ($this->cart->contents() as $items):
	// 			$subtotallist = $items['qty']*$items['price'];
	// 			$datalist = array(
	// 				'lastIns'   => date('Y-m-d H:i:s'),
	// 				'NO_orders' => $noorder,
	// 				'ID_items'  => $items['id'],
	// 				'ItemName'  => $items['name'],
	// 				'color'     => $items['color'],
	// 				'size'      => $items['size'],
	// 				'ItemPrice' => $items['price2'],
	// 				'Disc'      => $items['discount'],
	// 				'qty'       => $items['qty'],
	// 				'PriceSell' => $items['price'],
	// 				'Total'     => $subtotallist
	// 				);
	// 		$this->db->insert('orders_list', $datalist);
	// 	    endforeach;

	// 		$insertorder = $this->db->insert('orders', $dataorder);
			
	// 		if($insertorder){
	// 			$array_items = array( 
	// 			'ship_name', 
	// 			'ship_addr', 
	// 			'ship_area', 
	// 			'ship_post', 
	// 			'ship_telp',
	// 			'ship_ship',
	// 			'cEmail',
	// 			'cBillName',
	// 			'cBillAddress',
	// 			'cBillArea',
	// 			'cBillPhone',
	// 			'cBillPostcode',
	// 			'costship',
	// 			'payment_sess'
	// 			);
	// 			$this->session->unset_userdata($array_items);
	// 			$this->cart->destroy();
	// 			redirect(base_url().'shop/order-detail/'.$noorder);
	// 		}else{
	// 			$this->session->set_flashdata('alert_errors', 'Terjadi kesalahan koneksi, mohon ulangi lagi!');
	// 			redirect(base_url().'shop/cart');
	// 		}
			
	// 	}else{
	// 		show_404();
	// 	}
	}

	public function jnetest(){

		$this->load->library('jne');

		$method = 'POST';
	    $action = 'pricedev';
	    $header = array('Content-Type:application/x-www-form-urlencoded', 'User-Agent:'.get_user_agent());
	    $parameter = array(
					'username' => setting_value('JNE_API_USERNAME'),
					'api_key'  => setting_value('JNE_API_PASSWORD'),
					'from'     => 'CGK10000',
					'thru'     => 'TGR10112',
					'weight'   => 1
	    );

	    $result = $this->jne->request($action, $method, $header, $parameter);
	    pre($result);
	}
} 