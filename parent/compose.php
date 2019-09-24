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

$std=$div="";
if(isset($_GET['std']))
{
	$std=$_GET['std'];
	$div=$_GET['div'];
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$teacher="";
 mysqli_select_db($database_PTS, $PTS);
  $query=mysqli_query("select username from teacher where is_class_teacher=1 and standard=$std and division='$div'",$PTS);
  if(mysqli_num_rows($query))
  {
	  $rec=mysqli_fetch_assoc($query);
	  $teacher=$rec['username'];
  }
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
 
  $insertSQL = sprintf("INSERT INTO chats (from_user, recipient, message) VALUES (%s, %s, %s)",
                       GetSQLValueString($username, "text"),
                       GetSQLValueString($_POST['txtrecipient'], "text"),
                       GetSQLValueString($_POST['txtmsg'], "text"));


  $Result1 = mysqli_query($insertSQL, $PTS) or die(mysqli_error());
}

$maxRows_recsent = 10;
$pageNum_recsent = 0;
if (isset($_GET['pageNum_recsent'])) {
  $pageNum_recsent = $_GET['pageNum_recsent'];
}
$startRow_recsent = $pageNum_recsent * $maxRows_recsent;

mysqli_select_db($database_PTS, $PTS);
$query_recsent = "SELECT * FROM chats WHERE chats.from_user='$username'";
$query_limit_recsent = sprintf("%s LIMIT %d, %d", $query_recsent, $startRow_recsent, $maxRows_recsent);
$recsent = mysqli_query($query_limit_recsent, $PTS) or die(mysqli_error());
$row_recsent = mysqli_fetch_assoc($recsent);

if (isset($_GET['totalRows_recsent'])) {
  $totalRows_recsent = $_GET['totalRows_recsent'];
} else {
  $all_recsent = mysqli_query($query_recsent);
  $totalRows_recsent = mysqli_num_rows($all_recsent);
}
$totalPages_recsent = ceil($totalRows_recsent/$maxRows_recsent)-1;
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Compose</h2>
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
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="476" height="218" border="0" align="center">
    <tr>
      <td width="74">&nbsp;</td>
      <td width="376">&nbsp;</td>
      <td width="12">&nbsp;</td>
    </tr>
    <tr>
      <td>Recipient</td>
      <td colspan="2"><label for="txtrecipient"></label>
      <input type="text" name="txtrecipient" id="txtrecipient" value="<?php echo $teacher?>" class="form-control"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Message</td>
      <td><label for="txtmsg"></label>
      <textarea name="txtmsg" id="txtmsg" cols="45" rows="5" class="form-control"></textarea></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td><input type="submit" name="btnsend" id="btnsend" value="Send" class="btn btn-primary"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="21">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<form name="form2" method="post" action="">
  <table cellpadding="5" cellspacing="5" class="table table-condensed">
    <?php
	$c=1;
	 do { 
	 //Delete a record
	 if(isset($_POST['btnDelete'.$c]))
	 {
		 mysqli_query("delete from chats where id=".$row_recsent['id'],$PTS) or die(mysqli_error($PTS));
		 header("location:".$_SERVER['PHP_SELF']);
	 }
	 
	 ?>
      <tr>
        <td>Recipient</td>
        <td>:<?php echo $row_recsent['recipient']; ?></td>
        <td><input type="submit" name="btnDelete<?php echo $c?>" id="btnDelete<?php echo $c?>" value="Delete"></td>
        </tr>
      <tr>
        <td>Subject</td>
        <td>:<?php echo $row_recsent['subject']; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">:<p align="justify"><?php echo $row_recsent['message']; ?></p></td>
        </tr>
      <?php
	  $c++;
	   } while ($row_recsent = mysqli_fetch_assoc($recsent)); ?>
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
<?php
mysqli_free_result($recsent);
?>
