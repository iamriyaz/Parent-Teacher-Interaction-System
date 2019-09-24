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
if(
isset($_GET['scode']))
{
	$v=$_GET['scode'];
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE subject SET sub_name=%s, standard=%s WHERE sub_code=%s",
                       GetSQLValueString($_POST['sub_name'], "text"),
                       GetSQLValueString($_POST['standard'], "int"),
                       GetSQLValueString($_POST['sub_code'], "int"));

  mysqli_select_db($database_PTS, $PTS);
  $Result1 = mysqli_query($updateSQL, $PTS) or die(mysqli_error());

  $updateGoTo = "subjectclass.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysqli_select_db($database_PTS, $PTS);
$query_Receditsub = "SELECT * FROM subject WHERE sub_code=$v";
$Receditsub = mysqli_query($query_Receditsub, $PTS) or die(mysqli_error());
$row_Receditsub = mysqli_fetch_assoc($Receditsub);
$totalRows_Receditsub = mysqli_num_rows($Receditsub);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">EDIT SUBJECTS</h2>
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
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sub_code:</td>
      <td><?php echo $row_Receditsub['sub_code']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sub_name:</td>
      <td><input type="text" name="sub_name" value="<?php echo htmlentities($row_Receditsub['sub_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Standard:</td>
      <td><input type="text" name="standard" value="<?php echo htmlentities($row_Receditsub['standard'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" class="btn btn-primary"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2" />
  <input type="hidden" name="sub_code" value="<?php echo $row_Receditsub['sub_code']; ?>" />
</form>
<p>&nbsp;</p>
    </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>
<?php
mysqli_free_result($Receditsub);
?>
