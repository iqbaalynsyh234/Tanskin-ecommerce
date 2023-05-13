<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_settings extends CI_Model {
	//insert
	function insert($data, $table){
		$this->db->where($data);
		$query = $this->db->get($table);
		if($query->num_rows() == 0){
			if($this->db->insert($table, $data)){
				$message = 'ok';
				return $message;
			}else{
				$message = 'err';
				return $message;
			}
		}else{
			$message = 'ada';
			return $message;
		}
	}
	//update
	function update($data, $table, $where){
		$this->db->where($data);
		$query = $this->db->get($table);
		if($query->num_rows() == 0){
			$this->db->where($where);
			if($this->db->update($table, $data, $where)){
				$message = 'ok';
				return $message;
			}else{
				$message = 'err';
				return $message;
			}
		}else{
			$message = 'noupdate';
			return $message;
		}
	}
	//view all
	function view ($table, $by = NULL){
		$this->db->order_by($by, 'desc');
		return $this->db->get($table);
	}
	//view where
	function view_where ($table, $where){
		$this->db->select('*');
		$this->db->where($where);
		return $this->db->get($table);
	}
	//delete
	function delete($where, $table){
		$this->db->where($where);
		if($this->db->delete($table)){
			return true;
		}else{
			return false;
		}
	}
	// view data publish
	function view_publish($table){
		$this->db->where('publish', '11');
		return $this->db->get($table);
	}

	//delete 2 from table
	function delete_2table($table1, $table2, $where1, $where2){
		if($this->db->delete($table1, $where1)){
		   $this->db->delete($table2, $where2);
		   return true;
		}else{
		   return false;
		}
	}
	
}
