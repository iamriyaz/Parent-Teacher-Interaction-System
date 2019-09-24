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
if (isset($_POST['txt1'])) {
  $loginUsername=$_POST['txt1'];
  $password=$_POST['txt2'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "parentuserarea.php";
  $MM_redirectLoginFailed = "error.php";
  $MM_redirecttoReferrer = false;
  mysqli_select_db($database_PTS, $PTS);
  
  $LoginRS__query=sprintf("SELECT Ration_card_no,username, password FROM parent WHERE username=%s AND password=%s and verified=1",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysqli_query($LoginRS__query, $PTS) or die(mysqli_error());
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    $rec=mysqli_fetch_assoc($LoginRS);
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
	
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
	$_SESSION['CNO']=$rec['Ration_card_no'];
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	 $err="";
    header("Location: " . $MM_redirectLoginSuccess );
	
  }
  else {
   // header("Location: ". $MM_redirectLoginFailed );
   $err="Invalid Login !..";
  }
}

	
		
?>
<?php require_once('header1.php')?>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />

<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="../css/styles.css">

	
<script>
function reg()
{
	window.location="parentsinup.php";
}
</script>
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
  <table width="300" border="0" align="center">
   
    <tr>
      <td width="104">&nbsp;</td>
      <td width="180">&nbsp;</td>
    </tr>
    <tr>
      <td>Username</td>
      <td>
      <label for="txtuser">
        <input type="text" name="txt1" id="txt1" class="form-control"/>
     </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Password</td>
      <td><span id="sprypassword1">
        <label for="txt2"></label>
        <input type="password" name="txt2" id="txt2" class="form-control" />
      <span class="passwordRequiredMsg">*required.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="color:#F00"><?php echo $err?></td>
    </tr>
    <tr>
      <td><div align="center"></div></td>
      <td><div align="center">
        <button type="submit" name="btn1" id="btn1" value="Log In">Log in</button>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="center">
        <button type="button" name="btn3" id="btn3" value="Sign Up" onClick="reg();">Sign up</button>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="center"><a href="forgotpassword1.php">Forgot Password..?</a></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<script type="text/javascript">
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
</script>
  
					</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>