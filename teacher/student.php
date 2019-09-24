
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


$v="";
if(isset($_GET['regno']))
{
	$v=$_GET['regno'];
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recstudent = 1;
$pageNum_Recstudent = 0;
if (isset($_GET['pageNum_Recstudent'])) {
  $pageNum_Recstudent = $_GET['pageNum_Recstudent'];
}
$startRow_Recstudent = $pageNum_Recstudent * $maxRows_Recstudent;

mysql_select_db($database_PTS, $PTS);
$query_Recstudent = "SELECT * FROM student,parent where reg_no='$v' and parent.Ration_card_no=student.Ration_card_no";
$query_limit_Recstudent = sprintf("%s LIMIT %d, %d", $query_Recstudent, $startRow_Recstudent, $maxRows_Recstudent);
$Recstudent = mysql_query($query_limit_Recstudent, $PTS) or die(mysql_error());
$row_Recstudent = mysql_fetch_assoc($Recstudent);

if (isset($_GET['totalRows_Recstudent'])) {
  $totalRows_Recstudent = $_GET['totalRows_Recstudent'];
} else {
  $all_Recstudent = mysql_query($query_Recstudent);
  $totalRows_Recstudent = mysql_num_rows($all_Recstudent);
}
$totalPages_Recstudent = ceil($totalRows_Recstudent/$maxRows_Recstudent)-1;

$queryString_Recstudent = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recstudent") == false && 
        stristr($param, "totalRows_Recstudent") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recstudent = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recstudent = sprintf("&totalRows_Recstudent=%d%s", $totalRows_Recstudent, $queryString_Recstudent);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Student</h2>
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
<form id="form1" name="form1" method="post" action="">
  <table border="0" class="table table-striped">
    <tr>
      <td width="259">&nbsp;</td>
      <td width="354"><a href="compose.php?receipient=<?php echo $row_Recstudent['Ration_card_no']; ?>">SENT MESSAGE </a></td>
      <td width="354"><a href="sms.php?phone=<?php echo $row_Recstudent['phone_no']; ?>">Send SMS</a></td>
    </tr>
    <?php do { ?>
      <tr>

        <td>Regno</td>
        <td colspan="2"><?php echo $row_Recstudent['reg_no']; ?></td>
      </tr>
      <tr>
        <td>Roll No</td>
        <td colspan="2"><?php echo $row_Recstudent['roll_no']; ?></td>
      </tr>
      <tr>
        <td>Name</td>
        <td colspan="2"><?php echo $row_Recstudent['name']; ?></td>
      </tr>
      <tr>
        <td>Addres</td>
        <td colspan="2"><?php echo $row_Recstudent['addres']; ?></td>
      </tr>
      <tr>
        <td>Admission Date</td>
        <td colspan="2"><?php echo $row_Recstudent['admn_date']; ?></td>
      </tr>
      <tr>
        <td>Gender</td>
        <td colspan="2"><?php echo $row_Recstudent['gender']; ?></td>
      </tr>
      <tr>
        <td>Date of Birth</td>
        <td colspan="2"><?php echo $row_Recstudent['dob']; ?></td>
      </tr>
      <tr>
        <td>Parent</td>
        <td colspan="2"><?php echo $row_Recstudent['first_name']; ?> <?php echo $row_Recstudent['last_name']; ?></td>
      </tr>
      <tr>
        <td>Guardian occupation</td>
        <td colspan="2"><?php echo $row_Recstudent['occupation']; ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td colspan="2"><?php echo $row_Recstudent['e_mail']; ?></td>
      </tr>
      <tr>
        <td>Contact no</td>
        <td colspan="2"><?php echo $row_Recstudent['phone_no']; ?></td>
      </tr>
     
      
      <tr>
        <td>Standard</td>
        <td colspan="2"><?php echo $row_Recstudent['standard']; ?></td>
      </tr>
      <tr>
        <td>Division</td>
        <td colspan="2"><?php echo $row_Recstudent['division']; ?></td>
      </tr>
      <tr>
        <td>Blood group</td>
        <td colspan="2"><?php echo $row_Recstudent['blood_group']; ?></td>
      </tr>
      <tr>
        <td>Religion</td>
        <td colspan="2"><?php echo $row_Recstudent['religion']; ?></td>
      </tr>
      <tr>
        <td>Caste</td>
        <td colspan="2"><?php echo $row_Recstudent['caste']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
      <?php } while ($row_Recstudent = mysql_fetch_assoc($Recstudent)); ?>
  </table>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_Recstudent > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recstudent=%d%s", $currentPage, 0, $queryString_Recstudent); ?>">First</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recstudent > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recstudent=%d%s", $currentPage, max(0, $pageNum_Recstudent - 1), $queryString_Recstudent); ?>">Previous</a>
      <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recstudent < $totalPages_Recstudent) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recstudent=%d%s", $currentPage, min($totalPages_Recstudent, $pageNum_Recstudent + 1), $queryString_Recstudent); ?>">Next</a>
      <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Recstudent < $totalPages_Recstudent) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recstudent=%d%s", $currentPage, $totalPages_Recstudent, $queryString_Recstudent); ?>">Last</a>
      <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
 </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?><?php
mysql_free_result($Recstudent);
?>
