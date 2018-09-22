<?php

/**
 * 
 */
class Auth extends CI_Controller
{
	
	public function index()
	{
		$this->load->view('login');
	}

	public function reg()
	{
		$username = 'prasanna';
		$password = 'prasanna@91';

		$hashed = $this->link->getHash($password);
print_r($hashed);
		 $this->db->insert('users',array('username'=>$username, 'password'=>$hashed));
		$result = $this->db->get_where('users', array('username' => $username, 'password' => $hashed))->result_array();
		print_r($result);
	
	}
	public function login()
	{
		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));	

		$data = array('username'=>$username,
						'password'=>$password);
		$curl = $this->link->hit('login-api',$data);
		$response = array('code' => -1, 'status' => false, 'message' => '');
		if($curl){
			$result = json_decode($curl);
			//print_r($result);
			if ($result->code === 200) {
				$data = $this->link->getuserdata($result->id);
				if ($data['status'] == true) {
					$userdata = $data['data'];
				//print_r($userdata); exit();
					if ($userdata['status'] == 2) {
						$this->session->set_userdata($userdata);
						$this->session->set_userdata(array('token' => $result->token));
						//redirect(base_url('Home'));
						$response['status']=true;
						$response['code'] = 200;
					}else if($userdata['status'] == 1) {
						$response['message']='Your do not have authority to access this account.';
						$response['code'] = 201;
						// $this->session->set_flashdata('msg','');
						// $this->index();
					}	
				}
			}else {
				$err_msg = $result->message;
				$response['message']=$err_msg;
				$response['code'] = 201;
				// $this->session->set_flashdata('msg',$err_msg);
				// $this->index();
			}

		}else {
			$response['message']='Oops! please try again later.';
			$response['code'] = 201;
			// $this->session->set_flashdata('msg','Oops! please try again later.');
			// $this->index();
		}
	echo json_encode($response);	

	}
	public function logout()
	{
		
		redirect("index.php/logout");
	}

}
 ?>