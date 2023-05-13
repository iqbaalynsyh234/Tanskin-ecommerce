<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_voucher extends CI_Model {

	function list_used_voucher(){
		$query = $this->db
		->select('v.*, u.first_name, u.last_name, u.email, u.phone')
		->join('users u', 'u.id = v.ID_member', 'LEFT')
		->get_where('voucher_temp_list v')->result_array();
		return $query;
	}

	function list_template(){
		$query = $this->db
		->get('voucher_temp')->result_array();
		return $query;
	}

	function add_template(){
		$post = $this->input->post();

		$image_name = FALSE;
		if($_FILES['image']['name'] !== '' ){
			$folder     = 'assets/image/voucher';
			$info       = file_import('image', $folder, 'template_'.date('Ymd'));
			$image_name = $info['file_name'];
		}

		if($image_name != FALSE){
			$input = array(
				'template'      => $image_name,
				'voucher_value' => rupiah_to_number(input_clean($post['disc'])),
				'publish'       => input_clean($post['publish']),
				'date_add'      => date('Y-m-d H:i')
			);
			$this->db->insert('voucher_temp', $input);
			$id = $this->db->insert_id();
			if($post['publish'] == '1'){
				
				$res  = $this->db->get_where('voucher_temp', array('ID !=' => $id, 'publish' => '1'))->result_array();
				foreach ($res as $key => $value) {
					$update = array('publish' => '0');
					$this->db->update('voucher_temp', $update, array('ID' => $value['ID']));
				}
				
			}
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	function edit_template(){
		$post = $this->input->post();

		$row  = $this->db->get_where('voucher_temp', array('ID' => $post['id']))->row_array();
		
		if($_FILES['image']['name'] !== '' ){
			$folder     = 'assets/image/voucher';
			$info       = file_import('image', $folder, 'template_'.date('Ymd'));
			$image_name = $info['file_name'];
		}else{
			$image_name = $row['template'];
		}

		if($image_name != FALSE){
			
			$input = array(
				'template'      => $image_name,
				'voucher_value' => rupiah_to_number(input_clean($post['disc'])),
				'publish'       => input_clean($post['publish'])
			);
			$this->db->update('voucher_temp', $input, array('ID' => $post['id']));
			if($post['publish'] == '1'){
				
				$res    = $this->db->get_where('voucher_temp', array('ID !=' => $post['id'], 'publish' => '1'))->result_array();
				foreach ($res as $key => $value) {
					$update = array('publish' => '0');
					$this->db->update('voucher_temp', $update, array('ID' => $value['ID']));
				}
			}
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}