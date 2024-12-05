<?php
/* 
注销功能
1.判断登录状态，（isLog.php）
2.清除服务器端会话数据（unset   session_unset   session_destroy）
3.清除存储会话id的cookie变量（session_name()    setcookie，参考unset.php）
4.可选，删除其他的cookie变量（setcookie）
5.提示，跳转到登录页面
6.在所有内部网页的菜单栏添加
*/
session_start();
if (isset($_SESSION['uId'])) {
    $_SESSION = array();
    session_destroy();
    setcookie('PHPSESSID', '', time() - 1, '/');
    if (ini_get('session.use_cookies') == 1) {
        # code...使用cookie保存会话
        // 获取当前环境的path参数和domain参数
        $param = session_get_cookie_params();
        setcookie(session_name(), '', time() - 1, $param['path'], $param['domain']);
        die(<<<end
            <script>
                alert('注销成功，下次再见！');
                location.href = '../../login.php';
            </script>
        end);
    }
}
