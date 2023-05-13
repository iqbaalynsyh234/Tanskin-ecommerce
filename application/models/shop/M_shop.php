<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class M_shop extends CI_Model{

    function get_test(){
        $target = array(
            'p.publish' => '11'
        );
        $this->db->where($target);
        $this->db->where("FIND_IN_SET(2, p.ItemSubcate) > 0");
        $data = $this->db->get('products p')->result_array();
        return $data;
    }

	function get_current_page_records($limit, $start, $special, $section = '') {
        $target = array(
            'p.publish' => '11',
            'pm.status' => '11'
        );

	 	$this->db->join('product_map pm', 'pm.item_code=p.ItemCode');
        if($special){
            if($section == 'new'){
                $this->db->order_by('p.created', 'desc');
            }elseif($section == 'sale'){
                $this->db->where(array('pm.disc !=' => 0));
            }
        }else{
            if($section != ''){
                $this->db->where("FIND_IN_SET($section, p.ItemSubcate) > 0");
            }
        }
        $this->db->where($target);
        $this->db->join("color c", "c.ID_color=pm.color", "left");
        $this->db->limit($limit, $start);
        $query = $this->db->get('products p');
        
        return $query->result_array();
    }
     
    function get_total($special, $section) {
        $target = array(
            'p.publish' => '11',
            'pm.status' => '11'
        );
        $this->db->join('product_map pm', 'pm.item_code=p.ItemCode');
        if($special){
            if($section == 'new'){
                $this->db->order_by('p.created', 'desc');
            }elseif($section == 'sale'){
                $this->db->where(array('pm.disc !=' => 0));
            }
        }else{
            if($section != ''){
                $this->db->where("FIND_IN_SET($section, p.ItemSubcate) > 0");
            }
        }
        $total = $this->db->get_where('products p', $target)->num_rows();
        return $total;
    }

    function get_category_id($url) {
        $data = $this->db->select('ID_cat, kategori, special_type')->get_where('category', array('link' => $url, 'publish' => '11'))->row_array();
        return $data;
    }

    function detailitem($id, $color=null){
        $this->db->select('*, pm.price as ItemPrice, pm.disc as ItemDisc');
    	$this->db->from('products');
	 	$this->db->join('product_map pm', 'pm.item_code=products.ItemCode');
        $this->db->join('product_map_stock pms', 'pms.ItemCode=products.ItemCode');
        if($color != null){
            $this->db->where('pms.color', $color);
            $this->db->where('pm.color', $color);
        }
	 	$this->db->where('products.url', $id);
        $this->db->limit(1);
	 	return $this->db->get();
    }

    function itemcolor($code, $color=null){
        $this->db->from('product_map');
        $this->db->join('color', 'product_map.color=color.ID_color');
        if($color != null){
            $this->db->where('product_map.color', $color);
        }
        $this->db->where(array('product_map.item_code' => $code, 'product_map.status !=' => '01'));
        return $this->db->get();
    }

    function itemDefSize($code, $color=null){
        if($color != null){
            $this->db->where('color', $color);
        }
        $this->db->where('ItemCode', $code);
        $this->db->where_not_in('stock', 0);
        $this->db->limit(1);
        return $this->db->get('product_map_stock');
    }

    function itemStock($code, $color=null, $size=null){
        $this->db->from('product_map_stock');
        if($color != null){
            $this->db->where('color', $color);
        }
        if($size != null){
            $this->db->where('size', $size);
        }
        $this->db->where('ItemCode', $code);
        return $this->db->get();
    }

    function getItemMap($id, $code){
        $this->db->select('*, pm.price as ItemPrice, pm.disc as ItemDisc');
        $this->db->from('products');
        $this->db->join('product_map pm', 'pm.item_code=products.ItemCode', 'left');
        $this->db->join('color', 'color.ID_color=pm.color', 'LEFT');
        $this->db->where('ItemCode', $code);
        $this->db->where('ID_map', $id);
        return $this->db->get();
    }

    function ItemSizeStock($code, $color=null){
        $this->db->from('product_map_stock pm');
        if($color != null){
            $this->db->where('color', $color);
        }
        $this->db->join('size', 'size.ID_size=pm.size', 'left');
        $this->db->where('pm.ItemCode', $code);
        $this->db->where_not_in('pm.size', '');
        return $this->db->get();
    }

    function relateditem($id = ''){
        if(!empty($id)){
            $this->db->where(array('ID_item !=' => $id));
        }
        $this->db->from('products');
        $this->db->join('product_map', 'product_map.item_code=products.ItemCode');
        $this->db->join('color', 'color.ID_color=product_map.color', 'LEFT');
        $this->db->where(array('products.publish' => '11', 'product_map.status' => '11'));
        $this->db->limit(4);
        $this->db->order_by('RAND()');
        return $this->db->get();
    }

    function checksome($table, $where){
        return $this->db->get_where($table, $where);
    }

    function userdata($iduser){
        $this->db->from('users');
        $this->db->join('destination', 'destination.ID=users.area', 'LEFT');
        $this->db->where('users.id', $iduser);
        return $this->db->get();
    }

    function ch_password($where, $update){
        if($this->db->update('users', $update, $where)){
            $message = 'ok';
            return $message;
        }else{
            $message = 'err';
            return $message;
        }

    }

    function atlas_confirm_payment($data){
        $this->db->where('No_Orders', $data['no_order']);
        $check = $this->db->get('orders');
        if($check > 0){
            $insert = $this->db->insert('confirmation', $data);
            if($insert){
                $status  = 1;
                $message = 'Konfirmasi pembayaran berhasil!';
            }else{
                $status  = 0;
                $message = 'Database Error-1';
            }
        }else{
            $status  = 0;
            $message = 'No.Order tidak ditemukan!';
        }
        return array(
            'status' => $status,
            'pesan'  => $message,
        );
    }

    //insert
    function insert($data, $table){
        $this->db->where($data);
        $query = $this->db->get($table);
        if($query->num_rows() == 0){
            if($this->db->insert($table, $data)){
                $message = 'ok';
            }else{
                $message = 'err';
            }
        }else{
            $message = 'ada';
        }
        return $message;

    }

    function check_voucher(){
        $post = $this->input->post();
        $array = array(
            'publish'      => 1,
            'vou_code'     => strtoupper($post['whatis']),
            'start_voucher <= ' => date("Y-m-d")
        );

        $where_or = '(end_voucher >= CURDATE() )';
        $query = $this->db
            ->where($array)
            ->where($where_or)
            ->get('voucher');

        return $query;
    }

    function check_voucher_gift(){
        $post = $this->input->post();
        $array = array(
            'ID_member'    => $this->session->userdata('id'),
            'voucher_code' => strtoupper($post['whatis']),
            'start <= ' => date("Y-m-d")
        );

        $where_or = '(end >= CURDATE() )';
        $query = $this->db
            ->where($array)
            ->where($where_or)
            ->get('voucher_temp_list');

        return $query;
    }

    function alamat($id_destination){
        $query = $this->db->get_where('destination', array('ID' => $id_destination))->row_array();
        return $query;
    }

    function private_list($id){
        $query = $this->db->get_where('private_order_list', array('order_number' => $id))->result_array();
        foreach ($query as $key => $value) {
            $query[$key]['data_item'] = $this->db
                ->get_where('product_map_stock pms', array('ID_ms' => $value['id_ms']))->row_array();
        }
        return $query;
    }

}