<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		if($this->link->isUserLoggedInAPI($this->session->userdata('token'), $this->user->getUserId())) {
			$date = date('m-d-Y H:i:s');
			$ip = $this->link->getIP();
			$this->db->update('login_sessions', array('ip_o' => $ip, 'out_dt' => $date, 'status' => 2), array('session_key' => $this->session->userdata('token'), 'userid' => $this->user->getUserId()));
		}
		$this->session->sess_destroy();
		redirect(base_url());
	}

}

?>