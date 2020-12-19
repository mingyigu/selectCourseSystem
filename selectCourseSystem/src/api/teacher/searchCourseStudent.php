<?php

$course_id = $_POST['course_id'];
$arr = array();

class studentObj {
  var $student_name;
}

//连接数据库
$dbhost = 'localhost';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = 'jxgmy';          // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if(! $conn )
{
    die('Could not connect: ' . mysqli_error());
}
mysqli_query($conn , "set names utf8");//防止中文乱码
mysqli_select_db($conn, 'selectcoursesystem' );


$sql = "SELECT * FROM  {$course_id}_student";
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('无法插入数据: ' . mysqli_error($conn));
}
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)){
  $obj = new studentObj();
  $obj->student_name = $row['student_name'];
  array_push($arr,$obj);
}
mysqli_close($conn);
echo json_encode($arr)
?>