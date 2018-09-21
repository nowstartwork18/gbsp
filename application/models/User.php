<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model{

	public function getUserId()
	{
		return $this->session->userdata('userid');
	}

	public function getToken()
	{
		return $this->session->userdata('token');
	}
}

?>
