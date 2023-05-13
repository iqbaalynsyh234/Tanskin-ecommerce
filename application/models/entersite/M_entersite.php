<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_entersite extends CI_Model{

	function admin_check($data = array()){
		$this->db->where('user_admin', $data['email']);
		$this->db->where('password', $data['password']);
		$query = $this->db->get('admin');
		if($query->num_rows() > 0){
			$check   = $query->row();
			$message = '01';
			$session_admin = array(
			'id_admin'    => $check->id_admin,
			'user_admin'  => $check->user_admin,
			'email_admin' => $check->email_admin,
			'akses_01'    => $check->akses1,
			'akses_02'    => $check->akses2,
			'akses_03'    => $check->akses3,
			'akses_04'    => $check->akses4,
			'akses_05'    => $check->akses5,
			'del_akses'   => $check->del_akses,
			'admin_login' => true
            );
            $modifiedate = date('Y-m-d H:i:s');
            $this->session->set_userdata($session_admin);
            $this->db->query("UPDATE admin SET modifiedate = '$modifiedate' WHERE id_admin= '$check->id_admin'");
		}else{
			$message = '00';
		}
		return $message;
	}

	function check_categories($category, $id = ''){
		$where = array(
			'link' => $category
		);
		if(!empty($id)){
			$where['ID_cat !='] = $id;
		}
		$this->db->where($where);
		return $this->db->get('category');
	}

	function list_db($data){
		return $this->db->get($data);
	}

	function list_sub($data){
		$this->db->where('parent_id', $data);
		return $this->db->get('category');
	}

	function list_where($where, $where2, $db){
		$this->db->where($where, $where2);
		return $this->db->get($db);
	}

	function list_category(){
		$this->db->select('*, t1.kategori AS parent1');
		$this->db->from('category AS t1');
		$this->db->join('category AS t2', 't1.ID_cat=t2.parent_id', 'RIGHT');
		return $this->db->get();
	}

	function list_products($where = array(), $results = FALSE){

		if(!empty($where)){
			foreach ($where as $key => $value) {
				$target[$key] = $value;
			}
		}

		$this->db->select('*, map.status as publish_product');
		$this->db->join('products p', 'p.ID_item=map.id_product', 'LEFT');
		$this->db->join('admin s', 's.id_admin=p.Uploader', 'LEFT');
		if(!empty($where)){
			$this->db->where($target);
		}
		$data =  $this->db->get('product_map map');

		if($results){
			$data = $data->result_array();
			$item = array();

			foreach ($data as $key => $value) {
				$item[] = array(
					'ID_item'         => $value['ID_map'],
					'ItemType'        => $value['ItemType'],
					'url'             => $value['url'],
					'ItemCode'        => $value['ItemCode'],
					'ItemSubcate'     => $this->db->select('kategori')->where_in('ID_cat', explode(',', $value['ItemSubcate']))->get_where('category', array('publish' => '11'))->result_array(),
					'ItemName'        => $value['ItemName'],
					'ItemNmDesc'      => $value['ItemNmDesc'],  
					'ItemPrice'       => $value['price'],
					'ItemDisc'        => $value['disc'],
					'ItemWeight'      => $value['ItemWeight'],
					'ItemDescription' => $value['ItemDescription'],
					'barcode'         => $value['barcode'],
					'adm_name'        => $value['user_admin'],
					'image'           => $value['image1'],
					'publish'         => $value['publish_product'],
					'stock'           => $this->db->select('SUM(p.stock) as total_stock, p.stock, s.Size, s.ID_size, c.ColorName')->join('color c', 'c.ID_color=p.color', 'left')->join('size s', 's.ID_size=p.size', 'left')->get_where('product_map_stock p', array('p.id_product'=> $value['id_product'], 'p.color' => $value['color']))->row_array()
				);
			}
			return $item;
		}else{
			$value = $data->row_array();
			if($value['ItemType'] == 1 || $value['ItemType'] == 2){
				$stock_where = $this->db->select('p.stock, s.Size, s.ID_size, c.ColorName, p.ID_ms')->join('color c', 'c.ID_color=p.color', 'left')->join('size s', 's.ID_size=p.size', 'left')->get_where('product_map_stock p', array('p.id_product'=> $value['id_product'], 'p.color' => $value['color']))->row_array();
			}else{
				$stock_where = $this->db->select('p.stock, s.Size, s.ID_size, c.ColorName, p.ID_ms')->join('color c', 'c.ID_color=p.color', 'left')->join('size s', 's.ID_size=p.size', 'left')->get_where('product_map_stock p', array('p.id_product'=> $value['id_product'], 'p.color' => $value['color']))->result_array();
			}

			$item  = array(
					'ID_map'          => $value['ID_map'],
					'ItemType'        => $value['ItemType'],
					'url'             => $value['url'],
					'ItemCode'        => $value['ItemCode'],
					'barcode'         => $value['barcode'],
					'ItemSubcate'     => $this->db->select('kategori')->where_in('ID_cat', explode(',', $value['ItemSubcate']))->get_where('category', array('publish' => '11'))->result_array(),
					'ItemName'        => $value['ItemName'],
					'ItemNmDesc'      => $value['ItemNmDesc'],  
					'ItemPrice'       => $value['price'],
					'ItemDisc'        => $value['disc'],
					'ItemWeight'      => $value['ItemWeight'],
					'ItemDescription' => $value['ItemDescription'],
					'adm_name'        => $value['user_admin'],
					'image'           => array($value['image1'], $value['image2'], $value['image3'], $value['image4'], $value['image5'], $value['image6']),
					'video'           => $value['video'],
					'publish'         => $value['publish_product'],
					'stock'           => $stock_where
			);
			return $item;
		}
	}

	function checksome($table, $where){
        $this->db->where($where);
        return $this->db->get($table);
    }

    function list_voucher($where = ''){
    	$data = array(
    		'publish !=' => 3
    	);
    	if(!empty($where)){
    		$data['ID_vou'] = $where;
    	}
    	return $this->db->get_where('voucher', $data);
    }

    function updateorder($data, $where){
		$this->db->where($where);
		$query = $this->db->get('orders');
		if($query->num_rows() > 0){
			if($this->db->update('orders', $data, $where)){
				$message = true;
				return $message;
			}else{
				$message = false;
				return $message;
			}
		}else{
			$message = 'nodata';
			return $message;
		}
	}

	public function no_transaksi(){
	    $this->db->select('*');
	    $this->db->order_by('no_transaksi', 'DESC');    
	    $this->db->limit(1);     
	    $query = $this->db->get('pos');  
	      
	    if($query->num_rows() <> 0){       
	       $data = $query->row_array(); 
	       $subs = substr($data['no_transaksi'], -5);     
	       $kode = intval($subs) + 1;   
	    }
	    else{       
	       $kode = 1;  
	    }
	    $kodemax  = str_pad($kode, 5, "0", STR_PAD_LEFT);    
	 
	    $kodejadi = date('ymd').$kodemax;

	    return $kodejadi;  
  	}

  	public function cek_customer($name = '', $phone='', $address = '', $template=''){
		$customer = $this->db->get_where('customer', array('phone' => $phone, 'kategori' => $template));
		if($customer->num_rows() == 0){
			$data = array(
				'name'     => $name,
				'phone'    => $phone,
				'address'  => $address,
				'kategori' => $template
				);
			$this->db->insert('customer', $data);
		    $id = $this->db->insert_id();
		}
		else{
			$data = $customer->row_array(); 
			$id   = $data['customer'];
		}
		return $id;
	}

	function order_to_packing($where){

		$no_transaksi = $this->no_transaksi();
		$order        = $this->db->get_where('orders', $where)->row_array();
		$order_list   = $this->db->get_where('orders_list', array('No_Orders' => $order['No_Orders']))->result_array();
		$user         = $this->db->get_where('users', array('id' => $order['ID_users']))->row_array();

		$buyer_id     = $this->cek_customer($user['first_name'].' '.$user['last_name'], $user['phone'], $user['address'], 'Website');

		$pos = array(
			'no_transaksi'  => $no_transaksi,
			'ordertimex'    => date('H:i:s', strtotime($order['OrdersDate'])),
			'tgl_transaksi' => date('Y-m-d', strtotime($order['OrdersDate'])),
			'Inputdate'     => date('Y-m-d'),
			'meth'          => 'Website',
			'buyer'         => $buyer_id,
			'Note'          => $order['No_Orders']
		);
		$this->db->insert('pos', $pos);

		foreach ($order_list as $key => $post) {
			$pos_list = array(
				'no_transaksi' => $no_transaksi,
				'cds'          => $post['size'],
				'barcode'      => $post['barcode'],
				'qty'          => $post['qty'],
				'price'        => $post['ItemPrice'],
				'total'        => $post['ItemPrice'] * $post['qty']
			);

			$this->db->insert('pos_list', $pos_list);
		}
	}

	function hirarki_kategori($where_cat = NULL){
		
		$this->db->select('t1.kategori AS name_level1, t2.kategori as name_level2
, t3.kategori AS name_level3, t4.kategori as name_level4, t5.kategori as name_level5');
		$this->db->from('category AS t1');
		$this->db->join('category AS t2', 't2.parent_id = t1.ID_cat', 'LEFT');
		$this->db->join('category AS t3', 't3.parent_id = t2.ID_cat', 'LEFT');
		$this->db->join('category AS t4', 't4.parent_id = t3.ID_cat', 'LEFT');
		$this->db->join('category AS t5', 't5.parent_id = t4.ID_cat', 'LEFT');
	
		$this->db->where('t1.parent_id IS NULL', null, false);
		if($where_cat != NULL){
			$this->db->where('t1.ID_cat', $where_cat);
		}
		return $this->db->get();
	}


	function category_hirarki($levelid = null){
		$where = array('t1.parent_id' => 0);
		//level1
		$this->db->select("t1.ID_cat, t1.kategori, 1 AS level, t1.kategori AS name_level1, '' AS name_level2, '' AS name_level3, '' AS name_level4, '' as name_level5, t1.ID_cat AS path");
		$this->db->from('category AS t1');
		$this->db->where($where);
		if($levelid != null){
			$this->db->where(array('t1.ID_cat' => $levelid));
		}
		$query1 = $this->db->get_compiled_select();
		//level2
		$this->db->select("t2.ID_cat, t2.kategori, 2 AS level, t1.kategori AS name_level1, t2.kategori as name_level2, '' as name_level3, '' as name_level4, '' as name_level5, concat(t1.ID_cat,'/',t2.ID_cat) AS path");
		$this->db->from('category AS t1');
		$this->db->join('category AS t2', 't2.parent_id = t1.ID_cat');
		$this->db->where($where);
		if($levelid != null){
			$this->db->where(array('t2.ID_cat' => $levelid));
		}
		$query2 = $this->db->get_compiled_select();
		//level3
		$this->db->select("t3.ID_cat, t3.kategori, 3 AS level, t1.kategori AS name_level1, t2.kategori as name_level2, t3.kategori AS name_level3, '' as name_level4, '' as name_level5, concat(t1.ID_cat,'/',t2.ID_cat,'/',t3.ID_cat) AS path");
		$this->db->from('category AS t1');
		$this->db->join('category AS t2', 't2.parent_id = t1.ID_cat');
		$this->db->join('category AS t3', 't3.parent_id = t2.ID_cat');
		$this->db->where($where);
		if($levelid != null){
			$this->db->where(array('t3.ID_cat' => $levelid));
		}
		$query3 = $this->db->get_compiled_select();
		//level4
		$this->db->select("t4.ID_cat, t4.kategori, 4 AS level, t1.kategori AS name_level1, t2.kategori as name_level2, t3.kategori AS name_level3, t4.kategori as name_level4, '' as name_level5, concat(t1.ID_cat,'/',t2.ID_cat,'/',t3.ID_cat,'/',t4.ID_cat) AS path");
		$this->db->from('category AS t1');
		$this->db->join('category AS t2', 't2.parent_id = t1.ID_cat');
		$this->db->join('category AS t3', 't3.parent_id = t2.ID_cat');
		$this->db->join('category AS t4', 't4.parent_id = t3.ID_cat');
		$this->db->where($where);
		if($levelid != null){
			$this->db->where(array('t4.ID_cat' => $levelid));
		}
		$query4 = $this->db->get_compiled_select();
		//level5
		$this->db->select("t5.ID_cat, t5.kategori, 5 AS level, t1.kategori AS name_level1, t2.kategori as name_level2, t3.kategori AS name_level3, t4.kategori as name_level4, t5.kategori as name_level5, concat(t1.ID_cat,'/',t2.ID_cat,'/',t3.ID_cat,'/',t4.ID_cat,'/',t5.ID_cat) AS path");
		$this->db->from('category AS t1');
		$this->db->join('category AS t2', 't2.parent_id = t1.ID_cat');
		$this->db->join('category AS t3', 't3.parent_id = t2.ID_cat');
		$this->db->join('category AS t4', 't4.parent_id = t3.ID_cat');
		$this->db->join('category AS t5', 't5.parent_id = t4.ID_cat');
		$this->db->where($where);
		if($levelid != null){
			$this->db->where(array('t5.ID_cat' => $levelid));
		}
		$this->db->order_by('path');
		$query5 = $this->db->get_compiled_select();

		$query = $this->db->query($query1." UNION ".$query2." UNION ".$query3." UNION ".$query4." UNION ".$query5);
		return $query;

	}

	function insertslide($dataslide){
		$insert = $this->db->insert('slide', $dataslide);
		if($insert){
			$status  = 1;
            $message = 'Berhasil menambahkan slide!';
		}else{
			$status  = 0;
            $message = 'Gagal menambahkan slide!';
		}
		return array(
			'status' => $status,
            'pesan'  => $message,
			);
	}

	function updateslide($dataupdate, $id){
		$update = $this->db->update('slide', $dataupdate, array('id' => $id));
	}

	function insert_db($data, $table){
		$this->db->where($data);
		$rows = $this->db->get($table)->num_rows();
		if($rows == 0){
			$insert = $this->db->insert($table, $data);
			if($insert){
				$status  = 1;
            	$message = 'Berhasil menyimpan data.';
			}else{
				$status  = 0;
            	$message = 'Gagal menyimpan data.';
			}
		}else{
			$status  = 0;
            $message = 'Data sudah ada.';
		}
		return array(
			'status' => $status,
            'pesan'  => $message,
			);
	}

	function kategori_page(){
		$this->db->order_by('id', 'desc');
		return $this->db->get('kategori_tambahan');
	}

	function static_list($where = NULL){
		$this->db->select('*');
		$this->db->from('static_page AS sp');
		$this->db->join('kategori_tambahan AS kt', 'kt.id=sp.kategori');
		if($where){
			$this->db->where($where);
		}
		return $this->db->get();
	}

	function static_page($a, $b, $id = NULL){
		if($b == 'new'){
		$this->db->where('section', $a['section']);
		$this->db->where('kategori', $a['kategori']);
		$row = $this->db->get('static_page')->num_rows();
		if($row == 0){
			$save = $this->db->insert('static_page', $a);
			if($save){
				$status  = 1;
            	$message = 'Berhasil menyimpan data.';
			}else{
				$status  = 0;
            	$message = 'Gagal menyimpan data.';
			}
		}else{
			$status  = 0;
            $message = 'Data sudah ada.';
		}
		return array(
			'status' => $status,
            'pesan'  => $message,
			);
		}else{
			$this->db->where('id_page', $id);
			$row = $this->db->get('static_page')->num_rows();
			if($row > 0){
				$c = array('id_page' => $id);
				$update = $this->db->update('static_page', $a, $c);
				if($update){
					$status  = 1;
	            	$message = 'Berhasil mengubah data.';
				}else{
					$status  = 0;
	            	$message = 'Gagal mengubah data.';
				}
			}else{
				$status  = 0;
            	$message = 'Data tidak ditemukan.';
			}
		return array(
			'status' => $status,
            'pesan'  => $message,
			);
		}
		
	}


	function remove_batch($data, $field, $table){
		$this->db->where_in($field, $data);
        $delete = $this->db->delete($table);
		if($delete){
			$status  = 1;
            $message = 'Berhasil menghapus data.';
		}else{
			$status  = 0;
            $message = 'Gagal menghapus data.';
		}
		return array(
			'status' => $status,
            'pesan'  => $message,
			);
	}

	function edit_batch($where, $table, $data){
		$delete = $this->db->update_batch($table, $data, $where);
		if($delete){
			$status  = 1;
            $message = 'Berhasil merubah data.';
		}else{
			$status  = 0;
            $message = 'Gagal merubah data.';
		}
		return array(
			'status' => $status,
            'pesan'  => $message,
			);
	}

	function blog_data($a, $data, $id = NULL){
		if($a == 'new'){
			$this->db->where('title' , $data['title']);
			$row = $this->db->get('blog')->num_rows();
			if($row == 0){
				$save = $this->db->insert('blog', $data);
				if($save){
					$status  = 1;
	            	$message = 'Berhasil menyimpan data.';
				}else{
					$status  = 0;
	            	$message = 'Gagal menyimpan data.';
				}
			}else{
				$status  = 0;
	            $message = 'Data sudah ada.';
			}
			return array(
				'status' => $status,
	            'pesan'  => $message,
				);
		}else{


		}
	}


	function get_details_products($id = ''){
		$row = $this->db->get_where('products', array('ID_item' => $id))->row_array();
		$product_detail = array(
			'ID_item'         => $row['ID_item'],
			'ItemType'        => $row['ItemType'],
			'url'             => $row['url'],
			'ItemCode'        => $row['ItemCode'],
			'ItemSubcate'     => $row['ItemSubcate'],
			'ID_categories'   => $row['ID_categories'],
			'ItemName'        => $row['ItemName'],
			'ItemNmDesc'      => $row['ItemNmDesc'],
			'ItemPrice'       => $row['ItemPrice'],
			'ItemDisc'        => $row['ItemDisc'],
			'ItemWeight'      => $row['ItemWeight'],
			'ItemDescription' => $row['ItemDescription'],
			'meta_title'      => $row['meta_title'],
			'meta_keyword'    => $row['meta_keyword'],
			'meta_deskripsi'  => $row['meta_deskripsi'],
			'modified'        => $row['modified'],
			'publish'         => $row['publish'],
			'images'   		  => $this->db->get_where('product_map', array('item_code' => $row['ItemCode']))->result_array(),
			'stock'           => $this->db->get_where('product_map_stock', array('ItemCode' => $row['ItemCode']))->result_array()
		);

		return $product_detail;
	}

	function awb($noorder = ''){
		$where = array(
			'o.OrderStatus' => 3
		);
		if(!empty($noorder)){
			$where['o.cnote_no'] = $noorder;
		}
		$query = $this->db->join('destination d', 'd.ID=o.ShipAddress2', 'left')->get_where('orders o', $where)->result_array();
		$data = array();
		foreach ($query as $key => $value) {
			$data[] = array(
				'ID_orders'    => $value['ID_orders'],
				'No_Orders'    => $value['No_Orders'],
				'ID_users'     => $value['ID_users'],
				'Email'        => $value['Email'],
				'OrdersDate'   => $value['OrdersDate'],
				'OrderStatus'  => $value['OrderStatus'],
				'ShipName'     => $value['ShipName'],
				'ShipAddress'  => $value['ShipAddress'],
				'ShipAddress2' => $value['ShipAddress2'],
				'ShipPostcode' => $value['ShipPostcode'],
				'ShipPhone'    => $value['ShipPhone'],
				'ShippingMet'  => $value['ShippingMet'],
				'cnote_no'     => $value['cnote_no'],
				'ShippingCost' => $value['ShippingCost'],
				'total_weight' => $value['total_weight'],
				'total_qty'    => $value['total_qty'],
				'total_value'  => $value['total_value'],
				'propinsi'     => $value['propinsi'],
				'kabupaten'    => $value['kabupaten'],
				'kecamatan'    => $value['kecamatan'],
				'desa'         => $value['desa'],
				'zip'          => $value['zip'],
				'orderlist'    => $this->db->join('color c', 'c.ID_color=ol.color', 'left')->get_where('orders_list ol', array('ol.NO_orders' => $value['No_Orders']))->result_array()
			);
		}
		return $data;
	}


	function inv($noorder){
		$where = array(
			'o.No_Orders' => $noorder
		);
		$query = $this->db->join('destination d', 'd.ID=o.ShipAddress2', 'left')->get_where('orders o', $where);
		$data  = $query->row_array();

		$data['list_order'] = $this->db
		->join('color c', 'c.ID_color=ol.color', 'left')
		->get_where('orders_list ol', array('ol.NO_orders' => $noorder))->result();

		return $data;
	}

	function produk_terlaris(){
		$query = $this->db->select('ol.ItemCode, ol.color, ol.size, p.ItemName, pm.barcode, SUM(ol.qty) as total')
		->order_by('total', 'DESC')
		->join('products p', 'p.ID_item = ol.ID_items', 'left')
		->join('product_map pm', 'pm.barcode = ol.barcode', 'left')
		->join('orders o', 'o.No_Orders = ol.NO_orders', 'left')
		->group_by('ol.ID_items')
		->where('DATE(o.OrdersDate) BETWEEN "'. date('Y-m-d', strtotime(week_ago())).'" and "'. date('Y-m-d').'"')
		->limit(10)
		->get("orders_list ol")->result_array();
		return $query;
	}

	function warning_stock(){
		$query = $this->db->select('p.ItemCode, pms.color, pms.size, p.ItemName, pms.barcode, pms.stock')
		->order_by('pms.stock', 'ASC')
		->join('products p', 'p.ID_item = pms.id_product', 'left')
		->join('product_map pm', 'pm.id_product = pms.id_product', 'left')
		->where(array('pms.stock <=' => 20, 'p.publish' => '11', 'pm.status !='=> '01', 'pm.image1 !=' => ''))
		->group_by(array('pms.size', 'pms.color'))
		->limit(15)
		->get("product_map_stock pms")->result_array();
		return $query;
	}

	function order_today(){
		$query = $this->db
		->where(array("OrderStatus" => 1))
		->where('DATE(o.OrdersDate) BETWEEN "'.date('Y-m-d').'" and "'. date('Y-m-d').'"')
		->get("orders o")->num_rows();
		return $query;
	}

	function order_item_week(){
		$query = $this->db
		->select('SUM(ol.qty) as total')
		->join('orders o', 'o.No_Orders = ol.NO_orders', 'left')
		->where('DATE(o.OrdersDate) BETWEEN "'. date('Y-m-d', strtotime(week_ago())).'" and "'. date('Y-m-d').'"')
		->get("orders_list ol")->row_array();
		return $query;
	}

	function order_pay_week(){
		$query = $this->db
		->select('SUM(Subtotal) AS penjualan')
		->where('DATE(OrdersDate) BETWEEN "'. date('Y-m-d', strtotime(week_ago())).'" and "'. date('Y-m-d').'"')
		->get("orders")->row_array();
		return $query;
	}

	function tahun(){
		$query = $this->db
		->select("LEFT (OrdersDate, 4) as tahun")
		->group_by("tahun")
		->get("orders");

		return $query->result_array();
	}

	function get_print_barcode($where = array(), $res = TRUE){
		if(!empty($where)){
			$this->db->where($where);
		}
		
		$query = $this->db
		->select('c.ColorName, pm.ItemCode, pm.barcode, p.ItemName, s.Size, pm.size')
		->join('color c', 'c.ID_color = pm.color', 'LEFT')
		->join('size s', 's.ID_size = pm.size', 'LEFT')
		->join('products p', 'p.ID_item = pm.id_product', 'LEFT')
		->get('product_map_stock pm');
		if($res){
			return $query->result_array();
		}
		else{
			return $query->row_array();
		}
		
	}

	public function badges($req){
		$query = $this->db->get_where('orders', array('OrderStatus' => $req))->num_rows();
		return $query;
	}


	public function penjualan($start, $end){
		$datestart = date('Y-m-d', strtotime($start));
		$dateend   = date('Y-m-d', strtotime($end));
		$where     = array(
			'p.tgl_transaksi >=' => $datestart,
			'p.tgl_transaksi <=' => $dateend
		);

		$query = $this->db->select('p.*, c.name as cusname, c.phone as cusphone')
				->order_by('p.no_transaksi','DESC')
				->join('customer c', 'c.customer=p.buyer', 'LEFT')
				->where($where)
				->get('pos p')->result_array();
		return $query;
	}

	function list_packing(){
		
		$query = $this->db->select('p.*, c.name as cusname, c.phone as cusphone')
				->order_by('p.no_transaksi','DESC')
				->join('customer c', 'c.customer=p.buyer', 'LEFT')
				->where(array('p.table_packing' => 0))
				->get('pos p')->result_array();
		return $query;
	}

	function input_banner(){
		$post      = $this->input->post();
		$publish   = ($post['publish'] == 'yes') ? '11' : '01';

		if($post['type'] == '1'){
			$video = '';
			$image_name = '';
			if($_FILES['imagemain']['name'] !== '' ){
				$folder     = 'assets/image/slideshow/';
				$info       = file_import('imagemain', $folder, my_slug($post['name']).'_'.date('Ymd_His'));
				$image_name = $info['file_name'];
			}

		}else{
			$video      = input_clean($post['video']);
			$image_name = '';
		}

		$input = array(
			'name'    => input_clean($post['name']),
			'type'    => input_clean($post['type']),
			'side'    => input_clean($post['side']),
			'video'   => $video,
			'image'   => $image_name,
			'url'     => input_clean($post['url']),
			'publish' => $publish
		);

		$insert = $this->db->insert('banner', $input);
		if($insert){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	function edit_banner($id){
		$row = $this->db->get_where('banner', array('id' => $id))->row_array();
		if($row){
			$post      = $this->input->post();
			$publish   = ($post['publish'] == 'yes') ? '11' : '01';

			if($post['type'] == '1'){
				$video = '';
				$image_name = $row['image'];
				if($_FILES['imagemain']['name'] !== '' ){
					$folder     = 'assets/image/slideshow/';
					$info       = file_import('imagemain', $folder, my_slug($post['name']).'_'.date('Ymd_His'));
					$image_name = $info['file_name'];
				}

			}else{
				$video      = input_clean($post['video']);
				$image_name = '';
			}

			$input = array(
				'name'    => input_clean($post['name']),
				'type'    => input_clean($post['type']),
				'side'    => input_clean($post['side']),
				'video'   => $video,
				'image'   => $image_name,
				'url'     => input_clean($post['url']),
				'publish' => $publish
			);

			$update = $this->db->update('banner', $input, array('id' => $id));

			if($update){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function input_image(){
		$post      = $this->input->post();
		$publish   = ($post['publish'] == 'yes') ? '11' : '01';

		if($post['type'] == '1'){
			$video = '';
			$image_name = '';
			if($_FILES['imagemain']['name'] !== '' ){
				$folder     = 'assets/image/slideshow/';
				$info       = file_import('imagemain', $folder, my_slug($post['name']).'_'.date('Ymd_His'));
				$image_name = $info['file_name'];
			}

		}else{
			$video      = input_clean($post['video']);
			$image_name = '';
		}

		$input = array(
			'name'     => input_clean($post['name']),
			'category' => 0,
			'type'     => input_clean($post['type']),
			'side'     => input_clean($post['side']),
			'video'    => $video,
			'image'    => $image_name,
			'url'      => input_clean($post['url']),
			'publish'  => $publish
		);

		$insert = $this->db->insert('banner', $input);
		if($insert){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	function edit_image($id){
		$row = $this->db->get_where('banner', array('id' => $id))->row_array();
		if($row){
			$post      = $this->input->post();
			$publish   = ($post['publish'] == 'yes') ? '11' : '01';

			if($post['type'] == '1'){
				$video = '';
				$image_name = $row['image'];
				if($_FILES['imagemain']['name'] !== '' ){
					$folder     = 'assets/image/slideshow/';
					$info       = file_import('imagemain', $folder, my_slug($post['name']).'_'.date('Ymd_His'));
					$image_name = $info['file_name'];
				}

			}else{
				$video      = input_clean($post['video']);
				$image_name = '';
			}

			$input = array(
				'name'     => input_clean($post['name']),
				'category' => 0,
				'type'     => input_clean($post['type']),
				'side'     => input_clean($post['side']),
				'video'    => $video,
				'image'    => $image_name,
				'url'      => input_clean($post['url']),
				'publish'  => $publish
			);

			$update = $this->db->update('banner', $input, array('id' => $id));

			if($update){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

   function packing($data_pos){
   	// pre($data_pos);
   	$post = $this->input->post();
   	
   	$data = array(
		'packing'       => date('Y-m-d H:i:s'),
		'table_packing' => $this->session->userdata('table'),
		'id_admin'      => $this->session->userdata('id_admin')
   	);
   	$this->db->update('pos',$data, array('id' => $post['id']));
   	if($data_pos['meth'] != 'Website'){
   		$list = $this->db->get_where('pos_list', array('no_transaksi' => $data_pos['no_transaksi']))->result_array();
	   	foreach ($list as $key => $value) {
	   		$where = array('barcode' => $value['barcode']);

			if($value['id_barang'] == 0){
				$where['size'] = (!empty($value['cds'])) ? $value['cds'] : 14;
			}else{
				$where['ID_ms'] = $value['id_barang'];
			}

	   		$stock_item = $this->db->get_where('product_map_stock', $where)->row_array();
	   		$stock = $stock_item['stock'] - ($value['qty']);
	   		
	   		$this->db->update('product_map_stock', array('stock' => $stock), array('ID_ms' => $stock_item['ID_ms']));
	   	}
   	}
   	return TRUE;
   }
}