<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Entersite extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->model(array('entersite/m_entersite', 'entersite/m_settings'));
		$this->load->model('entersite/M_datatables', 'entersite');
		$this->load->model('entersite/M_orderslist', 'orderlist');
	}

	public function index(){
		$data['produk']        = $this->m_entersite->produk_terlaris();
		$data['order_today']   = $this->m_entersite->order_today();
		$data['pay_week']      = $this->m_entersite->order_pay_week();
		$data['items_week']    = $this->m_entersite->order_item_week();
		$data['warning_stock'] = $this->m_entersite->warning_stock();
		// pre($data['warning_stock']);
		$this->temp_admin('admin/dashboard', $data);
	}

	public function login(){
		if($this->session->userdata('admin_login') == true){
			redirect(base_url('entersite'));
		}else{
			$this->load->view('admin/login');
		}
	}

	public function logout_admin(){
		$this->session->sess_destroy();
		redirect(base_url('entersite/login'));
	}

	function admin_gate(){
		if(IS_AJAX){
			$admin['email']    = $this->input->post('field_0994');
			$admin['password'] = encyript_password($this->input->post('field_0995'));
			$gate    = $this->m_entersite->admin_check($admin);
			if($gate == '01'){
				$json['status'] = '01';
				$json['uri']    = base_url('entersite');
			}else{
				$json['status'] = '00';
				$json['alert']  = 'alert-warning';
				$json['message']= 'Email or Password is not match';
			}
			echo json_encode($json);
		}
	}

	public function view_website(){
		$this->temp_admin('admin/view_website');
	}

	public function product($segment, $sub = NULL){
		if($segment == 'add-item'){

			$data['all_hirarki']     = $this->m_entersite->category_hirarki();
			$data['listcolor']       = $this->m_entersite->list_db('color');
			$data['listsize']        = $this->m_entersite->list_db('size');
			$data['list_categories'] = $this->m_entersite->list_db('category');
			
			$this->temp_admin('admin/products/add_item', $data);

		}
		elseif($segment == 'update-item'){
			$row = $this->m_entersite->get_details_products($sub);

			if($row){
				$data['all_hirarki']     = $this->m_entersite->category_hirarki();
				$data['listcolor']       = $this->m_entersite->list_db('color');
				$data['listsize']        = $this->m_entersite->list_db('size');
				$data['list_categories'] = $this->m_entersite->list_db('category');
				$data['item']            = $row;

				$this->temp_admin('admin/products/update_item', $data);
			}else{
				show_404();
			}
		}
		elseif($segment == 'list'){
			$where = array();
			$get   = $this->input->get();
			if(!empty($get['itemcode']) || !empty($this->session->userdata('sort_product'))){
				
				if(empty($this->session->userdata('sort_product'))){
					$this->session->set_userdata('sort_product', input_clean($get['itemcode']));
				}
				$data['item_code'] = $this->session->userdata('sort_product');
				$where = array(
					'map.item_code' => $data['item_code']
				);
				
			}
			$data['list_produk'] = $this->m_entersite->list_products($where, TRUE);
			// pre($data['list_produk']);
			$this->temp_admin('admin/products/list', $data);

		}
		elseif($segment == 'clear'){
			$this->session->unset_userdata('sort_product');
			redirect(base_url('entersite/product/list'));
		}
		elseif($segment == 'categories'){

			$data['list_categories'] = $this->m_entersite->list_category();
			$data['all_hirarki']     = $this->m_entersite->category_hirarki();

			if($sub == NULL){
				$this->temp_admin('admin/products/categories', $data);
			}elseif($sub == 'edit'){
				$id  = $this->uri->segment(5);
				$row = $this->db->get_where('category', array('ID_cat' => $id))->row_array();
				if(!empty($row)){
					$data['row'] = $row;
					// pre($data['row']);
					$this->temp_admin('admin/products/categories_edit', $data);
				}else{
					show_404();
				}
			}elseif($sub == 'add'){
				$this->temp_admin('admin/products/categories_add', $data);
			}else{
				show_404();
			}
			
		}elseif($segment == 'color-and-size'){
			
			$data['listcolor'] = $this->m_entersite->list_db('color');
			$data['listsize']  = $this->m_entersite->list_db('size');
			$this->temp_admin('admin/products/color', $data);

		}else{
			show_404();
		}
	}


	function addcolor(){
		if($this->input->post('submitcolor') != null){
		$colorcode = implode(';', $this->input->post('colorcode'));
		$colorname = strtolower($this->input->post('colorname'));
		$cekcolor  = $this->m_entersite->list_where('ID_colorname', my_slug($colorname), 'color')->num_rows();
		if($cekcolor == 0){
			$kode = $this->db->order_by('ID_color', 'DESC')->get('color')->row_array();
			$datainsert = array(
				'ID_colorname' => my_slug($colorname), 
				'ColorName' => $colorname, 
				'ColorCode' => $colorcode,
				'kodewarna' => $kode['ID_color'] + 1,
			);
			$insert     = $this->db->insert('color', $datainsert);
			if($insert){
				$this->session->set_flashdata('alert_success', 'Berhasil menambahkan data');
			}else{
				$this->session->set_flashdata('alert_errors', 'Gagal menambahkan data');
			}
		}else{
			$this->session->set_flashdata('alert_errors', 'Nama sudah digunakan');
		}
		redirect(base_url().'entersite/product/color-and-size');
		}else{
			show_404();
		}
	}

	function addsize(){
		if($this->input->post('submitsize') != null){
		$size     = strtolower($this->input->post('size'));
		$ceksize  = $this->m_entersite->list_where('ID_sizename', my_slug($size), 'size')->num_rows();
		if($ceksize == 0){
			$datainsert = array('ID_sizename' => my_slug($size), 'Size' => $size);
			$insert     = $this->db->insert('size', $datainsert);
			if($insert){
				$this->session->set_flashdata('alert_success', 'Berhasil menambahkan data');
			}else{
				$this->session->set_flashdata('alert_errors', 'Gagal menambahkan data');
			}
		}else{
			$this->session->set_flashdata('alert_errors', 'Nama sudah digunakan');
		}
		redirect(base_url().'entersite/product/color-and-size');
		}else{
			show_404();
		}
	}

	public function voucher($page = '', $uri = ''){
		if($page == 'add'){
			
		}
		elseif($page == 'edit'){
			$data['list_voucher'] = $this->m_entersite->list_voucher($uri)->row_array();
			$this->temp_admin('admin/voucher/edit', $data);
		}
		else{
			$data['list_voucher'] = $this->m_entersite->list_voucher()->result();
			$this->temp_admin('admin/voucher/list', $data);
		}
	}

	function addvoucher(){
		if($this->input->post('submit') != null){
			$coup    = strtoupper($this->input->post('coupon'));
			$max     = 0;
			if($this->input->post('potongan-max') !=''){ $max = $this->input->post('potongan-max'); }
			$where   = 'vou_code = "'.$coup.'"';
			$dataold = $this->m_entersite->checksome('voucher', $where)->num_rows();
			if($dataold == 0){
				$exp_vou = explode('-', $this->input->post('sortdate'));
			$datavou = array(
				'vou_code'      => $coup,
				'Disc'          => rupiah_to_number($this->input->post('potongan')),
				'vou_for'       => $this->input->post('kategori'),
				'min_amount'    => rupiah_to_number($this->input->post('mintagihan')),
				'max'           => rupiah_to_number($max),
				'usage_vou'     => $this->input->post('kuota'),
				'input_vou'     => date('Y-m-d'),
				'start_voucher' => date('Y-m-d', strtotime($exp_vou[0])),
				'end_voucher'   => date('Y-m-d', strtotime($exp_vou[1])),
				'publish'       => $this->input->post('publish'),
				'gbrqrcode'       => $this->input->post('gbrqrcode'),
				);
				$insert = $this->db->insert('voucher', $datavou);
				if($insert){
					$this->session->set_flashdata('alert_success', 'Berhasil membuat voucher baru');
				}else{
					$this->session->set_flashdata('alert_errors', 'Gagal membuat voucher');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Nama voucher sudah digunakan!');
			}
			redirect(base_url().'entersite/voucher');
		}else{
			show_404();
		}
	}


	function editvoucher($uri){
		if($this->input->post('submit') != null){
			$coup    = strtoupper($this->input->post('coupon'));
			$max     = 0;
			if($this->input->post('potongan-max') !=''){ $max = $this->input->post('potongan-max'); }
			$where   = array('vou_code' => $coup, 'ID_vou !=' => $uri);
			$dataold = $this->m_entersite->checksome('voucher', $where)->num_rows();
			if($dataold == 0){
				$exp_vou = explode('-', $this->input->post('sortdate'));
			$datavou = array(
				'vou_code'      => $coup,
				'Disc'          => rupiah_to_number($this->input->post('potongan')),
				'vou_for'       => $this->input->post('kategori'),
				'min_amount'    => rupiah_to_number($this->input->post('mintagihan')),
				'usage_vou'     => $this->input->post('kuota'),
				'input_vou'     => date('Y-m-d'),
				'start_voucher' => date('Y-m-d', strtotime($exp_vou[0])),
				'end_voucher'   => date('Y-m-d', strtotime($exp_vou[1])),
				'publish'       => $this->input->post('publish')
				);
				$insert = $this->db->update('voucher', $datavou, array('ID_vou' => $uri));
				if($insert){
					$this->session->set_flashdata('alert_success', 'Berhasil edit voucher baru');
				}else{
					$this->session->set_flashdata('alert_errors', 'Gagal edit voucher');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Nama voucher sudah digunakan!');
			}
			redirect(base_url().'entersite/voucher');
		}else{
			show_404();
		}
	}


	public function setting( $segment = '' ){
		$this->load->library('form_validation');
		if($segment == '' || $segment == 'store'){
			$data['store'] = $this->m_settings->view('store')->row();
			$this->temp_admin('admin/setting/store', $data);

		}elseif($segment == 'delivery'){

			$this->temp_admin('admin/setting/delivery');

		}elseif($segment == 'shipping'){

			$data['ekspedisi']   = $this->m_settings->view('expedisi');
			$data['eks_publish'] = $this->m_settings->view_publish('expedisi');
			$this->temp_admin('admin/setting/shipping', $data);

		}elseif($segment == 'bank'){

			$data['bank'] = $this->m_settings->view('bank');
			$this->temp_admin('admin/setting/bank', $data);

		}elseif($segment == 'social-media'){

			$data['medsos'] = $this->m_settings->view_where('social_media', array('type' => 0));
			$this->temp_admin('admin/setting/social-media', $data);

		}elseif($segment == 'marketplace'){

			$data['medsos'] = $this->m_settings->view_where('social_media', array('type' => 1));
			$this->temp_admin('admin/setting/marketplace', $data);

		}
		elseif($segment == 'web'){
			$this->form_validation->set_rules('min_pembelanjaan', 'Min', 'required');
			$this->form_validation->set_rules('max_potongan', 'Max', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				$data = array();
				$this->temp_admin('admin/setting/web', $data);
			}else{

				foreach ($this->input->post() as $key => $value) {
					$this->db->update('setting', array('value' => $value), array('key' => $key));
				}
				
				$this->session->set_flashdata('alert_success', 'Berhasil update data');
				redirect(base_url('entersite/setting/web'));
			}
		}
		else{
			show_404();
		}
	}


	public function ajax_list(){

		$expd = $this->m_settings->view_publish('expedisi')->result();
		$list = $this->entersite->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $customers) {
			if($customers->reg == 0) { $reg = '-'; } else { $reg = rupiah($customers->reg); }
			if($customers->oke == 0) { $oke = '-'; } else { $oke = rupiah($customers->oke); }
			if($customers->yes == 0) { $yes = '-'; } else { $yes = rupiah($customers->yes); }
			if($customers->pos == 0) { $pos = '-'; } else { $pos = rupiah($customers->pos); }
			if($customers->wahana1 == 0) { $wah = '-'; } else { $wah = rupiah($customers->wahana1); }
			if($customers->tiki == 0) { $tik = '-'; } else { $tik = rupiah($customers->tiki); }
			if($customers->sicepat == 0) { $sic = '-'; } else { $sic = rupiah($customers->sicepat); }
			if($customers->jt == 0) { $jte = '-'; } else { $jte = rupiah($customers->jt); }
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '('.$customers->propinsi.') '.$customers->kabupaten;
			$row[] = $customers->kecamatan;
			foreach ($expd as $key) {
				if($key->id_ex == 1){
					$row[] = '<input class="priceformat" type="text" data-id="a" value="'.$reg.'" readonly>';
					$row[] = '<input class="priceformat" type="text" data-id="b" value="'.$oke.'" readonly>';
					$row[] = '<input class="priceformat" type="text" data-id="c" value="'.$yes.'" readonly>';
				}elseif($key->id_ex == 2){
					$row[] = '<input class="priceformat" type="text" data-id="f" value="'.$jte.'" readonly>';
				}elseif($key->id_ex == 3){
					$row[] = '<input class="priceformat" type="text" data-id="e" value="'.$wah.'" readonly>';
				}elseif($key->id_ex == 4){
					$row[] = '<input class="priceformat" type="text" data-id="d" value="'.$pos.'" readonly>';
				}elseif($key->id_ex == 5){
					$row[] = '<input class="priceformat" type="text" data-id="g" value="'.$sic.'" readonly>';
				}else{
					$row[] = '<input class="priceformat" type="text" data-id="h" value="'.$tik.'" readonly>';
				}
			}
			
			$row[] = '<button class="btn btn-default btn-xs btn-edit"><i class="fa fa-edit"></i> ubah</button>&nbsp;<button class="btn btn-success btn-xs cost-btn" data-id="'.$customers->ID.'" disabled>simpan</button>';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->entersite->count_all(),
						"recordsFiltered" => $this->entersite->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


	function changedcost(){
		if(IS_AJAX){
		$id = $this->input->post('id');
		if($this->input->post('a') != '') { $a  = $this->input->post('a'); } else { $a = 0; }
		if($this->input->post('b') != '') { $b  = $this->input->post('b'); } else { $b = 0; }
		if($this->input->post('c') != '') { $c  = $this->input->post('c'); } else { $c = 0; }
		if($this->input->post('d') != '') { $d  = $this->input->post('d'); } else { $d = 0; }
		if($this->input->post('e') != '') { $e  = $this->input->post('e'); } else { $e = 0; }
		if($this->input->post('f') != '') { $f  = $this->input->post('f'); } else { $f = 0; }
		if($this->input->post('g') != '') { $g  = $this->input->post('g'); } else { $g = 0; }
		if($this->input->post('h') != '') { $h  = $this->input->post('h'); } else { $h = 0; }
		$datacost = array (
			'reg'     => rupiah_to_number($a),
			'oke'     => rupiah_to_number($b),
			'yes'     => rupiah_to_number($c),
			'pos'     => rupiah_to_number($d),
			'wahana1' => rupiah_to_number($e),
			'tiki'    => rupiah_to_number($h),
			'sicepat' => rupiah_to_number($g),
			'jt'      => rupiah_to_number($f)
		);

		$where  = array('ID' => $id);
		$update = $this->db->update('pengiriman', $datacost, $where);
			if($update){
				$json['status']  = 1;
				$json['message'] = '<div class="alert alert-success" role="alert">Berhasil merubah data</div>';
			}else{
				$json['status']  = 0;
				$json['message'] = '<div class="alert alert-danger" role="alert">Gagal merubah data</div>';
			}
			echo json_encode($json);
		}else{
			show_404();
		}
		
	}


	function addmedsos(){
		if($this->input->post('addmedsos') != null){
			$media  = $this->input->post('media');
			$akun   = $this->input->post('akun');
			$url    = $this->input->post('url');
			if($media != null && $akun != null && $url != null){
			$data   = array (
				'socialmedia' => $media,
				'nama_akun'   => $akun,
				'url'         => $url
				); 

				if(!empty($this->input->post('marketplace')) || $this->input->post('marketplace') != ''){
					$data['type'] = 1;
				}

				$insert = $this->m_settings->insert($data, 'social_media');
				if($insert == 'ok'){
					$this->session->set_flashdata('alert_success', 'Berhasil menambah data!');
				}elseif($insert =='ada'){
					$this->session->set_flashdata('alert_success', 'Data sudah ada');
				}else{
					$this->session->set_flashdata('alert_errors', 'Gagal menambah data');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Isi semua field!');
			}

			if(!empty($this->input->post('marketplace')) || $this->input->post('marketplace') != ''){
				redirect(base_url().'entersite/setting/marketplace');
			}else{
				redirect(base_url().'entersite/setting/social-media');
			}
			
		}else{
			show_404();
		}
	}

	function updatemedsos($id){
		if($this->input->post('addmedsos') != null){
			$media  = $this->input->post('media');
			$akun   = $this->input->post('akun');
			$url    = $this->input->post('url');
			if($media != null && $akun != null && $url != null){
			$data   = array (
				'socialmedia' => $media,
				'nama_akun'   => $akun,
				'url'         => $url
				);

			$where  = array('id_sm' => $id);
				$update = $this->m_settings->update($data, 'social_media', $where);
				if($update == 'ok'){
					$this->session->set_flashdata('alert_success', 'Berhasil merubah data!');
				}elseif($update == 'noupdate'){
					$this->session->set_flashdata('alert_success', 'Tidak ada perubahan data!');
				}else{
					$this->session->set_flashdata('alert_errors', 'Gagal merubah data!');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Isi semua field!');
			}
			if(!empty($this->input->post('marketplace')) || $this->input->post('marketplace') != ''){
				redirect(base_url().'entersite/setting/marketplace');
			}else{
				redirect(base_url().'entersite/setting/social-media');
			}
		}else{
			show_404();
		}
	}

	function del($section, $id){
		if($section == 'social_media'){
			$idname = 'id_sm';
			$link   = 'setting/social-media';
		}elseif($section == 'bank'){
			$idname = 'id_bank';
			$link   = 'setting/bank';
		}elseif($section == 'faq'){
			$idname = 'id_faq';
			$link   = 'static_page/faq';
		}else{
			$idname = '';
			$link   = '404error';
		}
		$data = array( $idname => $id );
		if($this->m_settings->delete($data, $section) == true){
			$this->session->set_flashdata('alert_success', 'Berhasil hapus data!');
		}else{
			$this->session->set_flashdata('alert_errors', 'Gagal menghapus data!');
		}
		redirect(base_url().'entersite/'.$link);
	}


	function prosesbank($product_bag = NULL,  $product_id = NULL){
		if($this->input->post('bankproses') != null){
			$bank   = $this->input->post('bank');
			$akun   = $this->input->post('akun');
			$norek  = $this->input->post('norek');
			$cabang = $this->input->post('cabang');
			$meth   = $this->input->post('meth');

			if($bank != null && $akun != null && $norek != null && $cabang != null && $meth != null){
				$data = array(
					'nama_bank' => $bank,
					'method'    => $meth,
					'nama_akun' => $akun, 
					'no_rek'    => $norek,
					'cabang'    =>  $cabang,
					'publish'   => '11'
					);
				if($product_id != null && $product_bag == 'edit'){
					$where  = array('id_bank' => $product_id);
					$update = $this->m_settings->update($data, 'bank', $where);
					if($update == 'ok'){
						$this->session->set_flashdata('alert_success', 'Berhasil merubah data!');
					}elseif($update == 'noupdate'){
						$this->session->set_flashdata('alert_success', 'Tidak ada perubahan data!');
					}else{
						$this->session->set_flashdata('alert_errors', 'Gagal merubah data!');
					}
				}else{
					$insert = $this->m_settings->insert($data, 'bank');
					if($insert == 'ok'){
						$this->session->set_flashdata('alert_success', 'Berhasil menambah data!');
					}elseif($insert =='ada'){
						$this->session->set_flashdata('alert_success', 'Data sudah ada');
					}else{
						$this->session->set_flashdata('alert_errors', 'Gagal menambah data');
					}
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Isi semua field!');
			}
			redirect(base_url().'entersite/setting/bank');

		}else{
			show_404();
		}
	}

	function proses_ekspedisi(){
		if($this->input->post('shipping_publish') != null){
			$ekspedisi = $this->input->post('ekspedisi');
			$where1    = ''; $where2 = '';
			$data1  = array('publish' => '01');
			$data2  = array('publish' => '11');
			for ($i=0; $i < count($ekspedisi); $i++) { 
				if($i == count($ekspedisi)-1){ $bts = ''; }else{ $bts = ' OR '; }
				$where1 .= 'id_ex <>'.$ekspedisi[$i].$bts;
				$where2 .= 'id_ex ='.$ekspedisi[$i].$bts;
			}
			if(count($ekspedisi) > 0){
			$an = $this->db->update('expedisi', $data1, $where1);
			$en = $this->db->update('expedisi', $data2, $where2);
				$this->session->set_flashdata('alert_success', 'Berhasil simpan data!');
			}else{
				$this->session->set_flashdata('alert_errors', 'Minimal 1 Ekspedisi aktif');
			}
			redirect(base_url().'entersite/setting/shipping');
		
		}else{
			show_404();
		}
	}


	function proses_store(){
		if($this->input->post('toko') != null){
			$viewdatastore           = $this->m_settings->view('store')->row();
			$nama                    = $this->input->post('nama');
			$email                   = $this->input->post('email');
			$telpon                  = $this->input->post('notel');
			$alamat                  = $this->input->post('address');
			$deskripsi               = $this->input->post('deskripsi');
			$author                  = $this->input->post('author');
			$keyword                 = $this->input->post('keyword');
			$title                   = $this->input->post('title');
				
			$config['upload_path']   = './assets/image/logo';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = 10000;
			// $config['max_width']     = 300;
			// $config['max_height']    = 100;
			// $config['min_width']     = 300;
			// $config['min_height']    = 100;
			$new_name                = my_slug($nama).'-logo-'.time();
			$config['file_name']     = $new_name;

	        $this->load->library('upload', $config);
	        if($_FILES['imagemain']['name']!=''){
		    	if ( ! $this->upload->do_upload('imagemain')){ 
		    		$up1   = 'false'; 
		    	}else{ 
		    		$up1   = 'true'; 
		    		$image = $this->upload->data('file_name');
		      	}
		    }else{
		        $up1   = 'true';
		        $image = $viewdatastore->brand_logo;;
		    }

		    $data = array(
					'nama_toko'      => $nama,
					'email'          => $email,
					'no_telp'        => $telpon,
					'alamat_toko'    => $alamat,
					'brand_logo'     => $image,
					'title'          => $title,
					'meta_keyword'   => $keyword,
					'meta_deskripsi' => $deskripsi,
					'meta_author'    => $author
					);
		    $where = array('id_store' => 1);
			if($up1 == 'true'){
				if($nama != null && $email != null && $telpon != null){
					$update = $this->db->update('store', $data, $where);
					if($update){
						$this->session->set_flashdata('alert_success', 'Berhasil merubah data!');
					}else{
						$this->session->set_flashdata('alert_errors', 'Gagal merubah data!');
					}
				}else{
					$this->session->set_flashdata('alert_errors', 'Isi semua field');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Kesalahan gambar, gagal diupload!');
			}
			redirect(base_url().'entersite/setting/store');
		
		}else{
			show_404();
		}
	}

	function proses_faq($sec = NULL, $id = NULL){
		if($this->input->post('submit') != null){
			$ask = $this->input->post('ask');
			$ans = $this->input->post('answer');
			if($ask != null && $ans != null){
				$data = array(
					'pertanyaan' => stripslashes($ask),
					'jawaban'    => stripslashes(htmlspecialchars($ans))
					);
				if($sec == 'edit'){
					$where  = array('id_faq' => $id);
					$update = $this->m_settings->update($data, 'faq', $where);
					if($update == 'ok'){
						$this->session->set_flashdata('alert_success', 'Berhasil merubah data!');
					}elseif($update == 'noupdate'){
						$this->session->set_flashdata('alert_success', 'Tidak ada perubahan data!');
					}else{
						$this->session->set_flashdata('alert_errors', 'Gagal merubah data');
					}
				}else{
					$insert = $this->m_settings->insert($data, 'faq');
					if($insert == 'ok'){
						$this->session->set_flashdata('alert_success', 'Berhasil menambah data!');
					}elseif($insert =='ada'){
						$this->session->set_flashdata('alert_success', 'Data sudah ada');
					}else{
						$this->session->set_flashdata('alert_errors', 'Gagal menambah data');
					}
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'all field are required!');
			}
			redirect(base_url().'entersite/static_page/faq');
		}else{
			show_404();
		}
	}


	public function navigation(){
		$data['list_categories'] = $this->m_entersite->list_db('category')->result_array();
		$data['navigasi'] = $this->m_settings->view('navigasi');

		$this->temp_admin('admin/content/navigasi', $data);
	}

	function proses_nav($section = NULL, $id = NULL){
		if($this->input->post('submit') != null){
			$nav  = strtoupper($this->input->post('nav'));
			$cat  = $this->input->post('kategori');
			$pub  = $this->input->post('publish');
			if($pub == 'yes'){ $publish = '11'; } else { $publish = '01'; }
			$data = array(
				'navigasi' => $nav,
				'kategori' => $cat,
				'publish'  => $publish
				);
			if($nav != NULL && $cat != NULL && $pub != NULL){
				if($section == 'edit' && $id != NULL){
					$where  = array('id_nav' => $id);
					$update = $this->m_settings->update($data, 'navigasi', $where);
					if($update == 'ok'){
						$this->session->set_flashdata('alert_success', 'Berhasil merubah data!');
					}elseif($update == 'noupdate'){
						$this->session->set_flashdata('alert_success', 'Tidak ada perubahan data!');
					}else{
						$this->session->set_flashdata('alert_errors', 'Gagal merubah data');
					}
				}else{
					$insert = $this->m_settings->insert($data, 'navigasi');
					if($insert == 'ok'){
						$this->session->set_flashdata('alert_success', 'Berhasil menambah data!');
					}elseif($insert =='ada'){
						$this->session->set_flashdata('alert_success', 'Data sudah ada');
					}else{
						$this->session->set_flashdata('alert_errors', 'Gagal menambah data');
					}
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'all field are required!');
			}
			redirect(base_url().'entersite/navigation');
		}else{
			show_404();
		}
	}


	public function orders($segment = NULL){
			$data['badges'] = array(
							'new' => ($this->m_entersite->badges(1) > 0) ? $this->m_entersite->badges(1) : '',
							'pay' => ($this->m_entersite->badges(2) > 0) ? $this->m_entersite->badges(2) : '',
							);
			$data['tahun']  = $this->m_entersite->tahun();
			
			$data['bag']    = $segment; 
			$heading = ($segment == 'shipping') ? 'Resi' : '';
			$data['list_temp'] = '<table id="table-01" class="table table-bordered table-responsive">
									<thead>
									    <tr>
									       <th width="5px">No</th>
									       <th>No. Orders</th>
									       <th>Order Date</th>
									       <th>Account</th>
									       <th>Phone</th>
									       <th>Shipping Name</th>
									       <th>Payment Meth</th>
									       <th class="text-right">Amount</th>
									       <th>'.$heading.'</th>
									    </tr>
									</thead>
									<tbody>      
									</tbody>
								 </table>';
		if($segment == 'all'){

			$this->temp_admin('admin/orders/new', $data);
		}else if($segment == 'new'){
			
			$this->temp_admin('admin/orders/new', $data);
		}else if($segment == 'payment'){
			
			$this->temp_admin('admin/orders/new', $data);
		}else if($segment == 'shipping'){
			
			$this->temp_admin('admin/orders/new', $data);
		}else if($segment == 'sent'){
			$field = 'Sent Date';
			$this->temp_admin('admin/orders/new', $data);
		}else if($segment == 'cancel'){
			$this->temp_admin('admin/orders/new', $data);
		}else{
			show_404();
		}
	}

	public function orders_list($uri = NULL){
		if($uri == 'all'){
			$where = '';
		}elseif($uri == 'new'){
			$where =  '1';
		}elseif($uri == 'payment'){
			$where =  '2';
		}elseif($uri == 'shipping'){
			$where =  '3';
		}elseif($uri == 'sent'){
			$where =  '4';
		}elseif($uri == 'cancel'){
			$where =  '0';
		}else{
			$where = '';
		}

		$list = $this->orderlist->get_datatables($where);
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $customers) {
			if($customers->OrderStatus == 0){
				$status = 'CANCEL';
			}elseif($customers->OrderStatus == 1){
				$status = 'NEW ORDER';
			}
			elseif($customers->OrderStatus == 2){
				$status = 'PAYMENT';
			}
			elseif($customers->OrderStatus == 3){
				$status = 'PROCCESS';
			}
			elseif($customers->OrderStatus == 4){
				$status = 'SENT';
			}else{
				$status = 'UNKNOW';
			}

			$no++;
			$row   	= array();
			$row[] 	= $no;
			$row[] 	= '<a href="'.base_url('entersite/invoice/'.$customers->No_Orders).'">'.$customers->No_Orders.'</a>';
			$row[] 	= strtoupper(date('d M Y H:i', strtotime($customers->OrdersDate)));
			$row[] 	= '<a href="#">'.strtoupper($customers->Email).'</a>';
			$row[]  = $customers->BillPhone;
			$row[] 	= strtoupper($customers->ShipName);
			$row[] 	= strtoupper($customers->PaymentMet);
			$row[] 	= '<div class="text-right">'.rupiah($customers->Subtotal).'</div>';
			if($uri == 'all'){
				$row[] 	= $status;
			}elseif($uri == 'new'){
				$row[] 	= '<select name="status" class="select2 no-padd" data-order="'.$customers->No_Orders.'">
                <option value="0" selected> -- SELECT OPTIONS --</option>
                <option value="payment">PAYMENT CONFIRMATIONS</option>
                <option value="proccess">PROCCESS (SHIPPING)</option>
                <option value="sent">SENT</option>
                <option value="cancel">CANCEL</option>
              </select>';
			}elseif($uri == 'payment'){
				$row[] 	= '<form class="atlas_payment" action="'.base_url().'entersite/prosesorder/'.$customers->ID_orders.'/'.$customers->No_Orders.'" method="post"><div class="text-center"><button type="button" name="submitpay" value="reject" class="btn btn-warning btn-xs subrej"> REJECT </button>&nbsp;<button type="button" name="submitpay" value="accept" class="btn btn-success btn-xs"> ACCEPT </button></div></form>';
			}elseif($uri == 'shipping'){
				$row[] 	= '<a href="'.base_url('entersite/awb/'.$customers->cnote_no).'">'.strtoupper($customers->cnote_no).'</a>';
			}elseif($uri == 'cancel'){
				$row[] 	= '<select name="status" class="select2 no-padd" data-order="'.$customers->No_Orders.'">
                <option value="0" selected> -- SELECT OPTIONS --</option>
                <option value="new">NEW ORDER</option>
                <option value="payment">PAYMENT CONFIRMATIONS</option>
                <option value="proccess">PROCCESS (SHIPPING)</option>
              </select>';
			}elseif($uri == 'sent'){
				$row[] 	= '';
			}else{
				$row[] 	= '';
			}

			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->orderlist->count_all(),
						"recordsFiltered" => $this->orderlist->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	function changestatus(){
		if($this->input->post()){
			$noorder = $this->input->post('order');
			$status  = $this->input->post('status');
			if($status == 'payment'){
				$changest = '2';
			}elseif($status == 'proccess'){
				$changest = '3';
			}elseif($status == 'new'){
				$changest = '1';
			}elseif($status == 'cancel'){
				$changest = '0';
			}elseif($status == 'sent'){
				$changest = '4';
			}else{
				$changest = 100;				
			}

			if($changest != 100){
				$data  = array('OrderStatus' => $changest);
				$where = array('No_Orders' => $noorder);
				$update = $this->m_entersite->updateorder($data, $where);
				if($update == true){
					$json['status'] = 1;
					$json['message'] = '<div class="alert alert-success" role="alert">Data berhasil di ubah.</div>';
				}elseif($update == 'nodata'){
					$json['message'] = '<div class="alert alert-warning" role="alert">Data tidak ditemukan.</div>';
					$json['status'] = 0;
				}else{
					$json['message'] = '<div class="alert alert-warning" role="alert">Data tidak berhasil di ubah.</div>';
					$json['status'] = 0;
				}
			}else{
				$json['message'] = '<div class="alert alert-warning" role="alert">Wrong Status.</div>';
				$json['status'] = 0;
			}
			echo json_encode($json);
		}
	}


	function prosesorder($id, $order){
		
			
		if($this->input->post('submitpay') == "accept"){

			
			$where   = array('ID_orders' => $id, 'No_Orders' => $order);
			$row     = $this->db->get_where('orders', $where)->row_array();
			$address = $this->db->get_where('destination', array('ID'=> $row['ShipAddress2']))->row_array();

			$this->load->library('job');
			$method = 'POST';
			$action = 'gentiket';
			$header = array('Content-Type:application/x-www-form-urlencoded', 'User-Agent:'.get_user_agent());
			$parameter = array(
				'username'         => setting_value('JNE_API_USERNAME'),
				'api_key'          => setting_value('JNE_API_PASSWORD'),
				'SHIPPER_NAME'     => strtoupper(get_data('store')['nama_toko']),
				'SHIPPER_ADDR1'    => trim(preg_replace('/\s\s+/', ' ',  strtoupper(substr(get_data('store')['alamat_toko'], 0, 15)))),
				'SHIPPER_ADDR2'    => 'HANG LEKIU',
				'SHIPPER_ADDR3'    => 'KEBAYORAN BARU',
				'SHIPPER_CITY'     => 'JAKARTA',
				'SHIPPER_ZIP'      => '12120',
				'SHIPPER_REGION'   => 'JAKARTA',
				'SHIPPER_COUNTRY'  => 'INDONESIA',
				'SHIPPER_CONTACT'  => strtoupper(get_data('store')['nama_toko']),
				'SHIPPER_PHONE'    => strtoupper(get_data('store')['no_telp']),
				'RECEIVER_NAME'    => strtoupper($row['ShipName']),
				'RECEIVER_ADDR1'   => trim(preg_replace('/\s\s+/', ' ', strtoupper(substr($row['ShipAddress'], 0, 15)))),
				'RECEIVER_ADDR2'   => strtoupper($address['kabupaten']),
				'RECEIVER_ADDR3'   => strtoupper($address['kecamatan']),
				'RECEIVER_CITY'    => strtoupper($address['propinsi']),
				'RECEIVER_ZIP'     => $row['ShipPostcode'],
				'RECEIVER_REGION'  => strtoupper($address['propinsi']),
				'RECEIVER_COUNTRY' => 'INDONESIA',
				'RECEIVER_CONTACT' => strtoupper($row['ShipName']),
				'RECEIVER_PHONE'   => $row['ShipPhone'], 
				'ORIGIN_DESC'      => 'Jakarta',
				'ORIGIN_CODE'      => 'CGK10100',
				'DESTINATION_DESC' => trim(preg_replace('/\s\s+/', ' ', strtoupper(substr($row['ShipAddress'], 0, 15)))),
				'DESTINATION_CODE' => $address['tariff_jne_code'],
				'SERVICE_CODE'     => $row['ShippingMet'],
				'QTY'              => $row['total_qty'], 
				'WEIGHT'           => $row['total_weight'],
				'GOODS_DESC'       => 'Kosmetik',
				'GOODS_AMOUNT'     => $row['total_value'], 
				'INSURANCE_FLAG'   => 0,
				'INSURANCE_AMOUNT' => 0,
				'DELIVERY_PRICE'   => $row['ShippingCost'],
				'BOOK_CODE'        => 'TS-0'.$row['No_Orders'],
			);

			$result = $this->job->request($action, $method, $header, $parameter);

			if($result['status'] == "Error" || empty($result['no_tiket']) || $result['status'] == 'false'){

				$json['message'] = '<div class="alert alert-warning" role="alert">'.$result['reason'].'</div>';
				$json['status']  = 0;

			}else{

				$cnote_no     = (!empty($result['no_tiket'])) ? $result['no_tiket'] : '';
				$data         = array('OrderStatus' => '3', 'cnote_no' => $cnote_no);
				$update       = $this->m_entersite->updateorder($data, $where);
				$send_packing = $this->m_entersite->order_to_packing($where);
				if($update == true){
					$this->send_voucher($row);
					$json['status'] = 1;
					$json['message'] = '<div class="alert alert-success" role="alert">Pembayaran diterima! Pesanan diproses.</div>';
				}elseif($update == 'nodata'){
					$json['message'] = '<div class="alert alert-warning" role="alert">Data tidak ditemukan.</div>';
					$json['status'] = 0;
				}else{
					$json['message'] = '<div class="alert alert-warning" role="alert">Data tidak berhasil di ubah.</div>';
					$json['status'] = 0;
				}
			}


		}elseif($this->input->post('submitpay') == "reject"){
			$data  = array('OrderStatus' => '0');
			$where = array('ID_orders' => $id, 'No_Orders' => $order);
			$update = $this->m_entersite->updateorder($data, $where);
				if($update == true){
					$json['status'] = 1;
					$json['message'] = '<div class="alert alert-success" role="alert">Pembayaran ditolak, pesanan dibatalkan!</div>';
				}elseif($update == 'nodata'){
					$json['message'] = '<div class="alert alert-warning" role="alert">Data tidak ditemukan.</div>';
					$json['status'] = 0;
				}else{
					$json['message'] = '<div class="alert alert-warning" role="alert">Data tidak berhasil di ubah.</div>';
					$json['status'] = 0;
				}
		}else{
			$json['message'] = '<div class="alert alert-warning" role="alert">Undifined.</div>';
			$json['status'] = 0;
		}
		echo json_encode($json);
	}

	public function static_page($section = NULL, $subsection = NULL){
		if($section == 	NULL){
			$data['pages'] = $this->m_entersite->static_list();
			$this->temp_admin('admin/content/static_list', $data);
		}
		elseif($section == 'new'){
			$data['kategori'] = $this->m_entersite->kategori_page()->result();
			$this->temp_admin('admin/content/static_new_n_edit', $data);
		}
		elseif($section == 'edit' && $subsection){
			$data['kategori'] = $this->m_entersite->kategori_page()->result();
			$data['dt_edit']  = $this->m_entersite->static_list(array('id_page' => $subsection));
			if($data['dt_edit']->num_rows() > 0){
				$this->temp_admin('admin/content/static_new_n_edit', $data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
		
	}

	function blog($section = NULL, $subsection = NULL){
		if($section == NULL){
			$where = array(
				'publish' => '11',
				);
			$data['blog_list'] = $this->m_entersite->checksome('blog', $where);
			$this->temp_admin('admin/content/blog_list', $data);
		}elseif($section == 'new'){
			$this->temp_admin('admin/content/blog_new_n_edit');
		}elseif($section == 'edit' && $subsection){
			$where = array(
					'id_page' => $subsection
					);
			$data['edit'] = $this->m_entersite->checksome('blog', $where);
			if($data['edit']->num_rows() > 0){
				$this->temp_admin('admin/content/blog_new_n_edit', $data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
		
	}

	function content($uri = NULL){
		if($uri == 'sliders'){
			$data['slider'] = $this->m_entersite->checksome('slide', array('publish !=' => '00'));
			$this->temp_admin('admin/content/sliders', $data);
		}elseif($uri == 'static-page'){

		}else{
			show_404();
		}
	}

	public function subscriber(){
		$data['subscriber'] = $this->m_entersite->list_db('subscriber')->result_array();
		$this->temp_admin('admin/subscriber', $data);
	}

	public function members($page = NULL){
		
		if($page == 'customers'){
			$data['users'] = $this->m_entersite->list_db('users');
			$this->temp_admin('admin/member/customers', $data);
		}else{
			show_404();
		}
	}


	function logout(){
		$sess_data = array(
			'id'       => NULL,
			'name'     => NULL,
			'email'    => NULL,
			'image'    => NULL,
			'loggedin' => FALSE
        );
        $this->session->unset_userdata($sess_data);
        delete_cookie('ci_session');
        redirect(base_url());
	}

	function awb($noorder = ''){

		$data = array(
			'awb'     => $this->m_entersite->awb($noorder)
		);
// 		pre($data['awb']);
		$this->temp_admin('admin/orders/awb', $data);
		
	}

	function invoice($noorder = ''){
		if(!empty($noorder)){
			$data['orders'] = $this->m_entersite->inv($noorder);
			// pre($data['orders']);
			$this->temp_admin('admin/orders/invoice', $data);
		}else{
			show_404();
		}
	}

	private function barcode_awb($code){
		$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
		$barcode = base64_encode($generator->getBarcode($code, $generator::TYPE_CODE_128));
		return $barcode;
	}

	public function generate_barcode($kode){
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
	}
	
	public function generate_barcode_awb($kode){
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$style = array(
		    'text'=> $kode,
		    'barHeight' => 40,
		    'fontSize' => 15
		);
		Zend_Barcode::render('code128', 'image', $style, array());
	}

	function barcode(){
		$this->form_validation->set_rules('code', 'Item Code', 'required');
		$data = array(
			'code' => $this->m_entersite->get_print_barcode(),
			'row'  => '',
			'for'  => 0
		);

		if ($this->form_validation->run() == TRUE)
		{
			$key         = explode('-', trim($this->input->post('code')));
			$where       = array('pm.barcode' => $key[0], 'pm.size' => $key['1']);
			$data['row'] = $this->m_entersite->get_print_barcode($where, FALSE);
			$data['for'] = $this->input->post('qty');   
		}
		// pre($data['row']);
		$this->temp_admin('admin/products/barcode', $data);		
	}


	function penjualan(){
		$data = array(
			'start' => date('d M Y'),
			'end'   => date('d M Y')
		);
		$this->form_validation->set_rules('sortdate', 'Tanggal', 'required');
		if ($this->form_validation->run() == TRUE)
		{
			$date = explode('-', input_clean(trim($this->input->post('sortdate'))));
			$data = array(
				'start' => date('d M Y', strtotime($date[0])),
				'end'   => date('d M Y', strtotime($date[1]))
			);
		}
		$data['penjualan'] = $this->m_entersite->penjualan($data['start'], $data['end']);
		$this->temp_admin('admin/orders/penjualan', $data);	
	}

	function packing(){
		$this->form_validation->set_rules('id', 'id', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data = array(
				'list_packing' => $this->m_entersite->list_packing()
			);

			if(empty($this->session->userdata('table')) || $this->session->userdata('table') == ''){
				$this->session->set_flashdata('set_meja', 'Pilih Meja Packing Dahulu');
			}

			$this->temp_admin('admin/orders/packing', $data);	
		}
		else
		{
			if(empty($this->session->userdata('table')) || $this->session->userdata('table') == ''){
				$post = $this->input->post();
				$row  = $this->db->get_where('pos', array('id' => $post['id']));
				if($row->num_rows() > 0){
					$packing = $this->m_entersite->packing($row->row_array());
					$this->session->set_flashdata('alert_success', 'Berhasil');
				}
				else{
					$this->session->set_flashdata('alert_errors', 'Daftar tidak ditemukan!');
				}
			}else{
				$this->session->set_flashdata('alert_errors', 'Pilih Meja Packing Dahulu');
			}
			redirect(base_url('entersite/packing'));

		}
	}

	public function del_order_list($id){
		$row = $this->db->get_where('pos', array('id' => $id))->row_array();
		if(!empty($row)){
			$this->db->delete('pos', array('id' => $id));
			$this->db->delete('pos_list', array('no_transaksi' => $row['no_transaksi']));
			
			$this->session->set_flashdata('alert_success', 'No Invoice:'.$row['Note'].'. Berhasil di hapus!');
		}else{
			$this->session->set_flashdata('alert_errors', 'Daftar tidak ditemukan!');
		}
		redirect(base_url('entersite/packing'));
	}

	function detail_penjualan(){
		$data = array();
		$this->temp_admin('admin/orders/detail_penjualan', $data);
	}

	function status_produk(){
		$this->form_validation->set_rules('optionsRadios', 'Status', 'required');
		if ($this->form_validation->run() == TRUE)
		{
			$post   = $this->input->post();
			$status = array('status' => input_clean($post['optionsRadios']));
			$row    = $this->db->update('product_map', $status, array('ID_map' => input_clean($post['id'])));
		}
		redirect(base_url('entersite/product/list'));
	}


	public function banner(){
		$data['slider'] = $this->m_entersite->checksome('banner', array('category' => 1, 'publish !=' => '00'));
		$this->temp_admin('admin/content/banner', $data);
	}

	public function image(){
		$data['slider'] = $this->m_entersite->checksome('banner', array('category' => 0, 'publish !=' => '00'));
		$this->temp_admin('admin/content/image', $data);
	}

	public function send_voucher($data)
	{
		$temp_voucher = $this->db->get_where('voucher_temp', array('publish' => 1));
		if($temp_voucher->num_rows() > 0){

		   	$data_voucher = $temp_voucher->row_array();
			   $voucher = array(
					'ID_member'     => $data['ID_users'],
					'voucher_code'  => readable_random_string(4).rand(10,100),
					'voucher_value' => $data_voucher['voucher_value'],
					'start'         => date('Y-m-d'),
					'end'           => date('Y-m-d', strtotime(date('Y-m-d'). '+14 Days'))
			   );

			   	$this->db->insert('voucher_temp_list', $voucher);
			   	$email_data = array(
					'to'            => $data['Email'],
					'title'         => "Vocher Belanja di ".setting_value('site_name'),
					'subject'       => "Selamat Anda Mendapatkan Vocher Belanja di ".setting_value('site_name'),
					'to_name'       => $data['BillName'],
					'from'          => setting_value('email'),
					'name'          => setting_value('site_name'),
					'reply_to'      => setting_value('email'),
					'reply_to_name' => setting_value('site_name'),
				);

				create_image($voucher['voucher_code'], $voucher['start'], $data_voucher['template']);

				$message = '<img style="width: 100%" src="'.base_url('assets/image/voucher/voucher_'.$voucher['voucher_code'].'.jpg').'">';
				$email_data['message'] = $message;

				sendemail($email_data);
		}
	}

	// function stok_produk(){
	// 	$post = $this->input->post();
	// 	if($post){
	// 		if(!empty($post['id'])){
	// 			$stock = array('stock' => $post['stock']);
	// 			$this->db->update('product_map_stock', $stock, array('barcode' => input_clean($post['id'])));
	// 		}

	// 		redirect(base_url('entersite/product/list'));
	// 	}else{
	// 		show_404();
	// 	}
	// }


} 