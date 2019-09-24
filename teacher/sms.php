<?php 
$phone="";
if(isset($_GET['phone']))
{
	$phone=$_GET['phone'];
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
if(isset($_POST['btnSubmit']))
{
$phonenum = $phone;
$message = $_POST['txtSMS'];
$debug = true;

ozekiSend($phonenum,$message,$debug);
$msg="SMS Sent !...";
}
?>


<?php require_once('header1.php')?>

 <script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
 <link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
 <?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
								<h2 class="section-heading animated" data-animation="bounceInUp">Compose</h2>
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
                
                  <form name="form1" method="post" action="">
                    <table border="0" cellspacing="15">
                      <tr>
                        <td>Phone No</td>
                        <td><?php echo $phone?>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>Message</td>
                        <td><span id="sprytextarea1">
                          <label for="txtSMS"></label>
                          <textarea name="txtSMS" id="txtSMS" cols="45" rows="5" class="form-control"></textarea>
                        <span class="textareaRequiredMsg">*required.</span></span></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td style="color:#F00"><?php echo $msg?></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Send" class="btn btn-primary"></td>
                      </tr>
                    </table>
                  </form>
                </div>
               	</div>	
		  </div>
					
  </div>
			
		</div>
</section>
	<!--/about-->
<?php require_once('footer.php')?>
<script>
var sprytextarea1=new Spry.Widget.ValidationTextarea("sprytextarea1");
</script>