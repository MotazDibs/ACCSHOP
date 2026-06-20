<?php
if (!class_exists('PhpOffice\PhpWord\PhpWord')) {
    require_once(APPPATH.'third_party/PHPWord/src/PhpWord/Autoloader.php');
    \PhpOffice\PhpWord\Autoloader::register();
}
