<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_admin extends CI_Model {

	function get_list(){
		$query = $this->db->get_where('admin');
		return $query->result_array();
	}

	function add_admin(){
		$post  = $this->input->post();
		$row   = $this->db->get_where('admin', array('email_admin' => input_clean($post['email'])))->num_rows();
		if($row == 0){
			$input = array(
				'user_admin'  => input_clean($post['name']),
				'email_admin' => input_clean($post['email']),
				'password'    => encyript_password(input_clean($post['password'])),
				'akses1'      => (!empty($post['akses_1'])) ? '11' : '01',
				'akses2'      => (!empty($post['akses_2'])) ? '11' : '01',
				'akses3'      => (!empty($post['akses_3'])) ? '11' : '01',
				'akses4'      => (!empty($post['akses_4'])) ? '11' : '01',
				'akses5'      => (!empty($post['akses_5'])) ? '11' : '01',
				'del_akses'   => (!empty($post['del_akses'])) ? '11' : '01',
				'crated'      => date('Y-m-d H:i:s'),
				'modifiedate' => date('Y-m-d H:i:s'),
				'status'      => '11',
			);

			$insert = $this->db->insert('admin', $input);
			if($insert){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function update_admin($id){
		$post  = $this->input->post();
		$row   = $this->db->get_where('admin', array('id_admin' => input_clean($id)));
		if($row->num_rows() > 0){
			$row = $row->row_array();
			$password = (!empty($post['password'])) ? encyript_password(input_clean($post['password'])) : $row['password'];
			$input = array(
				'user_admin'  => input_clean($post['name']),
				'email_admin' => input_clean($post['email']),
				'password'    => $password,
				'akses1'      => (!empty($post['akses_1'])) ? '11' : '01',
				'akses2'      => (!empty($post['akses_2'])) ? '11' : '01',
				'akses3'      => (!empty($post['akses_3'])) ? '11' : '01',
				'akses4'      => (!empty($post['akses_4'])) ? '11' : '01',
				'akses5'      => (!empty($post['akses_5'])) ? '11' : '01',
				'del_akses'   => (!empty($post['del_akses'])) ? '11' : '01',
				'modifiedate' => date('Y-m-d H:i:s'),
				'status'      => $post['status']
			);

			$update = $this->db->update('admin', $input, array('id_admin' => input_clean($id)));
			if($update){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
}