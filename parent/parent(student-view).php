<?php require_once('Connections/PTS.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];
if (!isset($_SESSION)) {
  session_start();
}
$username="";
$CNO="";
if(isset($_SESSION['MM_Username']))
{
	$username=$_SESSION['MM_Username'];
	$CNO=$_SESSION['CNO'];
}

else
{
	header("location:error.php");
}

$maxRows_Recstudent1 = 1;
$pageNum_Recstudent1 = 0;
if (isset($_GET['pageNum_Recstudent1'])) {
  $pageNum_Recstudent1 = $_GET['pageNum_Recstudent1'];
}
$startRow_Recstudent1 = $pageNum_Recstudent1 * $maxRows_Recstudent1;

mysql_select_db($database_PTS, $PTS);
$query_Recstudent1 = "SELECT * FROM student where student.Ration_card_no='$CNO'";
$query_limit_Recstudent1 = sprintf("%s LIMIT %d, %d", $query_Recstudent1, $startRow_Recstudent1, $maxRows_Recstudent1);
$Recstudent1 = mysql_query($query_limit_Recstudent1, $PTS) or die(mysql_error());
$row_Recstudent1 = mysql_fetch_assoc($Recstudent1);

if (isset($_GET['totalRows_Recstudent1'])) {
  $totalRows_Recstudent1 = $_GET['totalRows_Recstudent1'];
} else {
  $all_Recstudent1 = mysql_query($query_Recstudent1);
  $totalRows_Recstudent1 = mysql_num_rows($all_Recstudent1);
}
$totalPages_Recstudent1 = ceil($totalRows_Recstudent1/$maxRows_Recstudent1)-1;

$maxRows_Recteachers1 = 20;
$pageNum_Recteachers1 = 0;
if (isset($_GET['pageNum_Recteachers1'])) {
  $pageNum_Recteachers1 = $_GET['pageNum_Recteachers1'];
}
$startRow_Recteachers1 = $pageNum_Recteachers1 * $maxRows_Recteachers1;

mysql_select_db($database_PTS, $PTS);
$query_Recteachers1 = "SELECT * FROM teacher where standard in (select standard from student where ration_card_no='$CNO') and division in(select division from student where ration_card_no='$CNO') and is_class_teacher=1";
$query_limit_Recteachers1 = sprintf("%s LIMIT %d, %d", $query_Recteachers1, $startRow_Recteachers1, $maxRows_Recteachers1);
$Recteachers1 = mysql_query($query_limit_Recteachers1, $PTS) or die(mysql_error());
$row_Recteachers1 = mysql_fetch_assoc($Recteachers1);

if (isset($_GET['totalRows_Recteachers1'])) {
  $totalRows_Recteachers1 = $_GET['totalRows_Recteachers1'];
} else {
  $all_Recteachers1 = mysql_query($query_Recteachers1);
  $totalRows_Recteachers1 = mysql_num_rows($all_Recteachers1);
}
$totalPages_Recteachers1 = ceil($totalRows_Recteachers1/$maxRows_Recteachers1)-1;

$queryString_Recstudent1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recstudent1") == false && 
        stristr($param, "totalRows_Recstudent1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recstudent1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recstudent1 = sprintf("&totalRows_Recstudent1=%d%s", $totalRows_Recstudent1, $queryString_Recstudent1);
?>
<?php require_once('header1.php')?>

<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
								<h2 class="section-heading animated" data-animation="bounceInUp">Student Profile</h2>
							</div>
                          </div>
                        </div>
                      <?php require_once('log.php')?> 
				</div>
				<div class="row">
                <div class="col-lg-2">
                <?php require_once('parentmenu.php')?>
                </div>
                <div class="col-lg-10 ">
<form id="form1" name="form1" method="post" action="">

</form>
<table width="454" border="0" class="table table-striped">
  <?php do { ?>
      <tr>
        <td><a href="scoresheet.php?regno=<?php echo $row_Recstudent1['reg_no']; ?>">View Score Sheet </a></td>
        <td><a href="attendance.php?regno=<?php echo $row_Recstudent1['reg_no']; ?>">View Attendance</a></td>
        <td><a href="compose.php?std=<?php echo $row_Recstudent1['standard']; ?>&div=<?php echo $row_Recstudent1['division']; ?>">Message to Class Teacher</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
      <td>Regno</td>
      <td colspan="2"><?php echo $row_Recstudent1['reg_no']; ?></td>
    </tr>
    <tr>
      <td>Roll No</td>
      <td colspan="2"><?php echo $row_Recstudent1['roll_no']; ?></td>
    </tr>
    <tr>
      <td>Name</td>
      <td colspan="2"><?php echo $row_Recstudent1['name']; ?></td>
    </tr>
    <tr>
      <td>Address</td>
      <td colspan="2"><?php echo $row_Recstudent1['addres']; ?></td>
    </tr>
    <tr>
      <td>Admission Date</td>
      <td colspan="2"><?php echo $row_Recstudent1['admn_date']; ?></td>
    </tr>
    <tr>
      <td>Gender</td>
      <td colspan="2"><?php echo $row_Recstudent1['gender']; ?></td>
    </tr>
    <tr>
      <td>DOB</td>
      <td colspan="2"><?php echo $row_Recstudent1['dob']; ?></td>
    </tr>
    <tr>
      <td>Guardian</td>
      <td colspan="2"><?php echo $row_Recstudent1['parent_username']; ?></td>
    </tr>
    <tr>
      <td>Standard</td>
      <td colspan="2"><?php echo $row_Recstudent1['standard']; ?></td>
    </tr>
    <tr>
      <td>Division</td>
      <td colspan="2"><?php echo $row_Recstudent1['division']; ?></td>
    </tr>
    <tr>
      <td>Blood group</td>
      <td colspan="2"><?php echo $row_Recstudent1['blood_group']; ?></td>
    </tr>
    <tr>
      <td>Religion</td>
      <td colspan="2"><?php echo $row_Recstudent1['religion']; ?></td>
    </tr>
    <tr>
      <td>Caste</td>
      <td colspan="2"><?php echo $row_Recstudent1['caste']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
   

      <table>
      <?php if ($pageNum_Recstudent1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recstudent1=%d%s", $currentPage, 0, $queryString_Recstudent1); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Recstudent1 > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Recstudent1=%d%s", $currentPage, max(0, $pageNum_Recstudent1 - 1), $queryString_Recstudent1); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Recstudent1 < $totalPages_Recstudent1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recstudent1=%d%s", $currentPage, min($totalPages_Recstudent1, $pageNum_Recstudent1 + 1), $queryString_Recstudent1); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_Recstudent1 < $totalPages_Recstudent1) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Recstudent1=%d%s", $currentPage, $totalPages_Recstudent1, $queryString_Recstudent1); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
    <?php mysql_select_db($database_PTS, $PTS);
$query_Recteachers1 = "SELECT * FROM teacher WHERE teacher.standard in (select standard from student where reg_no=".$row_Recstudent1['reg_no'].") AND teacher.division in (select division from student where reg_no=".$row_Recstudent1['reg_no'].")";
$Recteachers1 = mysql_query($query_Recteachers1, $PTS) or die(mysql_error());
$row_Recteachers1 = mysql_fetch_assoc($Recteachers1);
$totalRows_Recteachers1 = mysql_num_rows($Recteachers1);?>
    <?php } while ($row_Recstudent1 = mysql_fetch_assoc($Recstudent1)); ?>
<table border="0">
<table border="0" class="table table-striped">
    <thead style="background-color:#036;color:#fff">
      <tr>
        <td>first_name</td>
        <td>last_name</td>
        <td>address</td>
        <td>phone_no</td>
        <td>e_mail</td>
        <td>experience</td>
        <td>qualification</td>
        <td>gender</td>
        <td>is_class_teacher</td>
        <td>subject</td>
      </tr>
      </thead>
      <?php do { ?>
        <tr>
          <td><?php echo $row_Recteachers1['first_name']; ?></td>
          <td><?php echo $row_Recteachers1['last_name']; ?></td>
          <td><?php echo $row_Recteachers1['address']; ?></td>
          <td><?php echo $row_Recteachers1['phone_no']; ?></td>
          <td><?php echo $row_Recteachers1['e_mail']; ?></td>
          <td><?php echo $row_Recteachers1['experience']; ?></td>
          <td><?php echo $row_Recteachers1['qualification']; ?></td>
          <td><?php echo $row_Recteachers1['gender']; ?></td>
          <td><?php echo $row_Recteachers1['is_class_teacher']; ?></td>
          <td><?php echo $row_Recteachers1['subject']; ?></td>
        </tr>
        <?php } while ($row_Recteachers1 = mysql_fetch_assoc($Recteachers1)); ?>
    </table>
  
 </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>
<?php
mysql_free_result($Recstudent1);

mysql_free_result($Recteachers1);
?>
