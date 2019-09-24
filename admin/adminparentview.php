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

$uname="";
if(isset($_GET['uname']))
{
	$uname=$_GET['uname'];
}
$maxRows_Recparentprof = 1;
$pageNum_Recparentprof = 0;
if (isset($_GET['pageNum_Recparentprof'])) {
  $pageNum_Recparentprof = $_GET['pageNum_Recparentprof'];
}
$startRow_Recparentprof = $pageNum_Recparentprof * $maxRows_Recparentprof;

mysql_select_db($database_PTS, $PTS);
$query_Recparentprof = "SELECT * FROM parent WHERE parent.username='$uname' ";
$query_limit_Recparentprof = sprintf("%s LIMIT %d, %d", $query_Recparentprof, $startRow_Recparentprof, $maxRows_Recparentprof);
$Recparentprof = mysql_query($query_limit_Recparentprof, $PTS) or die(mysql_error());
$row_Recparentprof = mysql_fetch_assoc($Recparentprof);

if (isset($_GET['totalRows_Recparentprof'])) {
  $totalRows_Recparentprof = $_GET['totalRows_Recparentprof'];
} else {
  $all_Recparentprof = mysql_query($query_Recparentprof);
  $totalRows_Recparentprof = mysql_num_rows($all_Recparentprof);
}
$totalPages_Recparentprof = ceil($totalRows_Recparentprof/$maxRows_Recparentprof)-1;
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Parent Profile</h2>
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
  <table border="0" class="table table-striped">
    <?php do { ?>
     
      <tr>
        <td width="151">Name</td>
        <td width="277"><?php echo $row_Recparentprof['first_name']; ?> &nbsp;<?php echo $row_Recparentprof['last_name']; ?></td>
      </tr>
      <tr>
        <td>Address</td>
        <td><?php echo $row_Recparentprof['address']; ?></td>
      </tr>
      <tr>
        <td>Phone no</td>
        <td><?php echo $row_Recparentprof['phone_no']; ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?php echo $row_Recparentprof['e_mail']; ?></td>
      </tr>
      <tr>
        <td>Relation</td>
        <td><?php echo $row_Recparentprof['relation']; ?></td>
      </tr>
      <tr>
        <td>Gender</td>
        <td><?php echo $row_Recparentprof['gender']; ?></td>
      </tr>
      <tr>
        <td>Occupation</td>
        <td><?php echo $row_Recparentprof['occupation']; ?></td>
      </tr>
      <tr>
        <td>Ration Card no</td>
        <td><?php echo $row_Recparentprof['Ration_card_no']; ?></td>
      </tr>
      <?php } while ($row_Recparentprof = mysql_fetch_assoc($Recparentprof)); ?>
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
mysql_free_result($Recparentprof);
?>
