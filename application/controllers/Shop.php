<?php if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Shop extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library(array('session', 'pagination', 'cart', 'facebook', 'Recaptcha'));
		$this->load->model(array('checkout/m_checkout', 'shop/m_shop', 'entersite/m_entersite', 'user', 'entersite/m_settings'));
	}

	public function index(){
		redirect(base_url() . 'shop/catalogue');
	}

	public function pembayaran($token=''){
		$row = $this->db->get_where('private_order', array('token' => $token))->row_array();
		if(!empty($row)){
			$data = array(
				'pengiriman' => $row,
				'alamat'     => $this->m_shop->alamat($row['id_destination']),
				'list'       => $this->m_shop->private_list($row['order_number']),
			);
			// pre($data);
			// $data_item      = $this->db->select('SUM(p.ItemWeight) as total_weight')
			// ->join('products p', 'p.ID_item = pl.id_product', 'LEFT')
			// ->get_where('private_order_list pl', array('pl.order_number' => $data['pengiriman']['order_number']))->row_array();
			// $total_weight = kilo($data_item['total_weight'] / 1000);
			// pre($total_weight);

			$this->render_page('shop/pembayaran', $data);
		}else{
			show_404();
		}
	}

	public function catalogue(){
		$params             = array();
		$limit_per_page     = 45;
		$page_hal           = $this->uri->segment(3);
		
		$params['kategori'] = category_nav_menu();


		if(!empty($page_hal) && !is_numeric($page_hal)){
			$get_spesial      = $this->m_shop->get_category_id($page_hal);
			$category_special = array('new', 'sale', 'featured', 'pre order', 'out of stock');
			if(in_array($get_spesial['special_type'], $category_special)){
				$section         = $page_hal;
				$product_section = $section;
				$special         = TRUE;
				$url             = $page_hal;
				$uri_segment     = 4;
			}else{
				$get_category    = $get_spesial;
				$product_section = $get_category['kategori'];
				$section         = $get_category['ID_cat'];
				$special         = FALSE;
				$url             = $page_hal;
				$uri_segment     = 4;
			}
		}
		else
		{
			$product_section = 'all';
			$section         = '';
			$special         = FALSE;
			$uri_segment     = 3;
			$url             = '';
		}

		$params['section']   = $product_section;
		if($product_section != 'all'){
			$params['sub_kategori'] = $this->db->get_where('category', array('parent_id' => $section))->result_array();
		}

     	$total_records  = $this->m_shop->get_total($special, $section);
        if ($total_records > 0)
        {	
        		

        		// pre($params["results"]);

            	$config['base_url']           = base_url() . 'shop/catalogue/'.$url;
				$config['total_rows']         = $total_records;
				$config['per_page']           = $limit_per_page;
				$config["uri_segment"]        = $uri_segment;
				$choice                       = $total_records / $limit_per_page;
				// custom paging configuration
				$config['num_links']          = floor($choice);
				$config['use_page_numbers']   = TRUE;
				$config['reuse_query_string'] = TRUE;
				
				$config['full_tag_open']      = '<ul class="pagination">';
				$config['full_tag_close']     = '</ul>';
				
				$config['first_link']         = '<span aria-hidden="true">&laquo;&laquo;</span>';
				$config['first_tag_open']     = '<li class="firstlink">';
				$config['first_tag_close']    = '</li>';
				
				$config['last_link']          = '<span aria-hidden="true">&raquo;&raquo;</span>';
				$config['last_tag_open']      = '<li class="lastlink">';
				$config['last_tag_close']     = '</li>';
				
				$config['next_link']          = '<span aria-hidden="true">&raquo;</span>';
				$config['next_tag_open']      = '<li class="nextlink">';
				$config['next_tag_close']     = '</li>';
				
				$config['prev_link']          = '<span aria-hidden="true">&laquo;</span>';
				$config['prev_tag_open']      = '<li class="prevlink">';
				$config['prev_tag_close']     = '</li>';
				
				$config['cur_tag_open']       = '<li class="numlink active"><span>';
				$config['cur_tag_close']      = '</span></li>';
				
				$config['num_tag_open']       = '<li class="numlink">';
				$config['num_tag_close']      = '</li>';
            	$this->pagination->initialize($config);

            	

				$params['page']    = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) - 1 : 0;
				// pre($limit_per_page);
				$params["results"] = $this->m_shop->get_current_page_records($limit_per_page, $params['page'], $special, $section);
				// pre($params['page']);
	            // build paging links
	            $params["links"] = $this->pagination->create_links();
        }
     
        $this->render_page('shop/itemlist', $params);
    }

	public function products($url=null, $color=null){
		if($url != null){
			if( $color != null ){
				$where    = array('ID_colorname'=> $color);
				$getcolor = $this->m_shop->checksome('color', $where)->row();
				$color    = $getcolor->ID_color;
			}
			$data['itemdetail']  = $this->m_shop->detailitem($url, $color);
			if($data['itemdetail']->num_rows() > 0){
				$item              = $data['itemdetail']->row();
				$data['data']      = $item;
				$data['coloritem'] = $this->m_shop->itemcolor($item->ItemCode);
				$data['sizeitem']  = $this->m_shop->ItemSizeStock($item->ItemCode, $color);
				// pre($data['coloritem']->result_array());

				if($item->ItemType == 1 || $item->ItemType == 2){
					$stock = $this->m_shop->itemStock($item->ItemCode, $item->color)->row();
				}else{
					// $cdeff = $this->m_shop->itemDefSize($item->ItemCode, $item->color)->row();
					// $data['deffsize']  = $cdeff->size;
					// $data['deffstock'] = $cdeff->stock;
					$stock = $this->m_shop->itemStock($item->ItemCode, $item->color, $item->size)->row();
				}
				$data['stock_item']    = $stock->stock;
				$data['other_product'] = $this->m_shop->relateditem($item->ID_item);
				$data['idmap']         = $item->ID_map;
				$this->render_page('shop/detail-products', $data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}	

	public function cart(){
		// pre($this->cart->contents());
		$this->render_page('shop/cart.php');
	}

	public function account(){
		$userData = array();
		// Check if user is logged in
		if($this->facebook->is_authenticated()){
			// Get user facebook profile details
			$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');

            // Preparing data for database insertion
			$userData['oauth_provider'] = 'facebook';
			$userData['oauth_uid']      = $userProfile['id'];
			$userData['first_name']     = $userProfile['first_name'];
			$userData['last_name']      = $userProfile['last_name'];
			$userData['email']          = $userProfile['email'];
			$userData['gender']         = $userProfile['gender'];
			$userData['locale']         = $userProfile['locale'];
			$userData['profile_url']    = 'https://www.facebook.com/'.$userProfile['id'];
			$userData['picture_url']    = $userProfile['picture']['data']['url'];
			
			// Insert or update user data
			$userID                     = $this->user->checkUser($userData);
			
			// Check user data insert or update status
            if(!empty($userID)){
                $data['userData'] = $userData;
                $this->session->set_userdata('userData',$userData);
                $session_admin = array(
				'id'         => $userID,
				'fname'      => $userData['first_name'],
				'email'      => $userData['email'],
				'login'      => true
				         );
				$this->session->set_userdata($session_admin);

            } else {
               $data['userData'] = array();
            }
			
			// Get logout URL
			$data['logoutUrl'] = $this->facebook->logout_url();
		}else{
            $fbuser = '';
			// Get login URL
            $data['authUrl'] =  $this->facebook->login_url();
        }



		if($this->session->userdata('login') == true){
			$segment         = $this->uri->segment(3);
			$data['users']   = $this->m_shop->userdata($this->session->userdata('id'));
			$data['account'] = $data['users']->row();
			if($segment == 'user-profile'){

				$data['province'] = $this->m_checkout->get_destination('propinsi');

				if($data['users']->num_rows() > 0){
					$this->render_page('shop/userprofile', $data);	
				}else{
					show_404();
				}
			}elseif($segment == 'user-password'){
				if($data['users']->num_rows() > 0){
				$this->render_page('shop/userpassword', $data);
				}else{
					show_404();
				}	
			}else{
				redirect(base_url().'shop/account/user-profile');
			}
		}else{
			$this->render_page('shop/account', $data);	
		}	
	}

	public function confirm_payment(){
		$data = array(
		 'captcha' => $this->recaptcha->getWidget(), 
         'script_captcha' => $this->recaptcha->getScriptTag(),
		);
		$data['bank'] = $this->m_settings->view_publish('bank');
		$this->render_page('shop/confirm-payment', $data);	
	}

	public function order_status(){
		if($this->session->userdata('login') == true){
			$where          = 'ID_users="'.$this->session->userdata('id').'" OR Email="'.$this->session->userdata('email').'"';
			$data['orders'] = $this->m_shop->checksome('orders', $where);
			$this->render_page('shop/order-status', $data);
		}else{
			$this->render_page('shop/order-status-form');
		}
	}

	public function order_detail($orderid = ''){
		$data['checkorder'] = $this->m_shop->checksome('orders', array('No_Orders' => $orderid));

		if($data['checkorder']->num_rows() > 0){
			$data['orders'] = $data['checkorder']->row();
			if($data['orders']->ID_users == 0 || $data['orders']->ID_users == $this->session->userdata('id')){
			$data['alamat'] = $this->m_shop->checksome('destination', array('ID' => $data['orders']->ShipAddress2))->row();
			$data['list']   = $this->m_shop->checksome('orders_list', array('No_Orders' => $orderid))->result();
				// pre($data['list']);
				$this->render_page('shop/order-detail', $data);
			}else{
				redirect(base_url('shop/account'));
			}
		}else{
			show_404();
		}	
	}

	public function processlog(){
			if($this->input->post('submitaccount') == 'weblogin'){
				$email = $this->input->post('emaillog');
				$passw = md5($this->input->post('passlog'));
				$cekuser = $this->m_checkout->get_users('email', $email);
				if($cekuser->num_rows() > 0){

					if (password_verify($passw, $cekuser->row()->password)) {
						$update          = array('modified'=>date('Y-m-d H:i:s'));
						$where           = "id='".$cekuser->row()->id."'";
						$updateuser      = $this->db->update('users', $update, $where);
						$session_admin = array(
							'id'         => $cekuser->row()->id,
							'fname'      => $cekuser->row()->first_name,
							'email'      => $cekuser->row()->email,
							'login'      => true
				            );
				        $this->session->set_userdata($session_admin);

					    $json['status']  = 1;
					    $json['loc']     = base_url().'shop/account/user-profile';
					} else {
					    $json['status']  = 0;
					    $json['alert']   = 'alert-warning';
						$json['message'] = 'Password salah';
					}
				}else{
					$json['status']  = 0;
					$json['alert']   = 'alert-warning';
					$json['message'] = 'Data tidak ditemukan';
				}
				echo json_encode($json);
			}
			if($this->input->post('submitaccount') == 'webregis'){
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$email = $this->input->post('email');
				$detim = date('Y-m-d H:i:s');
				$paswr = password_hash(md5($this->input->post('passwreg')), PASSWORD_DEFAULT);
				$cekuser = $this->m_checkout->get_users('email', $email);
				if($cekuser->num_rows() == 0){
				$datauser = array(
					'oauth_provider' => 'website',
					'password'   => $paswr,
					'first_name' => $fname,
					'last_name'  => $lname,
					'email'      => $email,
					'created'    => $detim,
					'modified'   => $detim 
					);
					$register = $this->db->insert('users', $datauser);
					if($register){ 

						$id = $this->db->query("SELECT id, email FROM users WHERE email='$email'")->row()->id;
						$session_admin = array(
						'id'         => $id,
						'fname'      => $fname,
						'email'      => $email,
						'login'      => true
					    );
					    $this->session->set_userdata($session_admin);
						$json['status']  = 1;
						$json['loc']     = base_url().'shop/account/user/';
					}else{ 
						$json['status']  = 0;
						$json['alert']   = 'alert-warning';
						$json['message'] = 'Database sibuk, coba beberapa saat lagi';
					}
				}else{
					$json['status']  = 0;
					$json['alert']   = 'alert-warning';
					$json['message'] = 'Email sudah dipakai';
				}
			echo json_encode($json);
			}
	}

	public function addtocart(){
		 if(IS_AJAX){
			$itemid  = decode64($this->input->post('item'));
			$size    = strtolower($this->input->post('size'));
			$qty     = $this->input->post('qty');
			$code    = decode64($this->input->post('hash'));
			$session = session_id();
			$check   = $this->m_shop->getItemMap($itemid, $code);
			//$json['isi'] = 'id:'.$itemid.' code:'.$code.' qty:'.$qty.' size:'.$size.' stock:'.$stockavail.' color:'.$item->color;
			if($check->num_rows() > 0){
			 	$item     = $check->row();
			 	$getstock = $this->m_shop->itemStock($code, $item->color, $size);

			 	if($getstock->num_rows() > 0){
			 		$stockavail = $getstock->row()->stock;
			 	}else{
			 		$stockavail = 0;
			 	}

			 	$flag = TRUE;
        		$dataTmp = $this->cart->contents();

		        foreach ($dataTmp as $itemS) {
		            if(isset($itemS['code'])){
		                if ($itemS['code'] == $code && $itemS['size'] == $size) {
    		                $qtyn = $itemS['qty'] + $qty;
    		                if($stockavail < $qtyn){
    		                	$flag = FALSE;
    		                }
    		            }
		            }
		            
		        }
        

			 	if($stockavail >= $qty && $flag){

					if($item->ItemDisc > 0){
						$sell = $item->ItemPrice-($item->ItemPrice*$item->ItemDisc)/100;
					}else{
						$sell = $item->ItemPrice;	
					}
                    $item_name_string_rep = str_replace(array('©', '@'),"-",$item->ItemName);
					$data = array(
						'id'        => $item->ID_item,
						'id_map'    => $itemid,
						'code'      => $code,
						'qty'       => $qty,
						'price'     => $sell,
						'name'      => $item_name_string_rep,
						'discount'  => $item->ItemDisc,
						'barcode'   => $item->barcode,
						'image'     => $item->image1,
						'price2'    => $item->ItemPrice,
						'size'      => $size, 
						'color'     => $item->color,
						'colorname' => (isset($item->ColorName)) ? $item->ColorName : '',
						'weight'    => $item->ItemWeight,
						'options'   => array('Size' => $size, 'Color' => $item->color)
					);

					$insertcart = $this->cart->insert($data);
					if($insertcart){
						$json['status']  = 1;
						$json['message'] = '<div class="alert alert-success" role="alert">Berhasil masuk keranjang!</div>';
					}else{
					    $json['data']  = $data;
					    $json['cart']  = $insertcart;
						$json['status']  = 0;
						$json['message'] = '<div class="alert alert-danger" role="alert">Gagal masuk keranjang! err-1</div>';
					}
				}else{
					$json['status']  = 0;
					$json['message'] = '<div class="alert alert-danger" role="alert">Stock tidak mencukupi!</div>';
				}
			}else{
				$json['status']  = 0;
				$json['message'] = '<div class="alert alert-danger" role="alert">Data tidak ditemukan</div>';
			}
			echo json_encode($json);
		}else{
			show_404();
		}
	}


	function badgecart(){
		echo $this->cart->total_items();
	}

	function delete_cart(){
		if(IS_AJAX){
		$rowid  = $this->input->post('rowid');
		$data   = array('rowid' => $rowid, 'qty' => 0 );
		$delete = $this->cart->update($data);
			if($delete){
				$json['status']  = 1;
				$json['message'] = '<div class="alert alert-success" role="alert">Berhasil hapus item!</div>';
			}else{
				$json['status']  = 0;
				$json['message'] = '<div class="alert alert-danger" role="alert">Gagal hapus item</div>';
			}
			echo json_encode($json);
		}else{
			show_404();
		}
	}

	function update_cart(){
		
		if(IS_AJAX){
			$rowid     = $this->input->post('rowid');
			$qty       = $this->input->post('qty');

			$data_cart = $this->cart->get_item($rowid);
			$getstock  = $this->m_shop->itemStock($data_cart['code'], $data_cart['color'], $data_cart['size'])->row_array();

			$total_qty = $qty;
			if($total_qty <= $getstock['stock']){
				$data   = array('rowid' => $rowid, 'qty' => $qty );
				$update = $this->cart->update($data);
					if($update){
						$json['status']  = 1;
					}else{
						$json['status']  = 0;
						$json['message'] = '<div class="alert alert-danger" role="alert">Gagal menambah item</div>';
					}
			}else{
				$json['status']  = 0;
				$json['message'] = '<div class="alert alert-danger" role="alert">Stock tidak mencukupi!</div>';
			}
			echo json_encode($json);
		}else{
			show_404();
		}
	}

	function cart_list(){
		$cartlist = '';
		// pre($this->cart->contents());
		
		if($this->cart->total_items() > 0){
		$cartlist .= '<h2 class="text-center">Cart</h2>
		<div class="row" style="padding-bottom: 49px;">
		<div class="col-sm-8 col-md-9">
		<div class="box-cart-list">
		<table class="cart-list">
		<caption><span>'.$this->cart->total_items().'</span> Item(s) in cart </caption>
			<thead>
			<tr>
			<th>Item</th>
			<th>Qty</th>
			<th>Total</th>
			<th></th>
			</tr>
			<tr><th colspan="4" height="2px" bgcolor="#000" style="padding: 0px;"></th></tr>
			</thead>
			<tbody>';
		$i = 1;
		foreach ($this->cart->contents() as $items) {
		$sizename = $this->db->get_where('size', array('ID_Size' => $items['size']))->row_array();
		$where = array(
			'barcode' => $items['barcode']
		);
		if(!empty($items['size'])){
			$where['size'] = $items['size'];
		}
		if(!empty($items['color'])){
			$where['color'] = $items['color'];
		}
		$stock    = $this->db->get_where('product_map_stock', $where)->row_array();
		$cartlist .= '<tr data-rowid="'.$items['rowid'].'">
			<td>
				<div class="media media-cart">
				  <div class="media-left">
				      <img class="media-object" src="'.base_url().'assets/image/product/'.$items['image'].'" alt="...">
				  </div>
				  <div class="media-body media-middle">
				    <h4 class="media-heading"><b>'.$items['name'].'</b></h4>
				    <span>Price : Rp. '.rupiah($items['price']).'</span><br>';
				    if(!empty($items['size'])):
				    $cartlist .= '<span>size : '.$sizename['Size'].'</span><br>';
					endif;
					if(!empty($items['color'])):
				    	$cartlist .= '<span>color : '.$items['colorname'].'</span>';
				    endif;
				    $cartlist .= '</div>
				</div>
			</td>
			<td>
			
			<div class="qty">
	        <div class="input-group number-spinner" data-max="'.$stock['stock'].'">
	        	<span class="input-group-btn">
				<div class="btn btn-default" data-dir="dwn"><i class="fa fa-minus"></i></div>
				</span>
	        <input style="z-index: 0;" type="text" class="form-control text-center updateqty" name="qtypro"  value="'.$items['qty'].'" readonly>
	        	<span class="input-group-btn">
				<div class="btn btn-default" data-dir="up"><i class="fa fa-plus"></i></div>
				</span>
	        </div>
	        </div>
			</td>
			<td>Rp. '.rupiah($items['price']*$items['qty']).'</td>
			<td><a href="javascript:void(0);" class="delete"><i class="fa fa-trash"></i></a></td>
			</tr>';
		 $i++; }
		 $cartlist .= '</tbody>
			</table>
			</div>';

			if(setting_value('min_pembelanjaan') > $this->cart->total()){
				$gratis_ongkir = setting_value('min_pembelanjaan') - $this->cart->total();
				$cartlist .= '<div class="alert alert-warning mt-5" role="alert">Belanja <strong>Rp.'.rupiah($gratis_ongkir).'</strong> lagi untuk mendapatkan <strong>Gratis</strong> ongkos kirim <i>(max. potongan Rp. '.rupiah(setting_value('max_potongan')).')</i>.</div>';
			}

		$cartlist .= '</div>
		<div class="col-sm-4 col-md-3">
			<div class="box-cart-info">
			<table>
			<caption><span>'.$this->cart->total_items().'</span> Item(s) in cart</caption>
				<tbody>
					<tr>
						<td>Total</td>
						<td>IDR '.rupiah($this->cart->total()).'</td>
					</tr>
					<tr>
						<td>Shipping</td>
						<td>IDR -,</td>
					</tr>
					<tr><td colspan="2"></td></tr>
					<tr><td colspan="2" style="border-top: 1px solid #d5d5d5; "></td></tr>
					<tr>
						<th>Sub Total</th>
						<th>IDR '.rupiah($this->cart->total()).'</th>
					</tr>
				</tbody>
			</table>
			<br>
			<div class="form-group">
			<a href="'.base_url().'checkout"><button class="btn btn-main btn-main-black">Checkout</button></a>
			</div>
			<a href="'.base_url().'shop"><button class="btn btn-main btn-main-white">Back</button></a>

			</div>
		</div>
		</div>'; 
		}else{
		$cartlist .= '<div class="row">
			<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 text-center">
			<div class="img-cart-empty">
			<img src="'.base_url().'assets/image/logo/empty-cart.png" style="max-width: 150px;">
			<br><br>
			<p><b>Oops! your cart is empty. &nbsp; Lets Shopping Now!</b></p>
			</div>
			<hr>
			
			<a href="'.base_url('shop/catalogue').'" class="btn btn-main btn-main-black btn-def">Belanja Sekarang</a>
			</div>
		</div>';
		}
		echo $cartlist;
	}


	public function logout(){
	    $this->session->sess_destroy();
	    redirect(base_url());
  	}
  	
  
  	public function faq(){
  		$this->render_page('shop/faq');
  	}

  	public function tracking($job = ''){
        
        
        if(!empty($job)){   
  		$this->load->library('job');
		$method = 'POST';
		$action = 'job/checkawb';
		$header = array('Content-Type:application/x-www-form-urlencoded', 'Accept:application/json', 'User-Agent:'.get_user_agent());
		$parameter = array(
			'username' => setting_value('JNE_API_USERNAME'),
			'api_key'  => setting_value('JNE_API_PASSWORD'),
			'JOB'      => $job,
		);

		$result = $this->job->request($action, $method, $header, $parameter);
		$data['tracking_status'] = FALSE;
// 		pre($result);
		if(!empty($result['status'])){
			$data['status'] = $result['reason'];
		}else{
			if(!empty($result['Cnote_No'])){
			    $register = $this->register_awb($result['Cnote_No'], $job);
			 //   pre($register);
			    if($register['status'] == 'Success' || $register['reason'] == 'Sorry, Airwaybill already registered'){
			        $data['tracking_status'] = TRUE;
				    $data['tracking'] = $this->listtracking($result['Cnote_No']); 
			    }else{
			        $data['status'] = 'Tracking Orders is not ready';
			    }
			}else{
				$data['status'] = 'AWB number is not ready';
			}
		}
        }else{
			$data['status'] = 'JOB Number is empty';
		}


  		$this->render_page('shop/tracking', $data);
  	}

  	public function register_awb($awb, $order){
  	    $this->load->library('job');
		$method = 'POST';
		$action = 'cnoteretails/';
		$header = array('Content-Type:application/x-www-form-urlencoded', 'Accept:application/json', 'User-Agent:'.get_user_agent());
		$parameter = array(
			'username'   => setting_value('JNE_API_USERNAME'),
			'api_key'    => setting_value('JNE_API_PASSWORD'),
			'ORDER_ID'   => $order,
			'AWB_NUMBER' => $awb,
		);
		$result = $this->job->request($action, $method, $header, $parameter);
		return $result;
  	}


  	public function listtracking($awb){
  		$this->load->library('jne');
		$method = 'POST';
		$action = 'list/cnoteretails/cnote/'.$awb;
		$header = array('Content-Type:application/x-www-form-urlencoded', 'Accept:application/json', 'User-Agent:'.get_user_agent());
		$parameter = array(
			'username' => setting_value('JNE_API_USERNAME'),
			'api_key'  => setting_value('JNE_API_PASSWORD'),
		);

		$result = $this->jne->request($action, $method, $header, $parameter);
// 		pre($result);
		return $result;
  	}

  	function userprofile_edit(){
  		if($this->session->userdata('login') == true){
  			$userid = $this->session->userdata('id');
  			$fname  = $this->input->post('fname');
  			$lname  = $this->input->post('lname');
  			$phone  = $this->input->post('phone');
  			$addre  = $this->input->post('address');
  			$area   = $this->input->post('csubdist');
  			$postc  = $this->input->post('postc');
  			$areao  = $this->input->post('edituser');
  			if(! empty($area)){
  				$are = $area;
  			}else{
  				$are = $areao;
  			}
  			$dataedit = array(
  				'first_name' => $fname,
  				'last_name'  => $lname,
  				'address'    => $addre,
  				'area'       => $are,
  				'postcode'   => $postc,
  				'phone'      => $phone
  				);
  			
  			$edituser = $this->db->update('users', $dataedit, array('id' => $userid));
  			if($edituser){
				$json['status']  = 1;
				$json['alert']   = 'alert-success';
				$json['message'] = 'Profile berhasil diperbaharui';
			}else{
				$json['status']  = 0;
				$json['alert']   = 'alert-warning';
				$json['message'] = 'Gagal perbaharui profile';
			}
			echo json_encode($json);
  		}else{
  			show_404();
  		}
  	}


  	public function csrf(){
  		$this->render_page('shop/csrf');
  	}

  	public function search_key()
  	{
  		$post = $this->input->post();
  		if($post){
  			$key    = input_clean($post['key']);
  			redirect(base_url('shop/search/'.$key));
  		}else{
  			show_404();
  		}
  	}

  	public function search($key){

  			$key = input_clean(urldecode($key));
  			$query = $this->db
	  		->like('kategori', $key, 'both')
	  		->or_like('special_type', $key, 'both')
	  		->get('category')->result_array();
	  		$category = array();
	  		foreach ($query as $i => $value) {
	  			array_push($category, $value['ID_cat']);
	  		}

	  		$this->db->where(array('p.publish' => '11', 'pm.status' => '11'));
	  		$this->db->group_start();
	  		if(count($category) > 0){
	  			for ($i=0; $i < count($category); $i++) { 
	  				$this->db->or_where("FIND_IN_SET($category[$i], ItemSubcate) > 0");
	  			}
	  		}
  			$search = $this->db
  			->join('product_map pm', 'pm.item_code=p.ItemCode')
  			->join("color c", "c.ID_color=pm.color", "left")
  			->or_like('p.ItemCode', $key, 'both')
  			->or_like('p.ItemName', $key, 'both')
  			->or_like('p.ItemNmDesc', $key, 'both')
  			->group_end()
  			->get('products p')->result_array();

  			$data = array(
  				'key'     => $key,
  				'results' => $search
  			);
  			$this->render_page('shop/search', $data);
  		
  	}

} 
