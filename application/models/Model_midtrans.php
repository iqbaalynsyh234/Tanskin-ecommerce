<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_midtrans extends CI_Model{

	function orders_status($where, $update){
		$this->db->update("orders", $where, $update);
	}

	function notification($notif){
		$data = array(
			'transaction_status' => $notif->transaction_status,
			'payment_type'       => $notif->payment_type,
			'order_id'           => $notif->order_id,
			'fraud_status'       => $notif->fraud_status
		);
		$this->db->insert("order_push_notification", $data);
	}

}