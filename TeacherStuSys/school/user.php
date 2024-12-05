<?php
// 判断是否登录状态
$logUrl = '../login.php';
require_once '../inc/log/isLog.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户设置</title>
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
            <li><a href="./user.php">修改密码</a></li>
            <li><a href="./portrait.php">修改头像</a></li>
            <li><a href="../login.php">注销</a></li>
        </ul>
    </div>
    <!-- 内容区域 -->
    <div id="content">
        <div>当前位置：用户设置</div>

        <!-- EXCEL -->

        <table id="te-userNewPwd" style="width: 500px;height: 250px;">
            <tr>
                <td>用户名</td>
                <td><input style="width:280px" type="text" name="" id="" placeholder="用户名"></td>
            </tr>
            <tr>
                <td>旧密码</td>
                <td><input style="width:280px" type="password" name="" id="" placeholder="旧密码"></td>
            </tr>
            <tr>
                <td>新密码</td>
                <td><input style="width:280px" type="password" name="" id="" placeholder="新密码"></td>
            </tr>
            <tr>
                <td>新密码确认</td>
                <td><input style="width:280px" type="password" name="" id="" placeholder="新密码"></td>
            </tr>
            <tr>
                <td>E-mail</td>
                <td><input style="width:280px" type="text" name="" id="" placeholder="E-mail"></td>
            </tr>
            <tr id="submit">
                <td colspan='2'><input type="submit" name="" value="确定"><input type="submit" name="" value="清空"></td>
            </tr>
        </table>
    </div>
    <!-- 版权区域 -->
    <div id="log-footer">
        版权所有© Copyright 1999-2021 深圳高校股份有限公司 中国深圳龙岗区龙岗大道2188号 版本V-1.0.0
    </div>
</body>

</html>