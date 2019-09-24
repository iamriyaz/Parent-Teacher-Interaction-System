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

$maxRows_recevent1 = 10;
$pageNum_recevent1 = 0;
if (isset($_GET['pageNum_recevent1'])) {
  $pageNum_recevent1 = $_GET['pageNum_recevent1'];
}
$startRow_recevent1 = $pageNum_recevent1 * $maxRows_recevent1;

mysqli_select_db($database_PTS, $PTS);
$query_recevent1 = "SELECT * FROM event ORDER BY event.id desc";
$query_limit_recevent1 = sprintf("%s LIMIT %d, %d", $query_recevent1, $startRow_recevent1, $maxRows_recevent1);
$recevent1 = mysqli_query($query_limit_recevent1, $PTS) or die(mysqli_error());
$row_recevent1 = mysqli_fetch_assoc($recevent1);

if (isset($_GET['totalRows_recevent1'])) {
  $totalRows_recevent1 = $_GET['totalRows_recevent1'];
} else {
  $all_recevent1 = mysqli_query($query_recevent1);
  $totalRows_recevent1 = mysqli_num_rows($all_recevent1);
}
$totalPages_recevent1 = ceil($totalRows_recevent1/$maxRows_recevent1)-1;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$error="";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1"))
 {
	 if($_FILES['fileevent']['size']>0 && $_FILES['fileevent']['type']=="image/jpeg")
	 {
		 move_uploaded_file($_FILES['fileevent']['tmp_name'],getcwd()."/event/".$_FILES['fileevent']['name']);
  $insertSQL = sprintf("INSERT INTO event (caption, `date`, `description`, photo) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['txtcaption'], "text"),
                       GetSQLValueString($_POST['txtdate'], "date"),
                       GetSQLValueString($_POST['txtdis'], "text"),
                       GetSQLValueString($_FILES['fileevent']['name'], "text"));

  mysqli_select_db($database_PTS, $PTS);
  $Result1 = mysqli_query($insertSQL, $PTS) or die(mysqli_error());

  $insertGoTo = "eventsadd.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
else
{
	$error="please choose jpeg file";
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
								<h2 class="section-heading animated" data-animation="bounceInUp">EVENTS</h2>
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
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="183" height="271" border="0" align="center">
    <tr>
      <td width="29">Caption</td>
      <td width="83"><input type="text" name="txtcaption" id="txtcaption" class="form-control"/></td>
      <td width="57">&nbsp;</td>
    </tr>
    <tr>
      <td>Decription</td>
      <td><textarea name="txtdis" id="txtdis" cols="45" rows="5" class="form-control"></textarea></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Date</td>
      <td><span id="sprytextfield1">
      <label for="txtdate"></label>
      <input type="date" name="txtdate" id="txtdate" class="form-control"/>
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Choose Photo</td>
      <td><input type="file" name="fileevent" id="fileevent" /><font color="#FF0000"><?php echo $error?></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnupload" id="btnupload" value="Upload" class="btn btn-primary"/></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
</form>
<form id="form2" name="form2" method="post" action="">
  <div align="center">
    <table border="0" class="table table-striped">
    
      <?php
	   $c=1;
	
	 do { 
	 //Delete a record
	 if(isset($_POST['btnDelete'.$c]))
	 {
		 mysqli_query("delete from event where id=".$row_recevent1['id'],$PTS);
		 header("location:".$_SERVER['PHP_SELF']);
	 }
	 ?>
        <tr>
          <td valign="top"><p><strong><?php echo $row_recevent1['caption']; ?></strong></p>
          <p><img src="event/<?php echo $row_recevent1['photo']; ?>" width="100" height="100"'/></p></td>
          <td>Date:<?php echo $row_recevent1['date']; ?><p align="justify"><?php echo $row_recevent1['description']; ?></p></td>
          <td><input type="submit" name="btnDelete<?php echo $c?>" id="btnDelete<?php echo $c?>" value="Delete" class="btn btn-primary"/></td>
        </tr>
        <?php 
		$c++;
		} while ($row_recevent1 = mysqli_fetch_assoc($recevent1)); ?>
    </table>
  </div>
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>
<?php
mysqli_free_result($recevent1);
?>
