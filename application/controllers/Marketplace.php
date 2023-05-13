<?php
if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Marketplace extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('model_marketplace');
	}


	function tokopedia(){
		$this->temp_admin('admin/marketplace/tokopedia');	
	}
}