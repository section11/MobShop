<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class api_model extends CI_Model {

	
	protected $products_table = 'products';
	protected $category_table = 'categories';	
	protected $subcategory_table = 'subcategories';	
	protected $photos_table = 'photos';
	protected $categoryPhotos_table = 'photos_categories';
	protected $user_table = 'users';
	
	
	public function getAllProducts(){
		$query = $this->db->get($this->products_table);
		$products = array();
		foreach($query->result() as $row){
			$produs = array(
				'id' => $row->products_id,
				'name' => $row->product_name,
				'description' => $row->description,
				'price' => $row->price,
				'quantity' => $row->quantity,
				'categories_id' => $row->categories_id,
				'subcategories_id' => $row->subcategories_id,
				'sale' => $row->sale,
				'discount' => $row->discount,
			);
			$products[] = $produs;
		}		
		return $products;
	}
	
	public function getAllCategories(){		
		$this->db->where('available', 1); 
		$query = $this->db->get($this->category_table);
		$categories = array();
		foreach($query->result() as $row){
			$category = array(
				'id' => $row->categories_id,
				'name' => $row->name				
			);
			$categories[] = $category;
		}		
		return $categories;
	}
	
	public function getAllSubCategoriesByName($categoryName){
		$this->db->where('name', $categoryName);
		$query = $this->db->get($this->category_table);
		$categoryId = $query->row()->categories_id;
		$this->db->where('categories_id', $categoryId);
		$this->db->where('available', 1);
		$query = $this->db->get($this->subcategory_table);
		$subcategories = array();
		foreach($query->result() as $row){
			$subcategory = array(
				'id' => $row->subcategories_id,
				'name' => $row->name,						
			);
			$subcategories[] = $subcategory;
		}	
		return $subcategories;
	}
	
	public function getProductById($productId){
		$this->db->where('products_id', $productId);
		$query = $this->db->get($this->products_table);
		$produs = $query->row();		
		$product = array(
			'id' => $productId,
			'name' =>$produs->product_name,
			'description' =>$produs->description,
			'price' =>$produs->price,
			'quantity' =>$produs->quantity,
			'categories_id' => $produs->categories_id,
			'subcategories_id' =>$produs->subcategories_id,
			'subcategory_name' => $this->getSubCategoryNameById($produs->subcategories_id),
			'category_name' => $this->getCategoryNameById($produs->categories_id),
			'sale' =>$produs->sale,
			'discount' =>$produs->discount,
			'photos_urls' => $this->getPhotosProductById($productId)
		);
		return $product;
	}
	
	public function getCategoryNameById($categoryId){
		$this->db->where('categories_id', $categoryId);
		$query = $this->db->get($this->category_table);
		$category = $query->row();
		return $category->name;
	}
	
	public function getSubCategoryNameById($subCategoryId){
		$this->db->where('subcategories_id', $subCategoryId);
		$query = $this->db->get($this->subcategory_table);
		$subCategory = $query->row();
		return $subCategory->name;
	}
	
	public function getPhotosProductById($productId){
		$this->db->where('products_id', $productId);
		$query = $this->db->get($this->photos_table);
		$photos = array();
		foreach($query->result() as $row){
			$photos[] = array('URL' => $row->url);
		}
		return $photos;
	}
	
	public function getProductsBySubCategory($subcategory){
		$this->db->where('subcategories_id', $subcategory);
		$query = $this->db->get($this->products_table);
		$products = array();
		foreach($query->result() as $produs){
			$product = array(
				'id' => $produs->products_id,
				'name' =>$produs->product_name,
				'description' =>$produs->description,
				'price' =>$produs->price,
				'quantity' =>$produs->quantity,
				'categories_id' =>$produs->categories_id,
				'subcategories_id' =>$produs->subcategories_id,
				'sale' =>$produs->sale,
				'discount' =>$produs->discount,
				'photo_url' => $this->getOnePhotoProductById($produs->products_id)
			);
			$products[] = $product;
		}
		return $products;
	}
	public function getOnePhotoProductById($productId){
		$this->db->where('products_id', $productId);
		$this->db->limit(1);
		$query = $this->db->get($this->photos_table);
		$photos = array();
		foreach($query->result() as $row){
			return $row->url;
		}		
	}
	
	public function getAllCategoriesWithSubcategoriesAndPhotos(){
		$this->db->where('available', 1);
		$query = $this->db->get($this->category_table);
		$categories = array();
		foreach($query->result() as $category){
				$cat = array(
					'id' => $category->categories_id,					
					'name' => $category->name,
					'photo_url' => $this->getPhotosOfCategory($category->categories_id) ,
					'subcategories' => $this->getSubCategoriesByCategoryId($category->categories_id)
				);
				$categories[] = $cat;
		}
		return $categories;
	}
	
	public function getPhotosOfCategory($id){
		$this->db->where('category_id', $id);
		$query = $this->db->get($this->categoryPhotos_table);		
		$photo = 'null';
		foreach($query->result() as $row){
			$photo = $row->url;	
			break;
		}
		return $photo;
	}
	
	public function getSubCategoriesByCategoryId($categoryId){
		$this->db->where('categories_id', $categoryId);
		$this->db->where('available', 1);
		$query = $this->db->get($this->subcategory_table);
		$subcategories = array();
		foreach($query->result() as $row){
			$subcategory = array(
				'id' => $row->subcategories_id,
				'name' => $row->name,						
			);
			$subcategories[] = $subcategory;
		}	
		return $subcategories;
	}
	
	public function register($name, $surname, $email, $password, $city, $district, $address, $phoneNumber ){
		$this->db->where('email', $email);
		$query = $this->db->get($this->user_table);
		if($query->num_rows() != 0){
			return array('result' => 0);
		}else{
			$data = array(
				'name' => $name,
				'surname' => $surname,
				'email' => $email,
				'password' => $password,
				'city' => $city,
				'district' => $district,
				'address' => $address,
				'phone' => $phoneNumber,
			);
			$this->db->insert($this->user_table, $data);
			return array('result' => 1);
		}
		return array('result' => 1);
	}	
	
	public function update($name, $surname, $email, $city, $district, $address, $phoneNumber){
		$this->db->where('email', $email);
		$data = array(
				'name' => $name,
				'surname' => $surname,
				'email' => $email,				
				'city' => $city,
				'district' => $district,
				'address' => $address,
				'phone' => $phoneNumber,
			);
		$this->db->update($this->user_table, $data); 
				
		return array('result' => 1);
	}
	
	public function login($email, $password){
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		
		$query = $this->db->get($this->user_table);
		
		if($query->num_rows() == 0){
			return array('result' => 0);
		}else{
			$row = $query->row();
			return array(
				'result' => 1,
				'name' => $row->name,
				'surname' => $row->surname,
				'email' => $row->email,
				'password' => $row->password,
				'city' => $row->city,
				'district' => $row->district,
				'address' => $row->address,
				'phone' => $row->phone,
				);
		}
	}
}