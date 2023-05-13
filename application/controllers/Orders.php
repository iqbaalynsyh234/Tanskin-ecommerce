<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Orders extends MY_Controller {
    function __construct(){
		parent::__construct();
	}
	
    function index(){
        
        $this->load->view('orders', array());
    }
}