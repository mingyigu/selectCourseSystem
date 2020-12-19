<?php

$teacher_name = $_POST['teacher_name'];
$course_id = $_POST['course_id'];
$course_name = $_POST['course_name'];
$course_type = $_POST['course_type'];
$max_num = $_POST['max_num'];

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




//往该老师课程数据表中插入该课程
$sql = "INSERT INTO teacher_{$teacher_name}_course".
      "(course_name,course_type,max_num,course_id) ".
      "VALUES ".
      "('$course_name','$course_type','$max_num','$course_id')";
$retval = mysqli_query( $conn, $sql );

//创建该课程数据表
$sql = "CREATE TABLE {$course_id}_student( ".
      "student_name varchar(50))ENGINE=InnoDB DEFAULT CHARSET=utf8; ";
$retval = mysqli_query( $conn, $sql );


echo '创建成功';


mysqli_close($conn);

?>