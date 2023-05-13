<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Private_order extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library(array('form_validation', 'cart'));
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->model(array('model_private_order', 'checkout/m_checkout'));
	}

	function index(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('pengiriman', 'Pengiriman', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$data = array(
				'province' => $this->m_checkout->get_destination('propinsi'),
				'item'     => $this->model_private_order->item_list()
			);

			$this->temp_admin('admin/private/private_order', $data);
		}else{
			$insert = $this->model_private_order->crate_order();

			if($insert){
				$this->session->set_flashdata('alert_success', 'Successfully added a product');
			}else{
				$this->session->set_flashdata('alert_errors', 'Error when contacting database');
			}

			redirect(base_url().'admin/private-order/listdata');
		}
	}

	public function listdata(){
		$data = array(
			'list' => $this->db->order_by('tanggal', 'DESC')->get('private_order')->result_array()
		);
		$this->temp_admin('admin/private/list', $data);
	}

	function addcart(){
		if($this->input->post()){
			$cart = $this->model_private_order->addcart();
			echo json_encode($cart);
		}
	}

	function delete(){
		$rowid  = $this->input->post('rowid');
		$data   = array('rowid' => $rowid, 'qty' => 0 );
		$delete = $this->cart->update($data);
		if($delete){
			$json['status']  = 1;
			$json['total']   = $this->cart->total();
		}else{
			$json['status']  = 0;
		}
		echo json_encode($json);
	}

	public function load_cart(){
		$cartlist = '';
		if($this->cart->total_items() > 0){
			foreach ($this->cart->contents() as $items) {
				$color = (!empty($items['options']['Color'])) ? ' / '.$items['options']['Color'] : '';
				$size  = (!empty($items['options']['Size'])) ? ' / '.$items['options']['Size'] : '';
				$disc  = ($items['disc'] > 0) ? ' <span class="red">('.$items['disc'].')</span>' : '';

				$cartlist .= '<tr data-rowid="'.$items['rowid'].'">
				<td><button type="button" class="btn btn-warning delete_cart"><i class="fa fa-trash"></i></button></td>
				<td>'.$items['name'].' '.$color.' '.$size.'</td>
				<td>'.$items['qty'].'</td>
				<td align="right">'.rupiah($items['ori_price']).' '.$disc.'</td>
				</tr>';
			}

			$cartlist .= '<tr id="total_cart"><td colspan="3"><b>Total</b></td><td align="right"><b>'.rupiah($this->cart->total()).'</b></td></tr>';
		}
		else{
			$cartlist = '<tr><td colspan="4"> No Data ! </td></tr>';
		}
		echo $cartlist;
	}
}