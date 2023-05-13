<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Master extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->model(array('entersite/m_entersite', 'model_master', 'model_import'));
	}

	public function product(){
		$this->form_validation->set_rules('itemcode', 'Item Code', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['all_hirarki'] = $this->m_entersite->category_hirarki();
// 			pre($data['all_hirarki']->result_array());
			$data['color']       = $this->model_master->color();
			$data['size']        = $this->db->get('size')->result_array();
			$data['brand']       = $this->model_master->data("brand", array("publish" => 1));

			$this->temp_admin('admin/master/produk', $data);
		}else{

			$insert = $this->model_master->addproduct();

			if($insert){
				$this->session->set_flashdata('alert_success', 'Successfully added a product');
			}else{
				$this->session->set_flashdata('alert_errors', 'Error when contacting database');
			}

			redirect(base_url().'entersite/product/list');
		}
	}

	public function product_master($section = '', $id = ''){
		if($section == 'edit'){
			$this->form_validation->set_rules('itemcode', 'Item Code', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				$data['row']         = $this->model_master->master_list(array('ID_item' => input_clean($id)), FALSE);
				$data['all_hirarki'] = $this->m_entersite->category_hirarki();
				$data['color']       = $this->model_master->color();
				$data['size']        = $this->db->get('size')->result_array();
				$data['brand']       = $this->model_master->data("brand", array("publish !=" => 3));

				// pre($data['row']);

				$this->temp_admin('admin/master/produk_edit', $data);
			}else{

				$insert = $this->model_master->editproduct();

				if($insert){
					$this->session->set_flashdata('alert_success', 'Successfully added a product');
				}else{
					$this->session->set_flashdata('alert_errors', 'Error when contacting database');
				}

				redirect(base_url().'master/product-master');
			}
		}else{
			$data = array(
				'list' => $this->model_master->master_list()
			);

			$this->temp_admin('admin/master/product_mater_list', $data);
		}
	}

	public function del_product($id)
	{
		$row = $this->db->get_where('products', array('ID_item' => $id))->row_array();
		if($row > 0){
			$this->db->delete('products', array('ID_item' => $id));
			$this->db->delete('product_map', array('id_product' => $id));
			$this->db->delete('product_map_stock', array('id_product' => $id));
			$this->session->set_flashdata('alert_success', 'Product Deleted');
			redirect(base_url('master/product-master'));
		}else{
			show_404();
		}
	}

	public function product_data($id = ""){
		if($id){
			$this->form_validation->set_rules('id_map', 'ID', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				$data['produk'] = $this->m_entersite->list_products(array('map.ID_map' => $id), FALSE);
				$data['id'] 	= $data['produk']['ID_map'];
				$data['size']   = $this->db->get('size')->result_array();

				// pre($data['produk']);

				$this->temp_admin('admin/master/product_data', $data);
			}else{
				$insert = $this->model_master->addimageproduct();

				if($insert){
					$this->session->set_flashdata('alert_success', 'Successfully added a product');
				}else{
					$this->session->set_flashdata('alert_errors', 'Error when contacting database');
				}

				redirect(base_url().'entersite/product/list');
			}

		}else{
			show_404();
		}
	}

	public function del_size($id){
		$row = $this->db->get_where('product_map_stock', array('ID_ms' => input_clean($id)))->row_array();
		if(!empty($row)){
			$id      = $this->db->get_where('product_map', array('item_code' => $row['ItemCode'], 'color' => $row['color']))->row_array();
			$this->db->delete('product_map_stock', array('ID_ms' => $row['ID_ms']));
		}
		redirect(base_url('master/product_data/'.$id['ID_map']));
	}

	public function brand($section = "", $data = ""){
		if($section == "add"){
			$this->form_validation->set_rules('brand_name', 'Name', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				$data = array();
				$this->temp_admin('admin/master/brand_add', $data);
			}
			else{
				$insert = $this->model_master->addbrand();

				if($insert){
					$this->session->set_flashdata('alert_success', 'Successfully added a item');
				}else{
					$this->session->set_flashdata('alert_errors', 'Error when contacting database');
				}

				redirect(base_url().'master/brand');
			}
			
		}
		else if($section == "edit"){
			$this->form_validation->set_rules('brand_name', 'Name', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				$data = array(
				'data' => $this->model_master->data("brand", array("ID_brand" => $data), FALSE),
				);

				if($data['data']){
					$this->temp_admin('admin/master/brand_edit', $data);
				}
				else{
					redirect(base_url('master/brand'));
				}
			}
			else{
				$insert = $this->model_master->editbrand();

				if($insert){
					$this->session->set_flashdata('alert_success', 'Successfully edited a item');
				}else{
					$this->session->set_flashdata('alert_errors', 'Error when contacting database');
				}

				redirect(base_url().'master/brand');
			}
		}
		else{
			$data = array(
				'list' => $this->model_master->brand_list(),
			);
			$this->temp_admin('admin/master/brand_list', $data);
		}
	}

	public function addsize(){
		$post = $this->input->post();
		if($post){
			$row = $this->db->get_where('product_map', array('ID_map' => input_clean($post['id_map'])))->row_array();
			if(count($row) > 0){
				$where_map = array(
					'size'       => 0,
					'ItemCode'   => $row['item_code'],
					'id_product' => $row['id_product'],
					'barcode'    => $row['barcode'],
				);
				$cekmap = $this->db->get_where('product_map_stock', $where_map)->row_array();
				if(count($cekmap) > 0){
					$input  = array(
						'size'       => $post['size'],
						'stock'      => $post['stock']
					);
					$this->db->update('product_map_stock', $input, array('ID_ms' => $cekmap['ID_ms']));
				}else{
					$input  = array(
						'ItemCode'   => $row['item_code'],
						'id_product' => $row['id_product'],
						'barcode'    => $row['barcode'],
						'color'      => $row['color'],
						'size'       => $post['size'],
						'stock'      => $post['stock']
					);
					$this->db->insert('product_map_stock', $input);
				}
				redirect(base_url('master/product_data/'.$post['id_map']));
			}
		}
	}

	public function adjustment(){
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			error_reporting(0);
	    	$data = array();
	        if($this->session->flashdata('preview') != ''){
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				$filename    = $this->session->flashdata('preview');
				
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel   = $excelreader->load('excel/stock/'.$filename);
				$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
				
				// $assets        = array();

				$numrow      = 1;
			    foreach($sheet as $row){
			      if($numrow > 1){
			      	$barcode = str_replace('`', '', $row['F']);
			      	$size_id = preg_split('/-/', $barcode,-1, PREG_SPLIT_NO_EMPTY);
			   //    	array_push($assets, array(
						// 'item_code'     => $row['B'],
						// 'name'          => $row['C'],
						// 'color'         => $row['D'],
						// 'size'          => $row['E'],
						// 'barcode_clear' => $size_id[0],
						// 'barcode'       => $barcode,
						// 'id_size'       => (!empty($size_id[1])) ? $size_id[1] : '',
						// 'stock'         => $row['G'],
	    	// 		));

	    			$where = array(
	    				'barcode' => $size_id[0],
	    				'size'    => (!empty($size_id[1])) ? $size_id[1] : 14,
	    			);
	    			$this->db->update('product_map_stock', array('stock' => $row['G']), $where); 

			      }
			      
			      $numrow++;
			    }

			}
			$data['preview'] = $this->model_master->allstock();
			$this->temp_admin('admin/master/adjustment', $data);
		}
		else
		{
			// pre($this->input->post());
			$datapreview = $this->model_import->input_file_stock();

			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('master/adjustment'));
		}

		
	}

	function adjustment_stock(){
		$post = $this->input->post();
		if($post){
			$stock = $this->model_master->update_stock();
			if($stock){
				$this->session->set_flashdata('alert_success', 'Success');
			}else{
				$this->session->set_flashdata('alert_errors', 'Data melebihi kapasitas sekali Upload (max 500 baris data)');
			}
			redirect(base_url('master/adjustment'));
		}
		else{
			show_404();
		}
	}

	public function product_delete($id){
		$row = $this->db->get_where('product_map', array('ID_map' => input_clean($id)))->row_array();
		if($row){
			$id      = $this->db->get_where('products', array('ItemCode' => $row['item_code']))->row_array();
			$barcode = $row['barcode'];
			$this->db->delete('product_map', array('barcode' => $barcode));
			$this->db->delete('product_map_stock', array('barcode' => $barcode));
		}
		redirect(base_url('master/product-master/edit/'.$id['ID_item']));
	}

	public function stock_produk(){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="STOK'.date("Y-m-d H:i:s").'".xls"');
		header('Cache-Control: max-age=0');
		
     	$data['list_produk']  = $this->model_master->allstock();
     	// pre($data['list_produk']);
     	$this->load->view('admin/master/stock_produk', $data);
	}


}