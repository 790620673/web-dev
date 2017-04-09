<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>PHP 分页符测试例程</title>
</head>
<!--
/*
 * 样式定义
 */
 -->
 <style>
 	body{
 		font-size:18px;
 		FONT-FAMILY:verdana;
 		width:100%;
 	}
 	input, label, select, option, textarea, button, fieldset, legend,table {
    font-size:18px;
 		FONT-FAMILY:verdana;
}
 	div.content{
 		height:300px;	
 	}
 	div.page{
 		text-align:center;	
 	}
 	div.page a{
 		border:#aaaadd 1px solid;
 		text-decoration:none;
 		padding:3px 5px 3px 5px;
 		margin:2px;
 	}
 	div.page span.current{
 		border:#000099 1px solid;
 		background-color:#000099;
 		padding:5px 7px 5px 7px;
 		color:#ffffff;
 		margin:2px;
 		font-weight:bold;
 	}
 	div.page span.disable{
 		border:#eee 1px solid;
 		padding:3px 5px 3px 5px;
 		margin:2px;
 		color:#ddd;
 	}
 	div.page form{
 		display:inline;	
 	}
 </style>

<body>
<?PHP
/*
 *1,传入页码
 */
$page = $_GET['p'];
$show_page = 3;

/*
 *2,根据页码获取数据php->mysql
 */
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'test';
//连接mysql数据库
$conn = mysql_connect($host, $user, $password);
if(!$conn){
	echo "数据库连接失败";
	exit;
}
//选择要操作的数据库
mysql_select_db($db);
//设置数据库编码格式
mysql_query("SET NAMES UTF8");
//获取分页数据SELECT * FROM 表名 LIMIT 起始位置，显示条目
$sql = "SELECT * FROM pages LIMIT ".(($page-1)*5).",5";
//$sql = "SELECT * FROM pages LIMIT 0,5";
//把SQL语句传送给数据库
//echo $sql;
$result = mysql_query($sql);
if(!$result){
	echo "could not query from db " . mysql_error();
	exit;
}
//绘制表格，处理数据
echo "<div class='content'>";
echo "<table border=1 cellspacing=0 width=40% align=center>";
//添加表头
echo "<tr><td>ID</td><td>姓名</td></tr>";
while($row = mysql_fetch_assoc($result)) {
	//echo $row['id'].'-'.$row['name'].'<br>';
	echo "<tr>";
		echo "<td>{$row['id']}</td>";
		echo "<td>{$row{'name'}}</td>";
	echo "</tr>";
}
echo "</table></div>";/*<div class='content'>*/
//释放$result
mysql_free_result($result);

//获取总条数
$total_sql = "SELECT COUNT(*) FROM pages";
$total_array = mysql_fetch_array(mysql_query($total_sql));
$total = $total_array[0];
//计算总页数
$total_pages = ceil($total/5);

//关闭链接
mysql_close($conn);


/*
 *3,显示数据+分页条
 */
$page_banner="<div class='page'>";
//计算偏移量
$page_off = ($show_page-1)/2;

//显示首页与上一页
if($page > 1){
	$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=1'>首页</a>";
	$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=".($page-1)."'><上一页</a>";
}else{
	$page_banner.="<span class='disable'>首页</span>";
	$page_banner.="<span class='disable'><上一页</span>";
}
//初始化数据
$start=1;
$end=$total_pages;
/*
if($total_pages > $show_page){
	if($page > $page_off+1){
		$page_banner.="...";
	}	
	if($page > $page_off){
		$start = $page-$page_off;
		$end = ($total_pages > $page_$page_off )? ($page+$page_off) : ($total_pages);
			
	}else{
		$start = 1;
		$end = $total_pages > $show_page ? $show_page : $total_page;	
	}
	if($page + $page_off > $total_pages){
		$start = $start - ($page + $page_off - $end);	
	}
}*/
//首页 上一页...567...下一页 尾页
if($total_pages > $show_page){
	if($page-$page_off > 1)	
		$page_banner.="...";
	
	$start = $page-$page_off;
	//12...下一页 尾页
	if($start == 0)
		$start = 1;
		
	$end = $page+$page_off;
	//...78 总共8页
	if($end > $total_pages)
		$end = $total_pages;
	
	for($i=$start; $i<=$end; $i++){
		//当前页显示高亮
		if($page == $i){
			$page_banner.="<span class='current'>$i</span>";
		}else{
			$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=".$i."'>{$i}</a>";
		}
	}
	if($page+$page_off < $total_pages)
		$page_banner.="...";
}

	//显示尾页与下一页
	if($page < $total_pages){
		$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=".($page+1)."'>下一页></a>";
		$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=".($total_pages)."'>尾页</a>";
	}else{
		$page_banner.="<span class='disable'>下一页></span>";
		$page_banner.="<span class='disable'>尾页</span>";
	}
//显示总页数
$page_banner.="共".$total_pages."页,";

//跳转页，到第[ ]页，确定
$page_banner.="<form action='".$_SERVER['PHP_SELF']."' method='get'>";
$page_banner.="到第<input type='text' size='1' name='p'>页";
$page_banner.="<input type='submit' value='确定'>";
$page_banner.="</form></div>";

echo $page_banner;

?>
</body>
</html>