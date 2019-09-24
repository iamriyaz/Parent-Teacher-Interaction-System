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

if (!isset($_SESSION)) {
  session_start();
}
$username="";
if(isset($_SESSION['MM_Username']))
{
	$username=$_SESSION['MM_Username'];
	
}

else
{
	header("location:error.php");
}

$fno="";
if(isset($_GET['fno']))
{
	$fno=$_GET['fno'];
}
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recteacher2 = 1;
$pageNum_Recteacher2 = 0;
if (isset($_GET['pageNum_Recteacher2'])) {
  $pageNum_Recteacher2 = $_GET['pageNum_Recteacher2'];
}
$startRow_Recteacher2 = $pageNum_Recteacher2 * $maxRows_Recteacher2;

mysql_select_db($database_PTS, $PTS);
$query_Recteacher2 = "SELECT teacher.faculty_no, teacher.first_name, teacher.last_name, teacher.address, teacher.phone_no, teacher.e_mail, teacher.experience, teacher.qualification, teacher.gender, teacher.is_class_teacher, teacher.standard, teacher.division, subject.sub_name FROM teacher,subject where faculty_no=$fno and subject.sub_code=teacher.subject ";
$query_limit_Recteacher2 = sprintf("%s LIMIT %d, %d", $query_Recteacher2, $startRow_Recteacher2, $maxRows_Recteacher2);
$Recteacher2 = mysql_query($query_limit_Recteacher2, $PTS) or die(mysql_error());
$row_Recteacher2 = mysql_fetch_assoc($Recteacher2);

if (isset($_GET['totalRows_Recteacher2'])) {
  $totalRows_Recteacher2 = $_GET['totalRows_Recteacher2'];
} else {
  $all_Recteacher2 = mysql_query($query_Recteacher2);
  $totalRows_Recteacher2 = mysql_num_rows($all_Recteacher2);
}
$totalPages_Recteacher2 = ceil($totalRows_Recteacher2/$maxRows_Recteacher2)-1;

$queryString_Recteacher2 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recteacher2") == false && 
        stristr($param, "totalRows_Recteacher2") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recteacher2 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recteacher2 = sprintf("&totalRows_Recteacher2=%d%s", $totalRows_Recteacher2, $queryString_Recteacher2);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Teacher Profile</h2>
							</div>
                          </div>
                        </div>
                      <?php require_once('log.php')?> 
				</div>
				<div class="row">
                <div class="col-lg-2">
                <?php require_once('adminmenu.php')?>
                </div>
                <div class="col-lg-10 ">

<form id="form1" name="form1" method="post" action="">
  <table border="0" class="table table-striped">
    <tr>
      <td width="232">Faculty_no</td>
      <td width="331"><?php echo $row_Recteacher2['faculty_no']; ?></td>
    </tr>
    <tr>
      <td>First_name</td>
      <td><?php echo $row_Recteacher2['first_name']; ?></td>
    </tr>
    <tr>
      <td>Last_name</td>
      <td><?php echo $row_Recteacher2['last_name']; ?></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><?php echo $row_Recteacher2['address']; ?></td>
    </tr>
    <tr>
      <td>Phone_no</td>
      <td><?php echo $row_Recteacher2['phone_no']; ?></td>
    </tr>
    <tr>
      <td>E_mail</td>
      <td><?php echo $row_Recteacher2['e_mail']; ?></td>
    </tr>
    <tr>
      <td>Experience</td>
      <td><?php echo $row_Recteacher2['experience']; ?></td>
    </tr>
    <tr>
      <td>Qualification</td>
      <td><?php echo $row_Recteacher2['qualification']; ?></td>
    </tr>
    <tr>
      <td>Gender</td>
      <td><?php echo $row_Recteacher2['gender']; ?></td>
    </tr>
    <tr>
      <td>Is_class_teacher</td>
      <td><?php echo $row_Recteacher2['is_class_teacher']; ?></td>
    </tr>
    <tr>
      <td>Standard</td>
      <td><?php echo $row_Recteacher2['standard']; ?></td>
    </tr>
    <tr>
      <td>Division</td>
      <td><?php echo $row_Recteacher2['division']; ?></td>
    </tr>
    <tr>
      <td>Subject</td>
      <td><?php echo $row_Recteacher2['sub_name']; ?></td>
    </tr>
    <?php do { ?>
    <?php } while ($row_Recteacher2 = mysql_fetch_assoc($Recteacher2)); ?>
  </table>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_Recteacher2 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recteacher2=%d%s", $currentPage, 0, $queryString_Recteacher2); ?>">First</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recteacher2 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recteacher2=%d%s", $currentPage, max(0, $pageNum_Recteacher2 - 1), $queryString_Recteacher2); ?>">Previous</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recteacher2 < $totalPages_Recteacher2) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recteacher2=%d%s", $currentPage, min($totalPages_Recteacher2, $pageNum_Recteacher2 + 1), $queryString_Recteacher2); ?>">Next</a>
      <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Recteacher2 < $totalPages_Recteacher2) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recteacher2=%d%s", $currentPage, $totalPages_Recteacher2, $queryString_Recteacher2); ?>">Last</a>
      <?php } // Show if not last page ?></td>
    </tr>
  </table>
</form>
</div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?><?php
mysql_free_result($Recteacher2);
?>
