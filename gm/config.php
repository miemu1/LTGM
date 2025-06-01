<?php 
//================================================
$key='// 版本 2021 Powered by 源码屋 www.51boshao.com';
//================================================
error_reporting(0);
session_start();
$_SESSION['gmbt'] ='GM';
//=========================================
$db_host='127.0.0.1';
$db_username='root';//数据库帐号
$db_password='X8iYn4p2adiwoxmv';//数据库密码
$dbport = 3306;
//===============游戏分区=================================
$qu  = trim($_POST['qu']);
if
($_POST['qu']==1){
	$dbgame='actor_s1';	//1区角色数据库
}elseif
($_POST['qu']==2){
	$dbgame='actor_s2';	//2区角色数据库
}elseif
($_POST['qu']==3){
	$dbgame='actor_s3';	//2区角色数据库
}elseif
($_POST['qu']==4){
	$dbgame='actor_s4';	//3区角色数据库
}elseif
($_POST['qu']==5){
	$dbgame='actor_s5';	//4区角色数据库
}elseif
($_POST['qu']==6){
	$dbgame='actor_s6';	//7区角色数据库
}
//=========================================================
$admin='admin'; 	//首次登陆账号，建议不要使用admin
$adminpass='51boshao.com';  //首次登陆密码	
$gmdb = "gm";	//后台数据库名称
//=========================================================
// 可修改玩家的后台
$max = 1000000000;  //邮件物品最大数量
$title = 'GM邮件';     //邮件标题
$content = 'aa';   //邮件内容
$month = $_POST['month'];
if($month=='1'){
	$card=280000;	 //月卡
}
elseif($month=='2'){
	$card=880000;    //特权卡
}

$yzfqu=array(
		  	'1'=>'1区',
		  	'2'=>'2区',
		  	'3'=>'3区',
		  	'4'=>'4区',
		  	'5'=>'5区',
		  	'6'=>'6区',


	);
$yzfhuobi=array(
		''=>'物品',   //自行修改
		'0'=>'经验',
		'1'=>'金币',
		'2'=>'元宝',
		'3'=>'声望',
		'4'=>'精练石',
		'5'=>'工会贡献',
		'6'=>'工会资金',
		'7'=>'功勋',
		'8'=>'成就',
		'9'=>'战纹精华',
		'10'=>'战纹碎片',
		'11'=>'低级符文精华',
		'12'=>'高级符文精华',
		'13'=>'神兵经验',
		'14'=>'威望',
		'15'=>'筹码',
		'16'=>'兽神精魂',
	);
//=========================================================
//  网站最下面版权信息修改。
$_SESSION['copyright'] = '
<br>
<span style="font-size:20px; font-weight:bold;">
🔥 
<font color="#FF0000">一</font>
<font color="#FFA500">刀</font>
<font color="#FFFF00">9</font>
<font color="#00FF00">9</font>
<font color="#00FFFF">9</font>
，
<font color="#1E90FF">极</font>
<font color="#0000FF">品</font>
<font color="#8A2BE2">全</font>
<font color="#FF69B4">靠</font>
<font color="#FF1493">爆</font>
！
</span>';
//=========================================================	
	$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
	$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
	$now = date('Y-m-d H:i:s',strtotime('now')); 
?>