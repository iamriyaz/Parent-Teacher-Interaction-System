<?php require_once('../Connections/PTS.php'); ?>
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
$grpmsg="";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")&&(isset($_REQUEST['btnsend']))) {
	  mysqli_select_db($database_PTS, $PTS);

	if($_POST['txtto']=="Parent")
	{
		$result=mysqli_query("select username from parent where verified=1",$PTS) or die(mysqli_error($PTS));
		while($rec=mysqli_fetch_assoc($result))
		{
			 $insertSQL = sprintf("INSERT INTO groupmsg (sub, msg, `from`, `to`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtSubject'], "text"),
                       GetSQLValueString($_POST['txtmsg'], "text"),
                       GetSQLValueString("Prinicipal", "text"),
                       GetSQLValueString($rec['username'], "text"));


  $Result1 = mysqli_query($insertSQL, $PTS) or die(mysqli_error());
		}
	}
	if($_POST['txtto']=="Teacher")
	{
		$result=mysqli_query("select username from teacher",$PTS) or die(mysqli_error($PTS));
		while($rec=mysqli_fetch_assoc($result))
		{
			 $insertSQL = sprintf("INSERT INTO groupmsg (sub, msg, `from`, `to`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtSubject'], "text"),
                       GetSQLValueString($_POST['txtmsg'], "text"),
                       GetSQLValueString("Prinicipal", "text"),
                       GetSQLValueString($rec['username'], "text"));


  $Result1 = mysqli_query($insertSQL, $PTS) or die(mysqli_error());
		}
	}
 $grpmsg="Message sent !..";
}

########################################################
# Login information for the SMS Gateway
########################################################

$ozeki_user = "admin";
$ozeki_password = "ptis2018";
$ozeki_url = "http://127.0.0.1:9501/api?";

########################################################
# Functions used to send the SMS message
########################################################
function httpRequest($url){
    $pattern = "/http...([0-9a-zA-Z-.]*).([0-9]*).(.*)/";
    preg_match($pattern,$url,$args);
    $in = "";
    $fp = fsockopen("$args[1]", $args[2], $errno, $errstr, 30);
    if (!$fp) {
       return("$errstr ($errno)");
    } else {
        $out = "GET /$args[3] HTTP/1.1\r\n";
        $out .= "Host: $args[1]:$args[2]\r\n";
        $out .= "User-agent: Ozeki PHP client\r\n";
        $out .= "Accept: */*\r\n";
        $out .= "Connection: Close\r\n\r\n";

        fwrite($fp, $out);
        while (!feof($fp)) {
           $in.=fgets($fp, 128);
        }
    }
    fclose($fp);
    return($in);
}



function ozekiSend($phone, $msg, $debug=false){
      global $ozeki_user,$ozeki_password,$ozeki_url;

      $url = 'username='.$ozeki_user;
      $url.= '&password='.$ozeki_password;
      $url.= '&action=sendmessage';
      $url.= '&messagetype=SMS:TEXT';
      $url.= '&recipient='.urlencode($phone);
      $url.= '&messagedata='.urlencode($msg);

      $urltouse =  $ozeki_url.$url;
      if ($debug) { echo "Request: <br>$urltouse<br><br>"; }

      //Open the URL to send the message
      $response = httpRequest($urltouse);
      if ($debug) {
           echo "Response: <br><pre>".
           str_replace(array("<",">"),array("&lt;","&gt;"),$response).
           "</pre><br>"; }

      return($response);
}

########################################################
# GET data from sms.php
########################################################
$msg="";
if(isset($_POST['btnSent']))
{
	if($_POST['txtto']=="Parent")
	{
	
	  $query="select phone_no from parent";
  $Result = mysqli_query($query, $PTS) or die(mysqli_error());
  while($rec=mysqli_fetch_assoc($Result))
  {
$phonenum = $rec['phone_no'];
$message = $_POST['txtmsg'];
$debug = true;

ozekiSend($phonenum,$message,$debug);
  }
	}
	if($_POST['txtto']=="Teacher")
	{
	
	  $query="select phone_no from teacher";
  $Result = mysqli_query($query, $PTS) or die(mysqli_error());
  while($rec=mysqli_fetch_assoc($Result))
  {
$phonenum = $rec['phone_no'];
$message = $_POST['txtmsg'];
$debug = true;

ozekiSend($phonenum,$message,$debug);
  }
	}
$msg="SMS Sent !...";
}
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Sent Message</h2>
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
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>To</td>
      <td><label for="txtto"></label>
        <select name="txtto" id="txtto" class="form-control">
          <option value="Parent">Parent</option>
          <option value="Teacher">Teacher</option>
      </select></td>
    </tr>
    <tr>
      <td>Subject</td>
      <td><label for="txtSubject"></label>
        <input type="text" name="txtSubject" id="txtSubject"  class="form-control"></td>
    </tr>
    <tr>
      <td>Message</td>
      <td><label for="txtmsg"></label>
      <textarea name="txtmsg" id="txtmsg" cols="45" rows="5"  class="form-control"></textarea></td>
    </tr>
    <tr>
      <td style="color:#00F"><?php echo $msg?></td>
      <td style="color:#00F"><?php echo $grpmsg?></td>
    </tr>
    <tr>
      <td><input type="submit" name="btnSent" id="btnSent" value="Sent SMS" class="btn btn-primary"></td>
      <td><input type="submit" name="btnsend" id="btnsend" value="Send" class="btn btn-primary"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
 </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>