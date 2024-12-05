<?php
require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$file = $_FILES['file'];
if ($file['error'] === UPLOAD_ERR_OK) {
    $allowExt = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
    $fileMime = mime_content_type($file['tmp_name']);
    if (!in_array($fileMime, $allowExt)) {
        # 非法文件
        echo "格式错误!";
        exit;
    }
    if (is_uploaded_file($file['tmp_name'])) {
        # 设置保存路径及文件名
        $uploadDir = '../inc/excel' . '/';

        if (!file_exists($uploadDir)) {
            #创建文件夹
            mkdir($uploadDir, 0777, true);
        }

        $fileName = $file['name'];
        $to = $uploadDir . $fileName;
        if (move_uploaded_file($file['tmp_name'], $to)) {
            # 移动成功
            setcookie('excelTo', $to, time() + 2 * 60, '/');
            // echo "文件保存成功!";
            $msg = '
                    <tr>
                    <td colspan="4">
                    <p>学生列表</p>
                    </td>
                    <td colspan="5">
                    <input type="button" id="btn5" name="btn5" value="修改提交" style="width: 80px;">
                    </td>
                    </tr>
                    <tr>
                    <td>序号</td>
                    <td>班级名称</td>
                    <td>学号</td>
                    <td>姓名</td>
                    <td>平时成绩</td>
                    <td>期中成绩</td>
                    <td>实验成绩</td>
                    <td>期末成绩</td>
                    <td>总评成绩</td>
                    </tr>';
            $spreadSheet = IOFactory::load("$to");
            $workSheet = $spreadSheet->getSheet(0);
            $highestRow = $workSheet->getHighestRow();
            for ($i = 2; $i < $highestRow; $i++) {
                $a = $i - 1;
                $Eclass = $workSheet->getCell("b$i")->getValue();
                $Eid = $workSheet->getCell("c$i")->getValue();
                $Ename = $workSheet->getCell("d$i")->getValue();
                $Escore = $workSheet->getCell("e$i")->getCalculatedValue();
                $msg .= <<<end
                        <tr>
                        <td>{$a}</td>
                        <td>{$Eclass}</td>
                        <td id="stuId" value='{$Eid}'>{$Eid}</td>
                        <td>{$Ename}</td>
                        <td><input type="text" id="normal"></td>
                        <td><input type="text" id="midterm"></td>
                        <td><input type="text" id="lab"></td>
                        <td><input type="text" id="final"></td>
                        <td><input type="text" id="overall" value='{$Escore}'></td>
                        </tr>
                        end;
            }
            $msg .= <<<end
            <tr>
            <td colspan="9">
            <input type="button" id="btn5" name="btn5" value="修改提交" style="width: 80px;">
            </td>
            </tr>
            end;
            echo $msg;
        } else {
            # 移动失败
            echo "文件载入失败!";
        }
    }
} else {
    $null = '';
    setcookie('excelTo', $null, time() + 2 * 60, '/');
    echo "载入出错!";
}
