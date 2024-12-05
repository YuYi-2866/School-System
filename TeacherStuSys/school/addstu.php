<?php
// 判断是否登录状态
$logUrl = '../login.php';
require_once '../inc/log/isLog.php';

// php连接数据库
require_once '../inc/data/connParam.php';
require_once '../inc/data/conFunc.php';
$conn = dbConn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>添加学生记录</title>
    <link rel="stylesheet" href="../inc/css/tTask.css">
</head>

<body>
    <!-- logo区域 -->
    <div id="logo">
        <img src="../inc/pci/logo1.png" alt="">
        <a href="#">教务管理系统</a>
    </div>

    <!-- 欢迎信息区域 -->
    <div id="welcome">
        <img src="../inc/portrait/<?= $_COOKIE['uPic'] ?>" alt="" style="margin:10px">
        <div>您好！<a href="../index.php"><?= $_COOKIE['uName'] ?></a>
            <?= $_COOKIE['uRole'] ?>：<?= $_SESSION['uId'] ?>
            系：<?= $_COOKIE['udep'] ?>
        </div>
    </div>
    <!-- 横向导航区域 -->
    <div id="nav">
        <ul>
            <li><a href="../index.php">首页</a></li>
        </ul>
        <ul>
            <li><a href="../login.php">注销</a></li>
        </ul>
    </div>
    <!-- 内容区域 -->
    <div id="content">
        <div>当前位置：添加学生</div>
        <div>
            <p>查询导入</p>
        </div>
        <form action="../inc/log/getExcel.php" method="post" enctype="multipart/form-data" id="addstu-form">
            <div>
                请选择需要导入数据的班级：
                <select name="clopt" id="clopt">
                    <option value='default' disabled selected>--请选择班级--</option>
                    <?php
                    $sqlCl = $conn->query("SELECT cl_name,cl_id FROM zhengxf_class");
                    while ($sqlC = $sqlCl->fetch_assoc()) {
                    ?>
                        <option value='<?= $sqlC['cl_id'] ?>'><?= $sqlC['cl_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <input type="file" style="width: auto;" name="stuE" id="stuE">
                <input style="height: 30px; margin-left: 100px;" type="submit" name="" value="确 定 导 入">
            </div>
        </form>
    </div>
    <!-- 版权区域 -->
    <div id="log-footer">
        版权所有© Copyright 1999-2021 深圳高校股份有限公司 中国深圳龙岗区龙岗大道2188号 版本V-1.0.0
    </div>
</body>

</html>