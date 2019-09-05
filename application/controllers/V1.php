<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class V1 extends REST_Controller {
	
	public $token;
	
    public function __construct()
    {
        parent::__construct();
		
		$this->token = $this->input->get_request_header('token');
		$this->load->library('user_agent');
		$this->load->library('form_validation');
        $this->load->model('login_api_model');
        $this->load->model('global_api_model');
		$this->lang->load('api', "arabic");
    }

    /*
     * Function to login and get access token
     * @param string username 
     * @param string password 
	 * @examp http://efadcar.com/api/v1/login
     */
    public function login_post(){
        $this->form_validation->set_rules('username', "أسم المستخدم", 'required|strip_tags');
        $this->form_validation->set_rules('password', "كلمة المرور", 'required|strip_tags');
		if ($this->form_validation->run() == FALSE) {
			$this->set_response([
				'status' => FALSE,
				'message' => strip_tags(validation_errors())
			], 401); // NOT_FOUND (404) being the HTTP response code
		}else{
			$data = $this->login_api_model->validate($this->post('username'), $this->post('password'));
			if ($data['status'] != false)
			{
				$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
			else
			{
				$this->set_response($data, 405); 
			}
		}
    }
	
    /*
     * Function to register and then login and return access token
     * @param string username 
     * @param string password 
	 * @examp http://efadcar.com/api/v1/register
     */
    public function register_post(){
        $this->form_validation->set_rules('member_fname', 'الأسم الاول', 'required');
        $this->form_validation->set_rules('member_lname', 'الأسم الاخير', 'required');
        $this->form_validation->set_rules('member_password', 'كلمة المرور', 'required|min_length[8]');
        $this->form_validation->set_rules('member_email', 'البريد الإلكترونى', 'required|is_unique[members.member_email]|valid_email');
        $this->form_validation->set_rules('country_uid', 'الدولة', 'required|min_length[1]');
        $this->form_validation->set_rules('city_uid', 'المدينة', 'required|min_length[1]');
        $this->form_validation->set_rules('member_mobile', 'رقم الجوال', 'required|numeric|min_length[10]|max_length[11]|is_unique[members.member_mobile]');
		
		if ($this->form_validation->run() == FALSE) 
		{
			$this->set_response([
				'status' => FALSE,
				'message' => strip_tags(validation_errors())
			], 401); // NOT_FOUND (404) being the HTTP response code
		}
		else
		{
			/* $facebook = $this->global_api_model->checkFacebookTokenWithNumber();
			if ($data['status'] != false)
			{
				$this->set_response([
					'status' => FALSE,
					'message' => strip_tags(validation_errors())
				], 401); // NOT_FOUND (404) being the HTTP response code
			}
			*/
			
			$data = $this->login_api_model->register();
			if ($data['status'] != false)
			{
				$loginData = $this->login_api_model->validate($this->post('member_email'), $this->post('member_password'));
				if ($loginData['status'] != false)
				{
					$this->set_response($loginData, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
				}
				else
				{
					$this->set_response($loginData, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
				}
			}
			else
			{
				$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}
    }
	
    /*
     * Function to get all countries
	 * @examp http://efadcar.com/api/v1/countries
     */
    public function countries_get(){
		$data = $this->global_api_model->getAllCountriesCodes();
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }

    /*
     * Function to get all cities by country ID
	 * @examp http://efadcar.com/api/v1/cities
     */
    public function cities_get(){
		$data = $this->global_api_model->getAllCitiesByCountryID($this->get('id'));
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }

    /*
     * Function to get all cars categories
	 * @examp http://efadcar.com/api/v1/cars_categories
     */
    public function cars_categories_get(){
		$data = $this->global_api_model->getAllCarsCategories();
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }

    /*
     * Function to get all cars categories
	 * @examp http://efadcar.com/api/v1/cars_types
     */
    public function cars_types_get(){
		$data = $this->global_api_model->getAllCarsTypes();
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }

    /*
     * Function to get all cars brands
	 * @examp http://efadcar.com/api/v1/cars_brands
     */
    public function cars_brands_get(){
		$data = $this->global_api_model->getAllCarsBrands();
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }

    /*
     * Function to get all car models by brand ID
	 * @examp http://efadcar.com/api/v1/cars_models
     */
    public function cars_models_get(){
		$data = $this->global_api_model->getAllModelsByBrandID($this->get('id'));
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }
	
    /*
     * Function to get all cars colors
	 * @examp http://efadcar.com/api/v1/cars_colors
     */
    public function cars_colors_get(){
		$data = $this->global_api_model->getAllCarsColors();
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }

    /*
     * Function to get all cars child colors by parent ID
	 * @examp http://efadcar.com/api/v1/cars_child_colors
     */
    public function cars_child_colors_get(){
		$data = $this->global_api_model->getAllCarsChildColors($this->get('id'));
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }

    /*
     * Function to get all faq categories with faqs questions on it
	 * @examp http://efadcar.com/api/v1/faq
     */
    public function faq_get(){
		$data = $this->global_api_model->getAllFaqs();
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }

    /*
     * Function to get page content by link name
	 * @examp http://efadcar.com/api/v1/page
     */
    public function page_get(){
		$data = $this->global_api_model->getPageContentByLink($this->get('link'));
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }

    /*
     * Function to get all memberships categories
	 * @examp http://efadcar.com/api/v1/memberships
     */
    public function memberships_get(){
		$data = $this->global_api_model->getAllMemberships();
		if ($data['status'] != false)
		{
			$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}
		else
		{
			$this->set_response($data, REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
		}
    }
	
    /*
     * Function to search for cars
	 * @examp http://efadcar.com/api/v1/explore
     */
    public function explore_post(){
		$this->form_validation->set_rules('order_by', 'order_by', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->set_response([
				'status' => FALSE,
				'message' => strip_tags(validation_errors())
			], 401); // NOT_FOUND (404) being the HTTP response code
		}else{
			$data = $this->global_api_model->explore();
			if ($data['status'] != false)
			{
				$this->set_response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
			else
			{
				$this->set_response($data, 405); 
			}
		}
    }
	

}
