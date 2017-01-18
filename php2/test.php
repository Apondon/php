<?php
	@mysql_connect("localhost:3306","root","123456")or die("mySql出错");
	mysql_select_db("conn")or die("数据库连接失败");
	mysql_query("set names 'utf8'");

	header("Content-type:text/html;charset='utf-8'");
	header("Access-Control-Allow-Origin:*");//设置请求头允许跨域

	// 初始参数，当返回为空时使用
	$page = 0;
	$pageNum = 10;

	if( @!is_null($_GET["page"]) ){ //判断该页码是否存在
		$page = $_GET["page"];
	};
	if( @!is_null($_GET["pageNum"]) ){ //判断该数量是否存在
		$pageNum = $_GET["pageNum"];
	};

	$sql = "SELECT * FROM `luxury` LIMIT $page,$pageNum"; //在数据库冲查询匹配信息
	$query = mysql_query($sql);
	$row = mysql_fetch_assoc($query);

	$list = array();
	$i = 0;
	while( $row = mysql_fetch_assoc($query) ){//将数据存如一个新数组中
		$list[$i] = $row;
		$i++;
	};
	
	echo json_encode(array("dataList"=>$list));//将数组返回给前端
	mysql_free_result($query); //请求结束后释放数据库
 	mysql_close(); //关闭数据库
?>
