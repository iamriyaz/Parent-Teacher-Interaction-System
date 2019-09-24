<?php require_once('Connections/PTS.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_escape_string($PTS, $theValue) : mysqli_real_escape_string($PTS, $theValue);

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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
$err="";
if (isset($_POST['txtuser'])) {
  $loginUsername=$_POST['txtuser'];
  $password=$_POST['txtpass'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "adminuserarea.php";
  $MM_redirectLoginFailed = "error.php";
  $MM_redirecttoReferrer = false;
  mysqli_select_db($PTS, $database_PTS);
  
  $LoginRS__query=sprintf("SELECT username, password FROM `admin` WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysqli_query($PTS, $LoginRS__query) or die(mysqli_error($PTS));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
$err="";
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    $err="Invalid Login !..";
  }
}


?>
<?php require_once('header1.php')?>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />

<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="../css/styles.css">

	

<?php require_once('header2.php')?>
<section id="section-about" style="background:url(../images/photo_bg.jpg)">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
						
							
							
						
							</div>
						</div>
					</div>
				</div>
                				<div class="row" >



                <div class="login-box animated fadeInUp">
			<div class="box-header">
				<h2>Log In</h2>
			</div>
				
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <table width="253" border="0" align="center">
    <tr>
      <td width="82">&nbsp;</td>
      <td width="161">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Username</td>
      <td><span id="sprytextfield1">
        <label for="txtuser"></label>
        <input type="text" name="txtuser" id="txtuser" class="form-control"/>
        <span class="textfieldRequiredMsg"> *required.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Password</td>
      <td><span id="sprypassword1">
        <label for="txtpass"></label>
        <input type="password" name="txtpass" id="txtpass" class="form-control" />
      <span class="passwordRequiredMsg">* required.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="color:#F00"><?php echo $err?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="center">
        <button type="submit" name="btnlogin" id="btnlogin" value="Log In"> Log in</button>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
</script>
</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>