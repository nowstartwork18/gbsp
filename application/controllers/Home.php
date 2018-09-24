<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{

		//$data['ad']=$this->db->query("SELECT * from account_detail order by id desc")->result_array();
		$this->load->view('home');
	}

	
}
