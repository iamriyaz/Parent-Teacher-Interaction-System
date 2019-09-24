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

mysqli_select_db($database_PTS, $PTS);
$query_Recfac = "SELECT * FROM teacher";
$Recfac = mysqli_query($query_Recfac, $PTS) or die(mysqli_error());
$row_Recfac = mysqli_fetch_assoc($Recfac);
$totalRows_Recfac = mysqli_num_rows($Recfac);
?>
<?php require_once('header1.php')?>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script>
function subject()
{
	var cid=$('#txtclass').val();
	//var cid=document.getElementById('txtclass').value;
	
 	$.get("subject.php?cmd="+cid,"",function(data){
		$('#txtsub').html(data);
	});
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
								<h2 class="section-heading animated" data-animation="bounceInUp">ASSIGN CLASS</h2>
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
<form id="form1" name="form1" method="post" action="">
  <table width="315" height="170" border="0" align="center">
    <tr>
      <td width="150">Faculty No:</td>
      <td width="155"><span id="spryselect1">
        <label for="txtfaculty"></label>
        <select name="txtfaculty" id="txtfaculty" class="form-control">
          <?php
do {  
?>
          <option value="<?php echo $row_Recfac['faculty_no']?>"<?php if (!(strcmp($row_Recfac['faculty_no'], $row_Recfac['faculty_no']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recfac['faculty_no']?></option>
          <?php
} while ($row_Recfac = mysqli_fetch_assoc($Recfac));
  $rows = mysqli_num_rows($Recfac);
  if($rows > 0) {
      mysqli_data_seek($Recfac, 0);
	  $row_Recfac = mysqli_fetch_assoc($Recfac);
  }
?>
          </select>
        <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Class</td>
      <td><span id="spryselect3">
        <label for="txtclass"></label>
        <select name="txtclass" id="txtclass" onchange="subject()" class="form-control">
          <option>-select class-</option>
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
    </tr>
    <tr>
      <td>Division</td>
      <td><select name="txtdiv" id="txtdiv" class="form-control">
        <option>-select division-</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        <option value="E">E</option>
        <option value="F">F</option>
        <option value="G">G</option>
        <option value="H">H</option>
        <option value="I">I</option>
        <option value="J">J</option>
        <option value="K">K</option>
        <option value="L">L</option>
        <option value="M">M</option>
        <option value="N">N</option>
        <option value="O">O</option>
        <option value="P">P</option>
        <option value="Q">Q</option>
        <option value="R">R</option>
        <option value="S">S</option>
        <option value="T">T</option>
        <option value="U">U</option>
        <option value="V">V</option>
        <option value="W">W</option>
        <option value="X">X</option>
        <option value="Y">Y</option>
        <option value="Z">Z</option>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Subject Name</td>
      <td><select name="txtsub" id="txtsub" class="form-control">
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><span id="spryselect4">
        <label for="txtdiv"></label>
      <span class="selectRequiredMsg">Please select an item.</span></span>
        <input type="submit" name="btnsubmit" id="btnsubmit" value="Submit" class="btn btn-primary"/></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
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
mysqli_free_result($Recfac);
?>
