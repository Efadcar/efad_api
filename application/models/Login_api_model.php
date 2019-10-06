<?php

class Login_api_model extends CI_Model {

    function validate($username, $password) {
        $username = strtolower($username);
        $password = md5($password);
		
		if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$this->db->where('member_email', $username);
		}else{
			$username = ltrim($username, '+');
			$username = ltrim($username, '0');
			$this->db->where('member_mobile', $username);
		}
        
        $this->db->where('member_password', $password);
        $query = $this->db->get('members');

        if ($query->result_id->num_rows == 1) {
            $row = $query->row();
			// update ast login ip
			$user_ip = $_SERVER['REMOTE_ADDR'];
			$q = $this->db->query("UPDATE `members` SET  
						`member_last_login` =  CURRENT_TIMESTAMP,
						`member_last_login_ip` =  '$user_ip'
						 WHERE `member_uid` = '$row->member_uid'") ;

			if ($row->member_status == 0) {
				$data['status'] = false;
				$data['message'] = "لقد تم حظرك";
				$data['result'] = (object)[];
				return $data;
            }
			$token = $this->global_api_model->generateToken($row->member_uid, $this->agent->agent_string());
			$data['status'] = true;
			$data['message'] = "تم تسجيل الدخول بنجاح";
			$data['result'] = (object)array(
                'member_full_name' => $row->member_fname." ".$row->member_lname,
                'member_uid' => $row->member_uid,
                'member_fname' => $row->member_fname,
                'member_lname' => $row->member_lname,
                'member_mobile' => $row->member_mobile,
                'country_uid' => $row->country_uid,
                'city_uid' => $row->city_uid,
                'member_email' => $row->member_email,
                'mc_uid' => $row->mc_uid,
                'member_renewal_date' => $row->member_renewal_date,
                'token' => $token,
                'is_logged_in' => true
            );
			return $data;
        } else {
			$data['status'] = false;
			$data['message'] = "أسم المستخدم أو كلمة المرور غير صحيحة";
			$data['result'] = (object)[];
			return $data;
        }
    }
	
	function register(){
		$member_title = $this->input->post('member_title');
		$member_fname = $this->input->post('member_fname');
		$member_lname = $this->input->post('member_lname');
		$member_dob = $this->input->post('member_dob');
		$member_email = $this->input->post('member_email');
		$country_uid = $this->input->post('country_uid');
		$country_code = $this->getCountryCodeByID($country_uid);
		$member_mobile = $this->input->post('member_mobile');
		$member_mobile = preg_replace("/^\+?{$country_code}/", "",$member_mobile);
		$member_mobile = ltrim($member_mobile, '+');
		$member_mobile = ltrim($member_mobile, '0');
		$member_password_not_hashed = $this->input->post('member_password');
		$member_password = md5($member_password_not_hashed);
		
		$city_uid = $this->input->post('city_uid');
		$member_id_type = $this->input->post('member_id_type');
		$member_id_expire = $this->input->post('member_id_expire');
		$member_license_expire = $this->input->post('member_license_expire');

		$data = array(
		   'member_title' => $member_title ,
		   'member_fname' => $member_fname ,
		   'member_lname' => $member_lname ,
		   'member_dob' => $member_dob ,
		   'member_email' => $member_email ,
		   'member_mobile' => $member_mobile ,
		   'member_password' => $member_password ,
		   'member_id_type' => $member_id_type ,
		   'member_id_expire' => $member_id_expire ,
		   'member_license_expire' => $member_license_expire ,
		   'country_uid' => $country_uid ,
		   'city_uid' => $city_uid 
		);
		
		$this->db->insert('members', $data); 
		
		if($this->db->affected_rows() > 0){
			$result['status'] = true;
			$result['message'] = "لقد تم تسجيل حسابك بنجاح.";
			return $result;
		}else{
			$result['status'] = false;
			$result['message'] = "لقد حدث خطأ أثناء الأضافة.";
			$result['result'] = (object)[];
			return $result;
		}

	}

	function getCountryCodeByID($id) {
		$q =  $this->db->get_where('countries', array('id' => $id));
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row->phonecode; 
		}else{
			return false;	
		}
	}
		
}

?>