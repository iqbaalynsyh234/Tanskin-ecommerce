<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_checkout extends CI_Model{

	function get_users($where, $key){
		$this->db->where($where, $key);
		return $this->db->get('users');
	}

	function get_shipping($shipid){
		$this->db->where('ID', $shipid);
		return $this->db->get('pengiriman');
	}

	function list_shipping($groupby){
		$this->db->group_by($groupby);
		return $this->db->get('pengiriman');
	}

	function search_city($prov){
		$this->db->where('propinsi', $prov);
		$this->db->group_by('kabupaten');
		return $this->db->get('pengiriman');
	}

	function search_district($prov, $city){
		$this->db->where('propinsi', $prov);
		$this->db->where('kabupaten', $city);
		$this->db->group_by('kecamatan');
		return $this->db->get('pengiriman');
	}

	function get_address($id){
		$this->db->where('ID', $id);
		return $this->db->get('destination');
	}

	function no_transaksi(){
		date_default_timezone_set('Asia/Jakarta');
		$this->db->select('*, LEFT(orders.ID_orders,3) as kode', FALSE);
		$this->db->order_by('ID_orders','DESC');    
		$this->db->limit(1);     
		$query = $this->db->get('orders');    
		if($query->num_rows() <> 0){       
		   $data = $query->row(); 
		   $subs = substr($data->ID_orders, -3);     
		   $kode = intval($subs) + 1;   
		}
		else{       
		   $kode = 1;  
		}
		$kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);    
		$kodejadi = date('ymdH').$kodemax; 

		return $kodejadi;  
	}

	function get_destination($groupby){
		$query = $this->db->group_by($groupby)->get('destination')->result_array();
		return $query;
	}

	function get_destination_bycity($city){
		$query = $this->db->group_by("kabupaten")->where(array("propinsi" => $city))->get('destination')->result_array();
		return $query;
	}

	function get_destination_bydistrict($prov, $city){
		$query = $this->db->group_by("kecamatan")->where(array("propinsi" => $prov, "kabupaten" => $city))->get('destination')->result_array();
		return $query;
	}

	function get_destination_bysubdistrict($prov, $city, $district){
		$query = $this->db->where(array("propinsi" => $prov, "kabupaten" => $city, "kecamatan" => $district))->get('destination')->result_array();
		return $query;
	}

	
}
?>