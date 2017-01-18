<?php
	@mysql_connect("localhost:3306","root","hellophp")or die("链接失败");
	$db = mysql_select_db("mytest")or die("数据库链接失败");
	mysql_query("set names 'utf8'");
	
	header("Content-type=text/html;charset='utf-8'");
	
	$action = $_POST["action"];
	
	switch($action){
		case "register" : 
			$username = $_POST["username"];
			$password = $_POST["password"];
			$tele = $_POST["tele"];
			
			if($username == "" || $password == ""){
				exit(json_encode(1));
			}
			$select = "SELECT * FROM `userlist` WHERE username='$username'";
			$sql = mysql_query($select);
			$count = mysql_num_rows($sql);
			
//			$select = "SELECT * FROM 'userlist' WHERE username='$username'";
//			$sql = mysql_query($select)or die(mysql_error());
//			$count = mysql_num_rows($sql);
			
			if($count > 0){
				exit(json_encode(2));
			}else{
				$insert = "INSERT INTO `userlist`(`id`, `username`, `password`,`tele`) VALUES (NULL,'$username','$password','$tele')";
				
//				$insert = "INSERT INTO 'userlist'('id', 'username', 'password','tele') VALUES (NULL,'$username','$password',NULL)";

				mysql_query($insert);
				exit(json_encode(0));
			};
			break;
			
		case "login" :
		
			$username = $_POST["username"];
			$password = $_POST["password"];	
			
			$selectusername = "SELECT * FROM `userlist` WHERE username='".$username."'";
			$selectpassword = "SELECT * FROM `userlist` WHERE password='".$password."'";
			
			$sqlname = mysql_query($selectusername);
			$sqlpwd = mysql_query($selectpassword);
			$arrName = mysql_fetch_array($sqlname);
			$arrpwd = mysql_fetch_array($sqlpwd);
			
			if( is_array($arrName) && !empty( $arrName ) && $arrName){
				if($arrName['username'] == $username && $arrpwd['password'] == $password){
					$res = urldecode("登陆成功");
					exit( json_encode($res) );
				}else{
					$res = urldecode("密码错误");
					exit( json_encode($res) );
				};
			}else{
				$res = urldecode("用户不存在");
				exit( json_encode($res) );
			};
			
			
			break;
	}
	
	
?>