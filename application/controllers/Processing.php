<?php 
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Processing extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library(array('session', 'pagination', 'cart', 'facebook', 'recaptcha'));
		$this->load->model(array('checkout/m_checkout', 'shop/m_shop', 'entersite/m_entersite'));
	}

	function atlas_ch_password(){
	if($this->session->userdata('login') == true){
		$id     = $this->session->userdata('id');
		$pass   = md5($this->input->post('pass_old'));
		$pass_n = $this->input->post('pass_new');
		$pass_r = $this->input->post('pass_new_r');

		$check  = $this->m_shop->checksome('users', array('id' => $id));
		if($check->num_rows() > 0){
			if (password_verify($pass, $check->row()->password)){
				
				if($pass_n == $pass_r){
				$newpass = password_hash(md5($pass_n), PASSWORD_DEFAULT);

				$update  = $this->m_shop->ch_password(array('id' => $id), array('password' => $newpass));
					if($update == 'ok'){
						$json['message'] = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Berhasil Merubah Password</div>';
					}else{
						$json['message'] = '<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Gagal Merubah Password</div>';
					}
				
				}else{
				$json['message'] = '<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Password baru salah / tidak sesuai</div></div>';
				}
			}else{
				$json['message'] = '<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Password salah!</div>';
			}
		}else{
			$json['message'] = '<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Account tidak ditemukan!</div>';
		}
	}else{
		$json['message'] = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Akses ditolak!</div>';
	}
	echo json_encode($json);
	}

	function atlas_confirm_payment(){
		if($this->input->post('confirm') != null){

			$no_order  = $this->input->post('no_order');
			$email     = $this->input->post('email');
			$paymeth   = $this->input->post('paymeth');
			$account   = $this->input->post('account');
			$payment   = $this->input->post('pay');
			$file_name = 'confirm-order-'.$no_order.'-time-'.date('YmdHis');

			$path                    = './assets/image/confirm/';
			$config['upload_path']   = $path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name']     = $file_name.$config['file_ext'];

        	$this->load->library('upload', $config);

			$recaptcha = $this->input->post('g-recaptcha-response');
        	$response  = $this->recaptcha->verifyResponse($recaptcha);
        	if(!isset($response['success']) || $response['success'] <> true){
        		$message = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Recaptcha is required!</div>';
        	}else{
        		if(!empty($_FILES['imagemain']['name'])){
	        		if ($this->upload->do_upload('imagemain')){
					$gbr                      = $this->upload->data();
					$width      = $gbr['image_width'];
					$height     = $gbr['image_height'];
					$new_width  = $width / ($width/500);
					$new_height = $height / ($width/500);
					
					//Compress Image
					$config['image_library']  ='gd2';
					$config['source_image']   = $path.$gbr['file_name'];
					$config['create_thumb']   = FALSE;
					$config['maintain_ratio'] = FALSE;
					$config['quality']        = '50%';
					$config['width']          = $new_width;
					$config['height']         = $new_height;
					$config['new_image']      = $path.$gbr['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					
					$gambar                   = $file_name.$gbr['file_ext'];
					
					$dataup = array(
					'no_order'   => $no_order,
					'email'      => $email,
					'PaymentMet' => $paymeth,
					'rekening'   => $account,
					'pay'        => $payment,
					'bukti_pay'  => $gambar,
        			);

	        		$confirm = $this->m_shop->atlas_confirm_payment($dataup);
	        		if($confirm['status'] == '1'){
	        			$message = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$confirm['pesan'].'</div>';
	        		}else{
	        			$message = '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'.$confirm['pesan'].'</div>';
	        		}
					
	            	}else{
	            		$message = '<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Error upload Image!</div>';
	            	}
	        	}else{
	        		$message = '<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Image is required!</div>';
	        	}
        		
        	}
        	$this->session->set_flashdata('alert_flash', $message);
        	redirect('shop/confirm-payment');
		}else{
			show_404();
		}
	}

	function atlas_subscribe(){
		if($this->input->post('field_0556') != null){
			$data  = array(
				'email'       => $this->input->post('field_0556'),
				'sub_date'    => date('Y-m-d'),
				'follow_mail' => 'yes'
			);
			$query = $this->m_shop->insert($data, 'subscriber');
			if ($query == 'ok') {
				$message = '<div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Selamat! Email anda telah terdaftar.</div>';
			} elseif ($query == 'ada') {
				$message = '<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Email ini sudah terdaftar.</div>';
			} else {
				$message = '<div class="alert alert-warning alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Gagal menghubungi database.</div>';
			}
			$this->session->set_flashdata('alert_flash', $message);
        	redirect(base_url());
		}else{
			show_404();
		}
	}


}
?>