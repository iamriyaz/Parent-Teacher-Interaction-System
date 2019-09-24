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


$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recallteachers = 1;
$pageNum_Recallteachers = 0;
if (isset($_GET['pageNum_Recallteachers'])) {
  $pageNum_Recallteachers = $_GET['pageNum_Recallteachers'];
}
$startRow_Recallteachers = $pageNum_Recallteachers * $maxRows_Recallteachers;

mysql_select_db($database_PTS, $PTS);
$query_Recallteachers = "SELECT `faculty_no`, `first_name`, `last_name`, `address`, `phone_no`, `e_mail`, `experience`, `qualification`, `gender`, `is_class_teacher`, teacher.`standard`, `division`, `username`, `password`, subject.sub_name FROM teacher,subject where teacher.standard in (select standard from student where ration_card_no='$CNO') and division in(select division from student where ration_card_no='$CNO') and subject.sub_code=teacher.subject ";
$query_limit_Recallteachers = sprintf("%s LIMIT %d, %d", $query_Recallteachers, $startRow_Recallteachers, $maxRows_Recallteachers);
$Recallteachers = mysql_query($query_limit_Recallteachers, $PTS) or die(mysql_error());
$row_Recallteachers = mysql_fetch_assoc($Recallteachers);

if (isset($_GET['totalRows_Recallteachers'])) {
  $totalRows_Recallteachers = $_GET['totalRows_Recallteachers'];
} else {
  $all_Recallteachers = mysql_query($query_Recallteachers);
  $totalRows_Recallteachers = mysql_num_rows($all_Recallteachers);
}
$totalPages_Recallteachers = ceil($totalRows_Recallteachers/$maxRows_Recallteachers)-1;

$queryString_Recallteachers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recallteachers") == false && 
        stristr($param, "totalRows_Recallteachers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recallteachers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recallteachers = sprintf("&totalRows_Recallteachers=%d%s", $totalRows_Recallteachers, $queryString_Recallteachers);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Teacher's Info</h2>
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
  <table  border="0" class="table table-striped">
    <?php do { ?>
      <tr>
        <td>First_name</td>
        <td><?php echo $row_Recallteachers['first_name']; ?></td>
      </tr>
      <tr>
        <td>Last_name</td>
        <td><?php echo $row_Recallteachers['last_name']; ?></td>
      </tr>
      <tr>
        <td>Address</td>
        <td><?php echo $row_Recallteachers['address']; ?></td>
      </tr>
      <tr>
        <td>Phone No</td>
        <td><?php echo $row_Recallteachers['phone_no']; ?></td>
      </tr>
      <tr>
        <td>E-mail</td>
        <td><?php echo $row_Recallteachers['e_mail']; ?></td>
      </tr>
      <tr>
        <td>Experience</td>
        <td><?php echo $row_Recallteachers['experience']; ?></td>
      </tr>
      <tr>
        <td>Qualification</td>
        <td><?php echo $row_Recallteachers['qualification']; ?></td>
      </tr>
      <tr>
        <td>Gender</td>
        <td><?php echo $row_Recallteachers['gender']; ?></td>
      </tr>
      <tr>
        <td>Subjects</td>
        <td><?php echo $row_Recallteachers['sub_name']; ?></td>
      </tr>
      <tr>
        <td>Class</td>
        <td><?php echo $row_Recallteachers['standard']; ?></td>
      </tr>
      <tr>
        <td>Division</td>
        <td><?php echo $row_Recallteachers['division']; ?></td>
      </tr>
      <?php } while ($row_Recallteachers = mysql_fetch_assoc($Recallteachers)); ?>
  </table>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_Recallteachers > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recallteachers=%d%s", $currentPage, 0, $queryString_Recallteachers); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recallteachers > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recallteachers=%d%s", $currentPage, max(0, $pageNum_Recallteachers - 1), $queryString_Recallteachers); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recallteachers < $totalPages_Recallteachers) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recallteachers=%d%s", $currentPage, min($totalPages_Recallteachers, $pageNum_Recallteachers + 1), $queryString_Recallteachers); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Recallteachers < $totalPages_Recallteachers) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recallteachers=%d%s", $currentPage, $totalPages_Recallteachers, $queryString_Recallteachers); ?>">Last</a>
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
<?php require_once('footer.php')?>
<?php
mysql_free_result($Recallteachers);
?>
