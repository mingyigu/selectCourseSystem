<?php
$teacherName = $_POST['teacherName'];
$courseType = $_POST['courseType'];
$studentName = $_POST['studentName'];
$courseArr = array();
$teacherArr = array();
class courseInfo {
  var $course_name;
  var $course_type;
  var $max_num;
  var $selected_num;
  var $course_id;
  var $isSelected;
  var $teacher_name;
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

$sql = 'SELECT * FROM  teacher_user';
$retval = mysqli_query( $conn, $sql );
if(! $retval )
{
  die('无法插入数据: ' . mysqli_error($conn));
}
if($teacherName == 'all'){
  while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)){
    array_push($teacherArr,$row['teacher_name']);
  }
}
else{
  array_push($teacherArr,$teacherName);
}

//遍历老师姓名数组，查找所有符合条件的课程
for($i=0; $i < count($teacherArr); ++$i){
  $sql = "SELECT * FROM teacher_{$teacherArr[$i]}_course";
  $retval = mysqli_query( $conn, $sql );
  if(! $retval )
  {
    die('无法插入数据: ' . mysqli_error($conn));
  }

  while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)){
    if($courseType == 'all' || $courseType == $row['course_type']){
      $obj = new courseInfo();
      $obj->course_name = $row['course_name'];
      $obj->course_type = $row['course_type'];
      $obj->max_num = $row['max_num'];
      $obj->course_id = $row['course_id'];
      $obj->isSelected = false;
      //获得已经选择该课的学生的数量
      $sql2 = "SELECT * FROM {$row['course_id']}_student";
      $retval2 = mysqli_query( $conn, $sql2 );
      if(! $retval2 )
      {
        die('无法插入数据: ' . mysqli_error($conn));
      }
      $num = 0;
      while($row2 = mysqli_fetch_array($retval2, MYSQLI_ASSOC)){
        $num++;
        if($row2['student_name'] == $studentName){
          $obj->isSelected = true;
        }
      }
      $obj->selected_num = $num;
      $obj->teacher_name = $teacherArr[$i];
      array_push($courseArr,$obj);
    }
  }
  
}

mysqli_close($conn);
echo json_encode($courseArr)
?>