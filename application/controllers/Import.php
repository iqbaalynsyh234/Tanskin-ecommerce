<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->model('model_import');
		$this->load->helper(array('function'));
	}

	public function index()
	{
		$test = $this->model_import->no_transaksi();
		pre($test);
        redirect(base_url('import/tokopedia'));
	}
	
	public function tokopedia()
	{
		error_reporting(0);

	    $data = array();
        if($this->session->flashdata('preview') != ''){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$filename    = $this->session->flashdata('preview');
			
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel   = $excelreader->load('excel/'.$filename);
			$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			$assets        = array();

			$numrow      = 1;
		    foreach($sheet as $row){
		      if($numrow > 4){
		      	$getcode       = barcode_from_sku(trim($row['I']));
		      	$barcode       = $getcode[0];
		        $cekinvoice    = $this->model_import->cek_pos($row['C'], 'Tokopedia')->num_rows();
		        if($cekinvoice == 0 && !empty($row['I'])){
		            $cekbarcode = $this->model_import->cek_produk($barcode)->num_rows();
		            array_push($assets, array(
    					'count'         => $row['A'],
    					'invoice'       => $row['C'],
    					'payment_date'  => $row['D'],
    					'product_name'  => $row['G'],
    					'qty'           => $row['H'],
    					'sku'           => $row['I'],
    					'barcode'       => $barcode,
    					'size'          => (!empty($getcode[1])) ? $getcode[1] : '',
    					'error'         => ($cekbarcode == 0) ? 'error' : '',
    					'price'         => $row['K'],
    					'customer_name' => $row['P'],
    					'phone'         => $row['Q'],
    					'address'       => $row['R'],
    					'shipping_fee'  => $row['V'],
    					'total'         => $row['W']
    			    ));
		        }
		      }
		      
		      $numrow++;
		    }

		    $data['preview'] = $assets;



		}
		
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->temp_admin('admin/import/tokopedia', $data);
		}
		else
		{
			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('import/tokopedia'));
		}
	}
	
	public function zalora()
	{
		error_reporting(0);
	    $data = array();
	    $data['marketplace'] = 'Zalora';
        if($this->session->flashdata('preview') != ''){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$filename    = $this->session->flashdata('preview');

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel   = $excelreader->load('excel/'.$filename);
			$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			$assets        = array();
			
			$numrow      = 1;
		    foreach($sheet as $row){
		      if($numrow > 1){
		      	$getcode       = barcode_from_sku(trim($row['C']));
		      	$barcode       = $getcode[0];
		        $cekinvoice   = $this->model_import->cek_pos($row['G'], $data['marketplace'])->num_rows();
		        if($cekinvoice == 0 && !empty($row['C'])){
		            $cekbarcode = $this->model_import->cek_produk($barcode)->num_rows();
		            array_push($assets, array(
		                'count'         => $row['B'],
    					'invoice'       => $row['G'],
    					'payment_date'  => $row['F'],
    					'product_name'  => $row['AR'],
    					'qty'           => ceil($row['AM'] / $row['AN']),
    					'sku'           => $row['C'],
    					'barcode'       => $barcode,
    					'size'          => (!empty($getcode[1])) ? $getcode[1] : '',
    					'error'         => ($cekbarcode == 0) ? 'error' : '',
    					'price'         => $row['AN'] + 0,
    					'customer_name' => $row['J'],
    					'phone'         => $row['S'],
    					'address'       => $row['Z'],
    					'shipping_fee'  => $row['AP'] + 0,
    					'total'         => $row['AM'] + $row['AP']
    			    ));
		        }
		      }
		      
		      $numrow++;
		    }
            
		    $data['preview'] = $assets;

		}
		
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->temp_admin('admin/import/'.strtolower($data['marketplace']), $data);
		}
		else
		{
			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('import/'.strtolower($data['marketplace'])));
		}
	}
	
	public function shopee()
	{
		error_reporting(0);
	    $data = array();
	    $data['marketplace'] = 'Shopee';
        if($this->session->flashdata('preview') != ''){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$filename    = $this->session->flashdata('preview');

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel   = $excelreader->load('excel/'.$filename);
			$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			$assets        = array();
			
			$numrow      = 1;
			$NO = 1;
		    foreach($sheet as $row){
		      if($numrow > 1 && $row['A'] != ''){
		      	$getcode       = barcode_from_sku(trim($row['M']));
		      	$barcode       = $getcode[0];
		        $cekinvoice   = $this->model_import->cek_pos($row['A'], $data['marketplace'])->num_rows();
		        if($cekinvoice == 0 && !empty($row['L'])){
		            $cekbarcode = $this->model_import->cek_produk($barcode)->num_rows();
		            array_push($assets, array(
		                'count'         => $NO,
    					'invoice'       => $row['A'],
    					'payment_date'  => $row['J'],
    					'product_name'  => $row['L'],
    					'qty'           => $row['Q'],
    					'sku'           => $row['M'],
    					'barcode'       => $barcode,
    					'size'          => (!empty($getcode[1])) ? $getcode[1] : '',
    					'error'         => ($cekbarcode == 0) ? 'error' : '',
    					'price'         => rupiah_to_number($row['P']),
    					'customer_name' => $row['AL'],
    					'phone'         => $row['AN'],
    					'address'       => $row['AO'],
    					'shipping_fee'  => rupiah_to_number($row['AG']),
    					'total'         => rupiah_to_number($row['P']) + rupiah_to_number($row['AG'])
    			    ));
		        }
		        $NO ++;
		      }
		      
		      $numrow++;
		    }
            
		    $data['preview'] = $assets;
		}
		
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->temp_admin('admin/import/'.strtolower($data['marketplace']), $data);
		}
		else
		{
			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('import/'.strtolower($data['marketplace'])));
		}
	}
	
	public function blibli()
	{
		error_reporting(0);
	    $data = array();
	    $data['marketplace'] = 'Blibli';
        if($this->session->flashdata('preview') != ''){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$filename    = $this->session->flashdata('preview');

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel   = $excelreader->load('excel/'.$filename);
			$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			$assets      = array();
			$numrow      = 1;
		    foreach($sheet as $row){
		      if($numrow > 1){
		      	$getcode       = barcode_from_sku(trim($row['E']));
		      	$barcode       = $getcode[0];
		        $cekinvoice   = $this->model_import->cek_pos($row['A'], $data['marketplace'])->num_rows();
		        if($cekinvoice == 0 && !empty($row['E'])){
		            $cekbarcode = $this->model_import->cek_produk($barcode)->num_rows();
		            array_push($assets, array(
		                'count'         => $numrow,
    					'invoice'       => $row['A'],
    					'payment_date'  => $row['C'],
    					'product_name'  => $row['G'],
    					'qty'           => $row['H'],
    					'sku'           => $row['E'],
    					'barcode'       => $barcode,
    					'size'          => (!empty($getcode[1])) ? $getcode[1] : '',
    					'error'         => ($cekbarcode == 0) ? 'error' : '',
    					'price'         => $row['I'],
    					'customer_name' => $row['D'],
    					'phone'         => '',
    					'address'       => '',
    					'shipping_fee'  => 0,
    					'total'         => $row['H'] * rupiah_to_number($row['I'])
    			    ));
		        }
		      }
		      
		      $numrow++;
		    }
		    
		    $data['preview'] = $assets;

		}
		
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->temp_admin('admin/import/'.strtolower($data['marketplace']), $data);
		}
		else
		{

			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('import/'.strtolower($data['marketplace'])));
		}
	}

	public function lazada()
	{
		error_reporting(0);
	    $data = array();
	    $data['marketplace'] = 'Lazada';
        if($this->session->flashdata('preview') != ''){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$filename    = $this->session->flashdata('preview');

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel   = $excelreader->load('excel/'.$filename);
			$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

			$assets      = array();
			
			$numrow      = 1;
		    foreach($sheet as $row){
		      if($numrow > 1){
		      	$getcode       = barcode_from_sku(trim($row['F']));
		      	$barcode       = $getcode[0];
		        $cekinvoice   = $this->model_import->cek_pos($row['A'], $data['marketplace'])->num_rows();
		        if($cekinvoice == 0 && !empty($row['F'])){
		            $cekbarcode = $this->model_import->cek_produk($barcode)->num_rows();
		            array_push($assets, array(
		                'count'         => $numrow,
    					'invoice'       => $row['M'],
    					'payment_date'  => $row['J'],
    					'product_name'  => $row['AY'],
    					'qty'           => ceil($row['AU'] / $row['AV']),
    					'sku'           => $row['F'],
    					'barcode'       => $barcode,
    					'size'          => (!empty($getcode[1])) ? $getcode[1] : '',
    					'error'         => ($cekbarcode == 0) ? 'error' : '',
    					'price'         => $row['AV'] + 0,
    					'customer_name' => $row['Q'],
    					'phone'         => $row['AL'],
    					'address'       => $row['AG'],
    					'shipping_fee'  => $row['AW'] + 0,
    					'total'         => $row['AU'] + $row['AW']
    			    ));
		        }
		      }
		      
		      $numrow++;
		    }
            
		    $data['preview'] = $assets;

		}
		
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->temp_admin('admin/import/'.strtolower($data['marketplace']), $data);
		}
		else
		{
			
			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('import/'.strtolower($data['marketplace'])));
		}
	}
	
	public function akulaku()
	{
		error_reporting(0);
	    $data = array();
	    $data['marketplace'] = 'Akulaku';
        if($this->session->flashdata('preview') != ''){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$filename    = $this->session->flashdata('preview');

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel   = $excelreader->load('excel/'.$filename);
			$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			$assets        = array();
			
			$numrow      = 1;
		    foreach($sheet as $row){
		      if($numrow > 1){
		        $cekinvoice   = $this->model_import->cek_pos($row['A'], $data['marketplace'])->num_rows();
		        if($cekinvoice == 0 && !empty($row['F'])){
		            $cekbarcode = $this->model_import->cek_produk($row['F'])->num_rows();
		            array_push($assets, array(
		                'count'         => $numrow,
    					'invoice'       => $row['A'],
    					'payment_date'  => $row['C'],
    					'product_name'  => $row['U'],
    					'qty'           => $row['P'],
    					'sku'           => $row['W'],
    					'barcode'       => $row['F'],
    					'error'         => ($cekbarcode == 0) ? 'error' : '',
    					'price'         => rupiah_to_number($row['Q']),
    					'customer_name' => $row['E'],
    					'phone'         => $row['M'],
    					'address'       => $row['K'],
    					'shipping_fee'  => rupiah_to_number($row['AA']),
    					'total'         => ($row['P'] * rupiah_to_number($row['Q'])) + rupiah_to_number($row['AA'])
    			    ));
		        }
		      }
		      
		      $numrow++;
		    }
            
		    $data['preview'] = $assets;

		}
		
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->temp_admin('admin/import/'.strtolower($data['marketplace']), $data);
		}
		else
		{
			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('import/'.strtolower($data['marketplace'])));
		}
	}
	
	public function kamnco()
	{
		error_reporting(0);
	    $data = array();
	    $data['marketplace'] = 'Kamnco';
        if($this->session->flashdata('preview') != ''){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$filename    = $this->session->flashdata('preview');

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel   = $excelreader->load('excel/'.$filename);
			$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			$assets        = array();
			
			$numrow      = 1;
		    foreach($sheet as $row){
		      if($numrow > 2){
		        $cekinvoice   = $this->model_import->cek_pos($row['B'], $data['marketplace'])->num_rows();
		        if($cekinvoice == 0 && !empty($row['F']) && !empty($row['P'])){
		            $cekbarcode = $this->model_import->cek_produk($row['F'])->num_rows();
		            $harga = ceil(rupiah_to_number($row['Q']) / $row['P']);
		            array_push($assets, array(
		                'count'         => $numrow,
    					'invoice'       => $row['A'],
    					'payment_date'  => $row['C'],
    					'product_name'  => $row['R'],
    					'qty'           => $row['P'],
    					'sku'           => $row['R'],
    					'barcode'       => $row['F'],
    					'error'         => ($cekbarcode == 0) ? 'error' : '',
    					'price'         => $harga,
    					'customer_name' => $row['E'],
    					'phone'         => $row['G'],
    					'address'       => $row['K'],
    					'shipping_fee'  => rupiah_to_number($row['M']),
    					'total'         => rupiah_to_number($row['Q']) + rupiah_to_number($row['M'])
    			    ));
		        }
		      }
		      
		      $numrow++;
		    }
            
		    $data['preview'] = $assets;

		}
		
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->temp_admin('admin/import/'.strtolower($data['marketplace']), $data);
		}
		else
		{
			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('import/'.strtolower($data['marketplace'])));
		}
	}
	
	public function bukalapak()
	{
		error_reporting(0);
	    $data = array();
	    $data['marketplace'] = 'Bukalapak';
        if($this->session->flashdata('preview') != ''){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$filename    = $this->session->flashdata('preview');

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel   = $excelreader->load('excel/'.$filename);
			$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			pre($sheet);
			$assets        = array();
			
			$numrow      = 1;
		    foreach($sheet as $row){
		      if($numrow > 1){
		        $cekinvoice   = $this->model_import->cek_pos($row['B'], $data['marketplace'])->num_rows();
		        if($cekinvoice == 0 && !empty($row['F'])){
		            $cekbarcode = $this->model_import->cek_produk($row['F'])->num_rows();
		            array_push($assets, array(
		                'count'         => $numrow,
    					'invoice'       => $row['B'],
    					'payment_date'  => $row['A'],
    					'product_name'  => $row['P'],
    					'qty'           => $row['U'],
    					'sku'           => $row['V'],
    					'barcode'       => $row['F'],
    					'error'         => ($cekbarcode == 0) ? 'error' : '',
    					'price'         => rupiah_to_number($row['T']) / $row['U'],
    					'customer_name' => $row['H'],
    					'phone'         => $row['J'],
    					'address'       => $row['K'],
    					'shipping_fee'  => rupiah_to_number($row['R']),
    					'total'         => rupiah_to_number($row['T']) + rupiah_to_number($row['R'])
    			    ));
		        }
		      }
		      
		      $numrow++;
		    }
            
		    $data['preview'] = $assets;

		}
		
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->temp_admin('admin/import/'.strtolower($data['marketplace']), $data);
		}
		else
		{
			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('import/'.strtolower($data['marketplace'])));
		}
	}
	
	public function meesho()
	{
		error_reporting(0);
	    $data = array();
	    $data['marketplace'] = 'Meesho';
        if($this->session->flashdata('preview') != ''){
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$filename    = $this->session->flashdata('preview');

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel   = $excelreader->load('excel/'.$filename);
			$sheet       = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			$assets        = array();
			
			$numrow      = 1;
		    foreach($sheet as $row){
		      if($numrow > 3){
		        $cekinvoice   = $this->model_import->cek_pos($row['C'], $data['marketplace'])->num_rows();
		        if($cekinvoice == 0 && !empty($row['F'])){
		            $cekbarcode = $this->model_import->cek_produk($row['F'])->num_rows();
		            array_push($assets, array(
		                'count'         => $numrow,
    					'invoice'       => $row['C'],
    					'payment_date'  => $row['G'],
    					'product_name'  => $row['K'],
    					'qty'           => $row['N'],
    					'sku'           => $row['L'],
    					'barcode'       => $row['F'],
    					'error'         => ($cekbarcode == 0) ? 'error' : '',
    					'price'         => rupiah_to_number($row['O']),
    					'customer_name' => $row['H'],
    					'phone'         => '',
    					'address'       => '',
    					'shipping_fee'  => 0,
    					'total'         => $row['N'] * rupiah_to_number($row['O'])
    			    ));
		        }
		      }
		      
		      $numrow++;
		    }
            
		    $data['preview'] = $assets;

		}
		
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->temp_admin('admin/import/'.strtolower($data['marketplace']), $data);
		}
		else
		{
			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('import/'.strtolower($data['marketplace'])));
		}
	}
	

	
	public function send()
	{
		$this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			$this->session->set_flashdata('error', 'no data sending');
		}
		else
		{

            $post = $this->input->post();
            $this->model_import->orders_insert();

		    $this->session->set_flashdata('alert_success', 'Data succesfully saved!');
		    $this->session->unset_userdata('preview');
		    
		    redirect(base_url('import/'.strtolower($post['template'])));
		}
		
	}

	public function stock(){
		$data = array();
		$this->temp_admin('admin/import/stock', $data);
	}

	public function stockmarketplace($section){
	    header("Content-disposition: attachment; filename= ".strtoupper($section).' - '.date("Y-m-d H:i:s").".xls");
	    header("Content-Type: application/vnd.ms-excel");
	    $post = $this->input->get();
	    $data['stock'] = $this->model_import->marketplace_stock(input_clean($post['percentase']));
	    $this->load->view('admin/marketplace/stock/template_stock', $data);
	    
	    // if($section == 'tokopedia'){
	    //     $data['stock'] = $this->model_import->marketplace_stock(input_clean($post['percentase']));
	    //     $this->load->view('admin/marketplace/stock/'.$section, $data);
	    // }
	    // else if($section == 'zalora'){
	    //     $data['stock'] = $this->model_import->marketplace_stock(input_clean($post['percentase']));
	    //     $this->load->view('admin/marketplace/stock/'.$section, $data);
	    // }
	    // else if($section == 'shopee'){
	    //     $data['stock'] = $this->model_import->marketplace_stock(input_clean($post['percentase']));
	    //     $this->load->view('admin/marketplace/stock/'.$section, $data);
	    // }
	    // else if($section == 'blibli'){
	    //     $data['stock'] = $this->model_import->marketplace_stock(input_clean($post['percentase']));
	    //     $this->load->view('admin/marketplace/stock/'.$section, $data);
	    // }
	    // else if($section == 'lazada'){
	    //     $data['stock'] = $this->model_import->marketplace_stock(input_clean($post['percentase']));
	    //     $this->load->view('admin/marketplace/stock/'.$section, $data);
	    // }
	    // else{
	    //     redirect(base_url('import/stock'));
	    // }
	  }
	
	public function adjustmentstock(){
	    $this->form_validation->set_rules('template', '<strong>template</strong>', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        if($this->form_validation->run() == FALSE)
        {
			redirect(base_url('home/movement/adjustment-doc'));
		}
		else
		{
			$datapreview = $this->model_import->input_file();
			if($datapreview == FALSE){
				$this->session->set_flashdata('errors', 'no file input');
			}else{
				$this->session->set_flashdata('preview', $datapreview);
			}
			redirect(base_url('home/movement/adjustment-doc'));
		}
	}
}
