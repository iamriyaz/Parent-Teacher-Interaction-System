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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")&&(isset($_POST['btnsubmit']))) {
  $insertSQL = sprintf("INSERT INTO subject (sub_code, sub_name, standard) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['txtcode'], "int"),
                       GetSQLValueString($_POST['txtname'], "text"),
                       GetSQLValueString($_POST['txtclass'], "int"));

  mysql_select_db($database_PTS, $PTS);
  $Result1 = mysql_query($insertSQL, $PTS) or die(mysql_error($PTS));

  $insertGoTo = "subjectclass.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_Recsubclas = 10;
$pageNum_Recsubclas = 0;
if (isset($_GET['pageNum_Recsubclas'])) {
  $pageNum_Recsubclas = $_GET['pageNum_Recsubclas'];
}
$startRow_Recsubclas = $pageNum_Recsubclas * $maxRows_Recsubclas;

mysql_select_db($database_PTS, $PTS);
$query_Recsubclas = "SELECT * FROM subject";
$query_limit_Recsubclas = sprintf("%s LIMIT %d, %d", $query_Recsubclas, $startRow_Recsubclas, $maxRows_Recsubclas);
$Recsubclas = mysql_query($query_limit_Recsubclas, $PTS) or die(mysql_error());
$row_Recsubclas = mysql_fetch_assoc($Recsubclas);

if (isset($_GET['totalRows_Recsubclas'])) {
  $totalRows_Recsubclas = $_GET['totalRows_Recsubclas'];
} else {
  $all_Recsubclas = mysql_query($query_Recsubclas);
  $totalRows_Recsubclas = mysql_num_rows($all_Recsubclas);
}
$totalPages_Recsubclas = ceil($totalRows_Recsubclas/$maxRows_Recsubclas)-1;
?>
<?php require_once('header1.php')?>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
								<h2 class="section-heading animated" data-animation="bounceInUp">ASSIGN SUBJECT & CLASS</h2>
							</div>
                          </div>
                        </div>
                      <?php require_once('log.php')?> 
				</div>
				<div class="row">
                <div class="col-lg-2">
                <?php require_once('adminmenu.php')?>
                </div>
                <div class="col-lg-10 "><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="356" height="253" border="0" align="center">
    <tr>
      <td width="109" height="44">Subjects Code</td>
      <td width="133"><span id="sprytextfield1">
        <label for="txtcode"></label>
        <input type="text" name="txtcode" id="txtcode"  class="form-control"/>
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td height="43">Subject Name</td>
      <td><span id="sprytextfield2">
        <label for="txtname"></label>
        <input type="text" name="txtname" id="txtname"  class="form-control"/>
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td height="57">Class</td>
      <td><span id="spryselect1">
        <label for="txtclass"></label>
        <select name="txtclass" id="txtclass"  class="form-control">
          <option>-Select Class-</option>
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
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnsubmit" id="btnsubmit" value="Submit" class="btn btn-primary"/></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<form id="form2" name="form2" method="post" action="">
  <table border="0" class="table table-striped">
     <thead style="background-color:#036;color:$fff">
    <tr>
      <td width="160">Subject Code</td>
      <td width="163">Subject Name</td>
      <td width="168">Class</td>
      <td width="127"></td>
      <td width="127"></td>
    </tr>
    </thead>
    <?php
	 $c=1;
	 do { 
	 //Delete a record
	 if(isset($_POST['btnDelete'.$c]))
	 {
		 mysql_query("delete from subject  where sub_code=".$row_Recsubclas['sub_code'],$PTS);
		 header("location:".$_SERVER['PHP_SELF']);
	 }
	 if(isset($_POST['btnedit'.$c]))
	 {
		 header("location:editsub.php?scode=".$row_Recsubclas['sub_code']);
	 }
		  ?>
      <tr>
        <td><?php echo $row_Recsubclas['sub_code']; ?></td>
        <td><?php echo $row_Recsubclas['sub_name']; ?></td>
        <td><?php echo $row_Recsubclas['standard']; ?></td>
        <td><div align="center">
        <input type="submit" name="btnedit<?php echo $c?>" id="btnedit" value="Edit" class="btn btn-primary"/>
        </div></td>
        <td><input type="submit" name="btnDelete<?php echo $c?>" id="btnDelete<?php echo $c?>" value="Delete" class="btn btn-primary" /></td>
      </tr>
      <?php
	  $c++;
	   } while ($row_Recsubclas = mysql_fetch_assoc($Recsubclas)); ?>
  </table>
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
<?php
mysql_free_result($Recsubclas);
?>
