<?php require_once('../Connections/PTS.php'); ?>
<?php
$regno="";

if(isset($_GET['regno']))
{
	$regno=$_GET['regno'];
	
}

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

$maxRows_RecAttendance = 30;
$pageNum_RecAttendance = 0;
if (isset($_GET['pageNum_RecAttendance'])) {
  $pageNum_RecAttendance = $_GET['pageNum_RecAttendance'];
}
$startRow_RecAttendance = $pageNum_RecAttendance * $maxRows_RecAttendance;

mysql_select_db($database_PTS, $PTS);
$query_RecAttendance = "SELECT * FROM attendance WHERE attendance.regno='$regno' ORDER BY attendance.`date` Desc";
$query_limit_RecAttendance = sprintf("%s LIMIT %d, %d", $query_RecAttendance, $startRow_RecAttendance, $maxRows_RecAttendance);
$RecAttendance = mysql_query($query_limit_RecAttendance, $PTS) or die(mysql_error());
$row_RecAttendance = mysql_fetch_assoc($RecAttendance);

if (isset($_GET['totalRows_RecAttendance'])) {
  $totalRows_RecAttendance = $_GET['totalRows_RecAttendance'];
} else {
  $all_RecAttendance = mysql_query($query_RecAttendance);
  $totalRows_RecAttendance = mysql_num_rows($all_RecAttendance);
}
$totalPages_RecAttendance = ceil($totalRows_RecAttendance/$maxRows_RecAttendance)-1;

$queryString_RecAttendance = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecAttendance") == false && 
        stristr($param, "totalRows_RecAttendance") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecAttendance = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecAttendance = sprintf("&totalRows_RecAttendance=%d%s", $totalRows_RecAttendance, $queryString_RecAttendance);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Attendance</h2>
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
                  <table border="0" cellpadding="5" cellspacing="5"  class="table table-striped">
                    <thead style="background-color:#036;color:#FFF">
                    <tr>
                      <td>Regno</td>
                      <td>Date</td>
                      <td>Status</td>
                      <td>Performance</td>
                    </tr>
                    </thead>
                    <?php do { ?>
                      <tr>
                        <td><?php echo $row_RecAttendance['regno']; ?></td>
                        <td><?php echo $row_RecAttendance['date']; ?></td>
                        <td><?php echo $row_RecAttendance['status']; ?></td>
                        <td><?php echo $row_RecAttendance['performance']; ?></td>
                      </tr>
                      <?php } while ($row_RecAttendance = mysql_fetch_assoc($RecAttendance)); ?>
                  </table>
                  <table border="0">
                    <tr>
                      <td><?php if ($pageNum_RecAttendance > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_RecAttendance=%d%s", $currentPage, 0, $queryString_RecAttendance); ?>">First</a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_RecAttendance > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_RecAttendance=%d%s", $currentPage, max(0, $pageNum_RecAttendance - 1), $queryString_RecAttendance); ?>">Previous</a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_RecAttendance < $totalPages_RecAttendance) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_RecAttendance=%d%s", $currentPage, min($totalPages_RecAttendance, $pageNum_RecAttendance + 1), $queryString_RecAttendance); ?>">Next</a>
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_RecAttendance < $totalPages_RecAttendance) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_RecAttendance=%d%s", $currentPage, $totalPages_RecAttendance, $queryString_RecAttendance); ?>">Last</a>
                          <?php } // Show if not last page ?></td>
                    </tr>
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
mysql_free_result($RecAttendance);
?>
