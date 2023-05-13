<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_penjualan extends CI_Model {

	function get_detail($id = ''){
		$query = $this->db->select('p.*, c.*, a.user_admin')->join('customer c', 'c.customer=p.buyer', 'LEFT')->join('admin a', 'a.id_admin=p.id_admin', 'LEFT')->get_where('pos p', array('p.id' => $id))->row_array();
		$list  = $this->db->get_where('pos_list pl', array('pl.no_transaksi' => $query['no_transaksi'] ))->result_array();
		// pre($list);
		$product_list = array();
		foreach ($list as $key => $value) {
			$where = array('pms.barcode' => $value['barcode']);

			if($value['id_barang'] != 0){
				$where['pms.ID_ms'] = $value['id_barang'];
			}else{
				$where['pms.size']  = (!empty($value['cds'])) ? $value['cds'] : 14;
			}

			// if(!empty($value['cds']) && $value['id_barang'] == 0){
			// 	$where['pms.size'] = $value['cds'] : 14;;
			// }
			// pre($where);

			$produk = $this->db->join('products p', 'p.ID_item = pms.id_product', 'LEFT')->get_where('product_map_stock pms', $where)->row_array();
			// pre($produk);
			$product_list[] = array(
				'id'       => $produk['ID_ms'],
				'qty'      => $value['qty'],
				'price'    => $value['price'],
				'size'     => $produk['size'],
				'color'    => $produk['color'],
				'item_code'=> $produk['ItemCode'],
				'ItemName' => $produk['ItemName'],
				'type'     => $produk['ItemType']
			);
		}
		$data  = array(
			'id'            => $query['id'],
			'no_transaksi'  => $query['no_transaksi'],
			'ordertimex'    => $query['ordertimex'],
			'tgl_transaksi' => $query['tgl_transaksi'],
			'meth'          => $query['meth'],
			'buyer'         => $query['buyer'],
			'costfor'       => $query['costfor'],
			'cost'          => $query['cost'],
			'Note'          => $query['Note'],
			'packing'       => $query['packing'],
			'table_packing' => $query['table_packing'],
			'id_admin'      => $query['id_admin'],
			'address'       => $query['address'],
			'name'          => $query['name'],
			'phone'         => $query['phone'],
			'user_admin'    => $query['user_admin'],
			'detail'        => $product_list
		);
		
		return $data;
	}

}