<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include 'config.php';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>三界-霸业管理系统</title>
</head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GM</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-1.7.2.min.js"></script>
</head>
<body>
<div class="text-center col-md-4 center-block">
<hr><h2 style="color:Red;"><?php echo $_SESSION['gmbt'];?>三界-管理系统</h2><hr/>
<form id="form" name="form" method="post" action="check.php" >
     <div class="form-group">
            <input type="text" placeholder="登陆账号" class="form-control" id="user" name="user" value="" >
        </div>
            <input type="password" placeholder="登陆密码" class="form-control" id="pass" name="pass" value="" ><br>
      
		 <div class="form-group">
        <button type="submit" class="btn btn-info btn-block" name="sub" value="login ">登陆</button>
		 </div>
		  
</form>
 <p class="admin_copyright">
  <span style="font-size:16px; color:#FFD700; font-weight:bold;">
    传奇再临 · 热血不灭！
  </span>
  <?php echo $_SESSION['copyright']; ?>
</p> 
</div>
</body>
</html>