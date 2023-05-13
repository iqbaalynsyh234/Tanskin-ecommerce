<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_import extends CI_Model{


	public function input_file(){

		$post = $this->input->post();

		$image_name = FALSE;
		if($_FILES['file']['name'] !== '' ){
			$folder     = 'excel/';
			$info       = file_import('file', $folder, my_slug($post['template']).'_'.date('Ymd_His'));
			$image_name = $info['file_name'];
		}

		return $image_name;
	}

	public function input_file_stock(){

		$post = $this->input->post();

		$image_name = FALSE;
		if($_FILES['file']['name'] !== '' ){
			$folder     = 'excel/stock/';
			$info       = file_import('file', $folder, my_slug('adjust_stock_'.date('dMY_His')));
			$image_name = $info['file_name'];
		}

		return $image_name;
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

  	public function store($store, $where){

	    $this->db->where($where, $store);
	    $query = $this->db->get('store');
	    return $query;

	}

	public function cek_pos($invoice, $template = ''){
		$where = array('Note' => $invoice);
        if(!empty($template)){
            $where['meth'] = $template;
        }
		$this->db->where($where);
		$query = $this->db->get('pos');
        return $query;
        
	}
	
	public function cek_produk($barcode){
	    $barcode = str_replace(array("'", "/", "`", '"'), '', $barcode);
		$this->db->where('barcode', $barcode);
		$query = $this->db->get('product_map');
		return $query;
	}

	public function cek_customer($name = '', $phone, $address = '', $template){
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

	public function orders_insert(){

		$post = $this->input->post();

		for ($i=0; $i < count($post['inv']); $i++) { 

		    
			$cek_pos = $this->cek_pos($post['inv'][$i], $post['template']);
			if($cek_pos->num_rows() == 0){

				$no_transaksi = $this->model_import->no_transaksi();
				$buyer_id     = $this->cek_customer($post['name'][$i], $post['phone'][$i], $post['address'][$i], $post['template']);

				$pos = array(
					'no_transaksi'  => $no_transaksi,
					'ordertimex'    => date('H:i:s', strtotime($post['pd'][$i])),
					'tgl_transaksi' => date('Y-m-d', strtotime($post['pd'][$i])),
					'Inputdate'     => date('Y-m-d'),
					'meth'          => $post['template'],
					'buyer'         => $buyer_id,
					'costfor'       => (rupiah_to_number($post['shipping'][$i]) > 0) ? 'Shipping' : '',
					'cost'          => rupiah_to_number($post['shipping'][$i]),
					'Note'          => $post['inv'][$i]
				);
				$this->db->insert('pos', $pos);

			}else{
				$data_pos = $cek_pos->row_array();
				$no_transaksi = $data_pos['no_transaksi'];
			}

            $clean_barcode = str_replace(array("'", "/", "`", '"'), '', $post['barcode'][$i]);

            $where_id = array(
            	'barcode' => $clean_barcode,
            	'size'    => (!empty($post['size'][$i])) ? $post['size'][$i] : 14
            );
           

            $get_id_barang = $this->db->get_where('product_map_stock', $where_id)->row_array();
            $id_barang = (!empty($get_id_barang)) ? $get_id_barang['ID_ms'] : 0;
            
			$pos_list = array(
				'no_transaksi' => $no_transaksi,
				'cds'          => $post['size'][$i],
				'id_barang'    => $id_barang,
				'barcode'      => $clean_barcode,
				'qty'          => $post['qty'][$i],
				'price'        => $post['price'][$i],
				'total'        => $post['price'][$i] * $post['qty'][$i]
			);

			$this->db->insert('pos_list', $pos_list);
		}
	
	}

	public function marketplace_stock($percent){
        $produk = $this->db->select('c.ColorName, p.*, pms.*')
        ->join('products p', 'p.ID_item = pms.id_product', 'left')
        ->join('color c', 'c.ID_color = pms.color', 'left')
        ->get('product_map_stock pms')->result_array();
        
        $data = array();
        
        foreach($produk as $key => $value){
            if($value['stock'] > 0){
                $marketplace_stock = ceil(($value['stock'] * $percent) / 100);
            }
            else{
                $marketplace_stock = 0;
            }
            $data[] = array(
                'barcode'   => $value['barcode'],
                'warna'     => $value['ColorName'],
                'kode'      => $value['ItemCode'],
                'name'      => $value['ItemName'],
                'size'      => $value['size'],
                'stock'     => $marketplace_stock
            );
        }
        return $data;
    }

	
}