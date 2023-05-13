<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Job {

	public $url = "http://apiv2.jne.co.id:10101/";

	public function request($action, $method, $header, $parameter = array())
	{
		$curl = curl_init();

		curl_setopt($curl, CURLOPT_URL, $this->url . $action);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    	curl_setopt($curl, CURLINFO_HEADER_OUT, true);
		if ($method == 'POST' || $method == 'post') {
        	curl_setopt($curl, CURLOPT_POST, true);
        	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameter));
		} else {
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		}
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
	}
}