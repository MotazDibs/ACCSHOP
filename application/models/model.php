<?php

class model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('encryption');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->dbforge();

        defined('BASEPATH') or exit('No direct script access allowed');
        // echo $this->db->last_query();
    
        
    }
    //model supplier info page
public function get_supplier_summary() {
    $sql = "
        SELECT 
            s.supplier AS supplier_name,
            COALESCE(SUM(CAST(o.numofproduct AS UNSIGNED)), 0) AS total_products,
            COALESCE(SUM(CAST(o.pay AS DECIMAL(10,2))), 0) AS total_pay,
            COALESCE(SUM(CAST(o.cost AS DECIMAL(10,2))), 0) AS total_cost
        FROM suppliers s
        LEFT JOIN products p ON s.id = p.supplierid
        LEFT JOIN orders o ON p.id = o.product_id
        GROUP BY s.id, s.supplier
        ORDER BY total_products DESC
        LIMIT 25
    ";

    $query = $this->db->query($sql);
    return $query->result();
}

public function get_products_with_supplier() {
    $this->db->select('product.*, suppliers.supplier as supplier_name, suppliers.id as supplier_id');
    $this->db->from('products');
    $this->db->join('suppliers', 'suppliers.id = products.supplierid', 'left');
    $this->db->order_by('suppliers.supplier', 'asc');  
    $query = $this->db->get();
    return $query->result();
}
public function get_products_summary_by_supplier()
{
    $this->db->select('
        suppliers.id AS supplier_id,
        suppliers.supplier AS supplier_name,
        COUNT(DISTINCT products.id) AS product_count,
        IFNULL(SUM(DISTINCT products.cost), 0) AS total_cost,
        IFNULL(SUM(DISTINCT products.pay), 0) AS total_price
    ', FALSE); // FALSE حتى لا يهرب الدوال (COUNT, SUM)

    $this->db->from('suppliers');

    // ✅ استخدم LEFT JOIN فقط إذا كنت تريد الموردين بدون منتجات أيضًا
    $this->db->join('products', 'products.supplierid = suppliers.id', 'left');

    // ✅ GROUP BY حسب المورد فقط
    $this->db->group_by('suppliers.id');

    $this->db->order_by('suppliers.supplier', 'asc');

    $query = $this->db->get();
    return $query->result();
}

public function get_supplier_summary_by_products()
{
    $this->db->select('
        products.product AS product_name,
        COUNT(DISTINCT suppliers.id) AS supplier_count,
        IFNULL(SUM(products.cost), 0) AS total_cost,
        IFNULL(SUM(products.pay), 0) AS total_price
    ', false); // false لعدم الهروب التلقائي للدوال

    $this->db->from('products');
    $this->db->join('suppliers', 'products.supplierid = suppliers.id', 'left');

    $this->db->group_by('products.product');
    $this->db->order_by('products.product', 'asc');

    $query = $this->db->get();
    return $query->result();
}

public function get_products_grouped_by_supplier()
{
    $this->db->select('
        suppliers.id AS supplier_id,
        suppliers.supplier AS supplier_name,
        products.product AS product_name,
        IFNULL(products.cost, 0) AS cost,
        IFNULL(products.pay, 0) AS pay
    ', false);

    $this->db->from('suppliers');
    $this->db->join('products', 'products.supplierid = suppliers.id', 'left');
    $this->db->order_by('suppliers.supplier', 'asc');
    $this->db->order_by('products.product', 'asc');

    $query = $this->db->get();
    return $query->result();
}

public function get_where_multiple($table, $conditions) {
        $query = $this->db->get_where($table, $conditions);
        return $query->result(); // ترجع مصفوفة كائنات
    }



///////////////////////////////////////////////////////////////

public function get_model_where($table, $col, $val, $where) {
    $this->db->where($col, $val);
    $data = $this->db->get($table)->result();

    if (!empty($data) && isset($data[0]->$where)) {
        return $data[0]->$where;
    }
    return null;
}


   public function get_all($table)
{
    return $this->db->get($table)->result();
}
 
    // Get a single row for editing
    public function update_model($table,$col,$val){
   
         $this->db->where($col,$val);
        
        $data= $this->db->get($table)->result();
        return $data;

}
    // delete model
   public function delete_model($table, $where) {
    return $this->db->where($where)->delete($table);
}

    //update model
    public function update_model1($table, $data, $where) {
    return $this->db->where($where)->update($table, $data);
}
// get where
    public function get_where($table, $where) {
    return $this->db->where($where)->get($table)->result();
}
public function get_where1($table, $column, $value) {
    return $this->db->get_where($table, [$column => $value])->result(); // ترجع مصفوفة من الكائنات
}

public function get_where2($table, $where) {
    return $this->db->get_where($table, $where);
}


    public function add_model($table, $data) {
           return $this->db->insert($table, $data);
    }
// add model for supplier
     public function add_model1($table, $data) {
           return $this->db->insert($table, $data);
    }
    // get suplier model
    public function get_supplier_model($table) {
        return $this->db->get($table)->result();
    }

    //------------------------------LOGIN --------------------------------
    public function login_model($table, $name, $password)
{
  
    $this->db->where('name', $name);
    $this->db->where('password', $password);
    $query = $this->db->get($table);
    $data = $query->result();

    if (count($data) > 0) {
        foreach ($data as $d) {
           $session_data = [
            'id'       => $d->id,
            'name'     => $d->name,
        ]; 
        }
        
        $this->session->set_userdata($session_data);
        // return true;
    } else {
        return false;
    }
}
// creatt ad insert model file excel 
 public function createTable($tableName, $columns)
    {
        $fields = [];
        foreach ($columns as $col) {
            $col = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower(trim($col)));
            $fields[] = "$col TEXT";
        }

        $fields_sql = implode(',', $fields);
        $sql = "CREATE TABLE IF NOT EXISTS $tableName (id INT AUTO_INCREMENT PRIMARY KEY, $fields_sql)";
        return $this->db->query($sql);
    }

    public function insertRow($tableName, $data)
    {
        return $this->db->insert($tableName, $data);
    }
// a model for uploade excel file to a data base 
 public function create_sub_active_table( $u_id,$p) {
	if ($this->db->table_exists('ac_cs_' . $u_id . '_' . $p)) {

        }else{
        $this->load->dbforge();

        $fields = array(
            'id' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ),
            'site_addressincludes_street' => array(
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'dependency' => array(
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'customer_nameinclude_contract' => array(
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'index_of_supplier' => array(
                'type'       => 'float',
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci',
		    'default'    => '0',
            ),
            'condition' => array(
                'type'       => 'VARCHAR',
                'constraint' => 11,
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'customer_contract_breach' => array(
                'type'       => 'VARCHAR',
                'constraint' => 11,
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'customer_contract_amount' => array(
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => TRUE,
		    'default'    => '0',
            ),
            'amount_received_from_customer' => array(
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => TRUE,
		    'default'    => '0',
            ),
            'pensions_issued' => array(
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => TRUE,
		    'default'    => '0',
            ),
            'total_Issued_suppliers' => array(
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => TRUE,
		    'default'    => '0',
            ),
            'amount_remaining_to_be' => array(
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => TRUE,
		    'default'    => '0',
            ),
            'implementation_protocol' => array(
                'type'           => 'INT',
                'constraint'     => 11,
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'site_index_attached' => array(
                'type'       => 'TEXT',
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'expensive' => array(
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => TRUE,
		    'collation'  => 'utf8_general_ci'
            ),
            'auditor' => array(
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'balance' => array(
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => TRUE,
		     'default'    => '0',
            ),
            'follow_update' => array(
                'type'       => 'DATE',
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'bug' => array(
                'type'       => 'TEXT',
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'action' => array(
                'type'       => 'TEXT',
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'add_by' => array(
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => TRUE,
                'collation'  => 'utf8_general_ci'
            ),
            'last_update_date' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'add_date' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); // Primary key

        if ($this->dbforge->create_table('ac_cs_' . $u_id . '_' . $p, TRUE)) {
            // echo "✅ Table created successfully.";
        } else {
            // echo "❌ Failed to create table.";
        }
	}
    }
    //word model
     public function save_document($filename, $content) {
        $data = [
            'filename' => $filename,
            'content'  => $content
        ];
        return $this->db->insert('documents', $data);
    }

    public function get_all_documents() {
        return $this->db->get('documents')->result();
    }

    public function get_document($id) {
        return $this->db->get_where('documents', ['id' => $id])->row();
    }

    public function get_where_w($table_name)
    {
        if (!$this->db->table_exists($table_name)) {
            return false;
        }
        $query = $this->db->get($table_name);
        return $query->result_array();  // أو result() لو بدك كائنات
    }

    // جلب أسماء الحقول (الأعمدة) في جدول معين
    public function get_table_fields($table_name)
    {
        if (!$this->db->table_exists($table_name)) {
            return false;
        }
        return $this->db->list_fields($table_name);
    }


}