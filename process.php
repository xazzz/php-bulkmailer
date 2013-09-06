<?php

//echo "hello world";

$guid = isset($_GET['guid']) ? $_GET['guid'] : null;

if (empty($guid)) {
    echo "Sorry, something wrong with your file upload and db operation";
    exit;
}

require_once 'class.model.php';

$file = new Files();
$result = $file->get($guid);
$result = $result[0];
//print_r ($result['file_name']);

if (!empty($result)) {
    $extension = strtolower(pathinfo($result['file_name'], PATHINFO_EXTENSION));
    //print_r ($extension);
}

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
//require_once dirname (__FILE__) . "/class/phpexcel/PHPExcel.php";
require_once "class/phpexcel/PHPExcel/IOFactory.php";

$inputFileName = dirname(__FILE__) . "/uploads/" . $result['file_name'];


$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$excel = $objReader->load($inputFileName);

$sheet = $excel->getSheet(0);
$highestRow = $sheet->getHighestRow();
//$highestColumn = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
$highestCol = $sheet->getHighestColumn();
$highestColIndex = PHPExcel_Cell::columnIndexFromString($highestCol);

//  Loop through each row of the worksheet in turn
$values = array ();
$record = array ();

$header = array (
    'request_email',
    'request_company',
    'request_contact_person',
    'request_location',
    'request_product1',
    'request_product2',
    'request_product3',
    'request_product4',
);


for ($row = 2; $row <= $highestRow; $row++) {
    //  Read a row of data into an array
    $record['request_row'] = $row;
    for ($col = 0; $col < $highestColIndex; ++$col) {
        $cell = $sheet->getCellByColumnAndRow($col, $row);
        $val = $cell->getValue();
        //$val = trim ($val);
        
        if ($col > 3) {
            $val = floatval($val);
        }
        $record [$header[$col]] = $val;
        //$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
        //echo '' . $val . '<br>(Typ ' . $dataType . ')';
    }
    
    $values[$row - 2] = $record;
}

require_once dirname (__FILE__) . "/class.model.php";
$request = new Requests();

$request->bulk_save($values, $guid);

echo ('{"error": "no", "message": "success"}');
exit;

?>
