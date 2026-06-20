<?php

defined('BASEPATH') or exit('No direct script access allowed');


class cont extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->library('upload');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('ExcelModel');
        $this->load->model('model');
        date_default_timezone_set('Asia/Hebron');
        ob_start();

    }
    //add admin into data base
    public function addadmin()
    {

        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'password' =>md5( $this->input->post('password')),
            'address' => $this->input->post('address'),
        ];
        // if (!empty($data['name']) && !empty($data['password']) && !empty($data['address']))
        $result = $this->model->add_model('admins', $data);
        if ($result) {
           redirect('../c/admin_add');
        }
        redirect('../c/admin_add');
    }
    //-----------------------------LOGIN --------------------------------
    public function login()
    {
        $name = $this->input->post('name');
        $password = md5($this->input->post('password'));

        // Check if the name and password are not empty
        if (empty($name) || empty($password)) {
            redirect('c/login');
        }
        $query = $this->model->login_model('admins', $name, $password);
        if (isset ($_SESSION['id'])) { 

            redirect('../c/home');
        } else {
            redirect('');
        }
    }
    // add supplier into data base

    public function addsupplier()
    {
        $id = $this->input->post('id');
        $data = [
            'supplier' => $this->input->post('supplier'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
        ];
        // if (!empty($data['name']) && !empty($data['phone']) && !empty($data['address']))
        $result = $this->model->add_model1('suppliers', $data);
        if ($result) {
           redirect('../c/addsupplier');
        }
        redirect('../c/addsupplier');
    }
     // add delivery into data base

    public function add_delivery()
    {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'cost' => $this->input->post('cost'),
            'address' => $this->input->post('address'),
        ];
        // if (!empty($data['name']) && !empty($data['phone']) && !empty($data['address']))
        $result = $this->model->add_model1('delivery', $data);
        if ($result) {
           redirect('../c/delivery');
        }
        redirect('../c/delivery');
    }
///////////////////////////////////////////////////////////////
// edit order
public function editorder(){
        $id = $this->input->post('id');
         $data = [
            'product' => $this->input->post('products'),
            'client' => $this->input->post('client'),
            'numofproduct' => $this->input->post('numofproduct'),
            'pay' => $this->input->post('pay'),
            'cost' => $this->input->post('cost'),
            'total' => $this->input->post('total'),
        ];
        $this->model->update_model1('orders', $data, ['id' => $id]);

        redirect("../c/order");



    }
// add order
public function addorder()
{
    $delivery_location = $this->input->post('delivery_location'); // id موقع التوصيل أو null
    $delivery_cost = $this->input->post('delivery_cost'); // قيمة التوصيل (قد تكون 0)

    $data = [
        'product' => $this->input->post('products'),
        'client' => $this->input->post('client'),
        'numofproduct' => $this->input->post('numofproduct'),
        'pay' => $this->input->post('pay'),
        'cost' => $this->input->post('cost'),
        'epay' => $this->input->post('apay'),
        'total' => $this->input->post('total'),
        'actualprofit' => $this->input->post('actualprofit'),
        'delivery_location' => $delivery_location ? $delivery_location : null,
        'delivery_cost' => $delivery_cost ? $delivery_cost : 0,
    ];

    $result = $this->model->add_model1('orders', $data);

    if ($result) {
        redirect('../c/order');
    } else {
        redirect('../c/addorder');
    }
}



