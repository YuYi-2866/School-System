<?php
// 判断用户是否登录
session_start();
if (!isset($_SESSION['uId'])) {
    session_write_close();
    die(<<<end
        <script>
            alert('请登录！');
            location = '{$logUrl}'
        </script>
    end);
}
