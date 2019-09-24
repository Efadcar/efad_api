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
        $this->db->where('token', $token);
        $this->db->where('tkn_device', $this->agent->agent_string());
        $query = $this->db->get('u_token');
		if (count($query->result()) > 0) {
			$row = $query->row();
			$this->db->where('member_uid', $row->member_uid);
			$query = $this->db->get('members');

			if ($query->result_id->num_rows == 1) {
				$member_row = $query->row();
				$data['result'] = $member_row;
				$data['status'] = true;
				$data['message'] = $this->lang->line('yes_data');
				return $data;	
				
			}else{
				$this->db->where('token', $token);
				$query = $this->db->get('u_token');
				$this->db->delete('u_token', array('token' => $token));
				$data['status'] = false;
				$data['message'] = 'session_expired';
				$data['result'] = [];
				return $data;
			}
			
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
			WHERE car_search_text LIKE '%".$search_text."%' GROUP BY `car_link`, `car_color`
			) AS car ORDER BY ".$field." ".$order_by." LIMIT 15 OFFSET ".$offset." 
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
					if($row->car_status == 0){
						$check_if_car_avalible = $this->checkIfCarAvalible($row->car_link);
						if($check_if_car_avalible){
							$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
							$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
							$row->car_status = 1;
							$data['result'][] = $row;
						}else{
							$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
							$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
							$data['result'][] = $row;
						}
					}else{
						$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
						$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
						$data['result'][] = $row;
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
				WHERE car_model_year >= ".$year_from." AND car_model_year <= ".$year_to." ".$where." GROUP BY `car_link`, `".$field."`, `car_color`
				) AS car ORDER BY ".$field." ".$order_by."
				");
				$num_rows = $n->num_rows();
			}
			$query = "
			SELECT * FROM (
			SELECT car_uid,car_link, cb_uid, cm_uid, car_color, car_model_year, album_uid, ".$field.", car_in_stock, car_status 
			  FROM cars
			WHERE car_model_year >= ".$year_from." AND car_model_year <= ".$year_to." ".$where." GROUP BY `car_link`, `".$field."`, `car_color`
			) AS car ORDER BY ".$field." ".$order_by." LIMIT 15 OFFSET ".$offset."
			";
			$q = $this->db->query($query);

			$data['num_rows'] = $num_rows;

			if($q->num_rows() > 0) {
				foreach($q->result() as $row) {
					$row->image = base_url().ALBUMS_IMAGES."sm_".$this->getShowMainImageByID($row->album_uid);
					if($row->car_in_stock == 0){
						$row->car_status = 2;
					}
					/*
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
					*/
					if($row->car_status == 0){
						$check_if_car_avalible = $this->checkIfCarAvalible($row->car_link);
						if($check_if_car_avalible){
							$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
							$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
							$row->car_status = 1;
							$data['result'][] = $row;
						}else{
							$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
							$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
							$data['result'][] = $row;
						}
					}else{
						$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
						$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
						$data['result'][] = $row;
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
				$data[] = base_url().ALBUMS_IMAGES."md_".$row->media_path; 
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
		
	function getCarColorNameByID($cco_uid) {
		$q =  $this->db->get_where('cars_colors', array('cco_uid' => $cco_uid));
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $this->getStringByKeyLanguage($row->cco_name, "arabic");
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
	
	function getCarInfo($car_uid){
		$q = $this->db->get_where('cars', array("car_uid" => $car_uid));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->image = base_url().ALBUMS_IMAGES."sm_".$this->getShowMainImageByID($row->album_uid);
				$row->album = $this->getAlbumByID($row->album_uid);
				$row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
				$row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
				$row->car_color = $this->getCarColorNameByID($row->car_color);
				$row->car_color_secondary = $this->getCarColorNameByID($row->car_color_secondary);
				
				$data['result'] = $row;
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
	
		
	function bookingCost($book_start_date, $book_end_date, $car_uid){
		
		// Get booking days
		$days = $this->dateDifference($book_start_date, $book_end_date);
		
		// Get car object
		$car_obj = $this->getCarByID($car_uid);
		if($car_obj == false){
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			$data['result'] = [];
			return $data;	
		}

		// 1- Get car daily rate depend on booking days
		switch($days){
			case ($days < 180):
				$daily_rate = $car_obj->car_daily_price;
				break;
			case ($days >= 180):
				$daily_rate = $car_obj->car_monthly_price;
				break;
		}
				
		// Get total fees for booking
		$total_fees = $daily_rate * $days;
		
		//return $total_fees_after_tax;exit;
		$data['result'] = array(
			"days" => $days, 
			"car_uid" => $car_uid, 
			"book_start_date" => $book_start_date, 
			"book_end_date" => $book_end_date, 
			"daily_rate" => $daily_rate, 
			"total_fees" => $total_fees
		);
		$data['status'] = true;
		$data['message'] = "تم حساب السعر";
		return $data; 
	}

	function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
	{
		$datetime1 = date_create($date_1);
		$datetime2 = date_create($date_2);

		$interval = date_diff($datetime1, $datetime2);

		return $interval->format($differenceFormat)+1;

	}
	
	function getCarByID($car_uid){
		//"12 june 2019 12:00:00";
		$this->db->where('car_uid', $car_uid);
		$q = $this->db->get('cars');
		if($q->num_rows() > 0) {
			$row = $q->row();
			$row->main_image = $this->getShowMainImageByID($row->album_uid);
			$row->cb_uid = $this->getCarBrandByID($row->cb_uid);
			$row->cm_uid = $this->getCarModelByID($row->cm_uid);
			
			return $row; 
		}else{
			return false;	
		}
	}
	
	function getCarBrandByID($cb_uid){
		$q =  $this->db->get_where('cars_brands', array('cb_uid' => $cb_uid));
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row; 
		}else{
			return false;	
		}
	}

	function getCarModelByID($cm_uid){
		$q =  $this->db->get_where('cars_models', array('cm_uid' => $cm_uid));
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row; 
		}else{
			return false;	
		}
	}

	function bookingConfirm(){		
		//$data['member_uid'] = $this->token;
		$data['member_uid'] = $this->member_obj->member_uid;
		$data['car_uid'] = $this->input->post('car_uid');
		$data['book_start_date'] = date("Y-m-d", strtotime($this->input->post('book_start_date')));
		$data['book_end_date'] = date("Y-m-d", strtotime($this->input->post('book_end_date')));
		$data['delivery_city_uid'] = $this->input->post('delivery_city_uid');
		$data['book_total_days'] = $this->input->post('book_total_days');
		$car_obj = $this->getCarByID($data['car_uid']);
		$car_status = $this->checkIfCarAvalible($car_obj->car_link);
		if(!$car_status){
			$result['result'] = [];
			$result['status'] = false;
			$result['message'] = "عفواً، السيارة غير متاحة للحجز";
			return $result;	
		}
		$car_obj->main_image =	base_url().ALBUMS_IMAGES."sm_".$car_obj->main_image;
		if($car_obj->car_transmission == "manual"){
			$car_obj->car_transmission = "يدوي";
		}else{
			$car_obj->car_transmission = "أوتوماتيك";
		}
		
		$car_brand_name = $this->getCarBrandNameByID($car_obj->cb_uid->cb_uid);
		$car_model_name = $this->getCarModelNameByID($car_obj->cm_uid->cm_uid);
		
		$car_full_name = $car_brand_name." ".$car_model_name." ".$car_obj->car_model_year;
		// $row->cb_uid = $this->getCarBrandNameByID($row->cb_uid);
		// $row->cm_uid = $this->getCarModelNameByID($row->cm_uid);
		$car = [
			"car_brand_name" => $car_brand_name,
			"car_model_name" => $car_model_name,
			"car_model_year" => $car_obj->car_model_year,
			"car_image" => $car_obj->main_image,
			"car_color" => $this->getCarColorNameByID($car_obj->car_color),
			"car_color_secondary" => $this->getCarColorNameByID($car_obj->car_color_secondary)
		];
		
		$data['car_obj'] = json_encode($car);
		// add to booking table
		$this->db->insert('bookings', $data); 
		
		if($this->db->affected_rows() > 0){
			$book_uid = $this->db->insert_id();
			$invoice['related_uid'] = $book_uid;
			$invoice['member_uid'] = $data['member_uid'];
			$invoice['invoice_start_date'] = $data['book_start_date'];
			$invoice['invoice_end_date'] = $data['book_end_date'];
			$invoice['book_total_days'] = $this->input->post('book_total_days');
			$invoice['daily_rate'] = $this->input->post('daily_rate');
			$invoice['invoice_total_fees'] = $this->input->post('daily_rate') * $data['book_total_days'];
			$invoice['invoice_tax_total'] = ($invoice['invoice_total_fees'] * (5 / 100));
			$invoice['invoice_total_fees_after_tax'] = $invoice['invoice_total_fees'] + $invoice['invoice_tax_total'];
			$invoice['invoice_payment_method'] = $this->input->post('payment_method');
			if($invoice['invoice_payment_method'] == "visa"){
				$invoice['invoice_status'] = 1;
			}else{
				$invoice['invoice_status'] = 2;
			}
			$this->db->insert('invoices', $invoice); 
			if($this->db->affected_rows() > 0){
				$mail_result = $this->sendBookingConfirmMail($car_obj->main_image, $this->member_obj->member_fname." ".$this->member_obj->member_lname, date("Y-m-d", time()), $book_uid, $car_full_name, $car_obj->car_bags, $car_obj->car_doors, $car_obj->car_transmission, $data['book_total_days'], $data['book_start_date'], $this->getCityByID($data['delivery_city_uid']), $invoice['invoice_total_fees'], $invoice['invoice_tax_total'], $invoice['invoice_total_fees_after_tax']);
				
				$data = array(
					'car_status' => 0
				);

				$this->db->where('car_uid', $car_obj->car_uid);
				$this->db->update('cars', $data);
				
				$result['result'] = [];
				$result['status'] = true;
				$result['message'] = "لقد تم حجز السيارة بنجاح.";
				return $result;	
			}else{
				$result['result'] = [];
				$result['status'] = false;
				$result['message'] = "لقد حدث خطأ أثناء الحجز";
				return $result;	
			}
		}else{
			$result['result'] = [];
			$result['status'] = false;
			$result['message'] = "لقد حدث خطأ أثناء الحجز";
			return $result;	
		}
		// add to invoice table
		
	}
	
	function sendBookingConfirmMail($car_image, $user_name, $date, $book_number, $car_brand_model_year, $bag, $door, $transmission, $book_days, $book_start, $book_city, $book_price, $book_tax, $book_total){
		$mail_body = file_get_contents(BOOKING_CONFIRM_MAIL);
		$mail_body = str_replace("CAR_IMAGE", $car_image, $mail_body);
		$mail_body = str_replace("USER_NAME", $user_name, $mail_body);
		$mail_body = str_replace("DATE", $date, $mail_body);
		$mail_body = str_replace("BOOK_NUMBER", $book_number, $mail_body);
		$mail_body = str_replace("CAR_BRAND_MODEL_YEAR", $car_brand_model_year, $mail_body);
		$mail_body = str_replace("BAG", $bag, $mail_body);
		$mail_body = str_replace("DOOR", $door, $mail_body);
		$mail_body = str_replace("TRANSMISSION", $transmission, $mail_body);
		$mail_body = str_replace("BOOK_DAYS", $book_days, $mail_body);
		$mail_body = str_replace("BOOK_START", $book_start, $mail_body);
		$mail_body = str_replace("BOOK_CITY", $book_city, $mail_body);
		$mail_body = str_replace("BOOK_PRICE", $book_price, $mail_body);
		$mail_body = str_replace("BOOK_TAX", $book_tax, $mail_body);
		$mail_body = str_replace("BOOK_TOTAL", $book_total, $mail_body);
		
		$url = 'http://18.220.20.34/mail_api/v1/send';
		$data = array('to' => $this->member_obj->member_email, 'subject' => 'تأكيد الحجز', 'body' => $mail_body);

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);	
		return $result;
		
	}
	
	function getCityByID($city_uid) {
		$q = $this->db->get_where('cities', array("city_uid" => $city_uid));
		if($q->num_rows() > 0) {
            $row = $q->row();
            return $row->city_name_ar;
		}else{
			return false;	
		}
	}
	
	function confirmMembership(){
		$member_uid = $this->member_obj->member_uid;
		$data['mc_uid'] = $this->input->post('mc_uid');
		$payment_method = $this->input->post('payment_method');
		$total = $this->input->post('total');
		$period = $this->input->post('period');
		
		if($this->member_obj->mc_uid < $_POST['mc_uid'] & $_POST['mc_uid'] != 4 || $this->member_obj->mc_uid == 4 & $_POST['mc_uid'] != 4){
		
		
		
			switch($period){
				case "mc_6months_price";
					$data['member_renewal_date'] = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 180 day"));
					$membership_duration = 6;
					$period_value = "6 أشهر";
					break;
				case "mc_9months_price";
					$data['member_renewal_date'] = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 270 day"));
					$membership_duration = 9;
					$period_value = "9 أشهر";
					break;
				case "mc_12months_price";
					$data['member_renewal_date'] = date('Y-m-d',strtotime(date("Y-m-d", time()) . " + 360 day"));
					$membership_duration = 12;
					$period_value = "12 شهر";
					break;
			}
			$membership_obj = $this->getMembershipByID($data['mc_uid']);

			$invoice2['related_uid'] = $data['mc_uid'];
			$invoice2['member_uid'] = $member_uid;
			$invoice2['invoice_start_date'] = date("Y-m-d", time());
			$invoice2['invoice_end_date'] = $data['member_renewal_date'];
			$invoice2['invoice_total_fees'] = $total;
			$invoice2['invoice_tax_total'] = (($total / 100) * 5 );
			$invoice2['invoice_total_fees_after_tax'] = $total + (($total / 100) * 5 );
			$invoice2['invoice_payment_method'] = $payment_method;
			$invoice2['is_membership'] = 1;
			$invoice2['membership_duration'] = $membership_duration;

			if($payment_method == "visa"){
				$invoice2['invoice_status'] = 1;
			}else{
				$invoice2['invoice_status'] = 2;
			}
			$this->db->insert('invoices', $invoice2); 
			if($this->db->affected_rows() > 0){
				//print_r( $membership_obj);
				$this->sendMembershipConfirmMail($membership_obj->mc_name, date("Y-m-d", time()), $data['member_renewal_date'], $total, $invoice2['invoice_tax_total'], $invoice2['invoice_total_fees_after_tax'], $period_value);

				$this->db->where('member_uid', $member_uid);
				$this->db->update('members', $data);
				
				$result['result'] = [];
				$result['status'] = true;
				$result['message'] = "لقد تم الأشتراك بالعضوية بنجاح.";
				return $result;	
			}else{
				$result['result'] = [];
				$result['status'] = false;
				$result['message'] = "لقد حدث خطأ أثناء الأشتراك";
				return $result;	
			}
		}else{

			$result['result'] = [];
			$result['status'] = false;
			$result['message'] = "عفواً، لا يمكنك تقليل فئة العضوية";
			return $result;	

			
		}
		
		// return true and set message to session msgs
	}
	
	
	function sendMembershipConfirmMail($mc_name, $membership_start, $membership_end, $membership_price, $membership_tax, $membership_total, $period_value){
		$mail_body = file_get_contents(MEMBERSHIP_CONFIRM_MAIL);
		$mail_body = str_replace("MEMBERSHIP_NAME", $mc_name, $mail_body);
		$mail_body = str_replace("MEMBERSHIP_START_DATE", $membership_start, $mail_body);
		$mail_body = str_replace("MEMBERSHIP_END_DATE", $membership_end, $mail_body);
		$mail_body = str_replace("MEMBERSHIP_PRICE", $membership_price, $mail_body);
		$mail_body = str_replace("MEMBERSHIP_TAX", $membership_tax, $mail_body);
		$mail_body = str_replace("MEMBERSHIP_TOTAL", $membership_total, $mail_body);
		$mail_body = str_replace("DATE", $membership_start, $mail_body);
		$mail_body = str_replace("USER_NAME", $this->member_obj->member_fname." ".$this->member_obj->member_lname, $mail_body);
		$mail_body = str_replace("MEMBERSHIP_PERIOD", $period_value, $mail_body);
		
		$url = 'http://18.220.20.34/mail_api/v1/send';
		$data = array('to' => $this->member_obj->member_email, 'subject' => 'تأكيد الاشتراك في العضوية', 'body' => $mail_body);

		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);	
		return $result;
	}
	
	function getMembershipByID($mc_uid){
		$q =  $this->db->get_where('memberships', array('mc_uid' => $mc_uid));
		if($q->num_rows() > 0) {
			$row = $q->row();
			return $row; 
		}else{
			return false;	
		}
	}
	
	function updateProfile(){
		$member_uid = $this->member_obj->member_uid;
		$data['member_fname'] = $this->input->post('member_fname');
		$data['member_lname'] = $this->input->post('member_lname');
		$data['member_email'] = $this->input->post('member_email');
		$data['member_mobile'] = $this->input->post('member_mobile');
		$member_password = $this->input->post('member_password');
		$data['country_uid'] = $this->input->post('country_uid');
		$data['city_uid'] = $this->input->post('city_uid');
		if($member_password !== "" && $member_password !== " ")
		{
			$data['member_password'] = md5($this->input->post('member_password'));
		}
		
		$this->db->where('member_uid', $member_uid);
		$this->db->update('members', $data);
		if($this->db->affected_rows() > 0){
			$result['result'] = [];
			$result['status'] = true;
			$result['message'] = "لقد تم تعديل البيانات بنجاح.";
			return $result;	
		}else{
			$result['result'] = [];
			$result['status'] = false;
			$result['message'] = "لم تقوم بتغيير البيانات";
			return $result;	
		}
	}
	
	function bookings(){
		$member_uid = $this->member_obj->member_uid;
		$this->db->select('book_uid,car_uid,car_obj,book_start_date,book_end_date,delivery_city_uid,book_total_days,book_status');
		$this->db->order_by("book_uid", "desc");
		$q = $this->db->get_where('bookings',array("member_uid" => $member_uid));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->car_obj = json_decode($row->car_obj);
				$this->db->select('invoice_total_fees,invoice_tax_total,invoice_total_fees_after_tax');
				$m = $this->db->get_where('invoices',array("related_uid" => $row->book_uid,"member_uid" => $member_uid));
				if($m->num_rows() > 0) {
					$mrow = $m->row();
					$row->inovice = $mrow;
					$data['result'][] = $row;
				}
			}
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data;	
		}else{
			$data['result'] = [];
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			return $data;	
		}
	}
	
	function quickPayment(){
		$member_uid = $this->member_obj->member_uid;
		$this->db->select('book_uid,car_uid,car_obj,book_start_date,book_end_date,delivery_city_uid,book_total_days,book_status');
		$this->db->order_by("book_uid", "desc");
		$q = $this->db->get_where('bookings',array("member_uid" => $member_uid,"book_start_date <" => date("Y-m-d", time()),"book_end_date >=" => date("Y-m-d", time())));
		if($q->num_rows() > 0) {
			foreach($q->result() as $row) {
				$row->car_obj = json_decode($row->car_obj);
				$this->db->select('invoice_total_fees,invoice_tax_total,invoice_total_fees_after_tax');
				$m = $this->db->get_where('invoices',array("related_uid" => $row->book_uid,"member_uid" => $member_uid));
				if($m->num_rows() > 0) {
					$mrow = $m->row();
					$row->inovice = $mrow;
					$data['result'][] = $row;
				}
			}
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data;	
		}else{
			$data['result'] = [];
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			return $data;	
		}
	}
	
	function booking(){
		$member_uid = $this->member_obj->member_uid;
		$book_uid = $this->input->post('book_uid');
		$this->db->select('book_uid,car_uid,car_obj,book_start_date,book_end_date,delivery_city_uid,book_total_days,book_status,book_added_date');
		$this->db->order_by("book_uid", "desc");
		$q = $this->db->get_where('bookings',array("member_uid" => $member_uid, "book_uid" => $book_uid));
		if($q->num_rows() > 0) {
			$row = $q->row();
			$row->car_obj = json_decode($row->car_obj);
			$this->db->select('invoice_uid,invoice_total_fees,invoice_tax_total,invoice_total_fees_after_tax,invoice_payment_method');
			$m = $this->db->get_where('invoices',array("related_uid" => $row->book_uid,"member_uid" => $member_uid));
			if($m->num_rows() > 0) {
				$mrow = $m->row();
				$row->inovice = $mrow;
				$data['result'][] = $row;
			}
			$data['status'] = true;
			$data['message'] = $this->lang->line('yes_data');
			return $data;	
		}else{
			$data['result'] = [];
			$data['status'] = false;
			$data['message'] = $this->lang->line('no_data');
			return $data;	
		}
	}
	
	function bookingCancel(){
		$member_uid = $this->member_obj->member_uid;
		$book_uid = $this->input->post('book_uid');
		$q = $this->db->get_where('bookings',array("member_uid" => $member_uid, "book_uid" => $book_uid));
		if($q->num_rows() > 0) {
			$row = $q->row();
			
			$data = array(
				'book_status' => 3
			);
			$this->db->where('member_uid', $member_uid);
			$this->db->where('book_uid', $book_uid);
			$this->db->update('bookings', $data);

			if($this->db->affected_rows() > 0){
				
				$data = array(
					'car_status' => 1
				);
				$this->db->where('car_uid', $row->car_uid);
				$this->db->update('cars', $data);
				
				$data = array(
					'invoice_status' => 3
				);
				$this->db->where('related_uid', $book_uid);
				$this->db->update('invoices', $data);
				
				$result['status'] = true;
				$result['message'] = "تم إلغاء الحجز بنجاح";
				return $result;	
			}else{
				$data['result'] = [];
				$data['status'] = false;
				$data['message'] = $this->lang->line('no_data');
				return $data;	
			}
		}else{
			$data['result'] = [];
			$data['status'] = false;
			$data['message'] = "الحجز غير موجود";
			return $data;	
		}
	}
	
	function get_string_between($string, $start, $end){
		$string = ' ' . $string;
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$len = strpos($string, $end, $ini) - $ini;
		return substr($string, $ini, $len);
	}
	
}

?>