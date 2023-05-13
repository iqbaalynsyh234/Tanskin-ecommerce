<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Return_order extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library('cart');
		$this->load->model('model_return');
	}

	public function form($invoice = ''){
		$this->form_validation->set_rules('invoice_number', 'Invoice', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data = array(
				'data_list'  => $this->model_return->get_list($invoice),
				'no_invoice' => $invoice,
				'list_no'    => $this->model_return->list_no_invoice(),
				'product'    => $this->model_return->list_product(),
				'order_temp' => $this->model_return->list_temp($invoice),
			);
			if(empty($invoice)){
				$this->model_return->del_temp();
			}
			// pre($data['order_temp']);
			$this->temp_admin('admin/return/return_order', $data);
		}
		else
		{
			$insert = $this->model_return->submit_form();

			if($insert){
				$this->session->set_flashdata('alert_success', 'Successfully');
			}else{
				$this->session->set_flashdata('alert_errors', 'Error');
			}

			redirect(base_url('admin/return-order/form'));
		}
	}
	

	public function invoice(){
		if($this->input->post()){
			$post = $this->input->post();
			redirect(base_url('admin/return-order/form/'.input_clean($post['no_invoice'])));
		}else{
			show_404();
		}
	}

	public function modal_item($noorder){
		$post = $this->input->post();
		if($post){

			$return = array(
				'no_transaksi' => $noorder,
				'id_barang'    => input_clean($post['id_return']),
				'qty'          => input_clean($post['qty']),
				'status'       => 1
			);
			$this->db->insert('pos_return_temp', $return);

			if(!empty($post['item_change']) || $post['item_change']){
				$change = array(
					'no_transaksi' => $noorder,
					'id_barang'    => input_clean($post['item_change']),
					'qty'          => input_clean($post['qty']),
					'status'       => 2
				);
				$this->db->insert('pos_return_temp', $change);
			}

			redirect(base_url('admin/return-order/form/'.$noorder));
		}else{
			show_404();
		}
	}
}