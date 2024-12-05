<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录页面</title>
    <link rel="stylesheet" href="../TeacherStuSys/inc/css/login.css">
    <script src="./inc/js/jquery-3.7.1.js"></script>
    <script>
        $(function() {
            $('#btn1').click(function() {
                $.post('./AJAX/doglogin.php', {
                    'uid': $('#uid').val(),
                    'upwd': $('#upwd').val(),
                    'role': $('input[name="role"]:checked').val()
                }, function(msg) {
                    var test = $.parseJSON(msg);
                    var logtest = $('#logtest')
                    logtest.empty();
                    logtest.append(test);
                });
            })
        })
    </script>
    <script id="logtest"></script>
</head>

<body>
    <!-- 登录表单黑龙江 -->
    <div id="log-form-all" style="background-image: url('../TeacherStuSys/inc/pci/login.jpg');width: 1080px;height: 500px;">
        <!-- 导航logo 2211270144 -->
        <div id="log-title">
            <img src="../TeacherStuSys/inc/pci/logo01.png" alt="网站 logo">
        </div>
        <div id="log-form">
            <h2 style="text-align: center;margin-top: 60px;">用户登录</h2>
            <form action="./AJAX/doglogin.php" method="post">
                <div>
                    <div id="log-form-name">
                        <div class="log-form-text">用户名：</div>
                        <div>
                            <input type="text" name="uid" id="uid" placeholder="用户名" style="width: 287px; height: 23px;">
                        </div>
                    </div>
                    <div id="log-form-passwd">
                        <div class="log-form-text">密码：</div>
                        <div>
                            <input type="password" name="upwd" id="upwd" placeholder="密码" style="width: 287px; height: 23px;" autocomplete="off">
                        </div>
                    </div>
                    <div id="log-form-shenfen">
                        <div class="log-form-text" style="margin-right: auto;">身份：
                        </div>
                        <div id="log-form-input">
                            <input type="radio" name="role" value="学号" checked>学生
                            <input type="radio" name="role" value="工号">老师
                        </div>
                    </div>
                    <div id="log-form-line">
                        <a href="#">忘记密码?</a>
                    </div>
                    <div id="log-form-submit">
                        <input type="button" id="btn1" value="登录" style="width: 360px;">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- 登录页面版权 -->
    <div id="log-footer">
        版权所有© Copyright 1999-2021 深圳高校股份有限公司 中国深圳龙岗区龙岗大道2188号 版本V-1.0.0
    </div>
</body>

</html>