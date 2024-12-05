<?php
// 数据获取，判断
$uId = trim($_POST['uid']);
$uPwd = md5(trim($_POST['upwd']));
$role = $_POST['role'];
$test = '';

if (empty($uId) || empty($uPwd) || empty($role)) {
  # 弹窗有空输入有误
  $test = <<<end
    alert('请填写正确完整的账号信息！');
  end;
} else {
  // 连接服务器
  require_once '../inc/data/connParam.php';
  require_once '../inc/data/conFunc.php';
  $conn = dbConn();

  // 准备执行语句
  if ($role == '工号') {
    # 教师
    $sql = 'SELECT te_name,te_id,te_pic,d_name
              FROM zhengxf_te,zhengxf_dep
              WHERE te_id = ? 
              AND te_pwd = ?
              AND te_dep = d_id';
  } else {
    # 学生
    $sql = 'SELECT stu_name,stu_id,stu_pic,d_name
              FROM zhengxf_stu,zhengxf_class,zhengxf_major,zhengxf_dep
              WHERE stu_id = ? 
              AND stu_pwd = ?
              AND stu_class = cl_id
              AND cl_major = m_id
              AND m_dep = d_id';
  }
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('is', $uId, $uPwd);
  $stmt->bind_result($name, $id, $pic, $dep);
  $stmt->execute();

  // 双分支判断，实施跳转
  if ($stmt->fetch()) {
    // 首页弹窗登录成功
    if ($role == '工号') {
      # 教师
      $test = <<<end
        alert('登录成功，欢迎{$name}老师!');
        location.href = './index.php';
      end;
    } else {
      # 学生
      $test = <<<end
        alert('登录成功，欢迎{$name}同学!');
        location.href = './index.php';
      end;
    }
    // cookie信息
    setcookie('uName', $name, time() + 10 * 60 * 60, '/');
    // setcookie('uid', $id, time() + 10 * 60 * 60, '/');
    setcookie('udep', $dep, time() + 10 * 60 * 60, '/');
    setcookie('uRole', $role, time() + 10 * 60 * 60, '/');
    setcookie('uPic', $pic, time() + 10 * 60 * 60, '/');

    session_start();
    $_SESSION['uId'] = $uId;
    session_write_close();
  } else {
    $test = <<<end
      alert('登录失败!');
    end;
  }
  // 释放空间
  $stmt->free_result();
  // 关闭对象
  $stmt->close();
  $conn->close();
}

// 把數組改為字符串
echo json_encode($test, JSON_UNESCAPED_UNICODE);
