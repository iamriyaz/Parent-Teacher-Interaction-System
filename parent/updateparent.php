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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE parent SET first_name=%s, last_name=%s, address=%s, phone_no=%s, e_mail=%s, relation=%s, gender=%s, occupation=%s  WHERE username=%s",
                      
                       GetSQLValueString($_POST['first_name'], "text"),
                       GetSQLValueString($_POST['last_name'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['phone_no'], "text"),
                       GetSQLValueString($_POST['e_mail'], "text"),
                       GetSQLValueString($_POST['relation'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['occupation'], "text"),
                      GetSQLValueString($_POST['username'], "text"));

  mysql_select_db($database_PTS, $PTS);
  $Result1 = mysql_query($updateSQL, $PTS) or die(mysql_error());

  $updateGoTo = "parentuserarea.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_PTS, $PTS);
$query_Recupdateparent = "SELECT * FROM parent WHERE parent.username='$username'";
$Recupdateparent = mysql_query($query_Recupdateparent, $PTS) or die(mysql_error());
$row_Recupdateparent = mysql_fetch_assoc($Recupdateparent);
$totalRows_Recupdateparent = mysql_num_rows($Recupdateparent);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Update Profile</h2>
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
</form>
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">First_name:</td>
      <td><input type="text" name="first_name" value="<?php echo htmlentities($row_Recupdateparent['first_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Last_name:</td>
      <td><input type="text" name="last_name" value="<?php echo htmlentities($row_Recupdateparent['last_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"  /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Address:</td>
      <td><input type="text" name="address" value="<?php echo htmlentities($row_Recupdateparent['address'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"  /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Phone_no:</td>
      <td><input type="text" name="phone_no" value="<?php echo htmlentities($row_Recupdateparent['phone_no'], ENT_COMPAT, 'utf-8'); ?>" size="32"  class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">E_mail:</td>
      <td><input type="text" name="e_mail" value="<?php echo htmlentities($row_Recupdateparent['e_mail'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Relation:</td>
      <td><input type="text" name="relation" value="<?php echo htmlentities($row_Recupdateparent['relation'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control"  /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Gender:</td>
      <td><input type="text" name="gender" value="<?php echo htmlentities($row_Recupdateparent['gender'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Occupation:</td>
      <td><input type="text" name="occupation" value="<?php echo htmlentities($row_Recupdateparent['occupation'], ENT_COMPAT, 'utf-8'); ?>" size="32" class="form-control" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Username:</td>
      <td><?php echo $row_Recupdateparent['username']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Save Changes" class="btn btn-primary"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form2" />
  <input type="hidden" name="username" value="<?php echo $row_Recupdateparent['username']; ?>" />
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
mysql_free_result($Recupdateparent);
?>
