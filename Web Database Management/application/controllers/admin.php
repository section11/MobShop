<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	
	public function index(){
		if($this->auth_model->is_logged() == TRUE){
			$this->load->view('admin_panel');
		}else{
			redirect('auth');
		}
	}
	
	public function products(){
			
		$this->load->library('gc_dependent_select');
		
		$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table('products');
		$this->grocery_crud->set_subject('Produse');		
		$this->grocery_crud->set_relation('categories_id', 'categories', 'name');
		$this->grocery_crud->set_relation('subcategories_id', 'subcategories', 'name');
		$this->grocery_crud->columns('product_name','price','categories_id', 'quantity');
		$this->grocery_crud->display_as('product_name','Nume')->display_as('price', 'Pret')->display_as('quantity', 'Stoc');
		$this->grocery_crud->display_as('categories_id','Categorie')->display_as('subcategories_id', 'Subcategorie')->display_as('sale', 'Promotie');
		$this->grocery_crud->field_type('sale','dropdown',array('0' => 'nu', '1' => 'da'));	
		$this->grocery_crud->add_action('Photos', '', 'admin/photos','ui-icon-image');
		$fields = array(
			// first field:
			'categories_id' => array( 
			'table_name' => 'categories',
			'title' => 'name', 
			'relate' => null 
			),
			// second field
			'subcategories_id' => array( 
			'table_name' => 'subcategories',
			'title' => 'name', 
			'id_field' => 'subcategories_id', 
			'relate' => 'categories_id', 
			'data-placeholder' => 'Selecteaza Subcategorie' 
			)
		);
		$config = array(
				'main_table' => 'products',
				'main_table_primary' => 'products_id',
				"url" => base_url() .  'admin/' . __FUNCTION__ . '/', 
				'ajax_loader' => base_url() . 'ajax-loader.gif' // path to ajax-loader image. It's an optional parameter				
		);
		
		$categories = new gc_dependent_select($this->grocery_crud, $fields, $config);

		//http://www.grocerycrud.com/forums/topic/1087-updated-24112012-dependent-dropdown-library/
		
		$js = $categories->get_js();
		$output = $this->grocery_crud->render();
		$output->output.= $js;		

		$this->load->view('example',$output);
	}
	
	public function photos($primary_key){
		$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table('photos');
		$this->grocery_crud->set_subject('Fotografie');		
		$this->grocery_crud->where('products_id', $primary_key);
		$this->grocery_crud->field_type('products_id', 'hidden', $primary_key);
		$this->grocery_crud->display_as('products_id','Produs');				
		$this->grocery_crud->set_field_upload('url','assets/uploads/products');		
		$output =  $this->grocery_crud->render();		
		$this->load->view('example',$output);
	}
	
	public function categories(){
		$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table('categories');
		$this->grocery_crud->set_subject('Categorie');	
		$this->grocery_crud->field_type('available','dropdown',array('0' => 'nu', '1' => 'da'));				
		$this->grocery_crud->display_as('name','Nume')->display_as('available', 'Valabila');
		$this->grocery_crud->add_action('Photos', '', 'admin/photos_categories','ui-icon-image');
		$output =  $this->grocery_crud->render();		

		$this->load->view('example',$output);
	}
	
	public function photos_categories($primary_key){
		$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table('photos_categories');
		$this->grocery_crud->set_subject('Fotografie');		
		$this->grocery_crud->where('category_id', $primary_key);
		$this->grocery_crud->field_type('category_id', 'hidden', $primary_key);
		$this->grocery_crud->display_as('category_id','Category');				
		$this->grocery_crud->set_field_upload('url','assets/uploads/categories');		
		$output =  $this->grocery_crud->render();		
		$this->load->view('example',$output);
	}
		
	
	public function subcategories(){
		$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table('subcategories');
		$this->grocery_crud->set_subject('Subcategorie');		
		$this->grocery_crud->display_as('name','Nume')->display_as('available', 'Valabila')->display_as('categories_id', 'Categoria Principala');		
		$this->grocery_crud->set_relation('categories_id', 'categories', 'name');
		$this->grocery_crud->field_type('available','dropdown',array('0' => 'nu', '1' => 'da'));				
		
		$output =  $this->grocery_crud->render();		

		$this->load->view('example',$output);
	}
	
	public function users(){
		$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table('users');
		$this->grocery_crud->set_subject('Utilizator');				
		
		$output =  $this->grocery_crud->render();		

		$this->load->view('example',$output);
	}
	
	public function orders(){
	
	}
}