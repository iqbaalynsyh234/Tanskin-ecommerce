<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_return extends CI_Model {

	public function get_list($no_invoice = ''){
		$where = array(
			'table_packing !=' => 0
		);

		if(!empty($no_invoice)){
			$where['no_transaksi'] = $no_invoice;
		}

		$query = $this->db->get_where('pos', $where)->row_array();
		if(!empty($no_invoice)){
			$data  = array(
				'pos_list' => $this->db->join('product_map_stock pms', 'pms.barcode=pl.barcode', 'LEFT')
				->join('products p', 'p.ID_item=pms.id_product', 'LEFT')->get_where('pos_list pl', array('pl.no_transaksi' => $no_invoice))->result_array()
			);
		}else{
			$data  = array();
		}
		
		return $data;
	}

	public function list_no_invoice(){
		$query = $this->db->select('Note, no_transaksi')->get_where('pos', array('table_packing' => 0))->result_array();
		return $query;
	}

	public function list_product(){
		$query = $this->db
		->select('pms.*, p.ItemName, p.ItemCode, s.Size as sizename, c.ColorName as colorname')
		->join('products p', 'p.ID_item = pms.id_product', 'LEFT')
		->join('color c', 'c.ID_color = pms.color', 'LEFT')
		->join('size s', 's.ID_size = pms.size', 'LEFT')
		->get_where('product_map_stock pms', array('pms.stock >' => 0))->result_array();
		return $query;
	}

	public function no_transaksi(){
	    $this->db->select('*');
	    $this->db->order_by('no_exchange', 'DESC');    
	    $this->db->limit(1);     
	    $query = $this->db->get('pos_list');  
	      
	    if($query->num_rows() <> 0){       
	       $data = $query->row_array(); 
	       $subs = substr($data['no_exchange'], -5);     
	       $kode = intval($subs) + 1;   
	    }
	    else{       
	       $kode = 1;  
	    }
	    $kodemax  = str_pad($kode, 5, "0", STR_PAD_LEFT);    
	 
	    $kodejadi = date('ymd').$kodemax;

	    return $kodejadi;  
  	}

	public function list_temp($invoice = ''){
		$query = $this->db
		->select('pms.*, p.ItemName, p.ItemCode, s.Size as sizename, c.ColorName as colorname, t.qty as qty_temp, t.status')
		->join('product_map_stock pms', 'pms.ID_ms = t.id_barang', 'LEFT')
		->join('products p', 'p.ID_item = pms.id_product', 'LEFT')
		->join('color c', 'c.ID_color = pms.color', 'LEFT')
		->join('size s', 's.ID_size = pms.size', 'LEFT')
		->get_where('pos_return_temp t', array('t.no_transaksi' => $invoice))->result_array();
		foreach ($query as $key => $value) {
			$row = $this->db->get_where('product_map', array('barcode' => $value['barcode'], 'color' => $value['color']))->row_array();
			$query[$key]['price'] = $row['price'];
		}
		return $query;
	}

	public function submit_form(){
		$post = $this->input->post();
		if($post){
			$row = $this->list_temp($post['invoice_number']);
			foreach ($row as $key => $value) {
				$status = ($value['status'] == 1) ? '-' : '';
				$data = array(
					'no_transaksi' => $post['invoice_number'],
					'no_exchange'  => 'XR-'.$this->no_transaksi(),
					'id_barang'    => $value['ID_ms'],
					'barcode'      => $value['barcode'],
					'qty'          => $status.$value['qty_temp'],
					'price'        => $value['price'],
					'total'        => $value['price'] * $value['qty_temp']
				);
				
				$this->db->insert('pos_list', $data);
			}
			$this->db->delete('pos_return_temp', array('no_transaksi' => $post['invoice_number']));
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function del_temp(){
		$this->db->delete('pos_return_temp', array('no_transaksi !=' => ''));
	}
}