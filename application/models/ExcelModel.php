<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExcelModel extends CI_Model
{
    // ✅ توليد اسم جدول متزايد مثل excel_table_1, excel_table_2...
    public function generate_table_name()
    {
        $base = 'excel_table_';
        $i = 1;

        while ($this->db->table_exists($base . $i)) {
            $i++;
        }

        return $base . $i;
    }

    // ✅ إنشاء الجدول بأسماء أعمدة ثابتة c1, c2,... مع تعليق لكل عمود واسم الجدول الأصلي كـ COMMENT
    public function create_table($safe_table_name, $original_table_comment, $columns)
    {
        $fields = [];

        foreach ($columns as $index => $original_col) {
            $colName = 'c' . ($index + 1); // c1, c2, c3...
            $comment = addslashes($original_col); // حتى لو بالعربي
            $fields[] = "`$colName` TEXT COMMENT '$comment'";
        }

        $sql = "CREATE TABLE `$safe_table_name` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            " . implode(',', $fields) . "
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='" . addslashes($original_table_comment) . "'";

        return $this->db->query($sql);
    }

    // ✅ إدخال صف إلى الجدول
    public function insert_row($table_name, $values)
    {
        if (isset($values['id'])) {
            unset($values['id']);
        }
        $this->db->insert($table_name, $values);
    }

    // (اختياري) ✅ جلب قائمة بجميع الجداول التي تبدأ بـ excel_table_ مع تعليقها
    public function list_excel_tables_with_comments()
    {
        $query = $this->db->query("SELECT table_name, table_comment 
            FROM information_schema.tables 
            WHERE table_schema = DATABASE() 
            AND table_name LIKE 'td_%'");

        return $query->result();
    }
    public function log_uploaded_table($original, $stored, $columns_count)
{
    $this->db->insert('uploaded_tables', [
        'original_name' => $original,
        'stored_name'   => $stored,
        'columns_count' => $columns_count,
    ]);
}

}