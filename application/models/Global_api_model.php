<?php

class Global_api_model extends CI_Model {
	
	function getAllCarsChildColors($id){
		$this->db->select('cco_uid,cco_name,cco_meta_desc');
		$q = $this->db->get_where('cars_colors', array("parent_uid" => $id));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->cco_name = $this->getStringByKeyLanguage($row->cco_name,"arabic");				
				$data['result'][] = $row;
			}
			usort($data['result'], function($first, $second)
			{
				return strtolower($first->cco_name) > strtolower($second->cco_name);
			});
			
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data; 
		}else{
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			$data['result'] = [];
			return $data;	
		}
	}
	
	function getAllCarsColors(){
		$this->db->select('cco_uid,cco_name,cco_meta_desc');
		$q = $this->db->get_where('cars_colors', array("parent_uid" => 0));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->cco_name = $this->getStringByKeyLanguage($row->cco_name,"arabic");				
				$data['result'][] = $row;
			}
			usort($data['result'], function($first, $second)
			{
				return strtolower($first->cco_name) > strtolower($second->cco_name);
			});
			
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data; 
		}else{
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			$data['result'] = [];
			return $data;	
		}
	}
	
	function getAllModelsByBrandID($cb_uid){
		$this->db->select('cm_uid,cm_name');
		$q = $this->db->get_where('cars_models', array("cb_uid" => $cb_uid));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->cm_name = $this->getStringByKeyLanguage($row->cm_name,"arabic");				
				$data['result'][] = $row;
			}
			usort($data['result'], function($first, $second)
			{
				return strtolower($first->cm_name) > strtolower($second->cm_name);
			});
			
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data; 
		}else{
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			$data['result'] = [];
			return $data;	
		}
	}
	
	
	function getAllCarsBrands(){
		$this->db->select('cb_uid,cb_name');
		$q = $this->db->get('cars_brands');
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->cb_name = $this->getStringByKeyLanguage($row->cb_name,"arabic");				
				$data['result'][] = $row;
			}
			
			usort($data['result'], function($first, $second)
			{
				return strtolower($first->cb_name) > strtolower($second->cb_name);
			});
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data; 
		}else{
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			$data['result'] = [];
			return $data;	
		}
	}
	
	function getAllCarsTypes(){
		$this->db->select('ct_uid,ct_name');
		$q = $this->db->get('cars_types');
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->ct_name = $this->getStringByKeyLanguage($row->ct_name,"arabic");				
				$data['result'][] = $row;
			}
			usort($data['result'], function($first, $second)
			{
				return strtolower($first->ct_name) > strtolower($second->ct_name);
			});
			
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data; 
		}else{
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			$data['result'] = [];
			return $data;	
		}
	}
	
	function getAllCarsCategories(){
		$this->db->select('cc_uid,cc_name');
		$q = $this->db->get('cars_categories');
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->cc_name = $this->getStringByKeyLanguage($row->cc_name,"arabic");				
				$data['result'][] = $row;
			}
			usort($data['result'], function($first, $second)
			{
				return strtolower($first->cc_name) > strtolower($second->cc_name);
			});
			
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data; 
		}else{
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			$data['result'] = [];
			return $data;	
		}
	}
	
	function getAllCountriesCodes(){
		$this->db->select('id,name,iso');
		$this->db->order_by("name", "asc");
		$q = $this->db->get_where('countries', array("status" => 1));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->flag = base_url().FLAGS_IMAGES.strtolower($row->iso).".png";				
				$data['result'][] = $row;
			}
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data; 
		}else{
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			$data['result'] = [];
			return $data;	
		}
	}
	

	function getAllCitiesByCountryID($country_uid){
		$this->db->select('city_uid,city_name_ar');
		$this->db->order_by("city_name_ar", "asc");
		$q = $this->db->get_where('cities', array("country_uid" => $country_uid));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$data['result'][] = $row;
			}
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data; 
		}else{
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			$data['result'] = [];
			return $data;	
		}
	}
	

	public function generateToken($member_uid, $tkn_device){
		
		// check if have token in database with same device id return it, 
		// or if deffrent device id send notification to the client for new device login
		
        $token_id = $this->random_text();
        $data = array(
                 'member_uid' => $member_uid,
                 'token' => $token_id,
                 'tkn_device' => $tkn_device,
                 //'tkn_ip' => $tkn_ip
                 );
		$this->db->insert('u_token', $data);
		return $token_id;
    }
	
	
	public function checkToken($token){
		//$last_x_days = date('Y-m-d H:i:s', strtotime('now - 7 days'));
		//echo $last_x_days;
        $this->db->where('token', $token);
        $this->db->where('tkn_device', $this->agent->agent_string());
        $query = $this->db->get('u_token');
		if (count($query->result()) > 0) {
			$row = $query->row();
			$data['result'] = $row->member_uid;
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data;	
			
		}else{
			// session attack possabilty add log
			$this->db->where('token', $token);
			$query = $this->db->get('u_token');
			$this->db->delete('u_token', array('token' => $token));
			$data['status'] = false;
			$data['message'] = 'session_expired';
			$data['result'] = [];
			return $data;
				
		}
    }
	
	function random_text( $type = 'alnum', $length = 32 ){
		switch ( $type ) {
			case 'alnum':
				$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 'alpha':
				$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 'hexdec':
				$pool = '0123456789abcdef';
				break;
			case 'numeric':
				$pool = '0123456789';
				break;
			case 'nozero':
				$pool = '123456789';
				break;
			case 'distinct':
				$pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
				break;
			default:
				$pool = (string) $type;
				break;
		}


		$crypto_rand_secure = function ( $min, $max ) {
			$range = $max - $min;
			if ( $range < 0 ) return $min; // not so random...
			$log    = log( $range, 2 );
			$bytes  = (int) ( $log / 8 ) + 1; // length in bytes
			$bits   = (int) $log + 1; // length in bits
			$filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
			do {
				$rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
				$rnd = $rnd & $filter; // discard irrelevant bits
			} while ( $rnd >= $range );
			return $min + $rnd;
		};

		$token = "";
		$max   = strlen( $pool );
		for ( $i = 0; $i < $length; $i++ ) {
			$token .= $pool[$crypto_rand_secure( 0, $max )];
		}
		return $token;
	}	
		
    function getStringByKeyLanguage($key, $lang) {
        $q = $this->db->get_where('strings', array('string_key' => $key, 'string_lang' => $lang));
        if ($q->num_rows() > 0) {
            $row = $q->row();
            return $row->string_content;
        } else {
            return false;
        }
    }
	

}

?>