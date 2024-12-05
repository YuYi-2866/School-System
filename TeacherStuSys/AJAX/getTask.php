<?php
$taTerm = $_POST['year'];
$clId = $_POST['info'];
$btn = $_POST['btn'];

// 连接数据库服务器
require_once '../inc/data/connParam.php';
require_once '../inc/data/conFunc.php';
$conn = dbConn();

$allsql = "SELECT cl_name,
            te_name,
            c_name,c_type,c_weekh,c_seweek,c_totalh,c_exam
            FROM zhengxf_class,zhengxf_te,zhengxf_course,zhengxf_task ";
$wheresql = "WHERE ta_term = ?
            AND ta_cid = c_id
            AND ta_class = cl_id
            AND ta_teid = te_id";

if ($btn == 2) {
    # 班级
    $sql = $allsql . $wheresql . ' AND ta_class = ?';
} else if ($btn == 3) {
    # 课程
    $sql = $allsql . $wheresql . ' AND c_code = ?';
} else if ($btn == 4) {
    # 教师
    $sql = $allsql . $wheresql . ' AND te_id = ?';
} else {
    $conn->close();
    die('<h3>请选择班级|课程|教师查询</h3>');
};

$stmt = $conn->prepare($sql);

$stmt->bind_param('ii', $taTerm, $clId);
// 绑定结果,字段列表中字段数量决定了变量的数量
$stmt->bind_result($clName, $teName, $cName, $cType, $cWeekh, $cSeweek, $cTotalh, $cExam);
// 执行
$stmt->execute();
// 保存记录
$stmt->store_result();

if ($stmt->num_rows() == 0) {
    $stmt->free_result();
    $stmt->close();
    $conn->close();
    die('<h3>查询结果为空！</h3>');
}
?>

<!-- EXCEL -->
<div style="display: flex; justify-content: center;margin: 20px;">
    <input type="button" name="Excel-C" value="导出Excel"> 
    点击导出EXCEL没有反应，请先关掉上网助手或者按住Ctrl键点击按钮！
</div>
<table id="Excel-class">
    <tr>
        <td>班级名称</td>
        <td>任课教师</td>
        <td>课程名称</td>
        <td>课程类型</td>
        <td>周课时</td>
        <td>起止周</td>
        <td>总课时</td>
        <td>考核方式</td>
    </tr>
    <?php
    while ($stmt->fetch()) {
        # code...
    ?>
        <tr>
            <td><?= $clName ?></td>
            <td><?= $teName ?></td>
            <td><?= $cName ?></td>
            <td><?= $cType ?></td>
            <td><?= $cWeekh ?></td>
            <td><?= $cSeweek ?></td>
            <td><?= $cTotalh ?></td>
            <td><?= $cExam ?></td>
        </tr>
    <?php
    }
    ?>
</table>
<?php
// 释放空间
$stmt->free_result();
// 关闭
$stmt->close();
?>