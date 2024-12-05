<?php
// 判断是否登录状态
$logUrl = '../../login.php';
require_once './isLog.php';

$file = $_FILES['uimg'];
$ext = pathinfo($file['name'])['extension'];
$allowExt = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp' , 'image/gif'];
$fileMime = mime_content_type($file['tmp_name']);

if (!isset($file) || $file['error'] > 0) {
    # 上传失败返回表单
    die(<<<end
            <script>
                alert('文件上传失败！');
                location = '../../school/portrait.php'
            </script>
        end);
} elseif (!in_array($fileMime, $allowExt)) {
    # 非法文件
    die(<<<end
            <script>
                alert('文件格式不符，请稍后重试！');
                location = '../../school/portrait.php'
            </script>
        end);
} elseif ($file['size'] > 100 * 1024) {
    # 文件大小限制
    die(<<<end
            <script>
                alert('文件过大，请重试！');
                location = '../../school/portrait.php'
            </script>
        end);
} else {
    if (is_uploaded_file($file['tmp_name'])) {
        # 设置保存路径及文件名
        $fileDay = date('Y') . '/' . date("m") . '/';
        $uploadDir = '../portrait' . '/' . $fileDay;

        if (!file_exists($uploadDir)) {
            #创建文件夹
            mkdir($uploadDir, 0777, true);
        }

        $fileName = $_SESSION['uId'] . rand(0, 9999) . '.' . $ext;
        $to = $uploadDir . $fileName;
        
        # 删除旧图片
        $oldPic = $_COOKIE['uPic']; // 获取旧的图片路径
        if ($oldPic) {
            $oldPath = '../portrait/' . $oldPic;
            if (file_exists($oldPath)) {
                unlink($oldPath); // 删除旧文件
            }
        }
        if (move_uploaded_file($file['tmp_name'], $to)) {
            # 移动成功
            // 作业2
            // 连接服务器
            require_once '../data/connParam.php';
            require_once '../data/conFunc.php';
            $conn = dbConn();
            if ($_COOKIE['uRole'] == '工号') {
                # 教师
                $sql = "UPDATE zhengxf_te SET te_pic = '{$fileDay}{$fileName}'
                    WHERE te_id = {$_SESSION['uId']}";
            } else {
                # 学生
                $sql = "UPDATE zhengxf_stu SET stu_pic = '{$fileDay}{$fileName}'
                    WHERE stu_id = {$_SESSION['uId']}";
            }
            $conn->query($sql);
            if ($conn->affected_rows == 1) {
                # 更新成功
                setcookie('uPic', $fileDay . $fileName, time() + 10 * 60 * 60, '/');
                echo <<<end
            <script>
                alert('头像更新成功！');
                location = '../../index.php'
            </script>
        end;
            } else {
                # 更新失败
                $newPic = $fileDay . $fileName; // 获取新的图片路径
                if ($newPic) {
                    $newPath = '../portrait/' . $newPic;
                    if (file_exists($newPath)) {
                        unlink($newPath); // 删除新文件
                    }
                }
                echo <<<end
            <script>
                alert('更新失败，请稍后重试！');
                location = '../../school/portrait.php'
            </script>
        end;
            }
            $conn->close();
        } else {
            # 移动失败
            die(<<<end
                <script>
                    alert('保存失败，请稍后重试！');
                    location = '../../school/portrait.php'
                </script>
            end);
        }
    }
}
