<?php
$teacher_name = $_POST['teacher_name'];
class myCourseObj {
  var $course_name;
  var $course_type;
  var $max_num;
  var $course_id;
}

$arr = array();
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

$sql = "SELECT * FROM  teacher_{$teacher_name}_course";
$retval = mysqli_query( $conn, $sql );
if(! $retval ){
    die('无法插入数据: ' . mysqli_error($conn));
}

while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)){
  $obj = new myCourseObj();
  $obj->course_name = $row['course_name'];
  $obj->course_type = $row['course_type'];
  $obj->max_num = $row['max_num'];
  $obj->course_id = $row['course_id'];
  array_push($arr,$obj);
}
mysqli_close($conn);
echo json_encode($arr)
?>