<?php

$student_name = $_POST['name'];
$course_id = $_POST['course_id'];
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

//在course_id_student表中删除对应的学生
$sql = "DELETE FROM {$course_id}_student WHERE student_name='$student_name'";
$retval = mysqli_query( $conn, $sql );
if(! $retval ){
  die(mysqli_error($conn));
}

//在stuent_xxx_course中删除对应的课程
$sql = "DELETE FROM student_{$student_name}_course WHERE course_id='$course_id'";
$retval = mysqli_query( $conn, $sql );
if(! $retval ){
  die('无法插入数据: ' . mysqli_error($conn));
}

mysqli_close($conn);
echo '退课成功';
?>