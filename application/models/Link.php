<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Link extends CI_Model {

    public function hit($link, $params, $type = 1, $headers = array()) {
        $Base_API = 'http://localhost:81/gbsp/index.php/';
        $query = http_build_query($params);
        $request = curl_init();
        if ($type == 0) {
            $url = $Base_API . $link . "?" . $query;
        } else {
            $url = $Base_API . $link;
        }
        curl_setopt($request, CURLOPT_URL, $url);
        if (count($headers) > 0) {
            curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($request, CURLOPT_POSTFIELDS, $params);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($request, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        $result = curl_exec($request);
        curl_close($request);
        return $result;
    }

    public function getIP() {
        $ip = $this->input->ip_address();
        return $ip;
    }

    public function getSupportPin() {
        $pin = '------';
        if ($this->session->userdata('supportpin')) {
            $pin = $this->session->userdata('supportpin');
        }
        return $pin;
    }

    public function isUserLoggedInAPI($token, $id) {
        $result = $this->db->get_where('login_sessions', array('userid' => $id , 'session_key' => $token, 'status' => 3));
        if ($result->num_rows() === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function isUserLoggedIn() {
        $result = $this->db->get_where('login_sessions', array('userid' => $this->user->getUserId() , 'session_key' => $this->session->userdata('token'), 'status' => 3));
        if ($result->num_rows() === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function curl($link, $params = array(), $type = 1, $headers = array()) {
        $url = '';
        if ($type == 0) {
            if (count($params) > 0) {
                $query = http_build_query($params);
                $url = $link . "?" . $query;
            } else {
                $url = $link;
            }
        } else {
            $url = $link;
        }
        $ret = array('status' => -1, 'msg' => 'Oops! please try again later.');
        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $url);
        if (count($headers) > 0) {
            curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($request, CURLOPT_POSTFIELDS, $params);
        //curl_setopt($request, CURLOPT_POST, $type);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($request, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        try {
            $result = curl_exec($request);
            $ret['msg'] = $result;
        } catch(Exception $e) {
        }
        $http_code = curl_getinfo($request, CURLINFO_HTTP_CODE);
        $ret['status'] = $http_code;
        curl_close($request);
        return $ret;
    }

    public function get_mtcVal() {
        $result = $this->db->get_where('mtcvalue', array());
        $row = $result->row();
        return floatval($row->val);
    }

    public function getHash($val) {
        return hash('sha256', '!l0v3'.trim($val).'mtcx!nd!a');
    }

    public function setsession($key, $value) {
        $this->session->set_userdata(array($key => $value));
    }

    public function setsessions($sess = array()) {
        $this->session->set_userdata($sess);
    }

    public function getuserdata($id, $print = false) {
        $response = array('status' => false, 'data' => array());
        $getuserdetails = $this->db->get_where('users',array('id'=>$id));
        if($getuserdetails->num_rows()===1) {
            $row = $getuserdetails->row();
            $id = $row->id;
            $name = $row->username;
            $status = $row->status;
            $sessionarray = array(
                'userid'=>$id,
                'username'=>$name,
                'status'=>$status
            );
            $this->session->set_userdata($sessionarray);
            $response['data'] = $sessionarray;
        }
        $response['status'] = true;
        if ($print) {
            echo json_encode($response);
        } else {
            return $response;
        }
    }
}
?>