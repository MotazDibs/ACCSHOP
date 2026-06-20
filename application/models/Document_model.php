<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_model extends CI_Model {
    protected $table = 'files_metadata';

    public function create_file_table($table_name) {
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            content_html LONGTEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        return $this->db->query($sql);
    }

    public function insert_file_content($table_name, $content_html) {
        return $this->db->insert($table_name, [
            'content_html' => $content_html,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    // صحح ترتيب الوسيطات: filename أولاً ثم table_name
    public function insert_file_metadata($filename, $table_name) {
        return $this->db->insert('files_metadata', [
            'filename' => $filename,
            'table_name' => $table_name,
            'uploaded_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function get_last_table_index() {
        $this->db->select('table_name');
        $this->db->from('files_metadata');
        $query = $this->db->order_by('id', 'desc')->limit(1)->get();

        if ($query->num_rows() > 0) {
            $last_table = $query->row()->table_name;
            if (preg_match('/word_(\d+)/', $last_table, $matches)) {
                return (int)$matches[1];
            }
        }
        return 0;
    }

    public function table_exists($table_name) {
        return $this->db->table_exists($table_name);
    }

    // جلب آخر محتوى محفوظ (صف واحد)
  public function get_file_content($table_name) {
    $query = $this->db->limit(1)->get($table_name);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        $row->filename = $table_name;
        return $row;
    }
    return null;
}




    public function get_all_files() {
        return $this->db->order_by('uploaded_at', 'desc')->get('files_metadata')->result();
    }

    public function get_file_by_filename($filename) {
        return $this->db->where('filename', $filename)->get($this->table)->row();
    }

    // دالة لتحديث المحتوى في الجدول الديناميكي الصحيح
    public function update_file_content_in_dynamic_table($filename, $new_content) {
    // جلب بيانات الملف من metadata
    $file_meta = $this->get_file_by_filename($filename);
    if (!$file_meta || !isset($file_meta->table_name)) {
        log_message('error', 'File metadata not found or table_name missing for filename: ' . $filename);
        return false;
    }

    $table_name = $file_meta->table_name;

    if (!$this->table_exists($table_name)) {
        log_message('error', 'Table does not exist: ' . $table_name);
        return false;
    }

    // جلب آخر صف
    $last_row = $this->db->order_by('created_at', 'desc')->limit(1)->get($table_name)->row();
    if (!$last_row || !isset($last_row->id)) {
        log_message('error', 'No rows found in table: ' . $table_name);
        return false;
    }

    // تحديث المحتوى
    $this->db->where('id', $last_row->id);
    $this->db->set('content_html', $new_content);
 

    $updated = $this->db->update($table_name);

    if (!$updated) {
        log_message('error', 'Failed to update row in table: ' . $table_name);
    }

    return $updated;
}
public function get_file_path($table_name) {
    $file_path = $this->db->get($table_name);
    return $file_path;
}


}