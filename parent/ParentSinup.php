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
  $insertSQL = sprintf("INSERT INTO parent (Ration_card_no,first_name, last_name, address, phone_no, e_mail, relation, gender, occupation, username, password) VALUES (%s,%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
           GetSQLValueString($_POST['txtRation'],"text"),             
                       GetSQLValueString($_POST['txtfname'], "text"),
                       GetSQLValueString($_POST['txtlname'], "text"),
                       GetSQLValueString($_POST['txtaddress'], "text"),
                       GetSQLValueString($_POST['txtphone'], "text"),
                       GetSQLValueString($_POST['txtemail'], "text"),
                       GetSQLValueString($_POST['txtrelation'], "text"),
                       GetSQLValueString($_POST['txtgender'], "text"),
                       GetSQLValueString($_POST['txtoccupation'], "text"),
                       GetSQLValueString($_POST['txtusername'], "text"),
                       GetSQLValueString($_POST['txtpass'], "text"));

  mysql_select_db($database_PTS, $PTS);
  $Result1 = mysql_query($insertSQL, $PTS) or die(mysql_error());
$msg=" Account successfully created ..";
 header("location:../completed.php");
}
?>
<?php require_once('header1.php')?>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />


  <script>
function check_availability(){  
  
        //get the username  
        var username = $('#txtusername').val();  
  		
        //use ajax to run the check  
        $.post("ajax.php", { username: username },  
            function(result){  
                //if the result is 1  
                if(result == 1){  
                    //show that the username is available  
                    $('#username_availability_result').html(username + ' is Available');  
                }else{  
                    //show that the username is NOT available  
                    $('#username_availability_result').html(username + ' is not Available');  
                }  
        });  
  
}  

function check()
{
	if(document.getElementById('txtpass').value.length<6)
	{
		 document.getElementById('hr1').style.width="50px";
		 document.getElementById('hr1').style.backgroundColor="red";
	}
	if(document.getElementById('txtpass').value.length>=6&&document.getElementById('txtpass').value.length<10)
	 {
		 document.getElementById('hr1').style.width="100px";
		 document.getElementById('hr1').style.backgroundColor="green";
	 }
}

</script>

<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="title">
							<div class="wow bounceIn">
						
							<h2 class="section-heading animated" data-animation="bounceInUp">Registration</h2>
							
						
							</div>
						</div>
					</div>
				</div>
				<div class="row">
                
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <div align="center">
    <table  border="0" align="center">
      
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" style="color:#F00"><?php echo $msg?>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>First Name</td>
        <td><span id="sprytextfield9">
          <label for="txtfname"></label>
          <input type="text" name="txtfname" id="txtfname" class="form-control"/>
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        <td>Username</td>
        <td><span id="sprytextfield5">
          <label for="txt12"></label>
          <input type="text" name="txtusername" id="txtusername" onchange="check_availability()" class="form-control"/>
        <span class="textfieldRequiredMsg">A value is required.</span></span><div id='username_availability_result' title="Error" style="color:#F00"></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Last Name</td>
        <td><label for="txtlname"><span id="sprytextfield1">
          <input type="text" name="txtlname" id="txt3" class="form-control" />
          <span class="textfieldRequiredMsg">A value is required.</span></span></label></td>
        <td>Password</td>
        <td><span id="sprypassword1"><span class="passwordRequiredMsg">A value is required.</span></span><span id="sprypassword2">
          <label for="txtrelation"></label>
          <span class="passwordRequiredMsg">A value is required.</span></span><span id="spryconfirm2"><span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">The values don't match.</span></span><span id="sprypassword3">
          <label for="txtpass"></label>
          <span class="passwordRequiredMsg">A value is required.</span></span><span id="sprytextfield7">
          <label for="txtpass"></label>
          <span class="textfieldRequiredMsg">A value is required.</span></span>
          <input type="password" class="form-control" name="txtpass" id="txtpass" onChange="check();" /><div  id="hr1">&nbsp;</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td rowspan="4">Address</td>
        <td rowspan="4"><label for="txtaddress"></label>
          <span id="sprytextarea2">
            <label for="txtphone"></label>
            <span class="textareaRequiredMsg">A value is required.</span></span>
          <textarea name="txtaddress" id="txt4" cols="45" rows="5" class="form-control"></textarea></td>
        <td><p>Conform Password</p></td>
        <td is ><span id="spryconfirm1">
          <label for="txtconpass"></label>
          <input type="password" name="txtconpass" id="txtconpass" class="form-control"/>
          <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">The values don't match.</span></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td rowspan="3"><p>&nbsp;</p>
        <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Phone</td>
        <td><label for="txtphone"><span id="sprytextfield2">
        <input type="text" name="txtphone" id="txt5" class="form-control" />
        <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Email</td>
        <td><label for="txtemail"><span id="sprytextfield3">
        <input type="text" name="txtemail" id="txt6" class="form-control" />
        <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Relation</td>
        <td><span id="spryselect2">
          <label for="txtoccupation"></label>
          <select name="txtrelation" id="txt9" class="form-control">
            <option value="Father" selected="selected">Father</option>
            <option value="Mother">Mother</option>
            <option value="Gardian">Gardian</option>
            </select>
          <span class="selectRequiredMsg">Please select an item.</span></span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="26">Gender</td>
        <td><label for="txtgender"><span id="spryselect1">
          <select name="txtgender" id="txt8" class="form-control">
            <option>Select one</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
            </select>
          <span class="selectRequiredMsg">Please select an item.</span></span></label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p>No: of child in this School</p></td>
        <td><label for="txtnostu"></label>
          <span id="spryselect3">
            <label for="txtusername"></label>
            <select name="txtnostu" id="txt10" class="form-control">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              </select>
            <span class="selectRequiredMsg">Please select an item.</span></span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Occuppation</td>
        <td><span id="sprytextfield4">
          <label for="txt11"></label>
          <input type="text" name="txtoccupation" id="txt11" class="form-control"/>
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="submit" name="btnsinup" id="btnsinup" value="Sin Up" class="btn btn-primary"/></td>
      </tr>
    </table>
  </div>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "phone_number", {format:"phone_custom", pattern:"0000000000"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:6, validateOn:["change"]});
var sprypassword2 = new Spry.Widget.ValidationPassword("sprypassword2");

var sprypassword3 = new Spry.Widget.ValidationPassword("sprypassword3");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "txtpass");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
</script>
                
					</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>