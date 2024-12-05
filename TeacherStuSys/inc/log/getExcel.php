<?php
$addCl = $_POST['clopt'];
if (!isset($addCl) || empty($addCl)) {
    die(<<<end
            <script>
                alert('请选择班级！');
                location = '../../school/addstu.php'
            </script>
        end);
}
$file = $_FILES['stuE'];
if (!isset($file) || $file['error'] > 0) {
    # 上传失败返回表单
    die(<<<end
            <script>
                alert('文件上传失败！');
                location = '../../school/addstu.php'
            </script>
        end);
}
$allowExt = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
$fileMime = mime_content_type($file['tmp_name']);
if (!in_array($fileMime, $allowExt)) {
    # 非法文件
    die(<<<end
            <script>
                alert('文件格式不符，请稍后重试！');
                location = '../../school/addstu.php'
            </script>
        end);
}

if (is_uploaded_file($file['tmp_name'])) {
    # 设置保存路径及文件名
    $uploadDir = '../excel' . '/';

    if (!file_exists($uploadDir)) {
        #创建文件夹
        mkdir($uploadDir, 0777, true);
    }

    $fileName = $file['name'];
    $to = $uploadDir . $fileName;
    if (move_uploaded_file($file['tmp_name'], $to)) {
        # 移动成功
    } else {
        # 移动失败
        die(<<<end
            <script>
                alert('文件上传失败，请稍后重试！');
                location = '../../school/addstu.php'
            </script>
        end);
    }
}


require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadSheet = IOFactory::load("../excel/$fileName");
$workSheet = $spreadSheet->getSheet(0);

require_once '../data/connParam.php';
require_once '../data/conFunc.php';
$conn = dbConn();
$count = 0;
$sql = 'INSERT INTO zhengxf_stu
        (stu_id,stu_name,stu_pwd,stu_class)
        VALUES
        (?,?,?,?)';
$stmt = $conn->prepare($sql);
for ($i = 2; $i < 54; $i++) {
    # code...
    $stuId = $workSheet->getCell("c$i")->getValue();
    $stuName = $workSheet->getCell("d$i")->getValue();
    if (!empty($stuId)) {
        $stuPwd = md5(substr($stuId, -6, 6));
        $stmt->bind_param('issi', $stuId, $stuName, $stuPwd, $addCl);
        $stmt->execute();
        if ($stmt->affected_rows === 1) {
            # code...
            $count++;
        }
    }
}

$stmt->close();
$conn->close();
die(<<<end
<script>
    alert('成功导入{$count}条数据！');
    location = '../../school/addstu.php'
</script>
end);
