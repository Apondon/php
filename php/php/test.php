<?php
	@mysql_connect("localhost:3306","root","hellophp")or die("链接失败"); //链接服务器
	$db = mysql_select_db("mytest")or die("数据库链接失败"); //链接数据库
	mysql_query("set names 'utf8'");

	header("Content-type=text/html;charset='utf-8'"); //设置文本解析方式为utf-8

	$action = $_POST["action"]; //接收请求

	switch($action){ //判断请求的关键字
		case "register" : //注册
			$username = $_POST["username"];
			$password = $_POST["password"];
			$tele = $_POST["tele"];

			if($username == "" || $password == ""){
				exit(json_encode(1));
			}
			$select = "SELECT * FROM `userlist` WHERE username='$username'"; //数据库中查询数据
			$sql = mysql_query($select);
			$count = mysql_num_rows($sql);

//			$select = "SELECT * FROM 'userlist' WHERE username='$username'";
//			$sql = mysql_query($select)or die(mysql_error());
//			$count = mysql_num_rows($sql);

			if($count > 0){ //是否有重复项
				exit(json_encode(2)); //有重复项返回 2
			}else{
				$insert = "INSERT INTO `userlist`(`id`, `username`, `password`,`tele`) VALUES (NULL,'$username','$password','$tele')"; //向服务器中插入数据

//				$insert = "INSERT INTO 'userlist'('id', 'username', 'password','tele') VALUES (NULL,'$username','$password',NULL)";

				mysql_query($insert);
				exit(json_encode(0)); //添加成功返回 0
			};
			break;

		case "login" : //登陆

			$username = $_POST["username"];
			$password = $_POST["password"];

			//从服务器中查询账号和密码
			$selectusername = "SELECT * FROM `userlist` WHERE username='".$username."'";
			$selectpassword = "SELECT * FROM `userlist` WHERE password='".$password."'";

			$sqlname = mysql_query($selectusername);
			$sqlpwd = mysql_query($selectpassword);
			$arrName = mysql_fetch_array($sqlname);
			$arrpwd = mysql_fetch_array($sqlpwd);

			if( is_array($arrName) && !empty( $arrName ) && $arrName){ // 判断是否有该账号
				if($arrName['username'] == $username && $arrpwd['password'] == $password){//判断账号密码是否匹配
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
