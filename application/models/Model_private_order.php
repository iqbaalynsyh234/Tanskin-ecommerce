<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_private_order extends CI_Model {

	public function item_list($id = '', $results = TRUE){
		$where = array(
			'stock !=' => 0,
		);
		if(!empty($id)){
			$where['ID_ms'] = $id;
		}

		$query = $this->db
		->select('pms.*, p.ItemName, p.ItemCode, p.ItemWeight, s.Size as sizename, c.ColorName as colorname')
		->join('color c', 'c.ID_color = pms.color', 'LEFT')
		->join('size s', 's.ID_size = pms.size', 'LEFT')
		->join('products p', 'p.ID_item = pms.id_product', 'LEFT')
		->get_where('product_map_stock pms', $where);

		if($results){
			$data_item = $query->result_array();
			foreach ($data_item as $key => $value) {
				$data = $this->db->get_where('product_map', array('barcode' => $value['barcode']))->row_array();
				if(!empty($data)){
					$data_item[$key]['price'] = $data['price'];
					$data_item[$key]['disc']  = $data['disc'];
				}
				else{
					$data_item[$key]['price'] = 0;
					$data_item[$key]['disc']  = 0;
				}
			}
		}else{
			$data_item = $query->row_array();
			$data = $this->db->get_where('product_map', array('barcode' => $data_item['barcode']))->row_array();
			if(!empty($data)){
				$data_item['price']  = $data['price'];
				$data_item['disc']   = $data['disc'];
			}
			else{
				$data_item['price'] = 0;
				$data_item['disc']  = 0;
			}
		}


		return $data_item;
	}

	public function addcart(){
		$post = $this->input->post();
		$row  = $this->item_list($post['item_id'], FALSE);

		$json = array();
		if(!empty($row)){
			$price = $row['price'];
			if($row['disc'] > 0){
				$price = $price - ($price * $row['disc'])/100;
			}

			$data = array(
				'id'         => $row['ID_ms'],
				'size'       => $row['size'],
				'color'      => $row['color'],
				'id_product' => $row['id_product'],
				'item_name'  => $row['ItemName'],
				'qty'        => $post['qty'],
				'price'      => $price,
				'disc'       => $row['disc'],
				'ori_price'  => $row['price'],
				'name'       => $row['ItemName'],
				'weight'     => $row['ItemWeight'],
			    'options' => array(
					'Size'  => $row['sizename'], 
					'Color' => $row['colorname']
			    )
			);
			$this->cart->insert($data);
			$json['status'] = 0;
			$json['total']  = $this->cart->total();
		}else{
			$json['status'] = 1;
		}
		return $json;
	}

	public function no_transaksi(){
		date_default_timezone_set('Asia/Jakarta');
		$this->db->select('*, LEFT(private_order.order_number,3) as kode', FALSE);
		$this->db->order_by('order_number','DESC');    
		$this->db->limit(1);     
		$query = $this->db->get('private_order');    
		if($query->num_rows() <> 0){       
		   $data = $query->row(); 
		   $subs = substr($data->order_number, -3);     
		   $kode = intval($subs) + 1;   
		}
		else{       
		   $kode = 1;  
		}
		$kodemax  = str_pad($kode, 3, "0", STR_PAD_LEFT);    
		$kodejadi = 'P-'.date('ymdH').$kodemax; 

		return $kodejadi;  
	}

	public function crate_order(){
		$post = $this->input->post();
		if($post){
			// pre($post);
			$order_number = $this->no_transaksi();
			$token        = date("dm") . uniqid() . date("yHis") . strtoupper(uniqid());
			$rand         = rand(100, 999);
			$data_order = array(
				'order_number'   => $order_number,
				'token'          => $token,
				'nama'           => $post['name'],
				'email'          => $post['email'],
				'telepon'        => $post['telepon'],
				'alamat'         => $post['alamat'],
				'id_destination' => $post['desa'],
				'zip'            => $post['zip_code'],
				'pengiriman'     => $post['pengiriman'],
				'total_weight'   => total_weight_cart(),
				'total_qty'      => $this->cart->total_items(),
				'cost'           => $post['cost'],
				'unic_code'      => $rand,
				'total'          => $this->cart->total() + $post['cost'] + $rand,
				'tanggal'        => date('Y-m-d H:i:s'),
			);

			$data_item = array();
			foreach ($this->cart->contents() as $items) {
				$data_item[] = array(
					'order_number' => $order_number,
					'id_ms'        => $items['id'],
					'size'         => $items['size'],
					'color'        => $items['color'],
					'id_product'   => $items['id_product'],
					'item_name'    => $items['item_name'],
					'qty'          => $items['qty'],
					'harga'        => $items['ori_price'],
					'disc'         => $items['disc'],
					'harga_jual'   => $items['price'],
					'total'        => $items['price'] * $items['qty']
				);
			}

			$insert = $this->db->insert('private_order', $data_order);
			$insert_list = $this->db->insert_batch('private_order_list', $data_item);
			if($insert && $insert_list){
				$this->cart->destroy();
				return true;
			}else{
				return false;
			}
			
		}
		else{
			show_404();
		}
	}

}