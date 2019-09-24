<?php require_once('../Connections/PTS.php'); ?>
<?php 
@set_magic_quotes_runtime(false);
ini_set('magic_quotes_runtime', 0);
require_once("../class.phpmailer.php");

define('GUSER','username@gmail.com'); // GMail username
define('GPWD', 'password'); // GMail password
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
$error="";
if(isset($_POST['btn1']))
{
	 mysql_select_db($database_PTS, $PTS);
	 $result=mysql_query("select password from teacher where username='".$_POST['txtuser']."' and e_mail='".$_POST['txtemail']."'",$PTS);
	 if(mysql_num_rows($result))
	{
		$rec=mysql_fetch_assoc($result);
		$pwd=$rec['password'];
		 $subj = 'Forgot Password';
			$to =$_POST['txtemail'] ;
			$from = 'Userid@gmail.com';
			$name = 'PTS';
			$msg="Your Password is :".$pwd." Please Login and continue....<br>Thank You!...";
			if (smtpmailer($to, $from, $name, $subj, $msg)) {
			$error="Please check your mail";
			} else {
				if (!smtpmailer($to, $from, $name, $subj, $msg, false)) {
					if (!empty($error)) echo $error;
				}
			}
		}
	}


?>
<?php require_once('header1.php')?>

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
						
							<h2 class="section-heading animated" data-animation="bounceInUp">Forgot Password</h2>
							
						
							</div>
						</div>
					</div>
				</div>
				<div class="row">
                
<form id="form1" name="form1" method="post" action="">
  <table width="339" border="0" align="center">
    <tr>
      <td>Username</td>
      <td><span id="sprytextfield1">
        <label for="txtuser"></label>
        <input type="text" name="txtuser" id="txtuser" class="form-control"/>
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>E-Mail </td>
      <td><span id="txtemail">
        <label for="txtemail"></label>
        <input type="text" name="txtemail" id="txtemail" class="form-control"/>
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><div align="center">
        <input type="submit" name="btn1" id="btn1" value="Send Code" class="btn btn-primary"/>
      </div></td>
    </tr>
    <tr>
      <td><?php echo $error ?>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>