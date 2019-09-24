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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recparent1 = 10;
$pageNum_Recparent1 = 0;
if (isset($_GET['pageNum_Recparent1'])) {
  $pageNum_Recparent1 = $_GET['pageNum_Recparent1'];
}
$startRow_Recparent1 = $pageNum_Recparent1 * $maxRows_Recparent1;

mysql_select_db($database_PTS, $PTS);
$query_Recparent1 = "SELECT parent.first_name, parent.last_name, parent.phone_no, parent.relation,username,verified FROM parent";
$query_limit_Recparent1 = sprintf("%s LIMIT %d, %d", $query_Recparent1, $startRow_Recparent1, $maxRows_Recparent1);
$Recparent1 = mysql_query($query_limit_Recparent1, $PTS) or die(mysql_error());
$row_Recparent1 = mysql_fetch_assoc($Recparent1);

if (isset($_GET['totalRows_Recparent1'])) {
  $totalRows_Recparent1 = $_GET['totalRows_Recparent1'];
} else {
  $all_Recparent1 = mysql_query($query_Recparent1);
  $totalRows_Recparent1 = mysql_num_rows($all_Recparent1);
}
$totalPages_Recparent1 = ceil($totalRows_Recparent1/$maxRows_Recparent1)-1;

$queryString_Recparent1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recparent1") == false && 
        stristr($param, "totalRows_Recparent1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recparent1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recparent1 = sprintf("&totalRows_Recparent1=%d%s", $totalRows_Recparent1, $queryString_Recparent1);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Parent Info</h2>
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
    <thead style="background-color:#036;color:#FFF">
    <tr>
      <td>First_name</td>
      <td>Last_name</td>
      <td>Phone_no</td>
      <td>Relation</td>
      <td>&nbsp;</td>
      <td colspan="2">Verification Status</td>
    </tr>
    </thead>
    <?php
	$ver=1;
	
	
		 do {
			 
			 if(isset($_POST['btnaccept'.$ver]))
			 
			 
			{
				mysql_query ("update parent set verified=1 where username='".$row_Recparent1['username']."'",$PTS) or die(mysql_error($PTS));
				
				header("location:".$_SERVER['PHP_SELF']);
			}
			
			 if(isset($_POST['btndecline'.$ver]))
			 
			 
			{
				mysql_query ("update parent set verified=0 where username='".$row_Recparent1['username']."'",$PTS);
				
				header("location:".$_SERVER['PHP_SELF']);
			}
			
			
			  ?>
      <tr>
        <td><?php echo $row_Recparent1['first_name']; ?></td>
        <td><?php echo $row_Recparent1['last_name']; ?></td>
        <td><?php echo $row_Recparent1['phone_no']; ?></td>
        <td><?php echo $row_Recparent1['relation']; ?></td>
        <td><a href="adminparentview.php?uname=<?php echo $row_Recparent1['username']; ?>">View</a></td>
        <td><?php echo $row_Recparent1['verified']; ?><br><input type="submit" name="btnaccept<?php echo $ver ?>" id="btnaccept<?php echo $ver ?>" value="Accept" class="btn btn-primary" /> </td>
        <td><input type="submit" name="btndecline<?php echo $ver ?>" id="btndecline<?php echo $ver ?>" value="Decline" class="btn btn-primary"/></td>
      </tr>
      <?php $ver++;
	  
	   } while ($row_Recparent1 = mysql_fetch_assoc($Recparent1)); ?>
  </table>
  <table border="0">
    <tr>
      <td><?php if ($pageNum_Recparent1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recparent1=%d%s", $currentPage, 0, $queryString_Recparent1); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recparent1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recparent1=%d%s", $currentPage, max(0, $pageNum_Recparent1 - 1), $queryString_Recparent1); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_Recparent1 < $totalPages_Recparent1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recparent1=%d%s", $currentPage, min($totalPages_Recparent1, $pageNum_Recparent1 + 1), $queryString_Recparent1); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_Recparent1 < $totalPages_Recparent1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recparent1=%d%s", $currentPage, $totalPages_Recparent1, $queryString_Recparent1); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
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
mysql_free_result($Recparent1);
?>
