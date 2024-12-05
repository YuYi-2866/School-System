<?php
// 2211270144
function dbConn(){
    $conn = @new mysqli(HostName, UserName, UserPwd, DBName);

    if ($conn->connect_errno) {
        #连接失败
        die('连接失败的原因是：' . $conn->connect_error);
    }
    // 设置字符集
    $conn->set_charset('utf8');
    return($conn);
}
