<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Administator extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->model(array('model_admin'));
	}

	public function index(){
		$data['admin'] = $this->model_admin->get_list();
		$this->temp_admin('admin/member/admin', $data);
	}

	public function add(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		if ($this->form_validation->run() == TRUE)
		{
			$insert = $this->model_admin->add_admin();
			if($insert){
				$this->session->set_flashdata('alert_success', 'Successfully added');
			}
			else{
				$this->session->set_flashdata('alert_errors', 'Error when contacting database');
			}
			redirect(base_url('admin/administator'));
		}
		else
		{
			$data = array();
			$this->temp_admin('admin/member/admin_add', $data);
		}
	}

	public function view($id){
		$row = $this->db->get_where('admin', array('id_admin' => $id));
		if($row->num_rows() > 0){
			$this->form_validation->set_rules('name', 'Name', 'required');
			if ($this->form_validation->run() == TRUE)
			{
				$update = $this->model_admin->update_admin($id);
				if($update){
					$this->session->set_flashdata('alert_success', 'Successfully update');
				}
				else{
					$this->session->set_flashdata('alert_errors', 'Error when contacting database');
				}
				redirect(base_url('admin/administator'));
			}
			else
			{
				$data['row'] = $row->row_array();
				$this->temp_admin('admin/member/admin_view', $data);
			}
		}else{
			redirect(base_url('admin/administator'));
		}
	}
	
// 	public function cek_out_list(){
// 	    $query = $this->db->
// 	    select('CAST(p.date_purchased AS DATE) AS DATE_PURCHASED')
// 	    ->join('pos_list pl', 'pl.no_transaksi = p.no_transaksi', 'left')
// 	    ->where(array('' => '2021-'))
// 	    ->get('pos p')->result_array();
// 	}
}