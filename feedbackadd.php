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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO feedback (feedback, name) VALUES (%s, %s)",
                       GetSQLValueString($_POST['txtmsg'], "text"),
                       GetSQLValueString($_POST['txtname'], "text"));

  mysqli_select_db($database_PTS, $PTS);
  $Result1 = mysqli_query($insertSQL, $PTS) or die(mysqli_error());
}

$maxRows_recfeedback = 10;
$pageNum_recfeedback = 0;
if (isset($_GET['pageNum_recfeedback'])) {
  $pageNum_recfeedback = $_GET['pageNum_recfeedback'];
}
$startRow_recfeedback = $pageNum_recfeedback * $maxRows_recfeedback;

mysqli_select_db($PTS, $database_PTS);
$query_recfeedback = "SELECT * FROM feedback ORDER BY feedback.id desc";
$query_limit_recfeedback = sprintf("%s LIMIT %d, %d", $query_recfeedback, $startRow_recfeedback, $maxRows_recfeedback);
$recfeedback = mysqli_query($PTS, $query_limit_recfeedback) or die(mysqli_error($PTS));
$row_recfeedback = mysqli_fetch_assoc($recfeedback);

if (isset($_GET['totalRows_recfeedback'])) {
  $totalRows_recfeedback = $_GET['totalRows_recfeedback'];
} else {
  $all_recfeedback = mysqli_query($query_recfeedback);
  $totalRows_recfeedback = mysqli_num_rows($all_recfeedback);
}
$totalPages_recfeedback = ceil($totalRows_recfeedback/$maxRows_recfeedback)-1;
?>
<?php require_once('header1.php')?>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
						
							<h2 class="section-heading animated" data-animation="bounceInUp">FEEDBACK</h2>
							
						
							</div>
						</div>
					</div>
				</div>
				<div class="row">
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="261" border="0" align="center">
    <tr>
      <td height="65" colspan="4">Name<span id="sprytextfield1">
        <label for="txtname"></label>
        <input type="text" name="txtname" id="txtname" class="form-control"/>
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td height="172" colspan="4"><textarea name="txtmsg" id="txtmsg" cols="45" rows="5" class="form-control"></textarea></td>
    </tr>
    <tr>
      <td width="15">&nbsp;</td>
      <td width="89">&nbsp;</td>
      <td width="97">&nbsp;</td>
      <td width="45"><input type="submit" name="txtsend" id="txtsend" value="Send" class="btn btn-info"/></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table border="0" class="table table-striped">
  
    <?php do { ?>
      <tr>
        <td>Name:<?php echo $row_recfeedback['name']; ?>
          </td>
      </tr>
      <tr>
        <td><p><?php echo $row_recfeedback['feedback']; ?></p></td>
      </tr>
    
      <?php } while ($row_recfeedback = mysqli_fetch_assoc($recfeedback)); ?>
  </table>
  <span id="sprytextarea1">
  <label for="txtmsg"></label>
  <span class="textareaRequiredMsg">A value is required.</span></span>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>
<?php
mysqli_free_result($recfeedback);
?>
