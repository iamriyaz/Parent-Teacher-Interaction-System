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
$error="";
if (isset($_POST['txt1'])) {
  $loginUsername=$_POST['txt1'];
  $password=$_POST['txt2'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "teacheruserarea.php";
  $MM_redirectLoginFailed = "teacherlogin.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_PTS, $PTS);
  
  $LoginRS__query=sprintf("SELECT faculty_no,username, password FROM teacher WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $PTS) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
 $facultyno=0;
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
	$rec=mysql_fetch_assoc($LoginRS);
	$facultyno=$rec['faculty_no'] ;
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
	$_SESSION['FACULTYNO']=$facultyno;
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
	$error="";
  }
  else {
    $error="Invalid login !...";
  }
}
?>
<?php require_once('header1.php')?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
  <table width="300" border="0" align="center">
    <tr>
      <td width="104">Username</td>
      <td width="180"><label for="txtuser"><span id="sprytextfield1">
        <input type="text" name="txt1" id="txt1" class="form-control"/>
        <span class="textfieldRequiredMsg">*required.</span></span></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Password</td>
      <td><label for="txtpass"><span id="sprytextfield2">
        <input type="password" name="txt2" id="txt2" class="form-control"/>
      <span class="textfieldRequiredMsg">*required.</span></span></label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" style="color:#F00"><?php echo $error?></td>
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
      <td><div align="center"><a href="forgotpassword1.php">Forgot Password..?</a></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="center"></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  </div>
	</div>
    
    
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
<script>
	$(document).ready(function () {
    	$('#logo').addClass('animated fadeInDown');
    	$("input:text:visible:first").focus();
	});
	$('#username').focus(function() {
		$('label[for="username"]').addClass('selected');
	});
	$('#username').blur(function() {
		$('label[for="username"]').removeClass('selected');
	});
	$('#password').focus(function() {
		$('label[for="password"]').addClass('selected');
	});
	$('#password').blur(function() {
		$('label[for="password"]').removeClass('selected');
	});
</script>



					</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>