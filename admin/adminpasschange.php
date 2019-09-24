<?php require_once('Connections/PTS.php'); ?>
<?php


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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$err="";
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	mysql_select_db($database_PTS, $PTS);
$query_recchangepass = "SELECT * FROM admin WHERE username='$username' and password='".$_POST['txtpass1']."'";
$recchangepass = mysql_query($query_recchangepass, $PTS) or die(mysql_error());
$row_recchangepass = mysql_fetch_assoc($recchangepass);
$totalRows_recchangepass = mysql_num_rows($recchangepass);

	if($totalRows_recchangepass)
	{
  $updateSQL = sprintf("UPDATE admin SET  password=%s WHERE username=%s",
                       
                       GetSQLValueString($_POST['txtpass3'], "text"),
                       GetSQLValueString($username, "text"));

  mysql_select_db($database_PTS, $PTS);
  $Result1 = mysql_query($updateSQL, $PTS) or die(mysql_error());

  $updateGoTo = "logout.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
	}
	else
	{
		$err="Password not changes !...";
	}
}

?>
<?php require_once('header1.php')?>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
								<h2 class="section-heading animated" data-animation="bounceInUp">CHANGE PASSWORD</h2>
							</div>
                          </div>
                        </div>
                      <?php require_once('log.php')?> 
				</div>
				<div class="row">
                <div class="col-lg-2">
                <?php require_once('adminmenu.php')?>
                </div>
                <div class="col-lg-10 "><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="354" border="0" align="center">
    <tr>
      <td width="178" height="34">Old Password</td>
      <td width="166"><span id="sprypassword1">
        <label for="txtpass2"></label>
        <input type="password" name="txtpass1" id="txtpass2" class="form-control"/>
        <span class="passwordRequiredMsg">* required.</span></span></td>
    </tr>
    <tr>
      <td height="31">New Password</td>
      <td><span id="sprypassword2">
        <label for="txtpass3"></label>
        <input type="password" name="txtpass2" id="txtpass3" class="form-control"/>
      <span class="passwordRequiredMsg">* required.</span></span></td>
    </tr>
    <tr>
      <td height="29">Re-Enter Password</td>
      <td><span id="spryconfirm1">
        <label for="txtpass4"></label>
        <input type="password" name="txtpass3" id="txtpass4" class="form-control"/>
      <span class="confirmRequiredMsg">* required.</span><span class="confirmInvalidMsg">Password don't match.</span></span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btnsubmit" id="btnsubmit" value="Submit" class="btn btn-primary" />
      </div></td>
    </tr>
    <tr>
      <td colspan="2"><font color="#FF0000"><?php echo $err?></font></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
</form>
<script type="text/javascript">
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
var sprypassword2 = new Spry.Widget.ValidationPassword("sprypassword2");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "txtpass3");
</script>
  </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>