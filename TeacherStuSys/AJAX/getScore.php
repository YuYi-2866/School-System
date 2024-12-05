<?php
$taTerm = $_POST['year'];
$clId = $_POST['Clinfo'];
$cId = $_POST['Cinfo'];

// 连接数据库服务器
require_once '../inc/data/connParam.php';
require_once '../inc/data/conFunc.php';
$conn = dbConn();
// 查询课程信息
$allsql = "SELECT cl_name,
            te_name,
            c_name,c_type,c_exam
            FROM zhengxf_class,zhengxf_te,zhengxf_course,zhengxf_task ";
$wheresql = "WHERE ta_term = ?
            AND ta_cid = c_id
            AND ta_class = cl_id
            AND ta_teid = te_id";
$sql = $allsql . $wheresql . ' AND ta_class = ? AND c_code = ?';
$stmt = $conn->prepare($sql);
$stmt->bind_param('iii', $taTerm, $clId, $cId);
$stmt->bind_result($clName, $teName, $cName, $cType, $cExam);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows() == 0) {
    $stmt->free_result();
    $stmt->close();
    $conn->close();
    die('<h3>查询结果为空！</h3>');
}
while ($stmt->fetch()) {
?>
    <tr>
        <td>教师姓名：<?= $teName ?></td>
        <td>课程名称：<?= $cName ?></td>
    </tr>
    <tr>
        <td>班级：<?= $clName ?></td>
        <td>学年学期：<?= $taTerm ?></td>
    </tr>
    <tr>
        <td>课程性质：<?= $cType ?></td>
        <td>考核方式：<?= $cExam ?></td>
    </tr>
<?php
}
?>
<tr>
    <td>输入规范提示：数字成绩不得超过100分。</td>
    <td>输入计分制：<input type="text"> 总评好成绩保存为: <input type="text"></td>
</tr>
<tr>
    <td colspan='2'>
        平时(%)<input type="text">
        期中(%)<input type="text">
        实验(%)<input type="text">
        期末(%)<input type="text">
        折算总评成绩之前请先清空总评成绩。<input type="submit" name="" value="清空总评成绩" style="width: 120px;">
    </td>
</tr>
<tr>
    <td colspan="2">
Excel成绩文件 :
        <input type="file" name="file" id="file" value="" style="width: 500px;">
        <input type="submit" id="btn3" name="btn3" value="保存载入" style="width: 80px;">
        <input type="button" id="btn4" name="btn4" value="成绩校对打印" style="width: 120px;">
        <input type="button" id="btn6" name="btn6" value="成绩输出打印" style="width: 120px;">
    </td>
</tr>
<tr>
    <td colspan="2" style="height: 50px;text-align: center; margin-top: 10px;">
        <input type="button" id="btn7" name="btn7" value="学生列表查看" style="width: 120px;">
        <input type="submit" name="" value="成绩下载模板" style="width: 120px;"> 
        <input type="button" id="btn8" name="btn8" value="直接提交" style="width: 120px;">
    </td>
</tr>
<?php
// 释放空间
$stmt->free_result();
// 关闭
$stmt->close();
?>