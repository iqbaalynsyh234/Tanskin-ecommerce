<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Import_new extends CI_Controller {

	public function index(){
		// $inputFileType = 'Xlsx';
		// $inputFileName = FCPATH . 'excel/item-1-100.xlsx';
		// $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
		// $reader->setReadDataOnly(true);
		// $spreadsheet = $reader->load($inputFileName);

		// $schdeules = $spreadsheet->getActiveSheet()->toArray();

		// foreach ($schdeules as $single_schedule) {
			
		// 	$row = $this->db->get_where('products', array('ItemCode' => $single_schedule[2]));
		// 	if($row->num_rows() == 0){
		// 		$data = array(
		// 				'ItemCode'   => $single_schedule[2],
		// 				'ItemSubcate' => '1',
		// 				'url'        => create_seo_url(my_slug($single_schedule[5])),
		// 				'ItemType'   => 2,
		// 				'brand_code' => substr(str_replace('`', '', $single_schedule[4]), 0, 4),
		// 				'ItemName'   => $single_schedule[5],
		// 				'ItemNmDesc' => 'Moeslim Dress',
		// 				'meta_title' => $single_schedule[5],
		// 				'ItemWeight' => 400,
		// 				'created'    => date('Y-m-d H:i:s'),
		// 				'Uploader'   => $this->session->userdata('id_admin'),
		// 				'publish'    => '11'
		// 			);
		// 		$this->db->insert("products", $data);
		// 		$id = $this->db->insert_id();
		// 	}else{
		// 		$id = $row->row_array()['ID_item'];
		// 	}
			
		// 	$kodecolor = $this->db->get_where("color", array("ColorName" => $single_schedule[3]))->row_array();
		// 	$barcode   = str_replace('`', '', $single_schedule[4]);

		// 	$map = array(
		// 		'id_product' => $id,
		// 		'item_code'  => $single_schedule[2],
		// 		'barcode'    => $barcode,
		// 		'color'      => $kodecolor['ID_color'],
		// 	);

		// 	$stock = array(
		// 		'id_product' => $id,
		// 		'ItemCode'   => $single_schedule[2],
		// 		'barcode'    => $barcode,
		// 		'color'      => $kodecolor['ID_color'],
		// 		'stock'      => $single_schedule[6]
		// 	);

		// 	$this->db->insert("product_map", $map);
		// 	$this->db->insert("product_map_stock", $stock);
		// }

		// echo 'finish';
		
	}
}
