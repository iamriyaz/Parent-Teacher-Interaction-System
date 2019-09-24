<?php require_once('Connections/PTS.php'); ?>
<?php

if (!isset($_SESSION)) {
  session_start();
}
$username="";
$facno=0;
if(isset($_SESSION['MM_Username']))
{
	$username=$_SESSION['MM_Username'];
	$facno=$_SESSION['FACULTYNO'];
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
  $insertSQL = sprintf("INSERT INTO groupmsg (sub, msg, `from`, `to`,division) VALUES (%s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['txtSub'], "text"),
                       GetSQLValueString($_POST['txtmsg'], "text"),
                       GetSQLValueString($username, "text"),
                       GetSQLValueString($_POST['txtmsgclass'], "text"),
					   GetSQLValueString($_POST['txtdiv'],"text"));

  mysqli_select_db($database_PTS, $PTS);
  $Result1 = mysqli_query($insertSQL, $PTS) or die(mysqli_error());
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
	  mysqli_select_db($database_PTS, $PTS);
	  $query="select phone_no from parent where username in(select parent_username from student where standard=".$_REQUEST['txtmsgclass']." and division='".$_POST['txtdiv']."')";
  $Result = mysqli_query($query, $PTS) or die(mysqli_error());
  while($rec=mysqli_fetch_assoc($Result))
  {
$phonenum = $rec['phone_no'];
$message = $_POST['txtmsg'];
$debug = true;

ozekiSend($phonenum,$message,$debug);
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
                <?php require_once('teachermenu.php')?>
                </div>
                <div class="col-lg-10 ">
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table height="176" border="0" align="center">
    <tr>
      <td width="21">STD</td>
      <td width="325"><label for="txtmsgclass"></label>
        &nbsp;
        <select name="txtmsgclass" id="txtmsgclass" class="form-control">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          </select>
        &nbsp;
        <select name="txtdiv" id="txtdiv" class="form-control">
          <option>Select Division</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
          <option value="F">F</option>
          <option value="G">G</option>
          <option value="H">H</option>
          </select></td>
    </tr>
    <tr>
      <td>Subject</td>
      <td><label for="txtSub"></label>
      <input type="text" name="txtSub" id="txtSub" class="form-control"/></td>
    </tr>
    <tr>
      <td colspan="2"><label for="txtmsg"></label>
        <label for="txtmsg"></label>
      <textarea name="txtmsg" id="txtmsg" cols="45" rows="5" class="form-control"></textarea></td>
    </tr>
    <tr>
      <td style="color:#00F"><?php echo $msg?></td>
      <td style="color:#00f"><?php  echo $grpmsg?>&nbsp;</td>
    </tr>
    <tr>
      <td><input type="submit" name="btnSent" id="btnSent" value="Sent SMS" class="btn btn-primary"></td>
      <td><input type="submit" name="btnsend" id="btnsend" value="Send" class="btn btn-primary"/></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
  <p>&nbsp;</p>
</form>
 </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>