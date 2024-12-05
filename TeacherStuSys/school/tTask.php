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
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>教学任务查询</title>
    <link rel="stylesheet" href="../inc/css/tTask.css">
    <script src="../inc/js/jquery-3.7.1.js"></script>
    <script>
        $(function() {
            var dep = $('#depopt');
            // 选择系显示专业
            dep.change(function() {
                var depVal = $(this).val();
                // 作業一
                $.post('../AJAX/getOpt.php', {
                    "dep": depVal
                }, function(msg) {
                    console.log(msg);
                    var obj = $.parseJSON(msg)
                    console.log(obj.class);
                    var clobj = $('#clopt');
                    clobj.empty();
                    clobj.append(obj.class);
                    var cobj = $('#copt');
                    cobj.empty();
                    cobj.append(obj.course);
                    var teobj = $('#teopt');
                    teobj.empty();
                    teobj.append(obj.teacher);
                })
            });
            // 作業2
            $('#btn1').click(function() {
                $.post('../AJAX/getTask.php', {
                        "year": $('#syear').val() + $('#semester').val(),
                        "info": $("#depopt").val(),
                        "btn": 1
                    },
                    function(msg) {
                        console.log(msg);
                        $('#outarea').empty()
                        $('#outarea').append(msg)
                    })
            });
            $('#btn2').click(function() {
                $.post('../AJAX/getTask.php', {
                        "year": $('#syear').val() + $('#semester').val(),
                        "info": $("#clopt").val(),
                        "btn": 2
                    },
                    function(msg) {
                        console.log(msg);
                        $('#outarea').empty()
                        $('#outarea').append(msg)
                    })
            });
            $('#btn3').click(function() {
                $.post('../AJAX/getTask.php', {
                        "year": $('#syear').val() + $('#semester').val(),
                        "info": $("#copt").val(),
                        "btn": 3
                    },
                    function(msg) {
                        console.log(msg);
                        $('#outarea').empty()
                        $('#outarea').append(msg)
                    })
            });
            $('#btn4').click(function() {
                $.post('../AJAX/getTask.php', {
                        "year": $('#syear').val() + $('#semester').val(),
                        "info": $("#teopt").val(),
                        "btn": 4
                    },
                    function(msg) {
                        console.log(msg);
                        $('#outarea').empty()
                        $('#outarea').append(msg)
                    })
            });
        })
    </script>
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
            <li><a href="../school/tScoreln.php">教师成绩录入</a></li>
            <li><a href="../school/tTask.php">教学任务查询</a></li>
            <li><a href="#">学生成绩查询</a></li>
            <li><a href="#">学生课表查询</a></li>
            <li><a href="../school/user.php">用户设置</a></li>
            <li><a href="../index.php">学生查询</a></li>
        </ul>
        <ul>
            <!-- <li><a href="../login.php">登录</a></li> -->
            <li><a href="../login.php">注销</a></li>
        </ul>
    </div>
    <!-- 内容区域 -->
    <div id="content">
        <div>当前位置：<a href="../school/tTask.php">教师-教学任务查询</a></div>
        <div>
            <p>查询条件</p>
        </div>
        <form action="" method="post" id="task-condition">
            <div>
                学年
                <select name="syear" id="syear">
                    <?php
                    $current_year = date('Y'); //获取当前年份
                    $current_month = date('m'); //获取当前月份
                    // 判断
                    if ($current_month < 7) {
                        $end_year = $current_year;
                    } else {
                        $end_year = $current_year + 1;
                    }

                    // for循环
                    for ($year = $end_year; $year >= 2003; $year--) {
                        $start_year = $year - 1;
                        $school_year = $start_year . '-' . $year;
                        // value值为开始年和结束年的后两位 语法substr(变量, -2指显示后两位)
                        $value = substr($start_year, -2) . substr($year, -2);
                        $selected = ($year == $current_year) ? 'selected' : '';

                        echo '<option value="' . $value . '" ' . $selected . '>' . $school_year . '</option>';
                    }
                    ?>
                </select>
                学期
                <select name="semester" id="semester">
                    <option value="01">1</option>
                    <option value="02" selected>2</option><!-- selected优先显示 -->
                </select>
                系：
                <select name="ta-dep" id="depopt">
                    <option value='default' disabled selected>--请选择系--</option>
                    <?php
                    $sqlDep = $conn->query("SELECT d_id,d_name FROM zhengxf_dep");
                    while ($sqld = $sqlDep->fetch_assoc()) {
                    ?>
                        <option value='<?= $sqld['d_id'] ?>'><?= $sqld['d_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <input type="button" id="btn1" value="查 询">
            </div>
            <div>
                按班级查询>>班级：
                <select name="ta-cl" id="clopt">
                    <option value='default' disabled selected>--请选择班级--</option>
                </select>
                <input type="button" id="btn2" value="查 询">
            </div>
            <div>
                按课程查询>>课程：
                <select name="course" id="copt">
                    <option value='default' disabled selected>--请选择课程--</option>
                </select>
                <input type="button" id="btn3" value="查 询">
            </div>
            <div>
                按教师查询>>教师：
                <select name="teacher" id="teopt">
                    <option value='default' disabled selected>--请选择教师--</option>
                </select>
                <input type="button" id="btn4" value="查 询">
            </div>
        </form>
        <div id="outarea"></div>
    </div>
    <!-- 版权区域 -->
    <div id="log-footer">
        版权所有© Copyright 1999-2021 深圳高校股份有限公司 中国深圳龙岗区龙岗大道2188号 版本V-1.0.0
    </div>
</body>

</html>

<?php
$conn->close();
?>