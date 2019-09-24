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
$msg="";
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO student (Ration_card_no,reg_no,roll_no, name, addres, admn_date, gender, dob,  standard, division, blood_group, religion, caste) VALUES (%s ,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
  GetSQLValueString($_POST['txtRation'],"text"),
                       GetSQLValueString($_POST['txtregno'], "text"),
					   GetSQLValueString($_POST['txtroll'], "text"),
                       GetSQLValueString($_POST['txtname'], "text"),
                       GetSQLValueString($_POST['txtaddress'], "text"),
                       GetSQLValueString($_POST['txtadmidate'], "date"),
                       GetSQLValueString($_POST['txtgen'], "text"),
                       GetSQLValueString($_POST['txtdob'], "date"),
                      
                      
                       GetSQLValueString($_POST['txtclass'], "int"),
                       GetSQLValueString($_POST['txtdiv'], "text"),
                       GetSQLValueString($_POST['txtblood'], "text"),
                       GetSQLValueString($_POST['txtreli'], "text"),
                       GetSQLValueString($_POST['txtcaste'], "text")
                      );

  mysql_select_db($database_PTS, $PTS);
  $Result1 = mysql_query($insertSQL, $PTS) or die(mysql_error());

 $msg="Account  successfully created !..";
}





mysql_select_db($database_PTS, $PTS);
$query_recparent = "SELECT parent.username, parent.first_name, parent.last_name FROM parent";
$recparent = mysql_query($query_recparent, $PTS) or die(mysql_error());
$row_recparent = mysql_fetch_assoc($recparent);
$totalRows_recparent = mysql_num_rows($recparent);
?>
<?php require_once('header1.php')?>

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
								<h2 class="section-heading animated" data-animation="bounceInUp">Student - Registration Form</h2>
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
<?php require_once('adminmenu.php')?>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table border="0">
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
      <td>Name</td>
      <td><span id="sprytextfield1">
        <label for="txtname"></label>
        <input type="text" name="txtname" id="txtname" class="form-control"/>
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>Class</td>
      <td><span id="spryselect3">
        <label for="txtclass"></label>
        <select name="txtclass" id="txtclass"  class="form-control">
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    
    </tr>
    <tr>
      <td>RegNo</td>
      <td><span id="sprytextfield2">
        <label for="txtregno"></label>
        <input type="text" name="txtregno" id="txtregno"  class="form-control"/>
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>Division</td>
      <td><span id="spryselect4">
        <label for="txtdiv"></label>
        <select name="txtdiv" id="txtdiv"  class="form-control">
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
          <option value="F">F</option>
          </select>
        <span class="selectRequiredMsg">Please select an item.</span></span></td>
     
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
     
    </tr>
    <tr>
      <td>Class Rollno</td>
      <td><span id="sprytextfield3">
        <label for="txtroll"></label>
        <input type="number" name="txtroll" id="txtroll"  class="form-control" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>Blood Group</td>
      <td><span id="spryselect2">
        <label for="txtblood"></label>
        <select name="txtblood" id="txtblood"  class="form-control">
          <option value="A+">A+</option>
          <option value="A-">A-</option>
          <option value="B+">B+</option>
          <option value="B-">B-</option>
          <option value="O+">O+</option>
          <option value="O-">O-</option>
          <option value="AB+">AB+</option>
          <option value="AB-">AB-</option>
          </select>
        <span class="selectRequiredMsg">Please select an item.</span></span></td>
      
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    
    </tr>
    <tr>
      <td>Admission Date</td>
      <td><span id="sprytextfield4">
        <label for="txtadmidate"></label>
        <input type="date" name="txtadmidate" id="txtadmidate"  class="form-control"/>
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>Religion</td>
      <td><span id="sprytextfield11">
        <label for="txtreli"></label>
        <input type="text" name="txtreli" id="txtreli"  class="form-control"/>
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
     
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      
    </tr>
    <tr>
      <td>Date Of Birth</td>
      <td><span id="sprytextfield12">
        <label for="txtdob"></label>
        <input type="date" name="txtdob" id="txtdob"  class="form-control" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      <td>&nbsp;</td>
      <td>Caste</td>
      <td><span id="sprytextfield13">
        <label for="txtcaste"></label>
        <input type="text" name="txtcaste" id="txtcaste"  class="form-control" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
     
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
     
    </tr>
    <tr>
      <td>Address</td>
      <td><span id="sprytextarea1">
        <label for="txtaddress"></label>
        <textarea name="txtaddress" id="txtaddress" cols="45" rows="5"  class="form-control"></textarea>
        <span class="textareaRequiredMsg">A value is required.</span></span></td>
      <td rowspan="2">&nbsp;</td>
      <td rowspan="2">&nbsp;</td>
      <td>&nbsp;</td>
     
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      
    </tr>
    <tr>
      <td>Gender</td>
      <td><span id="spryselect1">
        <label for="txtgen"></label>
        <select name="txtgen" id="txtgen"  class="form-control">
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      
    </tr>
    <tr>
      <td>Ration Card No</td>
      <td><span id="sprytextfield5">
        <label for="ddlparent"></label>
        <span class="textfieldRequiredMsg">* required.</span>
        <input type="text" name="txtRation" id="txtRation" class="form-control">
      </span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><span id="sprytextfield6">
        <label for="txtRation"></label>
        <span class="textfieldRequiredMsg">*required.</span></span></td>
     
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
     
    </tr>
    <tr>
      <td colspan="5" style="color:#F00"><?php echo $msg?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnsinup" id="btnsinup" value="Sign Up" class="btn btn-primary" /></td>
      <td>&nbsp;</td>
   
    </tr>
    </table>
  <div align="center"></div>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield14 = new Spry.Widget.ValidationTextField("sprytextfield14");
var sprytextfield15 = new Spry.Widget.ValidationTextField("sprytextfield15");
var sprytextfield16 = new Spry.Widget.ValidationTextField("sprytextfield16");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11");
var sprytextfield12 = new Spry.Widget.ValidationTextField("sprytextfield12");
var sprytextfield13 = new Spry.Widget.ValidationTextField("sprytextfield13");
var sprytextfield15 = new Spry.Widget.ValidationTextField("sprytextfield15");
var sprytextfield16 = new Spry.Widget.ValidationTextField("sprytextfield16");

</script>
 </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>