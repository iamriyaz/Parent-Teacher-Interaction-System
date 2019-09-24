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


$v="";
if(isset($_GET['regno']))
{
	$v=$_GET['regno'];
}

$maxRows_recattendance1 = 10;
$pageNum_recattendance1 = 0;
if (isset($_GET['pageNum_recattendance1'])) {
  $pageNum_recattendance1 = $_GET['pageNum_recattendance1'];
}
$startRow_recattendance1 = $pageNum_recattendance1 * $maxRows_recattendance1;

mysqli_select_db($database_PTS, $PTS);
$query_recattendance1 = "SELECT * FROM attendance WHERE attendance.regno='$v'";
$query_limit_recattendance1 = sprintf("%s LIMIT %d, %d", $query_recattendance1, $startRow_recattendance1, $maxRows_recattendance1);
$recattendance1 = mysqli_query($query_limit_recattendance1, $PTS) or die(mysqli_error());
$row_recattendance1 = mysqli_fetch_assoc($recattendance1);

if (isset($_GET['totalRows_recattendance1'])) {
  $totalRows_recattendance1 = $_GET['totalRows_recattendance1'];
} else {
  $all_recattendance1 = mysqli_query($query_recattendance1);
  $totalRows_recattendance1 = mysqli_num_rows($all_recattendance1);
}
$totalPages_recattendance1 = ceil($totalRows_recattendance1/$maxRows_recattendance1)-1;
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
                <?php require_once('teachermenu.php')?>
                </div>
                <div class="col-lg-10 "><form id="form1" name="form1" method="post" action="">
  <table border="0" class="table table-striped">
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
        <td><?php echo $row_recattendance1['regno']; ?></td>
        <td><?php echo $row_recattendance1['date']; ?></td>
        <td><?php echo $row_recattendance1['status']; ?></td>
        <td><?php echo $row_recattendance1['performance']; ?></td>
      </tr>
      <?php } while ($row_recattendance1 = mysqli_fetch_assoc($recattendance1)); ?>
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
mysqli_free_result($recattendance1);
?>
