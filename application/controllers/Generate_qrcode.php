<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Generate_qrcode extends CI_Controller
{
    public function index()
    {
        $data['coupon'] = "Generate QRCODE";
        $data['potongan'] = $this->db->get('potongan')->result(); 
        $data['potongan_max'] = $this->db->get('potongan_max')->result(); 
        $data['mintagihan'] = $this->db->get('mintagihan')->result(); 
        $data['sortdate'] = $this->db->get('sortdate')->result(); 
        $data['input_vou'] = $this->db->get('input_vou')->result(); 
        $data['start_voucher'] = $this->db->get('start_voucher')->result(); 
        $data['publish'] = $this->db->get('publish')->result(); 
        $this->load->view('entersite/voucher', $data); // passing data ke view
    }
}
