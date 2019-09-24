<?php require_once('../Connections/PTS.php'); ?>
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

$regno="";
$std="";
if(isset($_GET['regno']))
{
	$regno=$_GET['regno'];
	$std=$_GET['std'];
}

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO scoresheet (RegNO, Subject, Mark, Grade, Teacher) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($regno, "text"),
                       GetSQLValueString($_POST['cmbSubject'], "int"),
                       GetSQLValueString($_POST['txtMark'], "double"),
                       GetSQLValueString($_POST['txtGrade'], "text"),
                       GetSQLValueString($username, "text"));

  mysql_select_db($database_PTS, $PTS);
  $Result1 = mysql_query($insertSQL, $PTS) or die(mysql_error());
}


mysql_select_db($database_PTS, $PTS);
$query_RecSubject = "SELECT * FROM subject WHERE subject.standard=$std";
$RecSubject = mysql_query($query_RecSubject, $PTS) or die(mysql_error());
$row_RecSubject = mysql_fetch_assoc($RecSubject);
$totalRows_RecSubject = mysql_num_rows($RecSubject);

$maxRows_RecStdScore = 10;
$pageNum_RecStdScore = 0;
if (isset($_GET['pageNum_RecStdScore'])) {
  $pageNum_RecStdScore = $_GET['pageNum_RecStdScore'];
}
$startRow_RecStdScore = $pageNum_RecStdScore * $maxRows_RecStdScore;

mysql_select_db($database_PTS, $PTS);
$query_RecStdScore = "SELECT * FROM scoresheet,subject WHERE subject.sub_code=scoresheet.Subject and  scoresheet.RegNO='$regno' AND scoresheet.Teacher='$username'";
$query_limit_RecStdScore = sprintf("%s LIMIT %d, %d", $query_RecStdScore, $startRow_RecStdScore, $maxRows_RecStdScore);
$RecStdScore = mysql_query($query_limit_RecStdScore, $PTS) or die(mysql_error());
$row_RecStdScore = mysql_fetch_assoc($RecStdScore);

if (isset($_GET['totalRows_RecStdScore'])) {
  $totalRows_RecStdScore = $_GET['totalRows_RecStdScore'];
} else {
  $all_RecStdScore = mysql_query($query_RecStdScore);
  $totalRows_RecStdScore = mysql_num_rows($all_RecStdScore);
}
$totalPages_RecStdScore = ceil($totalRows_RecStdScore/$maxRows_RecStdScore)-1;
?>
<?php require_once('header1.php')?>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
	  <div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
								<h2 class="section-heading animated" data-animation="bounceInUp">Score Sheet</h2>
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
  <table border="0" cellspacing="15">
    <tr>
      <td>Subject</td>
      <td><span id="spryselect1">
        <label for="cmbSubject"></label>
        <select name="cmbSubject" id="cmbSubject" class="form-control">
          <?php
do {  
?>
          <option value="<?php echo $row_RecSubject['sub_code']?>"<?php if (!(strcmp($row_RecSubject['sub_code'], $row_RecSubject['sub_code']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RecSubject['sub_name']?></option>
          <?php
} while ($row_RecSubject = mysql_fetch_assoc($RecSubject));
  $rows = mysql_num_rows($RecSubject);
  if($rows > 0) {
      mysql_data_seek($RecSubject, 0);
	  $row_RecSubject = mysql_fetch_assoc($RecSubject);
  }
?>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr>
      <td>Mark</td>
      <td><span id="sprytextfield1">
        <label for="txtMark"></label>
        <input type="text" name="txtMark" id="txtMark" class="form-control"/>
      <span class="textfieldRequiredMsg">* required.</span></span></td>
    </tr>
    <tr>
      <td>Garde</td>
      <td><span id="sprytextfield2">
        <label for="txtGrade"></label>
        <input type="text" name="txtGrade" id="txtGrade" class="form-control"/>
      <span class="textfieldRequiredMsg">* required.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" id="Submit" value="Submit" class="btn btn-primary" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<form name="form2" method="post" action="">
  <table border="1" cellpadding="5" cellspacing="5" class="table table-striped">
  <thead style="background-color:#036;color:#FFF">
    <tr>
      <td>RegNO</td>
      <td>Subject</td>
      <td>Mark</td>
      <td>Grade</td>
      </tr>
      </thead>
    <?php do { ?>
      <tr>
        <td><?php echo $row_RecStdScore['RegNO']; ?></td>
        <td><?php echo $row_RecStdScore['sub_name']; ?></td>
        <td><?php echo $row_RecStdScore['Mark']; ?></td>
        <td><?php echo $row_RecStdScore['Grade']; ?></td>
        </tr>
      <?php } while ($row_RecStdScore = mysql_fetch_assoc($RecStdScore)); ?>
  </table>
</form>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
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
mysql_free_result($RecSubject);

mysql_free_result($RecStdScore);
?>
