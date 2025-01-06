<?php
session_start();
$open_connect = 1;
require('connect.php');

if(!isset($_SESSION['id_account']) || !isset($_SESSION['role_account'])){//ถ้าไม่มีเซสชัน id_account หรือเซสชัน role_account จะถูกส่งไปหน้า login
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บัญชีผู้ใช้</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: url('102847594_712608946224056_8771390303056691200_n.png') no-repeat;
    background-size: cover;
    background-position: center;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-img {
            display: block;
            margin: 0 auto;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .info-table th, .info-table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .info-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .edit-section {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>User Information</h2>
        </div>
        <img src="default-avatar.jpg" alt="Profile Image" class="profile-img" id="profile-img-preview">
        <table class="info-table">
            <div class="edit-section">
                <h3>Edit Information</h3>
                <div class="form-group">
                    <label for="profile-img">เปลี่ยนรูปภาพ:</label>
                    <input type="file" id="profile-img" accept="image/*" onchange="previewImage(event)">
                </div>
            </div>
            <tr>
                <th>เลขบัตรประชาชน:</th>
                <td><input type="text" id="id-input" placeholder="123456789"></td>
            </tr>
            <tr>
                <th>ชื่อ-นามสกุล:</th>
                <td><input type="text" id="name-input" placeholder="สมพง เจริญเถอะ"></td>
            </tr>
            <tr>
                <th>ชื่อเล่น:</th>
                <td><input type="text" id="nickname-input" placeholder="ยอด"></td>
            </tr>
            <tr>
                <th>วันเกิด:</th>
                <td><input type="text" id="dob-input" placeholder="1/1/2510"></td>
            </tr>
            <tr>
                <th>สัญชาติ:</th>
                <td><input type="text" id="nationality-input" placeholder="ไทย"></td>
            </tr>
            <tr>
                <th>ศาสนา:</th>
                <td><input type="text" id="religion-input" placeholder="พุธ"></td>
            </tr>
            <tr>
                <th>จังหวัดเกิด:</th>
                <td><input type="text" id="birthplace-input" placeholder="ขอนแก่น"></td>
            </tr>
            <tr>
                <th>กรุ๊ปเลือด:</th>
                <td><input type="text" id="bloodtype-input" placeholder="A"></td>
            </tr>
            <tr>
                <th>ทะเบียนประจำรถบรรทุก:</th>
                <td><input type="text" id="licenseplate-input" placeholder="ขอนแก่น 7กค"></td>
            </tr>
            <br>
            <button class="btn" onclick="saveChanges()">บันทึกข้อมูล</button>
            <div class="qr-code">
                <button class="btn" onclick="generateQRCode()">Generate QR Code</button>
                <div id="qr-code-container"></div>
            </div>
            <h2 class="btn"><a href="index.php?logout=1">logout</a></h2>
        </table>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const preview = document.getElementById('profile-img-preview');
                preview.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function saveChanges() {
            const id = document.getElementById('id-input').value;
            const name = document.getElementById('name-input').value;
            const nickname = document.getElementById('nickname-input').value;
            const dob = document.getElementById('dob-input').value;
            const nationality = document.getElementById('nationality-input').value;
            const religion = document.getElementById('religion-input').value;
            const birthplace = document.getElementById('birthplace-input').value;
            const bloodType = document.getElementById('bloodtype-input').value;
            const licensePlate = document.getElementById('licenseplate-input').value;

            alert(`Information Saved:\nID: ${id}\nName: ${name}\nNickname: ${nickname}\nDate of Birth: ${dob}\nNationality: ${nationality}\nReligion: ${religion}\nBirthplace: ${birthplace}\nBlood Type: ${bloodType}\nTruck License Plate: ${licensePlate}`);
        }

        function generateQRCode() {
            const qrContainer = document.getElementById('qr-code-container');
            qrContainer.innerHTML = '';

            const id = document.getElementById('id-input').value;
            const name = document.getElementById('name-input').value;
            const nickname = document.getElementById('nickname-input').value;
            const dob = document.getElementById('dob-input').value;
            const nationality = document.getElementById('nationality-input').value;
            const religion = document.getElementById('religion-input').value;
            const birthplace = document.getElementById('birthplace-input').value;
            const bloodType = document.getElementById('bloodtype-input').value;
            const licensePlate = document.getElementById('licenseplate-input').value;

            const qrData = `ID: ${id}\nName: ${name}\nNickname: ${nickname}\nDate of Birth: ${dob}\nNationality: ${nationality}\nReligion: ${religion}\nBirthplace: ${birthplace}\nBlood Type: ${bloodType}\nTruck License Plate: ${licensePlate}`;

            const qrCode = qrcode(0, 'L');
            qrCode.addData(qrData);
            qrCode.make();

            const qrCodeImg = document.createElement('img');
            qrCodeImg.src = qrCode.createDataURL();
            qrContainer.appendChild(qrCodeImg);
        }
    </script>
</body>
</html>