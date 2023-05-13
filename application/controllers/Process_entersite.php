<?php 
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Process_entersite extends CI_Controller {
	function __construct(){
		parent::__construct();
		check_login();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->library(array('session'));
		$this->load->model(array('checkout/m_checkout', 'shop/m_shop', 'entersite/m_entersite'));
	}


	function additems(){
		if($this->input->post('additems') != null && $this->input->post('product_type') != null) {

			$code             = strtoupper($this->input->post('itemcode'));
			$itemdesc         = $this->input->post('itemdesc');
			$name             = $this->input->post('itemname');
			$subcategory      = (!empty($this->input->post('category'))) ? implode(',', $this->input->post('category')) : '';
			$price            = $this->input->post('price');
			$disc             = $this->input->post('disc');
			$weight           = $this->input->post('weight');
			$description      = $this->input->post('description');
			$default          = $this->input->post('defaultitem');
			$publish          = $this->input->post('publish');

			$seo_title        = $this->input->post('seo_title');
			$seo_descriptions = $this->input->post('seo_descriptions');
			$seo_keywords     = $this->input->post('seo_keywords');
			
			$type             = $this->input->post('product_type');

			$config['upload_path']   = './assets/image/product/';
	        $config['allowed_types'] = 'jpg|jpeg|png';
	        $nmfile1                 = my_slug($name.'_'.$code).'_';
			$config['file_name']     = $nmfile1;
	        

			$cekcode        = $this->m_entersite->list_where('ItemCode', $code, 'products')->num_rows();
			if ($cekcode == 0) {
				if ( $type == '1' ) {
					$stock         = $this->input->post('stock')[0];
					//image upload
					$product_map   = array();
					$product_stock = array();
					$filecount1    = count($_FILES['imagemain']['name']);
					for ($i = 0; $i < $filecount1; $i++){
						$_FILES['file1']['name']     = $_FILES['imagemain']['name'][$i];
						$_FILES['file1']['type']     = $_FILES['imagemain']['type'][$i];
						$_FILES['file1']['tmp_name'] = $_FILES['imagemain']['tmp_name'][$i];
						$_FILES['file1']['error']    = $_FILES['imagemain']['error'][$i];
						$_FILES['file1']['size']     = $_FILES['imagemain']['size'][$i];

						$_FILES['file2']['name']     = $_FILES['imageseco']['name'][$i];
						$_FILES['file2']['type']     = $_FILES['imageseco']['type'][$i];
						$_FILES['file2']['tmp_name'] = $_FILES['imageseco']['tmp_name'][$i];
						$_FILES['file2']['error']    = $_FILES['imageseco']['error'][$i];
						$_FILES['file2']['size']     = $_FILES['imageseco']['size'][$i];

						$_FILES['file3']['name']     = $_FILES['imagethir']['name'][$i];
						$_FILES['file3']['type']     = $_FILES['imagethir']['type'][$i];
						$_FILES['file3']['tmp_name'] = $_FILES['imagethir']['tmp_name'][$i];
						$_FILES['file3']['error']    = $_FILES['imagethir']['error'][$i];
						$_FILES['file3']['size']     = $_FILES['imagethir']['size'][$i];

						$this->load->library('upload', $config);
	                	$this->upload->initialize($config);
	                	if ($this->upload->do_upload('file1')){
	                    	$uploadData1 = $this->upload->data('file_name');
						}
						if ($this->upload->do_upload('file2')){
	                    	$uploadData2 = $this->upload->data('file_name');
						}
						if ($this->upload->do_upload('file3')){
	                    	$uploadData3 = $this->upload->data('file_name');
						}
						$product_map[]  = array(
							'item_code' => $code,
							'image1'    => $uploadData1,
							'image2'    => $uploadData2,
							'image3'    => $uploadData3,
							'status'    => '11'
						);
						$product_stock[] = array(
							'ItemCode'  => $code,
							'stock'     => $stock
						);
					}	
				
					if(!empty($uploadData1) && !empty($uploadData2) && !empty($uploadData3)){
						$insert_status = true;
					}else{
						$insert_status = false;
					}

				} elseif ( $type == '2' ) {
					$defitem       = $this->input->post('defaultitem2');
					$color         = $this->input->post('color');
					$stock         = $this->input->post('stock');
					$product_map   = array();
					$product_stock = array();
					$uploadstat    = 0;
					for($i=0; $i < count($color); $i++){
						if($defitem == $i){
							$d_i    = '11';
						}else{
							$d_i    = '01';
						}
						$_FILES['file1']['name']     = $_FILES['imagemain']['name'][$i];
						$_FILES['file1']['type']     = $_FILES['imagemain']['type'][$i];
						$_FILES['file1']['tmp_name'] = $_FILES['imagemain']['tmp_name'][$i];
						$_FILES['file1']['error']    = $_FILES['imagemain']['error'][$i];
						$_FILES['file1']['size']     = $_FILES['imagemain']['size'][$i];

						$_FILES['file2']['name']     = $_FILES['imageseco']['name'][$i];
						$_FILES['file2']['type']     = $_FILES['imageseco']['type'][$i];
						$_FILES['file2']['tmp_name'] = $_FILES['imageseco']['tmp_name'][$i];
						$_FILES['file2']['error']    = $_FILES['imageseco']['error'][$i];
						$_FILES['file2']['size']     = $_FILES['imageseco']['size'][$i];

						$_FILES['file3']['name']     = $_FILES['imagethir']['name'][$i];
						$_FILES['file3']['type']     = $_FILES['imagethir']['type'][$i];
						$_FILES['file3']['tmp_name'] = $_FILES['imagethir']['tmp_name'][$i];
						$_FILES['file3']['error']    = $_FILES['imagethir']['error'][$i];
						$_FILES['file3']['size']     = $_FILES['imagethir']['size'][$i];

						$this->load->library('upload', $config);
	                	$this->upload->initialize($config);
	                	if ($this->upload->do_upload('file1')){
	                    	$uploadData1 = $this->upload->data('file_name');
	                    	$uploadstat++;
						}
						if ($this->upload->do_upload('file2')){
	                    	$uploadData2 = $this->upload->data('file_name');
	                    	$uploadstat++;
						}
						if ($this->upload->do_upload('file3')){
	                    	$uploadData3 = $this->upload->data('file_name');
	                    	$uploadstat++;
						}

						$product_map[] = array(
							'item_code' => $code,
							'color'     => $color[$i],
							'image1'    => $uploadData1,
							'image2'    => $uploadData2,
							'image3'    => $uploadData3,
							'status'    => $d_i
						);
						$product_stock[] = array(
							'ItemCode'  => $code,
							'color'     => $color[$i],
							'stock'     => $stock[$i]
						);
					}

					if($uploadstat/3 == count($color)){
						$insert_status = true;
					}else{
						$insert_status = false;
					}

				} elseif ( $type == '3' ) {

					$stock         = $this->input->post('stock');
					$size          = $this->input->post('size');
					$product_map   = array();
					$product_stock = array();

					    $_FILES['file1']['name']     = $_FILES['imagemain']['name'][0];
						$_FILES['file1']['type']     = $_FILES['imagemain']['type'][0];
						$_FILES['file1']['tmp_name'] = $_FILES['imagemain']['tmp_name'][0];
						$_FILES['file1']['error']    = $_FILES['imagemain']['error'][0];
						$_FILES['file1']['size']     = $_FILES['imagemain']['size'][0];

						$_FILES['file2']['name']     = $_FILES['imageseco']['name'][0];
						$_FILES['file2']['type']     = $_FILES['imageseco']['type'][0];
						$_FILES['file2']['tmp_name'] = $_FILES['imageseco']['tmp_name'][0];
						$_FILES['file2']['error']    = $_FILES['imageseco']['error'][0];
						$_FILES['file2']['size']     = $_FILES['imageseco']['size'][0];

						$_FILES['file3']['name']     = $_FILES['imagethir']['name'][0];
						$_FILES['file3']['type']     = $_FILES['imagethir']['type'][0];
						$_FILES['file3']['tmp_name'] = $_FILES['imagethir']['tmp_name'][0];
						$_FILES['file3']['error']    = $_FILES['imagethir']['error'][0];
						$_FILES['file3']['size']     = $_FILES['imagethir']['size'][0];

						$this->load->library('upload', $config);
	                	$this->upload->initialize($config);
	                	if ($this->upload->do_upload('file1')){
	                    	$uploadData1 = $this->upload->data('file_name');
						}
						if ($this->upload->do_upload('file2')){
	                    	$uploadData2 = $this->upload->data('file_name');
						}
						if ($this->upload->do_upload('file3')){
	                    	$uploadData3 = $this->upload->data('file_name');
						}

						for($i=0; $i < count($size); $i++){
						$product_stock[] = array(
							'ItemCode'  => $code,
							'size'      => $size[$i],
							'stock'     => $stock[$i]
						);
						}

						$product_map[] = array(
							'item_code' => $code,
							'image1'    => $uploadData1,
							'image2'    => $uploadData2,
							'image3'    => $uploadData3,
							'status'    => '11'
						);

					if(!empty($uploadData1) && !empty($uploadData2) && !empty($uploadData3)){
						$insert_status = true;
					}else{
						$insert_status = false;
					}

				} elseif ( $type == '4' ) {

					$defitem       = $this->input->post('defaultitem4');
					$color         = $this->input->post('color');
					$product_map   = array();
					$product_stock = array();
					$uploadstat    = 0;
					$s             = 0;
					$i = 0;
					foreach ($color as $key) {

						if($defitem == $i){
							$d_i    = '11';
						}else{
							$d_i    = '01';
						}

						$_FILES['file1']['name']     = $_FILES['imagemain']['name'][$i];
						$_FILES['file1']['type']     = $_FILES['imagemain']['type'][$i];
						$_FILES['file1']['tmp_name'] = $_FILES['imagemain']['tmp_name'][$i];
						$_FILES['file1']['error']    = $_FILES['imagemain']['error'][$i];
						$_FILES['file1']['size']     = $_FILES['imagemain']['size'][$i];

						$_FILES['file2']['name']     = $_FILES['imageseco']['name'][$i];
						$_FILES['file2']['type']     = $_FILES['imageseco']['type'][$i];
						$_FILES['file2']['tmp_name'] = $_FILES['imageseco']['tmp_name'][$i];
						$_FILES['file2']['error']    = $_FILES['imageseco']['error'][$i];
						$_FILES['file2']['size']     = $_FILES['imageseco']['size'][$i];

						$_FILES['file3']['name']     = $_FILES['imagethir']['name'][$i];
						$_FILES['file3']['type']     = $_FILES['imagethir']['type'][$i];
						$_FILES['file3']['tmp_name'] = $_FILES['imagethir']['tmp_name'][$i];
						$_FILES['file3']['error']    = $_FILES['imagethir']['error'][$i];
						$_FILES['file3']['size']     = $_FILES['imagethir']['size'][$i];

						$this->load->library('upload', $config);
	                	$this->upload->initialize($config);
	                	if ($this->upload->do_upload('file1')){
	                    	$uploadData1 = $this->upload->data('file_name');
	                    	$uploadstat++;
						}
						if ($this->upload->do_upload('file2')){
	                    	$uploadData2 = $this->upload->data('file_name');
	                    	$uploadstat++;
						}
						if ($this->upload->do_upload('file3')){
	                    	$uploadData3 = $this->upload->data('file_name');
	                    	$uploadstat++;
						}

						$product_map[] = array(
							'item_code' => $code,
							'color'     => $color[$i],
							'image1'    => $uploadData1,
							'image2'    => $uploadData2,
							'image3'    => $uploadData3,
							'status'    => $d_i
						);
						$size     = $this->input->post('size'.$i);
						$stock    = $this->input->post('stock'.$i);
						$colore   = $color[$i];

						for ($s=0; $s < count($stock) ; $s++) { 

							$product_stock[] = array(
								'ItemCode'  => $code,
								'color'     => $colore,
								'size'      => $size[$s],
								'stock'     => $stock[$s]
							);
						}
					$i++;
					}

					if($uploadstat/3 == count($color)){
						$insert_status = true;
					}else{
						$insert_status = false;
					}
					
				} else {
					$insert_status = false;
				}

				$sub      = '';
				for($c=0; $c < count($subcategory); $c++){ 
					$sub .= $subcategory[$c].'/';
				}


				$product_data = array(
					'ItemType'        => $type,
					'url'             => create_seo_url(my_slug($name)),
					'ItemCode'        => $code,
					'ItemSubcate'     => $subcategory,
					'ItemName'        => $name,
					'ItemNmDesc'      => $itemdesc,
					'ItemPrice'       => $price,
					'ItemDisc'        => $disc,
					'ItemWeight'      => $weight,
					'ItemDescription' => $description,
					'meta_title'      => $seo_title,
					'meta_keyword'    => $seo_keywords,
					'meta_deskripsi'  => $seo_descriptions,
					'created'         => date('Y-m-d H:i:s'),
					'Uploader'        => $this->session->userdata('id_admin'),
					'publish'         => $publish
				);
				if($insert_status == true){
					$insert1 = $this->db->insert('products', $product_data);
					$insert2 = $this->db->insert_batch('product_map', $product_map);
					$insert3 = $this->db->insert_batch('product_map_stock', $product_stock);
					if($insert1 && $insert2 && $insert3){
						$this->session->set_flashdata('alert_success', 'Successfully added a product');
					}else{
						$this->session->set_flashdata('alert_errors', 'Error when contacting database');
					}
				}else{
					$this->session->set_flashdata('alert_errors', 'Upload Image Error -1');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'This code has been used.');
			}

			redirect(base_url().'entersite/product/add-item');
		}else{
			show_404();
		}
	}

	function updateitems(){
		if($this->input->post('additems') != null && $this->input->post('product_type') != null) {
			$itemID           = $this->input->post('id');

			$data_items       = $this->m_entersite->get_details_products($itemID);

			$code             = strtoupper($this->input->post('itemcode'));
			$itemdesc         = $this->input->post('itemdesc');
			$name             = $this->input->post('itemname');
			$subcategory      = (!empty($this->input->post('category'))) ? implode(',', $this->input->post('category')) : '';
			$price            = $this->input->post('price');
			$disc             = $this->input->post('disc');
			$weight           = $this->input->post('weight');
			$description      = $this->input->post('description');
			$default          = $this->input->post('defaultitem');
			$publish          = $this->input->post('publish');

			$seo_title        = $this->input->post('seo_title');
			$seo_descriptions = $this->input->post('seo_descriptions');
			$seo_keywords     = $this->input->post('seo_keywords');
			
			$type             = $this->input->post('product_type');

			$config['upload_path']   = './assets/image/product/';
	        $config['allowed_types'] = 'jpg|jpeg|png';
	        $nmfile1                 = my_slug($name.'_'.$code).'_';
			$config['file_name']     = $nmfile1;
	        

			$cekcode        = $this->db->get_where('products', array('ItemCode' => $code, 'ID_item !=' => $itemID))->num_rows();
			if ($cekcode == 0) {
				if ( $type == '1' ) {
					$stock         = $this->input->post('stock')[0];
					//image upload
					$product_map   = array();
					$product_stock = array();

					$filecount1    = count($_FILES['imagemain']['name']);
					for ($i = 0; $i < $filecount1; $i++){

						if($_FILES['imagemain']['name'][$i] != ''){
							$_FILES['file1']['name']     = $_FILES['imagemain']['name'][$i];
							$_FILES['file1']['type']     = $_FILES['imagemain']['type'][$i];
							$_FILES['file1']['tmp_name'] = $_FILES['imagemain']['tmp_name'][$i];
							$_FILES['file1']['error']    = $_FILES['imagemain']['error'][$i];
							$_FILES['file1']['size']     = $_FILES['imagemain']['size'][$i];
						}
						
						if($_FILES['imagemain']['name'][$i] != ''){
							$_FILES['file2']['name']     = $_FILES['imageseco']['name'][$i];
							$_FILES['file2']['type']     = $_FILES['imageseco']['type'][$i];
							$_FILES['file2']['tmp_name'] = $_FILES['imageseco']['tmp_name'][$i];
							$_FILES['file2']['error']    = $_FILES['imageseco']['error'][$i];
							$_FILES['file2']['size']     = $_FILES['imageseco']['size'][$i];
						}

						if($_FILES['imagethir']['name'][$i] != ''){
							$_FILES['file3']['name']     = $_FILES['imagethir']['name'][$i];
							$_FILES['file3']['type']     = $_FILES['imagethir']['type'][$i];
							$_FILES['file3']['tmp_name'] = $_FILES['imagethir']['tmp_name'][$i];
							$_FILES['file3']['error']    = $_FILES['imagethir']['error'][$i];
							$_FILES['file3']['size']     = $_FILES['imagethir']['size'][$i];
						}

						$this->load->library('upload', $config);
	                	$this->upload->initialize($config);

	                	if($_FILES['imagemain']['name'][$i] != ''){
		                	if ($this->upload->do_upload('file1')){
		                    	$uploadData1 = $this->upload->data('file_name');
							}
						}
						else{
							$uploadData1 = $data_items['images'][0]['image1'];
						}
						
						if($_FILES['imagemain']['name'][$i] != ''){
							if ($this->upload->do_upload('file2')){
		                    	$uploadData2 = $this->upload->data('file_name');
							}
						}
						else{
							$uploadData2 = $data_items['images'][0]['image2'];
						}

						if($_FILES['imagethir']['name'][$i] != ''){
							if ($this->upload->do_upload('file3')){
		                    	$uploadData3 = $this->upload->data('file_name');
							}
						}
						else{
							$uploadData3 = $data_items['images'][0]['image3'];
						}

						$product_map[]  = array(
							'item_code' => $code,
							'image1'    => $uploadData1,
							'image2'    => $uploadData2,
							'image3'    => $uploadData3,
							'status'    => '11'
						);
						$product_stock[] = array(
							'ItemCode'  => $code,
							'stock'     => $stock
						);
					}	
				
					if(!empty($uploadData1) && !empty($uploadData2) && !empty($uploadData3)){
						$insert_status = true;
					}else{
						$insert_status = false;
					}

				} elseif ( $type == '2' ) {
					$defitem       = $this->input->post('defaultitem2');
					$color         = $this->input->post('color');
					$stock         = $this->input->post('stock');
					$product_map   = array();
					$product_stock = array();
					$uploadstat    = 0;
					for($i=0; $i < count($color); $i++){
						if($defitem == $i){
							$d_i    = '11';
						}else{
							$d_i    = '01';
						}
						$_FILES['file1']['name']     = $_FILES['imagemain']['name'][$i];
						$_FILES['file1']['type']     = $_FILES['imagemain']['type'][$i];
						$_FILES['file1']['tmp_name'] = $_FILES['imagemain']['tmp_name'][$i];
						$_FILES['file1']['error']    = $_FILES['imagemain']['error'][$i];
						$_FILES['file1']['size']     = $_FILES['imagemain']['size'][$i];

						$_FILES['file2']['name']     = $_FILES['imageseco']['name'][$i];
						$_FILES['file2']['type']     = $_FILES['imageseco']['type'][$i];
						$_FILES['file2']['tmp_name'] = $_FILES['imageseco']['tmp_name'][$i];
						$_FILES['file2']['error']    = $_FILES['imageseco']['error'][$i];
						$_FILES['file2']['size']     = $_FILES['imageseco']['size'][$i];

						$_FILES['file3']['name']     = $_FILES['imagethir']['name'][$i];
						$_FILES['file3']['type']     = $_FILES['imagethir']['type'][$i];
						$_FILES['file3']['tmp_name'] = $_FILES['imagethir']['tmp_name'][$i];
						$_FILES['file3']['error']    = $_FILES['imagethir']['error'][$i];
						$_FILES['file3']['size']     = $_FILES['imagethir']['size'][$i];

						$this->load->library('upload', $config);
	                	$this->upload->initialize($config);
	                	if ($this->upload->do_upload('file1')){
	                    	$uploadData1 = $this->upload->data('file_name');
	                    	$uploadstat = $uploadstat + 1;
						}
						if ($this->upload->do_upload('file2')){
	                    	$uploadData2 = $this->upload->data('file_name');
	                    	$uploadstat = $uploadstat + 1;
						}
						if ($this->upload->do_upload('file3')){
	                    	$uploadData3 = $this->upload->data('file_name');
	                    	$uploadstat = $uploadstat + 1;
						}

						$product_map[] = array(
							'item_code' => $code,
							'color'     => $color[$i],
							'image1'    => $uploadData1,
							'image2'    => $uploadData2,
							'image3'    => $uploadData3,
							'status'    => $d_i
						);
						$product_stock[] = array(
							'ItemCode'  => $code,
							'color'     => $color[$i],
							'stock'     => $stock[$i]
						);
					}

					if($uploadstat == 3){
						$insert_status = true;
					}else{
						$insert_status = false;
					}

				} elseif ( $type == '3' ) {

					$stock         = $this->input->post('stock');
					$size          = $this->input->post('size');
					$product_map   = array();
					$product_stock = array();

						if($_FILES['imagemain']['name'][0] != ''){
						    $_FILES['file1']['name']     = $_FILES['imagemain']['name'][0];
							$_FILES['file1']['type']     = $_FILES['imagemain']['type'][0];
							$_FILES['file1']['tmp_name'] = $_FILES['imagemain']['tmp_name'][0];
							$_FILES['file1']['error']    = $_FILES['imagemain']['error'][0];
							$_FILES['file1']['size']     = $_FILES['imagemain']['size'][0];
						}
						if($_FILES['imageseco']['name'][0] != ''){
							$_FILES['file2']['name']     = $_FILES['imageseco']['name'][0];
							$_FILES['file2']['type']     = $_FILES['imageseco']['type'][0];
							$_FILES['file2']['tmp_name'] = $_FILES['imageseco']['tmp_name'][0];
							$_FILES['file2']['error']    = $_FILES['imageseco']['error'][0];
							$_FILES['file2']['size']     = $_FILES['imageseco']['size'][0];
						}
						if($_FILES['imagethir']['name'][0] != ''){
							$_FILES['file3']['name']     = $_FILES['imagethir']['name'][0];
							$_FILES['file3']['type']     = $_FILES['imagethir']['type'][0];
							$_FILES['file3']['tmp_name'] = $_FILES['imagethir']['tmp_name'][0];
							$_FILES['file3']['error']    = $_FILES['imagethir']['error'][0];
							$_FILES['file3']['size']     = $_FILES['imagethir']['size'][0];
						}

						$this->load->library('upload', $config);
	                	$this->upload->initialize($config);
	                	if($_FILES['imagemain']['name'][0] != ''){
		                	if ($this->upload->do_upload('file1')){
		                    	$uploadData1 = $this->upload->data('file_name');
							}
						}
						else{
							$uploadData1 = $data_items['images'][0]['image1'];
						}
						
						if($_FILES['imagemain']['name'][0] != ''){
							if ($this->upload->do_upload('file2')){
		                    	$uploadData2 = $this->upload->data('file_name');
							}
						}
						else{
							$uploadData2 = $data_items['images'][0]['image2'];
						}

						if($_FILES['imagethir']['name'][0] != ''){
							if ($this->upload->do_upload('file3')){
		                    	$uploadData3 = $this->upload->data('file_name');
							}
						}
						else{
							$uploadData3 = $data_items['images'][0]['image3'];
						}

						for($i=0; $i < count($size); $i++){
							$product_stock[] = array(
								'ItemCode'  => $code,
								'size'      => $size[$i],
								'stock'     => $stock[$i]
							);
						}

						$product_map[] = array(
							'item_code' => $code,
							'image1'    => $uploadData1,
							'image2'    => $uploadData2,
							'image3'    => $uploadData3,
							'status'    => '11'
						);

					if(!empty($uploadData1) && !empty($uploadData2) && !empty($uploadData3)){
						$insert_status = true;
					}else{
						$insert_status = false;
					}

				} elseif ( $type == '4' ) {

					$defitem       = $this->input->post('defaultitem4');
					$color         = $this->input->post('color');
					$product_map   = array();
					$product_stock = array();
					$uploadstat    = 0;
					$s             = 0;
					$i = 0;
					foreach ($color as $key) {

						if($defitem == $i){
							$d_i    = '11';
						}else{
							$d_i    = '01';
						}

						$_FILES['file1']['name']     = $_FILES['imagemain']['name'][$i];
						$_FILES['file1']['type']     = $_FILES['imagemain']['type'][$i];
						$_FILES['file1']['tmp_name'] = $_FILES['imagemain']['tmp_name'][$i];
						$_FILES['file1']['error']    = $_FILES['imagemain']['error'][$i];
						$_FILES['file1']['size']     = $_FILES['imagemain']['size'][$i];

						$_FILES['file2']['name']     = $_FILES['imageseco']['name'][$i];
						$_FILES['file2']['type']     = $_FILES['imageseco']['type'][$i];
						$_FILES['file2']['tmp_name'] = $_FILES['imageseco']['tmp_name'][$i];
						$_FILES['file2']['error']    = $_FILES['imageseco']['error'][$i];
						$_FILES['file2']['size']     = $_FILES['imageseco']['size'][$i];

						$_FILES['file3']['name']     = $_FILES['imagethir']['name'][$i];
						$_FILES['file3']['type']     = $_FILES['imagethir']['type'][$i];
						$_FILES['file3']['tmp_name'] = $_FILES['imagethir']['tmp_name'][$i];
						$_FILES['file3']['error']    = $_FILES['imagethir']['error'][$i];
						$_FILES['file3']['size']     = $_FILES['imagethir']['size'][$i];

						$this->load->library('upload', $config);
	                	$this->upload->initialize($config);
	                	if ($this->upload->do_upload('file1')){
	                    	$uploadData1 = $this->upload->data('file_name');
	                    	$uploadstat++;
						}
						if ($this->upload->do_upload('file2')){
	                    	$uploadData2 = $this->upload->data('file_name');
	                    	$uploadstat++;
						}
						if ($this->upload->do_upload('file3')){
	                    	$uploadData3 = $this->upload->data('file_name');
	                    	$uploadstat++;
						}

						$product_map[] = array(
							'item_code' => $code,
							'color'     => $color[$i],
							'image1'    => $uploadData1,
							'image2'    => $uploadData2,
							'image3'    => $uploadData3,
							'status'    => $d_i
						);
						$size     = $this->input->post('size'.$i);
						$stock    = $this->input->post('stock'.$i);
						$colore   = $color[$i];

						for ($s=0; $s < count($stock) ; $s++) { 

							$product_stock[] = array(
								'ItemCode'  => $code,
								'color'     => $colore,
								'size'      => $size[$s],
								'stock'     => $stock[$s]
							);
						}
					$i++;
					}

					if($uploadstat/3 == count($color)){
						$insert_status = true;
					}else{
						$insert_status = false;
					}
					
				} else {
					$insert_status = false;
				}

				
				$product_data = array(
					'ItemType'        => $type,
					'url'             => create_seo_url(my_slug($name)),
					'ItemCode'        => $code,
					'ItemSubcate'     => $subcategory,
					'ItemName'        => $name,
					'ItemNmDesc'      => $itemdesc,
					'ItemPrice'       => $price,
					'ItemDisc'        => $disc,
					'ItemWeight'      => $weight,
					'ItemDescription' => $description,
					'meta_title'      => $seo_title,
					'meta_keyword'    => $seo_keywords,
					'meta_deskripsi'  => $seo_descriptions,
					'created'         => date('Y-m-d H:i:s'),
					'Uploader'        => $this->session->userdata('id_admin'),
					'publish'         => $publish
				);
				if($insert_status == true){
					$insert1 = $this->db->update('products', $product_data, array('ID_item' => $itemID));
					$this->db->delete('product_map', array('item_code' => $code));
					$insert2 = $this->db->insert_batch('product_map', $product_map);
					$this->db->delete('product_map_stock', array('ItemCode' => $code));
					$insert3 = $this->db->insert_batch('product_map_stock', $product_stock);
					if($insert1 && $insert2 && $insert3){
						$this->session->set_flashdata('alert_success', 'Successfully added a product');
					}else{
						$this->session->set_flashdata('alert_errors', 'Error when contacting database');
					}
				}else{
					$this->session->set_flashdata('alert_errors', 'Upload Image Error -1');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'This code has been used.');
			}

			redirect(base_url().'entersite/product/list');
		}else{
			show_404();
		}
	}

	function addcategory(){
		if($this->input->post('submitcategory') != null){
		$catname = strtolower($this->input->post('category'));
		$deskrip = htmlspecialchars($this->input->post('deskripsi'));
		$pub     = $this->input->post('publish');
		if($pub == 'yes'){ $publish = '11'; }else{ $publish = '01'; }

		if($this->input->post('parent_id') == ''){ 
			$parent   = 0;
			$link     = $catname;
			$leveling = 0;
			$urilink  = my_slug($link);
		}else{ 
			$parent   = (int)$this->input->post('parent_id'); 
			$link     = '-'.$catname;
			$level    = $this->m_entersite->category_hirarki($parent)->row();
			$leveling = $level->level;
			$urilink  = my_slug($level->name_level1.ol($level->name_level2).ol($level->name_level3).ol($level->name_level4).ol($level->name_level5).$link);
		}
		if(empty($this->input->post('specials'))){
			$special = null;
		}else{
			$special = $this->input->post('special');
		}
		$level   = $this->m_entersite->category_hirarki($parent)->row();

		if($leveling < 5){
		$check   = $this->m_entersite->check_categories($urilink)->num_rows();
			if($check == 0){
				$data = array(
					'kategori'     => $catname,
					'special_type' => $special,
					'parent_id'    => $parent,
					'deskripsi'    => $deskrip,
					'link'		   => $urilink,
					'publish'      => $publish
					);
				$insert = $this->db->insert('category', $data);
				if($insert){
					$this->session->set_flashdata('alert_success', 'Berhasil menambah data');
				}else{
					$this->session->set_flashdata('alert_errors', 'Gagal menambah data');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Nama sudah digunakan!');
			}
		}else{
			$this->session->set_flashdata('alert_errors', 'Sudah mencapai batas maksimum dari sub kategori');
		}
		redirect(base_url().'entersite/product/categories');
		}else{
			show_404();
		}
	}


	function editcategory(){
		if($this->input->post('submitcategory') != null){
		$catname = strtolower($this->input->post('category'));
		$deskrip = htmlspecialchars($this->input->post('deskripsi'));
		$pub     = $this->input->post('publish');
		$id      = $this->input->post('id');
		if($pub == 'yes'){ $publish = '11'; }else{ $publish = '01'; }

		if($this->input->post('parent_id') == ''){ 
			$parent   = 0;
			$link     = $catname;
			$leveling = 0;
			$urilink  = my_slug($link);
		}else{ 
			$parent   = (int)$this->input->post('parent_id'); 
			$link     = '-'.$catname;
			$level    = $this->m_entersite->category_hirarki($parent)->row();
			$leveling = $level->level;
			$urilink  = my_slug($level->name_level1.ol($level->name_level2).ol($level->name_level3).ol($level->name_level4).ol($level->name_level5).$link);
		}
		if(empty($this->input->post('specials'))){
			$special = null;
		}else{
			$special = $this->input->post('special');
		}
		$level   = $this->m_entersite->category_hirarki($parent)->row();

		if($leveling < 5){
		$check   = $this->m_entersite->check_categories($urilink, $id)->num_rows();
			if($check == 0){
				$data = array(
					'kategori'     => $catname,
					'special_type' => $special,
					'parent_id'    => $parent,
					'deskripsi'    => $deskrip,
					'link'		   => $urilink,
					'publish'      => $publish
					);
				$update = $this->db->update('category', $data, array('ID_cat' => $id));
				if($update){
					$this->session->set_flashdata('alert_success', 'Berhasil mengubah data');
				}else{
					$this->session->set_flashdata('alert_errors', 'Gagal mengubah data');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Nama sudah digunakan!');
			}
		}else{
			$this->session->set_flashdata('alert_errors', 'Sudah mencapai batas maksimum dari sub kategori');
		}
		redirect(base_url().'entersite/product/categories');
		}else{
			show_404();
		}
	}


	function slideshow(){
		if($this->input->post('submit') == 'true'){
			$nama = $this->input->post('name');
			$url  = $this->input->post('url');
			$pub  = $this->input->post('publish');
			if($pub == 'yes'){ $publish = '11'; }else{ $publish = '01'; }

			$file_name = 'slide-'.my_slug($nama).'-time-'.date('YmdHis');

			$path                    = './assets/image/slideshow/';
			$config['upload_path']   = $path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name']     = $file_name.$config['file_ext'];

        	$this->load->library('upload', $config);
        	if(!empty($_FILES['imagemain']['name'])){

        		if ($this->upload->do_upload('imagemain')){
					$gbr 		= $this->upload->data();
					
					//Compress Image
					$config['image_library']  ='gd2';
					$config['source_image']   = $path.$gbr['file_name'];
					$config['create_thumb']   = FALSE;
					$config['maintain_ratio'] = FALSE;
					$config['quality']        = '100%';
					$config['new_image']      = $path.$gbr['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$gambar                   = $file_name.$gbr['file_ext'];
					$dataslide = array(
					'name'    => $nama,
					'image'   => $gambar,
					'url'     => $url,
					'publish' => $publish
					);

					$confirm = $this->m_entersite->insertslide($dataslide);
					if($confirm['status'] == '1'){
						$message = $confirm['pesan'];
						$status  = 'alert_success';
					}else{
						$message = $confirm['pesan'];
						$status  = 'alert_errors';
					}
				}else{
					$message = 'Error upload Image!';
					$status  = 'alert_errors';
				}

        	}else{
        		$message = 'Image is required!';
        		$status  = 'alert_errors';
        	}
        	$this->session->set_flashdata($status, $message);
        	redirect(base_url().'entersite/content/sliders');

		}else{
			show_404();
		}
	}

	function slideshow_edit($id){
		$post = $this->input->post();
		$row  = $this->db->get_where('slide', array('id' => $id))->row_array();
		if($row){
        	
        	if(!empty($_FILES['imagemain']['name'])){
        		$file_name = 'slide-'.my_slug($nama).'-time-'.date('YmdHis');
				$path                    = './assets/image/slideshow/';
				$config['upload_path']   = $path;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['file_name']     = $file_name.$config['file_ext'];
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('imagemain')){
					$gbr = $this->upload->data();
					$config['image_library']  ='gd2';
					$config['source_image']   = $path.$gbr['file_name'];
					$config['create_thumb']   = FALSE;
					$config['maintain_ratio'] = FALSE;
					$config['quality']        = '100%';
					$config['new_image']      = $path.$gbr['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$gambar                   = $file_name.$gbr['file_ext'];
				}else{
					$message = 'Error upload Image!';
					$status  = 'alert_errors';
				}
        	}
        	else{
        		$gambar = $row['image'];
        	}
			$dataupdate = array(
				'name'    => $post['name'],
				'image'   => $gambar,
				'url'     => $post['url'], 
				'publish' => ($post['publish'] == 'yes') ? '11' : '01'
			);

			$update = $this->m_entersite->updateslide($dataupdate, $id);
			if($update['status'] == '1'){
				$message = $update['pesan'];
				$status  = 'alert_success';
			}else{
				$message = $update['pesan'];
				$status  = 'alert_errors';
			}
			$this->session->set_flashdata($status, $message);
        	redirect(base_url().'entersite/content/sliders');
		}else{
			show_404();
		}
	}


	function category_page(){
		
			$kategori_page = $this->input->post('kategori_page');
			$data = array(
				'title_kategori' => my_slug($kategori_page)
				);
			$load   = ''; 
			$simpan = $this->m_entersite->insert_db($data, 'kategori_tambahan');
			if($simpan['status'] == 1){
				$list = $this->m_entersite->kategori_page();
				foreach ($list->result() as $key) {
					$load .='<option value="'.$key->id.'">'.strtoupper($key->title_kategori).'</option>';
				}
				$json['status']  = '1';
				$json['data']    = $load;
			}else{
				$json['status']  = '0';
			}

			$json['message'] = $simpan['pesan'];
			echo json_encode($json);
	
	}

	function static_page($section, $id = NULL){
		$title    = $this->input->post('title');
		$content  = $this->input->post('deskripsi');
		$kategori = $this->input->post('category');
		$seo1     = $this->input->post('seo1');
		$seo2     = $this->input->post('seo2');
		$seo3     = $this->input->post('seo3');
		if($this->input->post('publish') == 'yes'){
		$publish  = '11'; 
		}else{
		$publish  = '01';
		}
		$data = array(
			'section'        => $title,
			'kategori'       => $kategori,
			'link'           => my_slug($title),
			'deskripsi'      => $content,
			'title'          => $seo1,
			'meta_keyword'   => $seo2,
			'meta_deskripsi' => $seo3,
			'publish'        => $publish,
		);

		if($section == 'new'){
			$simpan = $this->m_entersite->static_page($data, 'new');
		}
		elseif($section == 'edit'){
			$simpan  = $this->m_entersite->static_page($data, 'edit', $id);
		}
		else{
			show_404();
		}
		if($simpan['status'] == '1'){
				$status  = 'alert_success';
		}else{
				$status  = 'alert_errors';
		}
		$this->session->set_flashdata($status, $simpan['pesan']);
        redirect(base_url().'entersite/static-page');
	}

	function static_action(){
		$submit = $this->input->post('action');
		$list   = $this->input->post('pages');
		$data   = array();

		if($submit == 'del'){
			$action = $this->m_entersite->remove_batch($list, 'id_page', 'static_page');
		}elseif($submit == 'publish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'id_page' => $list[$i],
				'publish' => '11'
				); 
			}
			$action = $this->m_entersite->edit_batch('id_page', 'static_page', $data);
		}elseif($submit == 'unpublish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'id_page' => $list[$i],
				'publish' => '01'
				); 
			}
			$action = $this->m_entersite->edit_batch('id_page', 'static_page', $data);
		}else{
			show_404();
		}

		if($action['status'] == '1'){
			$status  = 'alert_success';
		}else{
			$status  = 'alert_errors';
		}
		$this->session->set_flashdata($status, $action['pesan']);
        redirect(base_url().'entersite/static-page');
	}

	function voucher_action(){
		$submit = $this->input->post('action');
		$list   = $this->input->post('pages');
		$data   = array();
		

		if($submit == 'del'){
			for ($i=0; $i < count($list) ; $i++) { 
				$data[] = array(
					'ID_vou' => $list[$i],
					'publish' => 3
				); 
			}
			$action = $this->m_entersite->edit_batch('ID_vou', 'voucher', $data);
		}elseif($submit == 'publish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'ID_vou' => $list[$i],
				'publish' => 1
				); 
			}
			$action = $this->m_entersite->edit_batch('ID_vou', 'voucher', $data);
		}elseif($submit == 'unpublish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'ID_vou' => $list[$i],
				'publish' => 2
				); 
			}
			$action = $this->m_entersite->edit_batch('ID_vou', 'voucher', $data);
		}else{
			show_404();
		}

		if($action['status'] == '1'){
			$status  = 'alert_success';
		}else{
			$status  = 'alert_errors';
		}
		$this->session->set_flashdata($status, $action['pesan']);
        redirect(base_url().'entersite/voucher');
	}

	function categories_action(){
		$submit = $this->input->post('action');
		$list   = $this->input->post('pages');
		$data   = array();

		if($submit == 'del'){
			$action = $this->m_entersite->remove_batch($list, 'ID_cat', 'category');
		}elseif($submit == 'publish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'ID_cat' => $list[$i],
				'publish' => '11'
				); 
			}
			$action = $this->m_entersite->edit_batch('ID_cat', 'category', $data);
		}elseif($submit == 'unpublish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'ID_cat' => $list[$i],
				'publish' => '01'
				); 
			}
			$action = $this->m_entersite->edit_batch('ID_cat', 'category', $data);
		}else{
			show_404();
		}

		if($action['status'] == '1'){
			$status  = 'alert_success';
		}else{
			$status  = 'alert_errors';
		}
		$this->session->set_flashdata($status, $action['pesan']);
        redirect(base_url().'entersite/product/categories');
	}

	function brand_action(){
		$submit = $this->input->post('action');
		$list   = $this->input->post('pages');
		$data   = array();

		if($submit == 'del'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'ID_brand' => $list[$i],
				'publish' => 3
				); 
			}
			$action = $this->m_entersite->edit_batch('ID_brand', 'brand', $data);
		}elseif($submit == 'publish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'ID_brand' => $list[$i],
				'publish' => 1
				); 
			}
			$action = $this->m_entersite->edit_batch('ID_brand', 'brand', $data);
		}elseif($submit == 'unpublish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'ID_brand' => $list[$i],
				'publish' => 2
				); 
			}
			$action = $this->m_entersite->edit_batch('ID_brand', 'brand', $data);
		}else{
			show_404();
		}

		if($action['status'] == '1'){
			$status  = 'alert_success';
		}else{
			$status  = 'alert_errors';
		}
		$this->session->set_flashdata($status, $action['pesan']);
        redirect(base_url().'master/brand');
	}

	function delete_batch($id, $db){
		$submit = $this->input->post('action');
		$list   = $this->input->post('pages');
		if($submit == 'del'){
			$action = $this->m_entersite->remove_batch($list, $id, $db);
			if($action['status'] == '1'){
			$status  = 'alert_success';
			}else{
				$status  = 'alert_errors';
			}
			$this->session->set_flashdata($status, $action['pesan']);
	        redirect(base_url().'entersite/product/color-and-size');
		}else{
			show_404();
		}
	}


	function blog_action($uri, $id = NULL){
		$title    = $this->input->post('title');
		$content  = $this->input->post('deskripsi');
		$tags     = $this->input->post('tags');
		$seo1     = $this->input->post('seo1');
		$seo2     = $this->input->post('seo2');
		$seo3     = $this->input->post('seo3');
		if($this->input->post('publish') == 'yes'){
		$publish  = '11'; 
		}else{
		$publish  = '01';
		}
		$datepost = date('Y-m-d H:i:s');

		if($uri == 'new'){
			$data = array(
				'title'      => $title,
				'tags'       => $tags,
				'content'    => $content,
				'dateposted' => $datepost,
				'modified'   => $datepost,
				'publish'    => $publish
			);
			$simpan = $this->m_entersite->blog_data($uri, $data);
			if($simpan['status'] == '1'){
				$status  = 'alert_success';
			}else{
				$status  = 'alert_errors';
			}
			$this->session->set_flashdata($status, $simpan['pesan']);
        	redirect(base_url().'entersite/blog');

		}elseif($uri == 'edit' && $id){

			
			
		}else{
			show_404();
		}
	}

	function summernote_add_image(){
		if(!empty($_FILES['image']['name'])){
			$path     = FCPATH . 'assets/image/media/';
			$img      = file_upload('image', $path);
			if($img){
				echo base_url('assets/image/media/'.$img['file_name']);
			}
		}
	}

	function summernote_del_image(){
		$src = $this->input->post('src');
	    $file_name = str_replace(base_url(), '', $src);
	    if(unlink($file_name)){
	        echo 'File Delete Successfully';
	    }
	}

	function slide_action(){
		$submit = $this->input->post('action');
		$list   = $this->input->post('pages');
		$table  = $this->input->post('table');
		$data   = array();

		if($submit == 'del'){
			$action = $this->m_entersite->remove_batch($list, 'id', $table);
		}elseif($submit == 'publish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'id' => $list[$i],
				'publish' => '11'
				); 
			}
			$action = $this->m_entersite->edit_batch('id', $table, $data);
		}elseif($submit == 'unpublish'){
			for ($i=0; $i < count($list) ; $i++) { 
			$data[] = array(
				'id' => $list[$i],
				'publish' => '01'
				); 
			}
			$action = $this->m_entersite->edit_batch('id', $table, $data);
		}else{
			show_404();
		}

		if($action['status'] == '1'){
			$status  = 'alert_success';
		}else{
			$status  = 'alert_errors';
		}
		$this->session->set_flashdata($status, $action['pesan']);
        redirect(base_url().'entersite/'.$this->input->post('urlback'));
	}

	function banner(){
		$post = $this->input->post();
		if($post){
			$input_banner = $this->m_entersite->input_banner();
			if($input_banner){
				$this->session->set_flashdata('alert_success', 'Berhasil menyimpan data.');
			}else{
				$this->session->set_flashdata('alert_errors', 'Gagal menyimpan data.');
			}
			redirect(base_url('entersite/banner'));
		}else{
			show_404();
		}
	}

	function banner_edit($id){
		$post = $this->input->post();
		if($post){
			$edit_banner = $this->m_entersite->edit_banner($id);
			if($edit_banner){
				$this->session->set_flashdata('alert_success', 'Berhasil menyimpan data.');
			}else{
				$this->session->set_flashdata('alert_errors', 'Gagal menyimpan data.');
			}
			redirect(base_url('entersite/banner'));
		}else{
			show_404();
		}
	}

	function image(){
		$post = $this->input->post();
		if($post){
			$input_banner = $this->m_entersite->input_image();
			if($input_banner){
				$this->session->set_flashdata('alert_success', 'Berhasil menyimpan data.');
			}else{
				$this->session->set_flashdata('alert_errors', 'Gagal menyimpan data.');
			}
			redirect(base_url('entersite/image'));
		}else{
			show_404();
		}
	}

	function image_edit($id){
		$post = $this->input->post();
		if($post){
			$edit_banner = $this->m_entersite->edit_image($id);
			if($edit_banner){
				$this->session->set_flashdata('alert_success', 'Berhasil menyimpan data.');
			}else{
				$this->session->set_flashdata('alert_errors', 'Gagal menyimpan data.');
			}
			redirect(base_url('entersite/image'));
		}else{
			show_404();
		}
	}

	function table(){
		$post = $this->input->post();
		if($post){
			$this->session->set_userdata('table', trim($post['meja']));
		}
		redirect(base_url('entersite/packing'));
	}

}