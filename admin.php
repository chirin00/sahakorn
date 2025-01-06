<?php
session_start();
$open_connect = 1;
require('connect.php');

if(!isset($_SESSION['id_account']) || $_SESSION['role_account'] != 'admin'){//ถ้าไม่มีเซสชัน id_account หรือเซสชัน role_account จะถูกส่งไปหน้า login
    die(header('Location: form-login.php'));
}elseif(isset($_GET['logout'])){ //ถ้ามีการกดปุ่มออกจากระบบให้ทำการทำลายเซสชันและส่งไปหน้า login
    session_destroy();
    die(header('Location: form-login.php'));
}else{
    $id_account = $_SESSION['id_account'];
    $query_show = "SELECT * FROM account WHERE id_account = '$id_account'";
    $call_back_show = mysqli_query($connect, $query_show);
    $result_show = mysqli_fetch_assoc($call_back_show);
    $directory = 'images_account/';
    $image_name = $directory . $result_show['images_account'];
    $clear_cache = '?' . filemtime($image_name);
    $image_account = $image_name . $clear_cache;
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลส่วนตัว</title>
    
    <style>
        body {
    justify-content: center;
    min-height: 100vh;
    background: url('102847594_712608946224056_8771390303056691200_n.png') no-repeat;
    background-size: cover;
    background-position: center;
        }
        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        .profile-header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .profile-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .profile-image {
            text-align: center;
            padding: 20px;
        }
        .profile-image img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #4CAF50;
        }
        .profile-body {
            padding: 20px;
            color: #333;
        }
        .profile-body p {
            margin: 10px 0;
            font-size: 16px;
        }
        .profile-body .label {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>ข้อมูลส่วนตัว</h1>
        </div>
        <div class="profile-image">
            <img src="images_account/default_images_account.jpg">
        </div>
        <div class="profile-body">
            <p><span class="label">ชื่อ:</span> นาย กวิน ซาสี่หมี่เกี๊ยว</p>
            <p><span class="label">อายุ:</span> 33</p>
            <p><span class="label">กรุ๊ปเลือด:</span> B</p>
            <p><span class="label">เกิดที่:</span> กรุงเทพ</p>
            <p><span class="label">เกิดวันที่:</span> 22/02/2535</p>
            <p><span class="label">สัญชาติ:</span> ไทย</p>
            <p><span class="label">ศาสนา:</span> พุธ</p>
        </div>
        <div class="profile-footer">
            <form action="http://localhost/phpmyadmin/index.php?route=/sql&pos=0&db=programming_world&table=account" method="get">
                <button type="submit" class="btn">แก้ไขข้อมูลผู้ใช้</button>
            </form>
        </div>
        <h2 class="btn"><a href="admin.php?logout=1">logout</a></h2>
    </div>
</body>
</html>