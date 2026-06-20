<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documents extends CI_Controller {
    protected $table = 'files_metadata';

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'form']);
        $this->load->library('upload');
        $this->load->model('Document_model');

        require_once APPPATH . 'third_party/PHPWord-master/src/PhpWord/Autoloader.php';
        \PhpOffice\PhpWord\Autoloader::register();
    }

    public function index() {
        $this->load->view('html/upload_form');
    }
     public function upload() {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'doc|docx';
        $config['max_size']      = 10240; 
        $config['encrypt_name']  = TRUE;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('word_file')) {
            $data['error'] = $this->upload->display_errors();
            $this->load->view('html/upload_form', $data);
            return;
        }

        $upload_data   = $this->upload->data();
        $filepath      = $upload_data['full_path'];
        $original_name = $upload_data['client_name'];

        $html_content = $this->read_docx_as_html($filepath);

        $table_name = $this->generate_table_name();

        $this->Document_model->create_file_table($table_name);
        $this->Document_model->insert_file_content($table_name, $html_content);
        $this->Document_model->insert_file_metadata($original_name, $table_name);

        $data['success'] = "✅ تم رفع الملف وتخزينه بنجاح.";
        $data['view_link'] = site_url("documents/view_file/$table_name");

        $this->load->view('html/addword', $data);
    }

    private function read_docx_as_html($filepath) {
        try {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($filepath);

            // يمكن إضافة معالجة اتجاه النص هنا إذا لزم الأمر

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
            ob_start();
            $objWriter->save('php://output');
            return ob_get_clean();
        } catch (Exception $e) {
            return '⚠ خطأ في قراءة ملف Word: ' . $e->getMessage();
        }
    }

    private function generate_table_name() {
        $last = $this->Document_model->get_last_table_index();
        $index = $last + 1;
        return 'word_' . $index;
    }

    public function view_file($table_name) {
        if (!$this->Document_model->table_exists($table_name)) {
            show_404();
        }

        $content = $this->Document_model->get_file_content($table_name);

        if (!is_object($content) || !isset($content->content_html)) {
            show_error("لا يوجد محتوى لعرضه لهذا الملف.");
        }

        $data['content'] = $content;
        $this->load->view('html/view_file', $data);
    }

    public function edit_file($table_name = null) {
        if (!$this->Document_model->table_exists($table_name)) {
            show_404();
        }

        $content = $this->Document_model->get_file_content($table_name);

        if (!is_object($content) || !isset($content->content_html)) {
            show_error("لا يوجد محتوى لعرضه لهذا الملف.");
        }

        $file_meta = $this->db->where('table_name', $table_name)->get('files_metadata')->row();
        if (!$file_meta) {
            show_error("لم يتم العثور على بيانات الملف.");
        }

        $data['filename'] = $file_meta->filename;
        $data['content'] = $content;

        $this->load->view('html/edit_file', $data);
    }

    public function update_file() {
        $filename = $this->input->post('filename');
        $new_content = $this->input->post('content_html');

        if (!$filename || $new_content === null) {
            $this->session->set_flashdata('error', 'بيانات غير كاملة');
            redirect('../documents/edit_file/' . urlencode($filename));
            return;
        }

        $updated = $this->Document_model->update_file_content_in_dynamic_table($filename, $new_content);

        if ($updated) {
            $this->session->set_flashdata('success', 'تم تحديث الملف بنجاح');
        } else {
            $this->session->set_flashdata('error', 'حدث خطأ أثناء تحديث الملف');
        }

        redirect('../c/list_file');
    }

    public function delete_file($table_name) {
        if (!$this->Document_model->table_exists($table_name)) {
            show_404();
        }

        $deleted = $this->Document_model->delete_file($table_name);

        if ($deleted) {
            $this->session->set_flashdata('success', 'تم حذف الملف بنجاح');
        } else {
            $this->session->set_flashdata('error', 'حدث خطأ أثناء حذف الملف');
        }

        redirect('../c/list_file');
    }

    // عرض جميع الملفات
    public function view_all_files() {
        $data['tables'] = $this->Document_model->get_all_files();
        $this->load->view('html/list_file', $data);
    }

    // تحميل ملف معين
    public function download_file($table_name) {
        if (!$this->Document_model->table_exists($table_name)) {
            show_404();
        }

        $file_meta = $this->Document_model->get_file_by_filename($table_name);
        if (!$file_meta) {
            show_error("لم يتم العثور على بيانات الملف.");
        }

        $file_path = './uploads/' . $file_meta->filename;

        if (!file_exists($file_path)) {
            show_error("الملف غير موجود.");
        }

        $this->load->helper('download');
        force_download($file_path, NULL);
    }
}
