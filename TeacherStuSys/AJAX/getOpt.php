<?php
// 根据提供的二级学院信息查询班级2211270144
$depInfo = $_POST['dep'];

// 连接数据库服务器
require_once '../inc/data/connParam.php';
require_once '../inc/data/conFunc.php';
$conn = dbConn();
$opt = [
        'class' => '',
        'teacher' => '',
        'course' => ''
];
// 查询班級
$sql = 'SELECT cl_id,cl_name
        FROM zhengxf_class,zhengxf_major
        WHERE m_dep = ?
        AND m_id = cl_major';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $depInfo);
$stmt->bind_result($clId, $clName);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows() == 0) {
        $opt['class'] .= <<<end
                <option value=''>--暂无班级--</option>;
        end;;
        $stmt->free_result();
} else {
        while ($stmt->fetch()) {
                $opt['class'] .= <<<end
                <option value='{$clId}'>{$clName}</option>;
        end;
        }
        $stmt->free_result();
}
//查詢course
$sql = 'SELECT DISTINCT c_code,c_name
        FROM zhengxf_course
        WHERE c_dep = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $depInfo);
$stmt->bind_result($cCode, $cName);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows() == 0) {
        $opt['course'] .= <<<end
                <option value=''>--暂无课程--</option>;
        end;;
        $stmt->free_result();
} else {
        while ($stmt->fetch()) {
                $opt['course'] .= <<<end
                        <option value='{$cCode}'>{$cName}</option>;
                end;
        }
        $stmt->free_result();
}
// 查詢teacher
$sql = 'SELECT te_id,te_name
        FROM zhengxf_te
        WHERE te_dep = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $depInfo);
$stmt->bind_result($teId, $teName);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows() == 0) {
        $opt['teacher'] .= <<<end
                <option value=''>--暂无教师--</option>;
        end;;
        $stmt->free_result();
} else {
        while ($stmt->fetch()) {
                $opt['teacher'] .= <<<end
                        <option value='{$teId}'>{$teName}</option>;
                end;
        }
        $stmt->free_result();
}
// 关闭对象
$stmt->close();
$conn->close();
// 把數組改為字符串
echo json_encode($opt, JSON_UNESCAPED_UNICODE);
