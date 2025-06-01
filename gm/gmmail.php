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
    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/random-bg.js"></script>
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
	 <button class="btn btn-info btn-block" onclick="window.location.href='gmmail.php'">邮件系统</button>
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
            <label for="username">游戏账号或角色名</label>
            <input type="text"  class="form-control" id="username" name="username" value="<?php echo $_SESSION['name'];?>" >
        </div>
    <div class="form-group">
		<fieldset><legend>邮件系统</legend>
		  		<div class="form-group">
			<label >邮件系统</label>
			<select class="form-control selectpicker" id="huobiid" name="huobiid" value="">
							<option value="">物品</option>
							<option value="0">经验</option>
                            <option value="1">金币</option>
                            <option value="2">元宝</option>
                            <option value="3">声望</option>
							<option value="4">精练石</option>
                            <option value="5">工会贡献</option>
                            <option value="6">工会资金</option>
                            <option value="7">功勋</option>
							<option value="8">成就</option>
                            <option value="9">战纹精华</option>
                            <option value="10">战纹碎片</option>
                            <option value="11">低级符文精华</option>
							<option value="12">高级符文精华</option>
                            <option value="13">神兵经验</option>
                            <option value="14">威望</option>
                            <option value="15">筹码</option>
							<option value="16">兽神精魂</option>
			</select>				
            <select class="form-control" id="category">
                <option value="">全部</option>
                <option value="prop">道具</option>
                <option value="chest">宝箱</option>
                <option value="costume">时装</option>
                <option value="card">卡</option>
                <option value="album">图鉴</option>
                <option value="pack">礼包</option>
                <option value="gem">宝石</option>
                <option value="title">称号</option>
            </select>
            <input type="text" value="" id="searchipt" placeholder="物品搜索" class="form-control"><input class="form-control" type="button" value="搜索" id="search" maxlength="20">
                  </div>
                        <div class="form-group">
         <select class="form-control selectpicker" id="item" name="item" value="item">
            <option value="">请选择</option>
         </select>
			<input type="text" placeholder="数量" class="form-control" id="num" name="num" value="" maxlength="12">
		<div class="form-group">
		 <button type="submit" class="btn btn-info btn-block" name="sub" value="mail">发送邮件</button>
		   </div>			
</form>
<script>
function loadItems(){
    var keyword = $('#searchipt').val();
    var category = $('#category').val();
    $.ajax({
        url:'itemquery.php',
        type:'post',
        data:{keyword:keyword, category:category},
        cache:false,
        dataType:'json',
        success:function(data){
            $('#item').html('');
            if(data && data.length){
                for(var i in data){
                    $('#item').append('<option value="'+data[i].key+'">'+data[i].val+'</option>');
                }
            }else{
                $('#item').html('<option value="0">未找到</option>');
            }
        },
        error:function(){
            alert('操作失败');
        }
    });
}

$('#search').click(loadItems);
$('#category').change(loadItems);
loadItems();
  </script>
<div class="form-group">
   <p class="admin_copyright">
  <span style="font-size:16px; color:#FFD700; font-weight:bold;">
    传奇再临 · 热血不灭！
  </span>
  <?php echo $_SESSION['copyright']; ?>
</p>  </div>
</body>
</html>