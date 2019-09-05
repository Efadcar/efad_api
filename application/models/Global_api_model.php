<?php

class Global_api_model extends CI_Model {
	
	function getAllMemberships(){
		$this->db->select('mc_uid,mc_name,mc_6months_price,mc_9months_price,mc_12months_price');
		$this->db->order_by("mc_name", "desc");
		$q = $this->db->get_where('memberships',array("mc_status" => 1));
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
		
	function getPageContentByLink($id){
		$this->db->select('page_title,page_text,page_meta_desc,page_meta_keywords');
		$q = $this->db->get_where('pages', array("page_link" => $id));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->page_title = $this->getStringByKeyLanguage($row->page_title,"arabic");	
				$row->page_text = $this->getStringByKeyLanguage($row->page_text,"arabic");	
				$row->page_meta_desc = $this->getStringByKeyLanguage($row->page_meta_desc,"arabic");	
				$row->page_meta_keywords = $this->getStringByKeyLanguage($row->page_meta_keywords,"arabic");	
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
	
	function getAllFaqs(){
		$this->db->select('fc_uid,fc_name');
		$this->db->order_by("fc_order", "asc");
		$q = $this->db->get('faq_categories');
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->faqs = $this->getFaqsByCatID($row->fc_uid);
				$row->fc_name = $this->getStringByKeyLanguage($row->fc_name,"arabic");				
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
	
	function getFaqsByCatID($faq_category_uid){
		$this->db->select('faq_question,faq_answer');
		$q = $this->db->get_where('faq', array("faq_category_uid" => $faq_category_uid));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->faq_question = $this->getStringByKeyLanguage($row->faq_question,"arabic");				
				$row->faq_answer = $this->getStringByKeyLanguage($row->faq_answer,"arabic");				
				$data[] = $row;
			}
			
			return $data;
		}else{
			return false;	
		}
	}
	
	
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
	
	function explore(){	
		$search_text = $this->input->post('search_text');
		$book_period = $this->input->post('book_period');
		$price_period = $this->input->post('price_period');
		$price_from = $this->input->post('price_from');
		$price_to = $this->input->post('price_to');
		$cb_uid = $this->input->post('cb_uid');
		$cm_uid = $this->input->post('cm_uid');
		$ct_uid = $this->input->post('ct_uid');
		$year_from = $this->input->post('year_from');
		$year_to = $this->input->post('year_to');
		$color = $this->input->post('color');
		$car_transmission = $this->input->post('transmission');
		
		$order_by = $this->input->post('order_by');
		
		$offset_before = $this->input->post('offset');
		$offset = $offset_before * 15;
		$num_rows = null;
		$where = "";
		if($search_text != null && $search_text != "")
		{
			$search_text = str_replace(" ", ", ", $search_text);
			$db = get_instance()->db->conn_id;
			$search_text = mysqli_real_escape_string($db, $search_text);

			if($book_period === "0"){
				$field = "car_daily_price";
			}else{
				$field = "car_monthly_price";
			}
			
			if($offset_before == 0){
				$n = $this->db->query("
			SELECT * FROM (
			SELECT car_uid,car_link, cb_uid, cm_uid, car_color, car_model_year, album_uid, ".$field.", car_in_stock, car_status 
			  FROM cars
			WHERE car_search_text LIKE '%".$search_text."%' GROUP BY `car_link`, `car_color`
			) AS car ORDER BY ".$field." ".$order_by." 
				");
				$num_rows = $n->num_rows();
			}
			$query = "
			SELECT * FROM (
			SELECT car_uid,car_link, cb_uid, cm_uid, car_color, car_model_year, album_uid, ".$field.", car_in_stock, car_status 
			  FROM cars
			WHERE car_search_text LIKE '%".$search_text."%' GROUP BY `car_link`, `car_color` LIMIT 15 OFFSET ".$offset."
			) AS car ORDER BY ".$field." ".$order_by." 
			";
			//return $query;
			$q = $this->db->query($query);

			$data['num_rows'] = $num_rows;

			if($q->num_rows() > 0) {
				foreach($q->result() as $row) {
					$row->image = base_url().ALBUMS_IMAGES."sm_".$this->getShowMainImageByID($row->album_uid);
					if($row->car_in_stock == 0){
						$row->car_status = 2;
					}
					$check_if_car_avalible = $this->checkIfCarAvalible($row->car_link);
					if($check_if_car_avalible){
						if($row->car_status == 1){
							$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
							$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
							$data['result'][] = $row;
						}
					}else{
						if($row->car_status == 0){
							$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
							$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
							$data['result'][] = $row;
						}
					}
				}
				$data['status'] = true;
				$data['message'] = "تم العثور علي نتائج";
				return $data; 
			}else{
				$data['status'] = false;
				$data['message'] = "لا توجد نتائج للبحث";
				$data['result'] = [];
				return $data;	
			}
		}
		else
		{
			switch($price_period){
				case "day":
				$price_from = $price_from / 1;
				break;
				case "week":
				$price_from = $price_from / 7;
				break;
				case "month":
				$price_from = $price_from / 30;
				break;
				case "year":
				$price_from = $price_from / 365;
				break;
					
			}
			
			switch($price_period){
				case "day":
				$price_to = $price_to / 1;
				break;
				case "week":
				$price_to = $price_to / 7;
				break;
				case "month":
				$price_to = $price_to / 30;
				break;
				case "year":
				$price_to = price_to / 365;
				break;
					
			}
			
			if($cb_uid == 0){
				$where .= " ";
			}else{
				$where .= " AND cb_uid = ".$cb_uid;
			}
			
			if($cm_uid == 0){
				$where .= "";
			}else{
				$where .= " AND cm_uid = ".$cm_uid;
			}
			
			if($ct_uid == 0){
				$where .= " ";
			}else{
				$where .= " AND ct_uid = ".$ct_uid;
			}
			
			if($color == 0){
				$where .= " ";
			}else{
				$i = 1;
				$where .= "AND (";
				foreach($color as $one){
					if($i ==1){
						$where .= "car_color = ".$one;
					}else{
						$where .= " OR car_color = ".$one;
					}
					$i++;
				}
				$where .= ")";
			}
			//return $car_transmission;
			if($car_transmission == null){
				$where .= " ";
			}else{
				$where .= " AND car_transmission LIKE '".$car_transmission."'";
			}
			
			if($book_period === "0"){
				$where .= " AND car_daily_price >= '".$price_from."' AND car_daily_price <= '".$price_to."' ";
				$field = "car_daily_price";
			}else{
				$where .= " AND car_monthly_price >= '".$price_from."' AND car_monthly_price <= '".$price_to."' ";
				$field = "car_monthly_price";
			}
			
			if($offset_before == 0){
				$n = $this->db->query("
				SELECT * FROM (
				SELECT car_uid,car_link, cb_uid, cm_uid, car_color, car_model_year, album_uid, ".$field.", car_in_stock, car_status 
				  FROM cars
				WHERE car_model_year >= ".$year_from." AND car_model_year <= ".$year_to." ".$where." GROUP BY `car_link`, `".$field."`, `car_color`, `car_status`
				) AS car ORDER BY `car_status` DESC, ".$field." ".$order_by."
				");
				$num_rows = $n->num_rows();
			}
			$query = "
			SELECT * FROM (
			SELECT car_uid,car_link, cb_uid, cm_uid, car_color, car_model_year, album_uid, ".$field.", car_in_stock, car_status 
			  FROM cars
			WHERE car_model_year >= ".$year_from." AND car_model_year <= ".$year_to." ".$where." GROUP BY `car_link`, `".$field."`, `car_color`, `car_status`  LIMIT 15 OFFSET ".$offset."
			) AS car ORDER BY `car_status` DESC, ".$field." ".$order_by."
			";
			$q = $this->db->query($query);

			$data['num_rows'] = $num_rows;

			if($q->num_rows() > 0) {
				foreach($q->result() as $row) {
					$row->image = base_url().ALBUMS_IMAGES."sm_".$this->getShowMainImageByID($row->album_uid);
					if($row->car_in_stock == 0){
						$row->car_status = 2;
					}
					$check_if_car_avalible = $this->checkIfCarAvalible($row->car_link);
					if($check_if_car_avalible){
						if($row->car_status == 1){
							$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
							$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
							$data['result'][] = $row;
						}
					}else{
						if($row->car_status == 0){
							$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
							$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
							$data['result'][] = $row;
						}
					}
				}
				$data['status'] = true;
				$data['message'] = "تم العثور علي نتائج";
				return $data; 
			}else{
				$data['status'] = false;
				$data['message'] = "لا توجد نتائج للبحث";
				$data['result'] = [];
				return $data;	
			}
		}
	}
	
	function getShowMainImageByID($album_uid){
		$this->db->order_by("album_uid","asc");
		$q =  $this->db->get_where('media', array('album_uid' => $album_uid),1);
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row->media_path; 
		}else{
			return false;	
		}
	}

	function getAlbumByID($album_uid){
		$q =  $this->db->get_where('media', array('album_uid' => $album_uid));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$data[] = "md_".$row->media_path; 
			}
			return $data; 
		}else{
			return false;	
		}
	}
	
	function checkIfCarAvalible($car_link){
		$q =  $this->db->get_where('cars', array('car_link' => $car_link, "car_status" => 1),1);
		if($q->num_rows() > 0) {
			return true; 
		}else{
			return false;	
		}
	}

	function getCarBrandNameByID($cb_uid) {
		$q =  $this->db->get_where('cars_brands', array('cb_uid' => $cb_uid));
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $this->getStringByKeyLanguage($row->cb_name, "arabic");
		}else{
			return false;	
		}
	}
		
	function getCarModelNameByID($cm_uid) {
		$q =  $this->db->get_where('cars_models', array('cm_uid' => $cm_uid));
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $this->getStringByKeyLanguage($row->cm_name, "arabic");
		}else{
			return false;	
		}
	}
		





}

?>