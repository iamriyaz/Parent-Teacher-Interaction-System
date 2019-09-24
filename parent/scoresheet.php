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

$maxRows_RecScoresheet = 20;
$pageNum_RecScoresheet = 0;
if (isset($_GET['pageNum_RecScoresheet'])) {
  $pageNum_RecScoresheet = $_GET['pageNum_RecScoresheet'];
}
$startRow_RecScoresheet = $pageNum_RecScoresheet * $maxRows_RecScoresheet;

mysql_select_db($database_PTS, $PTS);
$query_RecScoresheet = "SELECT  `ID`, `RegNO`, scoresheet.`Subject`, `Mark`, `Grade`, `Teacher` ,`sub_code`, `sub_name`, subject.`standard` FROM scoresheet,subject WHERE subject.sub_code=scoresheet.Subject and  scoresheet.RegNO='$regno'";
$query_limit_RecScoresheet = sprintf("%s LIMIT %d, %d", $query_RecScoresheet, $startRow_RecScoresheet, $maxRows_RecScoresheet);
$RecScoresheet = mysql_query($query_limit_RecScoresheet, $PTS) or die(mysql_error());
$row_RecScoresheet = mysql_fetch_assoc($RecScoresheet);

if (isset($_GET['totalRows_RecScoresheet'])) {
  $totalRows_RecScoresheet = $_GET['totalRows_RecScoresheet'];
} else {
  $all_RecScoresheet = mysql_query($query_RecScoresheet);
  $totalRows_RecScoresheet = mysql_num_rows($all_RecScoresheet);
}
$totalPages_RecScoresheet = ceil($totalRows_RecScoresheet/$maxRows_RecScoresheet)-1;
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Score Sheet</h2>
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
                  <table border="1" cellpadding="5" cellspacing="5" class="table table-striped">
                    <thead style="background-color:#036;color:#FFF">
                    <tr>
                      <td>RegNO</td>
                      <td>Subject</td>
                      <td>Mark</td>
                      <td>Grade</td>
                    </tr>
                    </thead>
                    <?php do { ?>
                      <tr>
                        <td><?php echo $row_RecScoresheet['RegNO']; ?></td>
                        <td><?php echo $row_RecScoresheet['sub_name']; ?></td>
                        <td><?php echo $row_RecScoresheet['Mark']; ?></td>
                        <td><?php echo $row_RecScoresheet['Grade']; ?></td>
                      </tr>
                      <?php } while ($row_RecScoresheet = mysql_fetch_assoc($RecScoresheet)); ?>
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
mysql_free_result($RecScoresheet);
?>
