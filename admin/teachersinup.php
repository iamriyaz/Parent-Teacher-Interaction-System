<?php require_once('Connections/PTS.php'); ?>
<?php 
@set_magic_quotes_runtime(false);
ini_set('magic_quotes_runtime', 0);
require_once("class.phpmailer.php");

define('GUSER','ptisofficial123@gmail.com'); // GMail username
define('GPWD', 'ptisofficial**'); // GMail password
function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->Debugoutput='html';
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$msg="";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO teacher (faculty_no, first_name, last_name, address, phone_no, e_mail, experience, qualification, gender, is_class_teacher, standard, division, username, password, subject) VALUES (%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
  						
                       GetSQLValueString($_POST['txtfacno'], "int"),
                       GetSQLValueString($_POST['txtfname'], "text"),
                       GetSQLValueString($_POST['txtlname'], "text"),
                       GetSQLValueString($_POST['txtaddress'], "text"),
                       GetSQLValueString($_POST['txtphone'], "text"),
                       GetSQLValueString($_POST['txtmail'], "text"),
                       GetSQLValueString($_POST['txtexp'], "int"),
                       GetSQLValueString($_POST['txtqual'], "text"),
                       GetSQLValueString($_POST['txtgen'], "text"),
                       GetSQLValueString($_POST['txtif'], "int"),
                       GetSQLValueString($_POST['txtclass'], "int"),
                       GetSQLValueString($_POST['txtdiv'], "text"),
                       GetSQLValueString($_POST['txtuser'], "text"),
                       GetSQLValueString($_POST['txtpass'], "text"),
                       GetSQLValueString($_POST['txtsubject'], "text"));

  mysql_select_db($database_PTS, $PTS);
  $Result1 = mysql_query($insertSQL, $PTS) or die(mysql_error($PTS));
$subj = 'Registration';
$to =$_POST['txtmail'];
$from = 'ptisofficial123@gmail.com';
$name = 'Parent Teacher Integration System';
$msg="Hai,Your username is ".$_POST['txtuser']." and  password is ".$_POST['txtpass'].".Please login and continue..";

if (smtpmailer($to, $from, $name, $subj, $msg)) {
	echo "send";
} else {
	if (!smtpmailer($to, $from, $name, $subj, $msg, false)) {
		if (!empty($error)) echo $error;
	
}
}

  $msg="Account successfully created..";
}
?>
<?php require_once('header1.php')?>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<script>
function subject()
{
	var cid=$('#txtclass').val();
	//var cid=document.getElementById('txtclass').value;
	
 	$.get("subject.php?cmd="+cid,"",function(data){
		$('#txtsubject').html(data);
	});
}
function check()
{
	if(document.getElementById('txtpass').value.length<6)
	{
		 document.getElementById('hr1').style.width="50px";
		 document.getElementById('hr1').style.backgroundColor="red";
	}
	if(document.getElementById('txtpass').value.length>=6&&document.getElementById('txtpass').value.length<10)
	 {
		 document.getElementById('hr1').style.width="100px";
		 document.getElementById('hr1').style.backgroundColor="green";
	 }
}
</script>
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
								<h2 class="section-heading animated" data-animation="bounceInUp">Teacher Registration</h2>
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

<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table border="0" align="center">
    <tr>
      <td>&nbsp;</td>
      <td colspan="3" style="color:#F00"><?php  echo $msg?></td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>First Name</td>
      <td><span id="sprytextfield1">
        <label for="txtfname"></label>
        <input type="text" name="txtfname" class="form-control" id="txtfname" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>Class</td>
      <td><label for="txtclass"></label>
        <input type="text" class="form-control" name="txtclass" id="txtclass" onchange="subject();"/></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>Last Name</td>
      <td><span id="sprytextfield2">
        <label for="txtlname"></label>
        <input name="txtlname" type="text" class="form-control" id="txtlname" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>Division</td>
      <td><label for="txtdiv"></label>
        <input type="text" name="txtdiv" class="form-control" id="txtdiv" /></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Subjects</td>
      <td><span id="spryselect3">
        <label for="txtsubject"></label>
        <select name="txtsubject" id="txtsubject" class="form-control">
          </select>
        <span class="selectRequiredMsg">Please select an item.</span></span>&nbsp;</td>
      </tr>
    <tr>
      <td>Facuality No </td>
      <td><span id="sprytextfield3">
        <label for="txtfacno"></label>
        <input type="text" name="txtfacno" class="form-control" id="txtfacno" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>Username</td>
      <td><span id="sprytextfield9">
        <label for="txtuser"></label>
        <input type="text" name="txtuser" class="form-control" id="txtuser" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      </tr>
    <tr>
      <td rowspan="4">Address</td>
      <td rowspan="4"><span id="sprytextarea1">
        <label for="txtaddress"></label>
        <textarea name="txtaddress" class="form-control" id="txtaddress" cols="45" rows="5"></textarea>
      <span class="textareaRequiredMsg">A value is required.</span></span></td>
      <td rowspan="4">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>Password</td>
      <td><span id="sprypassword1">
      <label for="txtpass"></label>
      <input type="password" class="form-control" name="txtpass" id="txtpass" onChange="check();" /><div  id="hr1">&nbsp;</div>
      <span class="passwordRequiredMsg">A value is required.</span><span class="passwordMinCharsMsg">Minimum number of characters not met.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Confirm Password</td>
      <td><span id="spryconfirm1">
        <label for="txtconpass"></label>
        <input type="password" class="form-control" name="txtconpass" id="txtconpass" />
      <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">The values don't match.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>Phone</td>
      <td><span id="sprytextfield4">
      <label for="txtphone"></label>
      <input type="text" class="form-control" name="txtphone" id="txtphone" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>E-Mail</td>
      <td><span id="sprytextfield5">
      <label for="txtmail"></label>
      <input type="text" class="form-control" name="txtmail" id="txtmail" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>Experience</td>
      <td><span id="sprytextfield6">
        <label for="txtexp"></label>
        <input type="text" class="form-control" name="txtexp" id="txtexp" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>Qualification</td>
      <td><span id="sprytextarea2">
        <label for="txtqual"></label>
        <textarea name="txtqual" class="form-control" id="txtqual" cols="45" rows="5"></textarea>
      <span class="textareaRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>Gender</td>
      <td><span id="spryselect1">
        <label for="txtgen"></label>
        <select name="txtgen" id="txtgen">
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>Is Class Teacher</td>
      <td><span id="spryselect2">
        <label for="txtif"></label>
        <select name="txtif" id="txtif">
          <option value="1">Yes</option>
          <option value="0">No</option>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2"></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnsinup" class="btn btn-danger" id="btnsinup" value="Sin Up" /></td>
      <td><input type="submit" name="btncancel" class="btn btn-info" id="btncancel" value="Cancel" /></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
  </table>
  </div>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "phone_number", {format:"phone_custom", pattern:"0000000000"});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "email");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");

var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:6, validateOn:["change"]});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "txtpass");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
</script>
 </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>