<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$test = '';
$taTerm = $_POST['year'];
$clId = $_POST['Clinfo'];
$cId = $_POST['Cinfo'];
$count = 0;
if (!isset($_COOKIE['excelTo'])) {
    $test = '请上传文件！';
    echo $test;
} else {
    # code...
    $to = $_COOKIE['excelTo'];
    // 查询特定科目
    require_once '../inc/data/connParam.php';
    require_once '../inc/data/conFunc.php';
    $conn = dbConn();

    $mysql = 'SELECT ta_id
                FROM zhengxf_task,zhengxf_course
                WHERE ta_term = ?
                AND ta_class = ?
                AND c_code = ?
                AND ta_cid = c_id';
    $mystmt = $conn->prepare($mysql);
    $mystmt->bind_param('iii', $taTerm, $clId, $cId);
    $mystmt->bind_result($taId);
    $mystmt->execute();
    $mystmt->store_result();
    # code...
    $spreadSheet = IOFactory::load("$to");
    $workSheet = $spreadSheet->getSheet(0);
    $highestRow = $workSheet->getHighestRow();
    for ($i = 2; $i < $highestRow; $i++) {
        # code...
        $Eid = floatval($workSheet->getCell("c$i")->getValue());
        $normal = floatval($workSheet->getCell("u$i")->getCalculatedValue());
        $lab = floatval($workSheet->getCell("v$i")->getCalculatedValue());
        $midterm = floatval($workSheet->getCell("w$i")->getCalculatedValue());
        $final = floatval($workSheet->getCell("x$i")->getCalculatedValue());
        $overall = floatval($workSheet->getCell("e$i")->getCalculatedValue());
        $sql = 'INSERT INTO zhengxf_score
    (sc_taskid,sc_stuid,sc_normal,sc_lab,sc_midterm,sc_final,sc_overall)
    VALUES
    (?,?,?,?,?,?,?)
    ';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiddddd', $taId, $Eid, $normal, $lab, $midterm, $final, $overall);
        $stmt->execute();
        if ($stmt->affected_rows === 1) {
            # code...
            $count++;
        }
    }
    $mystmt->close();
    $stmt->close();
    $conn->close();
    $test = "成功导入{$count}条数据！";
    echo $test;
}
