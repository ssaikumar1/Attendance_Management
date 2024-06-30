<!DOCTYPE html>

<html>

<head>

  <title>Login</title>

  <link rel="stylesheet" href="<?= base_url('public/css/logincss.css'); ?>">

</head>

  <body>

  <div class="login-box">

 <form action="<?= base_url('AuthController/login');?>"method="post">

   <div class="user-box">

     <input type="text" name="username" required>

     <label>Username</label>

   </div>

   <div class="user-box">

     <input type="password" name="password" required>

     <label>Password</label>

   </div>

   <span style="color:white;"><?= isset($error)?$error:''; ?></span>

   <center>

    <a><input class="login-btn" type="submit"><a>

    </center>

 </form>

</div>

</body>

</html>