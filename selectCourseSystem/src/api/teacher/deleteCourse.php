<?php
 
$teacher_name = $_POST['teacher_name'];
$course_id = $_POST['course_id'];

$studentArr = array();
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

//获得所有学生的姓名
$sql = 'SELECT * FROM  student_user';
$retval = mysqli_query( $conn, $sql );
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)){
  array_push($studentArr,$row['student_name']);
}


//遍历学生姓名数组，在学生个人课表中删除符合条件的课程
for($i=0; $i < count($studentArr); ++$i){
  $sql = "DELETE FROM student_{$studentArr[$i]}_course WHERE course_id='$course_id'";
  $retval = mysqli_query( $conn, $sql );
  if(! $retval ){
    die(mysqli_error($conn));
  }
}

//在老师课程表中删除该课
$sql = "DELETE FROM teacher_{$teacher_name}_course WHERE course_id='$course_id'";
$retval = mysqli_query( $conn, $sql );
if(! $retval ){
  die(mysqli_error($conn));
}

//删除该课程表
$sql = "DROP TABLE {$course_id}_student";
$retval = mysqli_query( $conn, $sql );
if(! $retval ){
  die(mysqli_error($conn));
}


mysqli_close($conn);
echo '删除成功';
?>