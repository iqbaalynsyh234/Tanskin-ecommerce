<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => setting_value('midtrans_serverkey'), 'production' => true);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
		$this->load->helper('url');
		$this->load->model('model_midtrans');
		
    }

	public function index()
	{
		$json_result = file_get_contents('php://input');
		$result      = json_decode($json_result);

		$dataorder   = $this->db->get_where('orders', array('order_id' => $result->order_id))->row_array();
		$status      = $dataorder['OrderStatus'];
		
		$transaction = $result->transaction_status;
		$type        = $result->payment_type;
		$order_id    = $result->order_id;
		$fraud       = $result->fraud_status;


		if ($transaction == 'capture') {
		  if ($type == 'credit_card'){
		    if($fraud == 'deny'){
		      $status = 0;
		    } 
		    else {
		      $status = 2;
		    }
		  }
		}
		else if($transaction == 'settlement'){
		  $status = 2;
		} 
		else if($transaction == 'pending'){
		  $status = 1;
		} 
		else if($transaction == 'deny') {
		  $status = 0;
		}

		$where = array(
			'No_Orders'    => $dataorder['No_Orders']
		);

		$update = array(
			'OrderStatus'        => $status,
			'transaction_status' => $transaction
		);

		if($result->status_code == 200){

		   	if($status == 2){
		   		//kirim email voucher
		   		$temp_voucher = $this->db->get_where('voucher_temp', array('publish' => 1));
		   		if($temp_voucher->num_rows() > 0){
		   			$data_voucher = $temp_voucher->row_array();
			   		$voucher = array(
						'ID_member'     => $dataorder['ID_users'],
						'voucher_code'  => readable_random_string(4).rand(10,100),
						'voucher_value' => $data_voucher['voucher_value'],
						'start'         => date('Y-m-d'),
						'end'           => date('Y-m-d', strtotime(date('Y-m-d'). '+14 Days'))
			   		);

			   		$this->db->insert('voucher_temp_list', $voucher);
			   		$email_data = array(
						'to'            => $dataorder['Email'],
						'title'         => '',
						'subject'       => "Vocher Belanja di ".setting_value('site_name'),
						'to_name'       => setting_value('site_name'),
						'from'          => setting_value('email'),
						'name'          => setting_value('site_name'),
						'reply_to'      => setting_value('email'),
						'reply_to_name' => setting_value('site_name'),
					);

					create_image($voucher['voucher_code'], $voucher['start'], $data_voucher['template']);

					$message = '<img src="'.base_url('assets/image/voucher/voucher_'.$voucher['voucher_code'].'.jpg').'">';
					$email_data['message'] = $message;

					sendemail($email_data);
					unlink('assets/image/voucher/voucher_'.$voucher['voucher_code'].'.jpg');
		   		}
		   	}
		   	
		   	$this->model_midtrans->notification($result);
		    $this->db->update('orders', $update, array('No_Orders'    => $dataorder['No_Orders']));
			

		}

	}
	
	public function test()
	{
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

	    pre($result);
	}

}