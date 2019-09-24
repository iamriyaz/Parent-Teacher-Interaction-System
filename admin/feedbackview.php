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

$maxRows_recfeedbackview = 10;
$pageNum_recfeedbackview = 0;
if (isset($_GET['pageNum_recfeedbackview'])) {
  $pageNum_recfeedbackview = $_GET['pageNum_recfeedbackview'];
}
$startRow_recfeedbackview = $pageNum_recfeedbackview * $maxRows_recfeedbackview;

mysqli_select_db($database_PTS, $PTS);
$query_recfeedbackview = "SELECT * FROM feedback ORDER BY feedback.id desc";
$query_limit_recfeedbackview = sprintf("%s LIMIT %d, %d", $query_recfeedbackview, $startRow_recfeedbackview, $maxRows_recfeedbackview);
$recfeedbackview = mysqli_query($query_limit_recfeedbackview, $PTS) or die(mysqli_error());
$row_recfeedbackview = mysqli_fetch_assoc($recfeedbackview);

if (isset($_GET['totalRows_recfeedbackview'])) {
  $totalRows_recfeedbackview = $_GET['totalRows_recfeedbackview'];
} else {
  $all_recfeedbackview = mysqli_query($query_recfeedbackview);
  $totalRows_recfeedbackview = mysqli_num_rows($all_recfeedbackview);
}
$totalPages_recfeedbackview = ceil($totalRows_recfeedbackview/$maxRows_recfeedbackview)-1;
?>
<?php require_once('header1.php')?>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
								<h2 class="section-heading animated" data-animation="bounceInUp">FEEDBACKS</h2>
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
  <span id="sprytextarea1">
  <label for="txtmsg"></label>
  <span class="textareaRequiredMsg">A value is required.</span></span>
</form>
<form id="form2" name="form2" method="post" action="">
  <table height="88" border="0" align="center" class="table table-striped">
    <?php 
	$c=1;
	
	 do { 
	 //Delete a record
	 if(isset($_POST['btnDelete'.$c]))
	 {
		 mysqli_query("delete from feedback where id=".$row_recfeedbackview['id'],$PTS);
		 header("location:".$_SERVER['PHP_SELF']);
	 } ?>
      <tr>
        <td width="229" height="84"><p>Name : <?php echo $row_recfeedbackview['name']; ?></p>
          <p><?php echo $row_recfeedbackview['feedback']; ?></p></td>
        <td width="144"><input type="submit" name="btnDelete<?php echo $c?>" id="btnDelete<?php echo $c?>" value="Delete" class="btn btn-primary"/></td>
      </tr>
      <?php 
	   $c++;
	 } while ($row_recfeedbackview = mysqli_fetch_assoc($recfeedbackview)); ?>
  </table>
</form>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
</script>
 </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>
<?php
mysqli_free_result($recfeedbackview);
?>
