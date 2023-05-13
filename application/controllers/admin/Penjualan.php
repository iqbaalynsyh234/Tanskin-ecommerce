<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Penjualan extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->model(array('model_penjualan', 'entersite/m_entersite'));
	}

	public function detail($id = ''){
		$this->form_validation->set_rules('id', 'id', 'required');
		if ($this->form_validation->run() == TRUE){
			$data['detail'] = $this->model_penjualan->get_detail($id);
			$data['id']     = $id;
			// pre($data['detail']);
			$this->temp_admin('admin/orders/pos_detail', $data);
		}
		else{
			$post = $this->input->post();

			$row  = $this->db->get_where('pos', array('id' => $post['id']));
			if($row->num_rows() > 0){
				$packing = $this->m_entersite->packing($row->row_array());
				$this->session->set_flashdata('alert_success', 'Berhasil');
			}
			else{
				$this->session->set_flashdata('alert_errors', 'Daftar tidak ditemukan!');
			}
			redirect(base_url('admin/penjualan/detail/'.$id));
		}

	}
}