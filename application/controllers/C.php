<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	// home page
     public function home()
	{
		$this->load->view('html/home');
	}
	// add admin page
	public function admin_add()
{
    $this->load->view('html/admin_add', isset($data) ? $data : []);
}
    // view products page
	// add products page
	public function addproducts()
	{
		$this ->load->model('model');
		$suppliers= $this->model->get_supplier_model('suppliers');
		$this->load->view('html/addproducts', ['suppliers' => $suppliers]);
	}
	// view products page
	public function products()
	{


		$this->load->model('model');
		 $data['products'] = $this->model->get_supplier_model('products');
		 $supdata['supplier'] =$this->model->get_supplier_model('suppliers');
   		 $this->load->view('html/products', $data,$supdata);
		
	}
	// edit suppliers
	public function editsuppliers() {
		$this->load->model('model');
		$data['suppliers']  = $this->model->update_model('suppliers','id',$_GET['id']);

		$this->load->view('html/editsuppliers', $data); 
	}
	// edit products
	public function editaddproducts() {
		$this->load->model('model');
		
		$data['suppliers'] = $this->model->get_supplier_model('suppliers');
		$data['products']  = $this->model->update_model('products','id',$_GET['id']);

		$this->load->view('html/editaddproducts', $data);
	}


    //view admin page
    public function admin_view()
	{
		$this->load->model('model');
		$admins= $this->model->get_supplier_model('admins');
		$this->load->view('html/admin_view', ['admins' => $admins]);
	}
	// view supplier page
	public function supplier() {
		// Get data from the model
		$this->load->model('model');
		$suppliers= $this->model->get_supplier_model('suppliers');

		// Load the view and pass the data
		$this->load->view('html/supplier', ['suppliers' => $suppliers]);
	}
	// view delivery  page
	public function delivery() {
		// Get data from the model
		$this->load->model('model');
		$delivery= $this->model->get_supplier_model('delivery');

		// Load the view and pass the data
		$this->load->view('html/delivery', ['delivery' => $delivery]);
	}
// add order 
public function addorder(){
	$this ->load->model('model');
	$products= $this->model->get_supplier_model('products');
	// جلب بيانات عناوين التوصيل من جدول delivery
    $address = $this->model->get_supplier_model('delivery');
	$data = [
        'products' => $products,
        'address' => $address
    ];
	$this->load->view('html/addorder',$data);
}
//view order page
public function order() {
    $this->load->model('model');
    $orders = $this->model->get_supplier_model('orders');
    $this->load->view('html/order', ['orders' => $orders]);
}
public function products_info()
{
    $this->load->model('model');

    $raw_data = $this->model->get_products_grouped_by_supplier();

    $grouped_data = [];
    foreach ($raw_data as $row) {
        $supplier_id = $row->supplier_id;

        if (!isset($grouped_data[$supplier_id])) {
            $grouped_data[$supplier_id] = [
                'supplier_name' => $row->supplier_name,
                'products' => [],
            ];
        }

        if (!empty($row->product_name)) {
            $grouped_data[$supplier_id]['products'][] = [
                'product_name' => $row->product_name,
                'cost' => $row->cost,
                'pay' => $row->pay,
            ];
        }
    }

    $data['grouped_suppliers'] = $grouped_data;

    $this->load->view('html/products_info', $data);
}

public function supplier_info() {
    $this->load->model('model');

    // استدعاء البيانات المجملة من قاعدة البيانات
    $suppliers_summary = $this->model->get_products_summary_by_supplier();

    $data['suppliers_summary'] = $suppliers_summary;

    $this->load->view('html/supplier_info', $data);
}


public function sup_pro()
{
    $this->load->model('model');
	$sup_id=$_GET['id'];
    $supplier_name = $this->model->get_where1('suppliers', 'id', $sup_id, 'supplier');
    $products = $this->model->get_where_multiple('products', ['supplierid' => $sup_id]);

    $data = [
        'supplier_name' => $supplier_name,
        'products' => $products
    ];

    $this->load->view('html/sup_pro', $data);
}



	//edit order page
	public function editorder() {
		$this->load->model('model');
		$data['products'] = $this->model->get_supplier_model('products');
		$data['orders']  = $this->model->update_model('orders','id',$_GET['id']);

		$this->load->view('html/editorder', $data); 
	}
// add supplier page
public function addsupplier()
{
	
	$this->load->view('html/addsupplier');
}
// add delivery page
public function add_delivery()
{
	
	$this->load->view('html/add_delivery');
}
 
public function editadmin() {
		$this->load->model('model');

		$data['admins']  = $this->model->update_model('admins','id',$_GET['id']);
		
		$this->load->view('html/editadmins', $data); 
	}

// view the add file page 

public function addfile(){
	$this->load->view('html/addfile');
}
//add word file 
public function addword(){
	$this->load->view('html/addword');
}
//view word file 
public function list_file(){
	$this->load->model('model');
	$data['tables'] = $this->model->get_supplier_model('files_metadata');
	$this->load->view('html/list_file', $data);
}



// عرض القائمة للملفات
public function list_tables()
{
    $this->load->model('model');
    $data['tables'] = $this->model->get_model('uploaded_tables');
    $this->load->view('html/list_tables', $data);
}
    // عرض بيانات جدول معين
    public function show_table($table_name) {
$this->load->model('model');
     
        $data['rows'] = $this->model->get_where_w($table_name);
        $data['fields'] = $this->model->get_table_fields($table_name);
        $data['table_name'] = $table_name;

        $this->load->view('html/show_table', $data);
    }


}