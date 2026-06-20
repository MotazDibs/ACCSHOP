<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_reader extends CI_Controller {

    public function __construct() {
        parent::__construct();
        require_once APPPATH . 'third_party/vendor/autoload.php';
        $this->load->database();
        $this->load->model('ExcelModel');
    }

    private function cleanName($name) {
        $name = strtolower(trim($name));
        $name = preg_replace('/[^a-z0-9_]/', '_', $name);
        $name = substr($name, 0, 50);
        return $name;
    }

public function upload() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['excel_file']['tmp_name']) && $_FILES['excel_file']['tmp_name'] != '') {
            $file = $_FILES['excel_file']['tmp_name'];
            $originalName = $_FILES['excel_file']['name'];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);

            if (!in_array($extension, ['xlsx', 'xls'])) {
                $this->session->set_flashdata('msg', 'صيغة الملف غير مدعومة. الرجاء رفع ملف Excel فقط');
                redirect('../c/addfile');
                return;
            }

            $originalTableName = pathinfo($originalName, PATHINFO_FILENAME); // الاسم العربي أو الأصلي

            $this->load->model('ExcelModel');
            $tableName = $this->ExcelModel->generate_table_name(); // excel_table_1, 2, ...

            try {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
                $sheet = $spreadsheet->getActiveSheet();
                $rows = $sheet->toArray();

                if (count($rows) < 1) {
                    $this->session->set_flashdata('msg', 'الملف فارغ');
                    redirect('../c/addfile');
                    return;
                }

                $headerColumns = $rows[0];
                $columnCount = count($headerColumns);

                if (!$this->ExcelModel->create_table($tableName, $originalTableName, $headerColumns)) {
                    $this->session->set_flashdata('msg', 'فشل في إنشاء الجدول');
                    redirect('../c/addfile');
                    return;
                }

                for ($i = 1; $i < count($rows); $i++) {
                    $data = [];
                    for ($j = 0; $j < $columnCount; $j++) {
                        $colName = 'c' . ($j + 1);
                        $data[$colName] = isset($rows[$i][$j]) ? $rows[$i][$j] : null;
                    }
                    $this->ExcelModel->insert_row($tableName, $data);
                   

                }
 $this->ExcelModel->log_uploaded_table($originalTableName, $tableName, $columnCount);
                $this->session->set_flashdata('msg', 'تم رفع الملف وإنشاء الجدول بنجاح باسم: ' . $tableName);
                redirect('../c/addfile');
                return;

            } catch (Exception $e) {
                $this->session->set_flashdata('msg', 'خطأ أثناء قراءة الملف: ' . $e->getMessage());
                redirect('../c/addfile');
                return;
            }

        } else {
            $this->session->set_flashdata('msg', 'يرجى اختيار ملف للرفع');
            redirect('../c/addfile');
            return;
        }
    } else {
        redirect('../c/addfile');
    }
}


}