////////////////////////////////////////////////////////////////

    // add products into data base
    public function addproducts()
{   

    try {
            

            date_default_timezone_set('Asia/Hebron');
            $this->load->helper('url');
            $this->load->helper('form');
            $this->load->helper('file');
            $config['upload_path']   = './assest/uploads/';
            $config['allowed_types'] = '*';
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            $p1   = 0;
            $p2   = 0;
            $adp1 = 0;
            $adp2 = 0;
            if ($this->upload->do_upload('image')) {
                $up_file_name = $this->upload->data();
                $pic1         = $up_file_name['file_name'];
                $p1           = 1;
            } else {
                $pic1 = 'user.jpeg';
            }

            $id = '';
            if (! $this->input->post('id')) {
                $id = '0';
            } else {
                $id = $this->input->post('id');
            }
            $data = [
            'product'  => $this->input->post('products'),
            'pay'  => $this->input->post( 'pay'),
            'cost'  => $this->input->post( 'cost'),
             'num'  => $this->input->post( 'num'),
            'supplierid'  => $this->input->post( 'suppliers')

        ];

            if ($p1 == 1) {
                $data += ['file' => $pic1];
            }
            $data=$this->model->add_model('products',$data);
            if ($data) {
                if ($this->input->post('adname') != '') {
                    if ($id == 0) {
                        $clint = $this->model->get_last_id('clint');
                    } else {
                        $clint = $id;
                    }
                }
            }
            redirect("../c/products");
                   
         } catch (Exception $e) {
            var_dump($e->getMessage());
            echo $e->getMessage();
        }
    }
    // edit admin
    public function updateadmin() {
        $id = $this->input->post('id');
        $password = $this->input->post('password');

        $data = [
            'name'    => $this->input->post('name'),
            'address' => $this->input->post('address')
        ];

        if (!empty($password)) {
            $data['password'] = md5($password);
        }

        $this->load->model('model');
        $this->model->update_model1('admins', $data, ['id' => $id]);

        redirect('../c/admin_view');
    }

    //edit supplier
    public function editsupplier(){
        $id = $this->input->post('id');
        $data = [
            'supplier'     => $this->input->post('supplier'),
            'phone'         => $this->input->post('phone'),
            'address'        => $this->input->post('address'),
        ];
        $this->model->update_model1('suppliers', $data, ['id' => $id]);

        redirect("../c/supplier");



    }
    // edit add products
    public function editaddproducts(){
    try {
        date_default_timezone_set('Asia/Hebron');
        $this->load->helper(['url', 'form', 'file']);
        $this->load->library('upload');

        $config['upload_path']   = './assets/uploads/';
        $config['allowed_types'] = '*';
        $this->upload->initialize($config);

        $id = $this->input->post('id');
        $old_image = $this->input->post('old_image');
        $image_name = $old_image ?? 'user.jpeg';

        // ✅ هل المستخدم رفع صورة جديدة؟
        $b=0;
        if (!empty($_FILES['image']['name'])) {
           
            if ($this->upload->do_upload('image')) {
                $uploaded_data = $this->upload->data();
                $image_name = $uploaded_data['file_name'];
                $b=1;

                // ✅ حذف الصورة القديمة إن لم تكن user.jpeg
                $old_path = './assets/uploads/' . $old_image;
                if ($old_image !== 'user.jpeg' && file_exists($old_path)) {
                    unlink($old_path);
                }
            }
        }

        // ✅ جهّز البيانات للتحديث
        $data = [
            'product'     => $this->input->post('products'),
            'pay'         => $this->input->post('pay'),
            'cost'        => $this->input->post('cost'),
            'num'         => $this->input->post('num'),
            'supplierid'  => $this->input->post('suppliers'),
            // 'file'        => $image_name
        ];
        if($b==1){
            $data += ['file'        => $image_name];
        }
        $this->model->update_model1('products', $data, ['id' => $id]);

        redirect("../c/products");

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
//edit function for admin table
public function edit($table, $id) {
    // Example: load edit view with record data
    $data['row'] = $this->model->get_where2($table, ['id' => $id])->row();
    $this->load->view('html/editadmins', $data);
}
// delete control code to sue in any page
public function delete($table) {
    $id = $this->input->post('id');
    
    if (!$id || !$table) {
        echo json_encode(['success' => false, 'message' => 'Missing table or ID']);
        return;
    }

    $result = $this->model->delete_model($table, ['id' => $id]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Deletion failed']);
    }
}

//delete products

    public function deleteproducts()
{
    $id = $this->input->post('id'); // استلام ID من الفورم

    if (!$id) {
        show_error('Invalid product ID.');
        return;
    }

    $product = $this->db->get_where('products', ['id' => $id])->row();

    if ($product) {
        $image = $product->file;

        // حذف الصورة من السيرفر إن لم تكن الافتراضية
        if (!empty($image) && $image != 'user.jpeg') {
            $image_path = './assets/uploads/' . $image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // حذف الصف من قاعدة البيانات
       $this->model->delete_model('products', ['id' => $id]);


        // إعادة التوجيه
        redirect('../c/products');
    } else {
        show_error('Product not found.');
    }
}

    



    
    //-----------------------------------------------------------------------
    //-----------------------------LOGOUT --------------------------------
    //logout function to destroy session and redirect to login page
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('c/login');
    }

}