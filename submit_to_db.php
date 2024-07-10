<?php
// 包含数据库连接文件
include 'connection.php';

// 检查表单是否提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 检查是否同意勾选框
    if (isset($_POST['consent']) && $_POST['consent'] == 'on') {
        // 获取表单数据
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // 数据验证
        if (strlen($name) > 255) {
            echo 'Name is too long.';
            exit();
        }
        if (strlen($email) > 30) {
            echo 'Email is too long.';
            exit();
        }
        if (strlen($phone) > 20) {
            echo 'Phone number is too long.';
            exit();
        }

        // 准备和执行SQL语句
        $stmt = $conn->prepare("INSERT INTO customer_details (name, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $phone);
        
        // 执行语句
        if ($stmt->execute()) {
            echo '信息已经发送给我们了，请耐心等候我们的联系。';
        } else {
            echo '数据插入失败: ' . $stmt->error;
        }

        // 关闭语句
        $stmt->close();
    } else {
        // 不同意勾选框的响应
        echo 'pdf下载中，请稍等';
    }
} else {
    // 错误请求方法响应
    echo '无效的请求方法。';
}

// 关闭数据库连接
$conn->close();
?>
