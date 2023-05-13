<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

    function render_page($content, $data = NULL){
        
	    date_default_timezone_set('Asia/Jakarta');
        $data['wrapper'] = $this->load->view('mainpage', $data, TRUE);
        $data['content'] = $this->load->view($content, $data, TRUE);
        $data['header']  = $this->load->view('mainheader', $data, TRUE);
        $data['footer']  = $this->load->view('mainfooter', $data, TRUE);
        $this->load->view('mainpage', $data);
    }


    function temp_admin($content, $data = NULL){
        if($this->session->userdata('admin_login') == false){
            redirect(base_url('entersite/login'));
        }
        date_default_timezone_set('Asia/Jakarta');
        $data['wrapper'] = $this->load->view('admin/mainpage', $data, TRUE);
        $data['content'] = $this->load->view($content, $data, TRUE);
        $this->load->view('admin/mainpage', $data);
    }
}
?>