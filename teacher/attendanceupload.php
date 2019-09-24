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

//Receive Query string
$rno=0;
if(isset($_GET['regno']))
{
	$rno=$_GET['regno'];
}
//end

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$msg="";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO attendance (regno, `date`, status,performance) VALUES (%s, %s, %s,%s)",
                       GetSQLValueString($_POST['txtregno'], "text"),
                       GetSQLValueString($_POST['txtdate'], "date"),
                       GetSQLValueString($_POST['txtstatus'], "text"), GetSQLValueString($_POST['txtperformance'], "text"));

  mysql_select_db($database_PTS, $PTS);
  $Result1 = mysql_query($insertSQL, $PTS) or die(mysql_error());
$msg="Uploaded successfullt ..";
 
}
?>
<?php require_once('header1.php')?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
								<h2 class="section-heading animated" data-animation="bounceInUp">Attendance</h2>
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
  <table border="0" align="center">
    <tr>
      <td width="48">&nbsp;</td>
      <td width="45">&nbsp;</td>
      <td colspan="3" style="color:#F00"><?php echo $msg?>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Regno</td>
      <td colspan="3"><span id="sprytextfield1">
        <label for="txtregno"></label>
        <input type="text" name="txtregno" id="txtregno" value="<?php echo $rno?>" class="form-control"/>
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Status</td>
      <td width="143"><span id="spryselect1">
      <label for="txtstatus"></label>
      <select name="txtstatus" id="txtstatus" class="form-control">
        <option value="Present">Present</option>
        <option value="Absent">Absent</option>
        <option value="Half-Day">Half-Day</option>
      </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
      <td width="106">&nbsp;</td>
      <td width="215"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>Date</td>
      <td>&nbsp;</td>
      <td colspan="3"><span id="sprytextfield2">
        <label for="txtdate"></label>
        <input type="date" name="txtdate" id="txtdate" class="form-control"/>
      <span class="textfieldRequiredMsg">A value is required.</span></span>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Performance</td>
      <td colspan="3"><p>&nbsp;</p>
        <p>
          <label for="txtperformance"></label>
          <textarea name="txtperformance" id="txtperformance" cols="45" rows="5" class="form-control"></textarea>
      </p></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="3"><input type="submit" name="btnupload" id="btnupload" value="Upload" class="btn btn-primary"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>