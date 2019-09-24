<?php require_once('Connections/PTS.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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

$maxRows_Recteachers = 10;
$pageNum_Recteachers = 0;
if (isset($_GET['pageNum_Recteachers'])) {
  $pageNum_Recteachers = $_GET['pageNum_Recteachers'];
}
$startRow_Recteachers = $pageNum_Recteachers * $maxRows_Recteachers;

mysqli_select_db($database_PTS, $PTS);
$query_Recteachers = "SELECT teacher.faculty_no, teacher.first_name, teacher.last_name, teacher.phone_no FROM teacher";
$query_limit_Recteachers = sprintf("%s LIMIT %d, %d", $query_Recteachers, $startRow_Recteachers, $maxRows_Recteachers);
$Recteachers = mysqli_query($query_limit_Recteachers, $PTS) or die(mysqli_error());
$row_Recteachers = mysqli_fetch_assoc($Recteachers);

if (isset($_GET['totalRows_Recteachers'])) {
  $totalRows_Recteachers = $_GET['totalRows_Recteachers'];
} else {
  $all_Recteachers = mysqli_query($query_Recteachers);
  $totalRows_Recteachers = mysqli_num_rows($all_Recteachers);
}
$totalPages_Recteachers = ceil($totalRows_Recteachers/$maxRows_Recteachers)-1;

$queryString_Recteachers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recteachers") == false && 
        stristr($param, "totalRows_Recteachers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recteachers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recteachers = sprintf("&totalRows_Recteachers=%d%s", $totalRows_Recteachers, $queryString_Recteachers);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Teachers</h2>
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
    <thead style="background-color:#036;color:#FFF">
    <tr>
      <td>Faculty no</td>
      <td>First_name</td>
      <td>Last_name</td>
      <td>Phone_no</td>
      <td>&nbsp;</td>
    </tr>
    </thead>
    <?php do { ?>
      <tr>
        <td><?php echo $row_Recteachers['faculty_no']; ?></td>
        <td><?php echo $row_Recteachers['first_name']; ?></td>
        <td><?php echo $row_Recteachers['last_name']; ?></td>
        <td><?php echo $row_Recteachers['phone_no']; ?></td>
        <td><a href="adminteacherview2.php?fno=<?php echo $row_Recteachers['faculty_no']; ?>">View</a></td>
      </tr>
      <?php } while ($row_Recteachers = mysqli_fetch_assoc($Recteachers)); ?>
  </table>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_Recteachers > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recteachers=%d%s", $currentPage, 0, $queryString_Recteachers); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recteachers > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recteachers=%d%s", $currentPage, max(0, $pageNum_Recteachers - 1), $queryString_Recteachers); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recteachers < $totalPages_Recteachers) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recteachers=%d%s", $currentPage, min($totalPages_Recteachers, $pageNum_Recteachers + 1), $queryString_Recteachers); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Recteachers < $totalPages_Recteachers) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recteachers=%d%s", $currentPage, $totalPages_Recteachers, $queryString_Recteachers); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
  </p>
</form>
 </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?><?php
mysqli_free_result($Recteachers);
?>
