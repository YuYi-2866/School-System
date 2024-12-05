<?php
// 判断是否登录状态
$logUrl = './login.php';
require_once './inc/log/isLog.php';

//php连接数据库
require_once './inc/data/connParam.php';
require_once './inc/data/conFunc.php';
$conn = dbConn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教务管理系统</title>
    <link rel="stylesheet" href="../TeacherStuSys/inc/css/tTask.css">
</head>

<body>
    <!-- logo区域 -->
    <div id="logo">
        <img src="../TeacherStuSys/inc/pci/logo1.png" alt="">
        <a href="#">教务管理系统</a>
    </div>

    <!-- 欢迎信息区域 -->
    <div id="welcome">
        <img src="./inc/portrait/<?= $_COOKIE['uPic'] ?>" alt="" style="margin:10px">
        <div>您好！<a href="./index.php"><?= $_COOKIE['uName'] ?></a>
            <?= $_COOKIE['uRole'] ?>：<?= $_SESSION['uId'] ?>
            系：<?= $_COOKIE['udep'] ?>
        </div>
    </div>
    <!-- 横向导航区域 -->
    <div id="nav">
        <ul>
            <li><a href="./school/tScoreln.php">教师成绩录入</a></li>
            <li><a href="./school/tTask.php">教学任务查询</a></li>
            <li><a href="#">学生成绩查询</a></li>
            <li><a href="#">学生课表查询</a></li>
            <li><a href="./index.php">学生查询</a></li>
        </ul>
        <ul>
            <li><a href="./school/user.php">用户设置</a></li>
            <li><a href="./inc/log/quit.php">注销</a></li>
        </ul>
    </div>
    <!-- 内容区域 -->
    <div id="content">
        <div id="content-location">当前位置：<a href="./index.php">学生-首页</a></div>
        <!-- 下拉选择框 -->
        <div>
            <form method="GET" action="">
                选择班级<select name="myclass" id="">
                    <?php
                    $sqlcl = $conn->query("SELECT DISTINCT cl_name FROM zhengxf_class");
                    while ($class = $sqlcl->fetch_assoc()) {
                    ?>
                        <option value='<?= $class['cl_name'] ?>'><?= $class['cl_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <input type="submit" name="123" value="查 询">
            </form>
        </div>
        <?php
        // 检查是否提交了表单
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // 获取选定的班级
            $selected_class = $_GET['myclass'];

            // 查询选定班级的相关信息
            $sql = "SELECT s.stu_id,s.stu_name,s.stu_class,c.cl_name,d.d_name
                    FROM zhengxf_stu AS s
                    JOIN zhengxf_class AS c ON s.stu_class = c.cl_id
                    JOIN zhengxf_major AS m ON m.m_id = c.cl_major
                    JOIN zhengxf_dep AS d ON m.m_dep = d.d_id
                    WHERE c.cl_name = '$selected_class'";
            $re = $conn->query($sql);
        }
        ?>
        <table id="Excel-class1">
            <tr>
                <td>序号</td>
                <td>班级</td>
                <td>学号</td>
                <td>姓名</td>
                <td>二级学院</td>
            </tr>
            <?php
            for ($i = 1; $i < 11 && $row = $re->fetch_assoc(); $i++) {
                # code... 

            ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $row['cl_name']; ?></td>
                    <td><?= $row['stu_id']; ?></td>
                    <td><?= $row['stu_name']; ?></td>
                    <td><?= $row['d_name']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <div id="content-location">
            <?= "当前记录数:", $re->num_rows ?>
        </div>
    </div>
    <!-- 版权区域 -->
    <div id="log-footer">
        版权所有© Copyright 1999-2021 深圳高校股份有限公司 中国深圳龙岗区龙岗大道2188号 版本V-1.0.0
    </div>
</body>

</html>

<?php
//关闭连接
$conn->close();
