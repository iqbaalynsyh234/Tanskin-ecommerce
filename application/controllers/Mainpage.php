<?php if( ! defined('BASEPATH')) exit ('No direct script access allowed');
class Mainpage extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url', 'function'));
		$this->load->model('user');
	}

	public function index(){

		$data = array(
			'title'         => '',
			'css'           => array('plugins/owl-carousel/owl.carousel.min'),
			'js'            => array('plugins/owl-carousel/owl.carousel.min'),
			'banner'        => $this->user->get_page('slide', array('publish' => '11'), TRUE),
			'slide_left'    => $this->user->get_page('banner', array('category' => 1, 'side' => '1', 'publish' => '11'), TRUE),
			'slide_right'   => $this->user->get_page('banner', array('category' => 1, 'side' => '2', 'publish' => '11'), TRUE),
			
			'item_featured' => $this->user->get_products(array('publish' => '11', 'pm.push' => '11'), 10, array('created', 'asc'), TRUE),
			'item'          => $this->user->get_products(array('publish' => '11', 'pm.status' => '11'), 10, array('created', 'asc'), TRUE),
			'home_desc'     => $this->user->get_page('static_page', array('id_page' => '23', 'publish' => '11'), FALSE),
			'home_skin'     => $this->user->get_page('static_page', array('id_page' => '24', 'publish' => '11'), FALSE),
			
			'home_image1'   => $this->user->get_page('banner', array('id' => 13, 'category' => 0, 'publish' => '11'), FALSE),
			'home_image2'   => $this->user->get_page('banner', array('id' => 14, 'category' => 0, 'publish' => '11'), FALSE),
			'feed'          => igfeed(setting_value('token_ig'))
		);

		// pre($data['home_image']);


		$this->render_page('mainhome', $data);
	}
	public function blog(){
		$data = array(
			'title' => 'Blogs',
		);

		$this->render_page('blog');
	}

	public function statics($seo_url = ''){
		$page      = $this->user->get_staticpage(array('p.link' => $seo_url));
		
		$data = array(
			'title' => $page['section'],
			'page'  => $page
		);
		$data['menu']      = $this->user->get_staticpage(array(), TRUE);

		if($data['page']){
			$this->render_page('static_page', $data);
		}else{
			show_404();
		}
	}
	
	public function contact(){
		$this->render_page('contact');
	}
	
} 
?>