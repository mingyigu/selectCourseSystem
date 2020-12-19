<?php
 
$name = $_POST['name'];
$password = $_POST['password'];
// echo '网站名: ' . $name . ' ' . $password ;
//连接数据库，查看是否有该账户
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'jxgmy';          // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if(! $conn )
{
    die('Could not connect: ' . mysqli_error());
}
mysqli_query($conn , "set names utf8");//放置中文乱码
mysqli_select_db($conn, 'selectcoursesystem' );


$sql = 'SELECT * FROM  student_user';
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('无法插入数据: ' . mysqli_error($conn));
}
$flag = 0;
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)){
  if($row['student_name'] == $name && $row['password'] == $password){
    $flag = 1;
    break;
  }
  else if($row['student_name'] == $name && $row['password'] != $password){
    $flag = 2;
    break;
  }
}
if($flag == 1){
  echo '登入成功';
}
else if($flag == 2){
  echo '密码错误';
}
else{
  echo '用户名不存在';
}


mysqli_close($conn);
?>