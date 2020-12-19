<?php

$name = $_POST['name'];
$course_id = $_POST['course_id'];
$teacher_name = $_POST['teacher_name'];
$course_type = $_POST['course_type'];
$course_name = $_POST['course_name'];
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


//获得已选该课的学生数量
$sql = "SELECT * FROM {$course_id}_student";
$retval = mysqli_query( $conn, $sql );

$num = 0;
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)){
  $num++;
}
if($num >= $max_num){
  echo '课程人数已达上限！';
}
else{
  //往该课程数据表中插入该学生
  $sql = "INSERT INTO {$course_id}_student".
        "(student_name) ".
        "VALUES ".
        "('$name')";
  $retval = mysqli_query( $conn, $sql );

  //往该学生课表中插入该课
  $sql = "INSERT INTO student_{$name}_course".
        "(course_teacher,course_type,course_name,course_id) ".
        "VALUES ".
        "('$teacher_name','$course_type','$course_name','$course_id')";
  $retval = mysqli_query( $conn, $sql );

  echo '选课成功';
}


mysqli_close($conn);

?>