<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Voucher extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->model(array('model_voucher'));
	}

	public function voucher_used(){
		$data = array(
			'list' => $this->model_voucher->list_used_voucher()
		);
		$this->temp_admin('admin/voucher/voucher_used', $data);
	}

	public function template_voucher(){
		$data = array(
			'list' => $this->model_voucher->list_template()
		);
		$this->temp_admin('admin/voucher/template_list', $data);
	}

	public function template_add(){
		$this->form_validation->set_rules('disc', 'Discount', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data = array();
			$this->temp_admin('admin/voucher/template_add', $data);
		}
		else{
			if($_FILES['image']['name'] != ''){
				$path       = $_FILES['image']['name'];
				$ext        = pathinfo($path, PATHINFO_EXTENSION);
			}else{
				$ext        = 'jpg';
			}
			if($ext == 'jpg'){
				$template = $this->model_voucher->add_template();
				if($template){
					$this->session->set_flashdata('alert_success', 'Successfully added');
				}else{
					$this->session->set_flashdata('alert_errors', 'Error');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Image Extension must be JPG format');
			}

			redirect(base_url().'admin/voucher/template_voucher');
		}
	}

	public function template_edit($id){
		$this->form_validation->set_rules('disc', 'Discount', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$row  = $this->db->get_where('voucher_temp', array('ID' => $id));
			if($row->num_rows() > 0){
				$data = array(
					'row' => $row->row_array()
				);
				$this->temp_admin('admin/voucher/template_edit', $data);
			} 
			else{
				$this->session->set_flashdata('alert_errors', 'no data');
				redirect(base_url().'admin/voucher/template_voucher');
			}
		}
		else{
			if($_FILES['image']['name'] != ''){
				$path       = $_FILES['image']['name'];
				$ext        = pathinfo($path, PATHINFO_EXTENSION);
			}else{
				$ext        = 'jpg';
			}
			if($ext == 'jpg'){
				$template = $this->model_voucher->edit_template();
				if($template){
					$this->session->set_flashdata('alert_success', 'Successfully Edit');
				}else{
					$this->session->set_flashdata('alert_errors', 'Error');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Image Extension must be JPG format');
			}


			redirect(base_url().'admin/voucher/template_voucher');
		}
	}

	public function delete_template($id){
		$where = array('ID' => $id);
		$this->db->delete('voucher_temp', $where);
		redirect(base_url().'admin/voucher/template_voucher');
	}

	function template(){
		create_image(readable_random_string(4).rand(10,100), date('Y-m-d'), 'template_20210630.jpg');
	}

	function barcode_qrcode($id){

		$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
		echo $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);
		redirect(base_url().'admin/barcode');
	 }
	// public function test_email(){
		   		/*$temp_voucher = $this->db->get_where('voucher_temp', array('publish' => 1));
		   		if($temp_voucher->num_rows() > 0){
		   			$data_voucher = $temp_voucher->row_array();
			   		$voucher = array(
						'ID_member'     => 1,
						'voucher_code'  => readable_random_string(4).rand(10,100),
						'voucher_value' => $data_voucher['voucher_value'],
						'start'         => date('Y-m-d'),
						'end'           => date('Y-m-d', strtotime(date('Y-m-d'). '+14 Days'))
			   		);

			   		$this->db->insert('voucher_temp_list', $voucher);
			   		$email_data = array(
						'to'            => 'ghomiefade@gmail.com',
						'title'         => "Vocher Belanja di ".setting_value('site_name'),
						'subject'       => "Vocher Belanja di ".setting_value('site_name'),
						'to_name'       => setting_value('site_name'),
						'from'          => setting_value('email'),
						'name'          => setting_value('site_name'),
						'reply_to'      => setting_value('email'),
						'reply_to_name' => setting_value('site_name'),
					);

					create_image($voucher['voucher_code'], $voucher['start'], $data_voucher['template']);

					$message = '<img style="width: 100%" src="'.base_url('assets/image/voucher/voucher_'.$voucher['voucher_code'].'.jpg').'">';
					$email_data['message'] = $message;

					$asd = sendemail($email_data);
					echo 'finish';
		   		}*/
		   		
	// }

	
}