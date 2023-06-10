<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiteMap extends CI_Controller {

    public function index()
    {
        $this->load->helper('url');

        // Mendapatkan semua URL yang ada pada website
        $data['urls'] = $this->getAllUrls();

        // Load view untuk menampilkan halaman sitemap
        $this->load->view('sitemap', $data);
    }

    private function getAllUrls()
    {
        // Mendapatkan semua URL dari website
        $this->load->helper('directory');
        $map = directory_map(APPPATH, 2);

        $urls = [];
        foreach ($map as $item) {
            if (is_array($item)) {
                foreach ($item as $subItem) {
                    if (is_string($subItem)) {
                        $url = base_url($subItem);
                        $urls[] = $url;
                    }
                }
            } else {
                if (is_string($item)) {
                    $url = base_url($item);
                    $urls[] = $url;
                }
            }
        }

        return $urls;
    }
}
