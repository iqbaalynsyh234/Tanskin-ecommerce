<?php defined('BASEPATH') OR exit('No direct script access allowed');
class ootdkamnco extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model(array('model_front'));
	}
	public function index(){
		$data = array(
			'ootd' => $this->model_front->get_ootd()
		);

		$this->render_page('ootdkamnco', $data);
	}
}