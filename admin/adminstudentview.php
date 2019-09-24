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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_recSTD = 10;
$pageNum_recSTD = 0;
if (isset($_GET['pageNum_recSTD'])) {
  $pageNum_recSTD = $_GET['pageNum_recSTD'];
}
$startRow_recSTD = $pageNum_recSTD * $maxRows_recSTD;
mysqli_select_db($database_PTS, $PTS);

$std=$div="---Select---";
 if(isset($_REQUEST['txtdiv']))
{
	$std=$_REQUEST['txtclass'];
	$div=$_REQUEST['txtdiv'];
	$query_recSTD = "SELECT * FROM student where standard=".$_POST['txtclass']."  and division='".$_REQUEST['txtdiv']."'";
}
else if(isset($_REQUEST['txtdiv'])&&($_REQUEST['txtdiv']=="---Select---"))
{

$query_recSTD = "SELECT * FROM student";
}
else
{
	$query_recSTD = "SELECT * FROM student";

}
$query_limit_recSTD = sprintf("%s LIMIT %d, %d", $query_recSTD, $startRow_recSTD, $maxRows_recSTD);
$recSTD = mysqli_query($query_limit_recSTD, $PTS) or die(mysqli_error());
$row_recSTD = mysqli_fetch_assoc($recSTD);

if (isset($_GET['totalRows_recSTD'])) {
  $totalRows_recSTD = $_GET['totalRows_recSTD'];
} else {
  $all_recSTD = mysqli_query($query_recSTD);
  $totalRows_recSTD = mysqli_num_rows($all_recSTD);
}
$totalPages_recSTD = ceil($totalRows_recSTD/$maxRows_recSTD)-1;

$queryString_recSTD = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_recSTD") == false && 
        stristr($param, "totalRows_recSTD") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_recSTD = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_recSTD = sprintf("&totalRows_recSTD=%d%s", $totalRows_recSTD, $queryString_recSTD);
?>
<?php require_once('header1.php')?>
<script>
function DIV()
{
	document.getElementById("form1").submit();
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
								<h2 class="section-heading animated" data-animation="bounceInUp">STUDENT CORNER</h2>
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
<table width="200" border="0">
  <tr>
    <td>STANDARD</td>
    <td><select name="txtclass" id="txtclass" class="form-control"> 
<option value="<?php echo $std?>" selected="selected"><?php echo $std?></option>
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
      </select>&nbsp;</td>
  </tr>
  <tr>
    <td>DIVISION</td>
    <td><select name="txtdiv" id="txtdiv" onchange="DIV();" class="form-control">

<option value="<?php echo $div?>" selected="selected"><?php echo $div?></option>
<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
<option value="D">D</option>
<option value="E">E</option>
<option value="F">F</option>
      </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table border="0" class="table table-striped">
<thead style="background-color:#036;color:#fff">
    <tr>
      <td>Reg_no</td>
      <td>Roll_no</td>
      <td>Name</td>
      <td>Standard</td>
      <td>Division</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    </thead>
    <?php
	$c=1;
	 do {
		 if(isset($_REQUEST['btnDelete'.$c]))
		 {
			 mysqli_query("delete from student where reg_no=".$row_recSTD['reg_no'],$PTS);
			 header("location:".$_SERVER['PHP_SELF']);
		 }
		  ?>
      <tr>
        <td><?php echo $row_recSTD['reg_no']; ?></td>
        <td><?php echo $row_recSTD['roll_no']; ?></td>
        <td><?php echo $row_recSTD['name']; ?></td>
        <td><?php echo $row_recSTD['standard']; ?></td>
        <td><?php echo $row_recSTD['division']; ?></td>
        <td><a href="student.php?regno=<?php echo $row_recSTD['reg_no']; ?>">View</a></td>
        <td><a href="attendance.php?regno=<?php echo $row_recSTD['reg_no']; ?>">View Attanadance</td>
        <td><input type="submit" name="btnDelete<?php echo $c?>" id="btnDelete<?php echo $c?>" value="Delete" class="btn btn-danger"></td>
      </tr>
      <?php 
	  $c++;
	  } while ($row_recSTD = mysqli_fetch_assoc($recSTD)); ?>
  </table>
  <p>&nbsp;
  <table border="0">
    <tr>
      <td><?php if ($pageNum_recSTD > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_recSTD=%d%s", $currentPage, 0, $queryString_recSTD); ?>">First</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_recSTD > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_recSTD=%d%s", $currentPage, max(0, $pageNum_recSTD - 1), $queryString_recSTD); ?>">Previous</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_recSTD < $totalPages_recSTD) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_recSTD=%d%s", $currentPage, min($totalPages_recSTD, $pageNum_recSTD + 1), $queryString_recSTD); ?>">Next</a>
      <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_recSTD < $totalPages_recSTD) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_recSTD=%d%s", $currentPage, $totalPages_recSTD, $queryString_recSTD); ?>">Last</a>
      <?php } // Show if not last page ?></td>
    </tr>
  </table>
  </p>
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
mysqli_free_result($recSTD);
?>
