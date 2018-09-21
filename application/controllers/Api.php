<?php
/**
 * 
 */
class Api extends CI_Controller
{
	public function login()
	{
		$response = array('code' => -1, 'status' => false, 'message' => '');
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$username1 = $this->input->post('username');
			$password = $this->input->post('password');	
			$ip = $this->link->getIP();
			$username = trim($username1);
			$password = trim($password);
			$hashed = $this->link->getHash($password);

			$result = $this->db->get_where('users', array('username' => $username, 'password' => $hashed));
			$response['status'] = $hashed;
			if ($result->num_rows() === 1) {
				$row = $result->row();
					$uid = $row->id;
					$date = date('m-d-Y H:i:s');
					$result = $this->db->get_where('login_sessions', array('userid' => $uid, 'status' => 3));
					if ($result->num_rows() > 0) {
						$this->db->update('login_sessions', array('ip_o' => $ip, 'out_dt' => $date, 'status' => 2, 'auto_logout' => 'true'), array('userid' => $uid, 'status' => 3));
					}
					$token = $this->generateRandomString(15);
					$this->db->insert('login_sessions', array('ip_i' => $ip, 'userid' => $uid, 'in_dt' => $date, 'session_key' => $token, 'status' => 3));
						$response['status'] = true;
						$response['code'] = 200;
						$response['id'] = $uid;
						$response['token'] = $token;

			}else {
					$response['message'] = 'username and password is incorrect.';
					$response['code'] = 203;
				}
		}else {
			$response['message'] = 'No direct script is allowed.';
			$response['code'] = 204;
		}
		echo json_encode($response);
	}

	function generateRandomString($length) {
		$randstr = "";
		for ($i = 0; $i < $length; $i++) {
			$randnum = mt_rand(0, 61);
			if ($randnum < 10) {
				$randstr.= chr($randnum + 48);
			} else if ($randnum < 36) {
				$randstr.= chr($randnum + 55);
			} else {
				$randstr.= chr($randnum + 61);
			}
		}
		return $randstr;
	}

	
}
?>