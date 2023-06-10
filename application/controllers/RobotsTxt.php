<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RobotsTxt extends CI_Controller {

    public function index()
    {
        $this->output->set_content_type('text/html');

        // Menampilkan konten robots.txt
        $this->load->view('robots');
    }
}