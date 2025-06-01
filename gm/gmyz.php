<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>三界-管理系统</title>
</head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GM</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
<script src="js/theme.js"></script>
    <!-- 可选的 Bootstrap 主题文件（一般不用引入） -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<?php
include 'config.php';
	$mysqli = new mysqli($db_host,$db_username,$db_password,$gmdb,$dbport);
	if(!$mysqli){
	echo "<script>alert('系统提示：数据库连接失败');history.go(-1)</script>";
	exit;	
	}
	session_start();
	$mysqli->set_charset('utf8');	
	$query = $mysqli->prepare("select * from `user` where `user`=? and `password`=? limit 1");
	$query->bind_param('ss', $_SESSION["user"], $_SESSION["password"]);
	$query->execute();
	$result = $query->get_result();
	$row = mysqli_fetch_array($result);
	$check = md5($row['user'] . $row['password']);
	$status= $row['status'];
	if ($_SESSION['check'] <> $check || empty($_SESSION['status']) || $_SESSION['status'] <> $status  || $_SESSION['status'] <> 'admin'){				
	unset($_SESSION);
	echo "<script>alert('您无此权限！');window.location.href='index.php';</script>";
	exit;
	}	
	if(isset($_SESSION['expiretime'])) {   
    if($_SESSION['expiretime'] < time()) {  
    unset($_SESSION['expiretime']);  
	$query = $mysqli->prepare("INSERT INTO gmlog (user, create_time,name,remark,ip) VALUES (?, now(),?,'退出登陆',?)");
	$query->bind_param('sss', $_SESSION["user"], $_SESSION["name"], $user_IP);
	$query->execute();
	$mysqli->close();
	header('Location: exit.php?TIMEOUT'); // 登出  
	exit(0);  
	} else {  
	$_SESSION['expiretime'] = time() + 3600; // 刷新时间戳  
	}  
  
} 	
?>
<div class="text-center col-md-4 center-block">
<h1><?php echo $_SESSION['gmbt'];?>授权后台</h1>
 <h3 style="color:blue"><?php echo $_SESSION['name'];?> 欢迎登陆</h3> <br>
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmyz.php?vip=yz1'">一键系统</button>	
	<button class="btn btn-info btn-block" onclick="window.location.href='gm.php'">返回主菜单</button>
	<button class="btn btn-info btn-block" onclick="window.location.href='exit.php'">登陆注销</button><br>		 
<form id="form1" name="form1" method="post" action="gmquery.php">
        <div class="form-group">
			<select class="form-control selectpicker" id="qu" name="qu" value="">
			<?php
			  foreach($yzfqu as $k=>$v){
				  echo '<option value="'.$k.'">'.$v.'</option>';
			  }
			  ?>
			</select>
            <label for="username">游戏角色名</label>
            <input type="text"  class="form-control" id="username" name="username" value="<?php echo $_SESSION['name'];?>" >	
			<select class="form-control selectpicker" onchange="self.location.href=options[selectedIndex].value">
			<option value="">选择套餐礼包</option>
			<option value="gmyz.php?vip=yz1">套餐礼包一</option>
			<option value="gmyz.php?vip=yz2">套餐礼包二</option>
			<option value="gmyz.php?vip=yz3">套餐礼包三</option>
			<option value="gmyz.php?vip=yz4">套餐礼包四</option>
			<option value="gmyz.php?vip=yz5">套餐礼包五</option>
			<option value="gmyz.php?vip=yz6">套餐礼包六</option>
			<option value="gmyz.php?vip=yz7">套餐礼包七</option>
			<option value="gmyz.php?vip=yz8">套餐礼包八</option>
			<option value="gmyz.php?vip=yz9">套餐礼包九</option>
			<option value="gmyz.php?vip=yz10">套餐礼包十</option>			
			</select>
			<input type="text" readOnly="true" style="display:none" class="form-control" id="vip" name="vip" value="<?php echo $_GET['vip'];?>" >		
		 <label style="color:red">提示：<?php echo $_GET['vip'];?>套餐礼包显示</label>  <select class="form-control selectpicker" value="item">
		<?php
        $file = fopen("onekey/item.".$_GET['vip'].".txt", "r");
        while(!feof($file))
        {
            $line=fgets($file);
			$txts=explode(';',$line);
			if(count($txts)==3){
				echo '<option value="'.$txts[0].'">'.$txts[2].' '.'数量:'.$txts[1].'</option>';
			}
        }
        fclose($file);
		?>
		</select></br>	

        <button type="submit" class="btn btn-info btn-block" name="sub" value="yz">一键发送套餐礼包</button></br>		
				
			
</form>
 <p class="admin_copyright">
  <span style="font-size:16px; color:#FFD700; font-weight:bold;">
    传奇再临 · 热血不灭！
  </span>
  <?php echo $_SESSION['copyright']; ?>
</p> </div>
 </div>	
</body>
</html>