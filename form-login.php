<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="wrapper">
    <form action="process-login.php" method="POST">
    <h1>Login</h1>
        <div class="input-box">
            <input name="email_account" type="email" placeholder="อีเมล" required>
        </div>
        <div class="input-box">
            <input name="password_account" type="password" placeholder="รหัสผ่าน" required>
        </div>
        <button type="submit" class="btn">เข้าสู่ระบบ</button>
        <a href="form-register.php">สร้างบัญชีใหม่</a>
    </form>
</div>
</body>
</html>