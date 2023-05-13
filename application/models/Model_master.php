<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_master extends CI_Model {
	public function __construct()
	{
		parent::__construct();

		$this->load->model('entersite/m_entersite');
	}

	public function data($table, $where = array(), $return = TRUE){
		$query = $this->db->get_where($table, $where);
		if($return){
			return $query->result_array();
		}
		else{
			return $query->row_array();
		}
	}

	public function color(){
		$query = $this->db->order_by('ColorName', 'asc')->get("color")->result_array();
		return $query;
	}

	public function brand_list(){
		$query = $this->db->get_where("brand", array('publish !=' => 3))->result_array();
		return $query;
	}

	public function addproduct(){
		$post = $this->input->post();
		$rand = mt_rand(100000, 999999);

		$cekcode = $this->db->get_where('products', array('ItemCode' => $post['itemcode']))->num_rows();
		if($cekcode == 0){
		$product_data = array(
			'ItemType'        => input_clean($post['product_type']),
			'url'             => create_seo_url(my_slug($post['itemname'])),
			'ItemCode'        => $post['itemcode'],
			'ItemSubcate'     => (!empty($post['category'])) ? implode(',', str_replace('/', ',', $post['category'])) : '',
			'brand_code'      => input_clean($post['brand']),
			'ItemName'        => input_clean($post['itemname']),
			'ItemNmDesc'      => input_clean($post['itemdesc']),
			'ItemWeight'      => input_clean($post['weight']),
			'ItemDescription' => $post['description'],
			'meta_title'      => input_clean($post['itemname']),
			'meta_keyword'    => input_clean($post['itemdesc']),
			'meta_deskripsi'  => $post['description'],
			'created'         => date('Y-m-d H:i:s'),
			'Uploader'        => $this->session->userdata('id_admin'),
			'publish'         => '11'
		);


		$this->db->insert("products", $product_data);
		$id = $this->db->insert_id();

		if($post['product_type'] == 1){
			// only stock
			$barcode   = input_clean($post['brand']).$rand.'01';
			$map = array(
				'id_product' => $id,
				'item_code'  => input_clean($post['itemcode']),
				'barcode'    => $barcode,
				'price'      => input_clean($post['price']),
				'disc'       => input_clean($post['disc']),
			);
			$stock = array(
				'id_product' => $id,
				'ItemCode'   => $post['itemcode'],
				'barcode'    => $barcode,
				'size'       => 14,
				'stock'      => $post['stock']
			);

			$this->db->insert("product_map", $map);
			$this->db->insert("product_map_stock", $stock);
		}
		if($post['product_type'] == 2 || $post['product_type'] == 4){
			// only color
			for ($i=0; $i < count($post['color']); $i++) { 
				$kodecolor = $this->db->get_where("color", array("ID_color" => $post['color'][$i]))->row_array();
				$barcode   = input_clean($post['brand']).$kodecolor['kodewarna'].$rand;

				$sizedefault = 14;

				$map = array(
					'id_product' => $id,
					'item_code'  => input_clean($post['itemcode']),
					'barcode'    => $barcode,
					'color'      => $post['color'][$i],
					'price'      => input_clean($post['price']),
					'disc'       => input_clean($post['disc']),
				);

				$stock = array(
					'id_product' => $id,
					'ItemCode'   => $post['itemcode'],
					'barcode'    => $barcode,
					'color'      => $post['color'][$i],
					'size'       => $sizedefault
				);

				$this->db->insert("product_map", $map);
				$this->db->insert("product_map_stock", $stock);
			}
		}
		if($post['product_type'] == 3){
			// only size
			$barcode   = input_clean($post['brand']).$rand.'03';
			$map = array(
				'id_product' => $id,
				'item_code'  => input_clean($post['itemcode']),
				'barcode'    => $barcode,
				'price'      => input_clean($post['price']),
				'disc'       => input_clean($post['disc']),
			);

			for ($i=0; $i < count($post['size']); $i++) { 
				$stock = array(
					'id_product' => $id,
					'ItemCode'   => $post['itemcode'],
					'barcode'    => $barcode,
					'size'       => $post['size'][$i],
				);
				$this->db->insert("product_map_stock", $stock);
			}

			$this->db->insert("product_map", $map);
			
		}
		

		return TRUE;
		}else{
			return FALSE;
		}

	}

	public function editproduct(){
		$post = $this->input->post();
		$rand = mt_rand(100000, 999999);
		$id   = input_clean($post['id']);

		$row  = $this->db->get_where("products", array("ID_item" => $id))->row_array();

		if($row){
			$product_data = array(
				'url'             => create_seo_url(my_slug($post['itemname']), $id),
				'ItemSubcate'     => (!empty($post['category'])) ? implode(',', str_replace('/', ',', $post['category'])) : '',
				'ItemName'        => input_clean($post['itemname']),
				'ItemNmDesc'      => input_clean($post['itemdesc']),
				'ItemWeight'      => input_clean($post['weight']),
				'ItemDescription' => $post['description'],
				'meta_title'      => input_clean($post['itemname']),
				'meta_keyword'    => input_clean($post['itemdesc']),
				'meta_deskripsi'  => $post['description'],
				'modified'        => date('Y-m-d H:i:s'),
				'Uploader'        => $this->session->userdata('id_admin'),
			);


			$this->db->update("products", $product_data, array('ID_item' => input_clean($post['id'])));


			if(!empty($post['color'])) :
			for ($i=0; $i < count($post['color']); $i++) { 
				$kodecolor = $this->db->get_where("color", array("ID_color" => $post['color'][$i]))->row_array();
				$barcode   = $row['brand_code'].$kodecolor['kodewarna'].$rand;

				$map = array(
					'id_product' => $id,
					'item_code'  => input_clean($post['itemcode']),
					'barcode'    => $barcode,
					'color'      => $post['color'][$i],
				);
				$stock = array(
					'id_product' => $id,
					'ItemCode'   => $post['itemcode'],
					'barcode'    => $barcode,
					'color'      => $post['color'][$i],
				);

				$this->db->insert("product_map", $map);
				$this->db->insert("product_map_stock", $stock);
			}
			endif;

			if($row['ItemType'] == 3){
				if(!empty($post['size'])) :
				$barcode   = $row['brand_code'].$rand.'03';
				
				for ($i=0; $i < count($post['size']); $i++) {
					$stock = array(
						'id_product' => $id,
						'ItemCode'   => $post['itemcode'],
						'barcode'    => $barcode,
						'size'       => $post['size'][$i],
					);
					$this->db->insert("product_map_stock", $stock);
				}

				endif;
			}

			return TRUE;

		}else{
			return FALSE;
		}

	}

	public function addimageproduct(){
		$post = $this->input->post();

		$row  = $this->m_entersite->list_products(array('map.ID_map' => input_clean($post['id_map'])), FALSE);

		if($row){
			$uploadPath = FCPATH . 'assets/image/product/';
			$imageName  = array();
			$colorname  = ($row['ItemType'] == 4) ? $row['stock'][0]['ColorName'] : $row['stock']['ColorName'];

			if(!empty($_FILES['imagemain']['name'])){
				for ($i=0; $i < count($_FILES['imagemain']['name']); $i++) {
					$_FILES['file']['name']     = $_FILES['imagemain']['name'][$i];
					$_FILES['file']['type']     = $_FILES['imagemain']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['imagemain']['tmp_name'][$i];
					$_FILES['file']['error']    = $_FILES['imagemain']['error'][$i];
					$_FILES['file']['size']     = $_FILES['imagemain']['size'][$i];

					$config['upload_path']   = $uploadPath;
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$new_name                = 'image-'.$i.'-'.$row['url'].'-'.my_slug($colorname);
					$config['file_name']     = $new_name;

					$this->load->library('upload', $config);
	            	$this->upload->initialize($config);
	            	if($this->upload->do_upload('file')){
	            		$fileData    = $this->upload->data();
						$info        = pathinfo($uploadPath . $fileData['file_name']);
						$multiple_nm = $fileData['file_name'];

						$imageName[] = $multiple_nm;
	            	}
				}
			}

			$image1 = (!empty($imageName[0])) ? $imageName[0] : $row['image'][0];
			$image2 = (!empty($imageName[1])) ? $imageName[1] : $row['image'][1];
			$image3 = (!empty($imageName[2])) ? $imageName[2] : $row['image'][2];
			$image4 = (!empty($imageName[3])) ? $imageName[3] : $row['image'][3];
			$image5 = (!empty($imageName[4])) ? $imageName[4] : $row['image'][4];
			$image6 = (!empty($imageName[5])) ? $imageName[5] : $row['image'][5];

			$data = array(
				'price'  => input_clean($post['price']),
				'disc'   => input_clean($post['disc']),
				'image1' => $image1,
				'image2' => $image2,
				'image3' => $image3,
				'image4' => $image4,
				'image5' => $image5,
				'image6' => $image6,
				'video'  => input_clean($post['video']),
				'status' => input_clean($post['publish'])
			);

			// pre($data);
			if($row['ItemType'] == 1 || $row['ItemType'] == 2){
				$map_stock = array(
					'stock' => input_clean($post['stock']), 
					'size'  => (!empty($post['size'])) ? input_clean($post['size']) : 14
				);
				$this->db->update('product_map_stock', $map_stock, array('ItemCode' => $row['ItemCode'], 'barcode' => $row['barcode']));
			}

			if($row['ItemType'] == 3 || $row['ItemType'] == 4){
				// pre($post['size']);
				for ($i=0; $i < count($post['stock']); $i++) { 
					$map_stock = array(
						'stock' => input_clean($post['stock'][$i]), 
					);
					$size = $this->db->get_where('size', array('Size' => $post['size'][$i]))->row_array();
					$this->db->update('product_map_stock', $map_stock, array('size' => $size['ID_size'], 'barcode' => $row['barcode'], 'ItemCode' => $row['ItemCode']));
				}
			}

			$this->db->update('product_map', $data, array('ID_map' => input_clean($post['id_map'])));
			

			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function addbrand(){
		$post = $this->input->post();

		$data = array(
			'brand_name'    => input_clean($post['brand_name']),
			'brand_code'    => input_clean($post['brand_code']),
			'brand_seo_url' => my_slug($post['brand_name']),
			'publish'       => $post['publish']
		);

		$input = $this->db->insert("brand", $data);
		if($input){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function editbrand(){
		$post = $this->input->post();

		$row  = $this->db->get_where("brand", array("brand_name" => $post['brand_name'], "ID_brand !=" => $post['id']))->num_rows();

		if($row == 0){
			$data = array(
				'brand_name'    => input_clean($post['brand_name']),
				'brand_code'    => input_clean($post['brand_code']),
				'brand_seo_url' => my_slug($post['brand_name']),
				'publish'       => $post['publish']
			);

			$input = $this->db->update("brand", $data, array('ID_brand' => input_clean($post['id'])));
			if($input){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	public function master_list($where = array(), $results = TRUE){
		if(!empty($where)){
			$this->db->where($where);
		}
		$query = $this->db
		->select('p.*, s.user_admin, b.*')
		->join('admin s', 's.id_admin=p.Uploader', 'LEFT')
		->join('brand b', 'b.brand_code=p.brand_code', 'LEFT')
		->get('products p');
		$data  = array();
		if($results){
			$row = $query->result_array();
			foreach ($row as $key => $value) {
				$data[] = array(
					'id'          => $value['ID_item'],
					'ItemType'    => $value['ItemType'],
					'item_code'   => $value['ItemCode'],
					'item_name'   => $value['ItemName'],
					'brand'       => $value['brand_name'],
					'uploader'    => $value['user_admin'],
					'publish'     => $value['publish'],
					'ItemSubcate' => $this->db->select('kategori')->where_in('ID_cat', explode(',', $value['ItemSubcate']))->get_where('category', array('publish' => '11'))->result_array(),
					'color'       => $this->db->select('pms.stock, c.ColorName')->join('color c', 'c.ID_color = pms.color', 'LEFT')->get_where("product_map_stock pms", array('ItemCode' => $value['ItemCode']))->result_array()
					
				);
			}
		} 
		else
		{
			$value = $query->row_array();
			$color = $this->db->select('pms.color')->get_where("product_map pms", array('item_code' => $value['ItemCode']))->result_array();
			$colorarray = array();
			foreach ($color as $key => $col) {
				array_push($colorarray, $col['color']);
			}

			$size = $this->db->select('pms.size')->get_where("product_map_stock pms", array('ItemCode' => $value['ItemCode']))->result_array();
			$sizerarray = array();
			foreach ($size as $key => $col) {
				array_push($sizerarray, $col['size']);
			}

			$data  = array(
				'id'            => $value['ID_item'],
				'ItemType'      => $value['ItemType'],
				'item_code'     => $value['ItemCode'],
				'brand'         => $value['brand_code'],
				'item_name'     => $value['ItemName'],
				'item_desc'     => $value['ItemNmDesc'],
				'item_longdesc' => $value['ItemDescription'],
				'ItemSubcate'   => $value['ItemSubcate'],
				'weight'        => $value['ItemWeight'],
				'uploader'      => $value['user_admin'],
				'publish'       => $value['publish'],
				'color'         => $colorarray,
				'color_ready'   => $color = $this->db->select('pms.color, pms.status, pms.ID_map, c.ColorName')->join('color c', 'c.ID_color = pms.color', 'LEFT')->get_where("product_map pms", array('item_code' => $value['ItemCode']))->result_array(),
				'size'          => $sizerarray,
				'size_ready'    => $this->db->select('pms.size, s.Size')->join('size s', 's.ID_size = pms.size', 'LEFT')->get_where("product_map_stock pms", array('pms.ItemCode' => $value['ItemCode']))->result_array()
					
			);
		}

		return $data;
	}

	function update_stock(){
		$post   = $this->input->post();
		$length = count($post['barcode']);
		pre($length);
		if($length > 500){
			return FALSE; 
		}else{
			// for ($i=0; $i < $length; $i++) { 
			// 	$updatestock = array(
			// 		'stock'   => $post['stock'][$i],
			// 	);
			// 	$where = array(
			// 		'barcode' => $post['barcode'][$i],
			// 		'size'    => (!empty($post['idsize'][$i])) ? $post['idsize'][$i] : 14;
			// 	);
			// 	if(!empty($post['idsize'][$i])){
			// 		$where['size'] = $post['idsize'][$i];
			// 	}
			// 	$this->db->update('product_map_stock', $updatestock, $where); 
			// }
			return TRUE; 
		}	
	}

	public function allstock(){
		$query = $this->db
			->select('pms.*, p.ItemName, c.ColorName as color_name, s.Size as size_name')
			->join('products p', 'p.ID_item = pms.id_product', 'LEFT')
			->join('color c', 'c.ID_color = pms.color', 'LEFT')
			->join('size s', 's.ID_size = pms.size', 'LEFT')
			->get('product_map_stock pms')->result_array();
		return $query;
	}
}