<?php 
/**
 * 
 */
class Accounts extends CI_Controller
{
	// get balance detail of account holder 
	public function get_details ()
	{
		$account_number = $this->input->post('account_number');

		$this->db->select('*');
		$this->db->from('account_detail');
		$this->db->join('account_holders', 'account_holders.account_number = account_detail.account_number');
		$this->db->where('account_detail.account_number',$account_number);
		$this->db->order_by('account_detail.id','desc');
		$this->db->limit(1);
		$data = $this->db->get();
		$response = array('status'=>false, 'message'=>'','code'=>''); 
		if($data->num_rows()>0){
			$get_row =$data->result_array();
			$result = reset($get_row);
			$response['status'] = true;
			$response['account_number'] = $result['account_number'];
			$response['name']           = $result['name'];
			$response['new_balance']    = $result['new_balance'];


		}else{
			$response['message'] = 'Account number not exist.';
			
		}

	echo json_encode($response);	
	}

	public function put_data()
	{
		$account_number  = $this->input->post('account_number');	
	    $holder_name     = $this->input->post('holder_name');
	    $current_balance = $this->input->post('current_balance');
	    $type            = $this->input->post('type');
	    $deposite_amount = $this->input->post('deposite_amount');

	    if($type=='credit'){
	    	//$this->db->get_where('account_detail',array('account_number'=>$account_number));
	    	$this->db->select('*');
			$this->db->from('account_detail');
			$this->db->where('account_number',$account_number);
	    	$this->db->order_by('id','desc');
			$this->db->limit(1);
			$data = $this->db->get();

			if($data->num_rows()>0){
				$get_row =$data->result_array();
				$result = reset($get_row);
				$bal = $result['new_balance'];
				$new_balance = $bal + $deposite_amount;

				$this->db->insert('account_detail',array('account_number' =>$account_number,
														'new_balance'     =>$new_balance,
														'old_balance'     =>$bal,
														'credit'          =>$deposite_amount,
														'txn_status'	  =>1
														));
				if($this->db->affected_rows()>0){

				}

			}else{
				$this->db->insert('account_detail',array('account_number'=>$account_number,
														'new_balance'	=>$deposite_amount,
														'credit'        =>$deposite_amount,
														'txn_status'	  =>1
														));
			}

	    }else{

	    }
	}
}
 ?>