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

$sql = 'SELECT * FROM   teacher_user';
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('无法插入数据: ' . mysqli_error($conn));
}
$flag = 0;
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)){
  if($row['teacher_name'] == $name){
    $flag = 1;
    break;
  }
}
if($flag == 1){
  echo '用户名已经存在';
}
else{
  //往数据库中插入新学生账户
  $sql = "INSERT INTO teacher_user ".
        "(teacher_name,password) ".
        "VALUES ".
        "('$name','$password')";
  $retval = mysqli_query( $conn, $sql );

  //为该老师创建课程数据表
  $sql = "CREATE TABLE teacher_{$name}_course( ".
        "course_name varchar(20), ".
        "course_type varchar(20), ".
        "max_num int, ".
        "course_id varchar(50))ENGINE=InnoDB DEFAULT CHARSET=utf8; ";
  $retval = mysqli_query( $conn, $sql );


  echo '注册成功';
}

mysqli_close($conn);
?>