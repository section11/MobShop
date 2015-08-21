<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class API extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        $this->load->model('api_model');
    }
	public function index(){
				
	}
	public function getallproducts(){
		$data['json'] = $this->api_model->getAllProducts();
		$this->load->view('json_view', $data);
	}
	public function getallcategories(){
		$data['json'] = $this->api_model->getAllCategories();
		$this->load->view('json_view', $data);
	}
	public function getsubcategorybyname(){
		$categoryName = $this->input->post('category');
		$data['json'] = $this->api_model->getAllSubCategoriesByName($categoryName);
		$this->load->view('json_view', $data);
	}
	public function getproductbyid(){
		$productId = $this->input->post('idProduct');		
		$data['json'] = $this->api_model->getProductById($productId);
		$this->load->view('json_view', $data);
	}
	public function getproductsbysubcategory(){
		$subcategory = $this->input->post('subCategory');		
		$data['json'] = $this->api_model->getProductsBySubCategory($subcategory);
		$this->load->view('json_view', $data);
	}
	public function getallcategorieswithsubcategoriesandphotos(){
		$data['json'] = $this->api_model->getAllCategoriesWithSubcategoriesAndPhotos();
		$this->load->view('json_view', $data);
	}
	public function registeruser(){
		$name = $this->input->post('name');
		$surname = $this->input->post('surname');
		
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		$city = $this->input->post('city');
		$district = $this->input->post('district');
		
		$address = $this->input->post('address');
		$phoneNumber = $this->input->post('phoneNumber');
		
		$data['json'] = $this->api_model->register($name, $surname, $email, $password, $city, $district, $address, $phoneNumber);
		$this->load->view('json_view', $data);
	}
	public function loginuser(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		
		$data['json'] = $this->api_model->login($email, $password);
		$this->load->view('json_view', $data);			
	}
	
	public function updateuser(){
		$name = $this->input->post('name');
		$surname = $this->input->post('surname');
		
		$email = $this->input->post('email');		
		
		$city = $this->input->post('city');
		$district = $this->input->post('district');
		
		$address = $this->input->post('address');
		$phoneNumber = $this->input->post('phoneNumber');
		
		$data['json'] = $this->api_model->update($name, $surname, $email, $city, $district, $address, $phoneNumber);
		$this->load->view('json_view', $data);
	}
}

