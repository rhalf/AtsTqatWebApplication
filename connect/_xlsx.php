<?php

error_reporting(E_ALL);
//ob_start();
$filename = filter_input(INPUT_POST, 'filename');
include_once("../settings.php");
include_once("../scripts.php");

if ((filter_input(INPUT_POST, 'data') === NULL) or (filter_input(INPUT_POST, 'exclude') === NULL)) {
    die;
}

$data = json_decode(filter_input(INPUT_POST, 'data'), true);
$excludes = json_decode(filter_input(INPUT_POST, 'exclude'), true);
/** PHPExcel */
require_once (ROOT_DIR . '/libraries/phpexcel/Classes/PHPExcel.php');


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator($filename)->
        setLastModifiedBy($filename)->setTitle($filename)->
        setSubject($filename)->setDescription($filename)->
        setKeywords($filename)->setCategory($filename);

$a = array(
    0 => 'A',
    1 => 'B',
    2 => 'C',
    3 => 'D',
    4 => 'E',
    5 => 'F',
    6 => 'G',
    7 => 'H',
    8 => 'I',
    9 => 'J',
    10 => 'K',
    11 => 'L',
    12 => 'M',
    13 => 'N',
    14 => 'O',
    15 => 'P',
    16 => 'Q',
    17 => 'R',
    18 => 'S',
    19 => 'T',
    20 => 'u',
    21 => 'V',
    22 => 'W',
    23 => 'X',
    24 => 'Y',
    25 => 'Z',
    26 => 'AA',
    27 => 'AB',
    28 => 'AC',
    29 => 'AD',
    30 => 'AE',
    31 => 'AF',
    32 => 'AG',
    33 => 'AH',
    34 => 'AI',
    35 => 'AJ'
);


$sharedStyle = new PHPExcel_Style();

$sharedStyle->applyFromArray(
        array('borders' => array(
                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        )
);

// set titles
$t = 0;
$c = 0;
foreach ((array) $data['cols'] as $col) {
    if (!in_array($c + 1, $excludes)) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($a[$t] . "1", $col);
        $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle, $a[$t] . "1");
        $objPHPExcel->getActiveSheet()->getStyle($a[$t] . "1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension($a[$t])->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle($a[$t] . "1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $t++;
    }
    $c++;
}




// set records 
$i = 2;
$id = 0;
if (isset($data['rows'])) {
    foreach ((array) $data['rows'] as $row) {
        $n = 0;
        $c = 0;
        foreach ($data['rows'][$id]['cell'] as $cell) {
            if (!in_array($c + 1, $excludes)) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($a[$n] . $i, "=\"".$cell."\"");
                $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle, $a[$n] . $i);
                $n++;
            }
            $c++;
        }
        $i++;
        $id++;
    }
}

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle($filename);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

ob_end_clean();
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

header("Content-Disposition: attachment; filename=\"" . $filename . '.xlsx' . "\";");

// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
$objPHPExcel->disconnectWorksheets();
unset($objPHPExcel);
?>