<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model{
	function __construct() {
		$this->tableName  = 'users';
		$this->primaryKey = 'id';
	}
	public function checkUser($data = array()){
		$this->db->select($this->primaryKey);
		$this->db->from($this->tableName);
		$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
		
		if($prevCheck > 0){
			$prevResult = $prevQuery->row_array();
			$data['modified'] = date("Y-m-d H:i:s");
			$update = $this->db->update($this->tableName,$data,array('id'=>$prevResult['id']));
			$userID = $prevResult['id'];
		}else{
			$data['created']  = date("Y-m-d H:i:s");
			$data['modified'] = date("Y-m-d H:i:s");
			$insert = $this->db->insert($this->tableName,$data);
			$userID = $this->db->insert_id();
		}

		return $userID?$userID:FALSE;
    }

    function get_staticpage($where = array(), $results = FALSE){
    	$target  = array('p.publish' => '11');

    	if(!empty($where)){
			foreach ($where as $key => $value) {
				$target[$key] = $value;
			}
		}

		$this->db->select('*');
		$this->db->join('kategori_tambahan kt', 'kt.id=p.kategori');
		$this->db->order_by('p.section', 'asc');
		$data =  $this->db->get_where('static_page p', $target);

		if($results){
			return $data->result_array();
		}else{
			return $data->row_array();
		}
    }

    function get_page($table, $where = array(), $results = FALSE){
    	if(!empty($where)){
			foreach ($where as $key => $value) {
				$target[$key] = $value;
			}
		}
		$this->db->select('*');
		$data =  $this->db->get_where($table, $target);

		if($results){
			return $data->result_array();
		}else{
			return $data->row_array();
		}
    }

    function get_products($where = array(), $limit = '', $sort = array(), $results = FALSE){
    	if(!empty($where)){
			foreach ($where as $key => $value) {
				$target[$key] = $value;
			}
		}
		$this->db->select('*, pm.price as ItemPrice, pm.disc as ItemDisc');
		if(!empty($limit)){
			$this->db->limit($limit);
		}
		if(!empty($sort)){
			$this->db->order_by($sort[0], $sort[1]);
		}
		$this->db->join('product_map pm', 'pm.item_code=p.ItemCode', 'left');
		$this->db->join('color c', 'c.ID_color=pm.color', 'left');
		$data =  $this->db->get_where('products p', $target);

		if($results){
			return $data->result_array();
		}else{
			return $data->row_array();
		}
    }
}
