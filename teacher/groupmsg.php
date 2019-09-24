<?php require_once('../Connections/PTS.php'); ?>
<?php
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

$maxRows_recInbox = 20;
$pageNum_recInbox = 0;
if (isset($_GET['pageNum_recInbox'])) {
  $pageNum_recInbox = $_GET['pageNum_recInbox'];
}
$startRow_recInbox = $pageNum_recInbox * $maxRows_recInbox;

mysql_select_db($database_PTS, $PTS);
$query_recInbox = "SELECT * FROM groupmsg WHERE `to`='$username'";
$query_limit_recInbox = sprintf("%s LIMIT %d, %d", $query_recInbox, $startRow_recInbox, $maxRows_recInbox);
$recInbox = mysql_query($query_limit_recInbox, $PTS) or die(mysql_error());
$row_recInbox = mysql_fetch_assoc($recInbox);

if (isset($_GET['totalRows_recInbox'])) {
  $totalRows_recInbox = $_GET['totalRows_recInbox'];
} else {
  $all_recInbox = mysql_query($query_recInbox);
  $totalRows_recInbox = mysql_num_rows($all_recInbox);
}
$totalPages_recInbox = ceil($totalRows_recInbox/$maxRows_recInbox)-1;

$queryString_recInbox = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_recInbox") == false && 
        stristr($param, "totalRows_recInbox") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_recInbox = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_recInbox = sprintf("&totalRows_recInbox=%d%s", $totalRows_recInbox, $queryString_recInbox);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Inbox</h2>
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
                <!--Content here-->
                <form name="form1" method="post" action="">
                <table border="0" cellpadding="5" cellspacing="5" class="table table-striped">
                  <tr>
                    <td colspan="3"><a href="inbox.php">Back</a></td>
                  </tr>
                  <?php 
				  $c=1;
	 do { 
	 //Delete a record
	 if(isset($_POST['btnDelete'.$c]))
	 {
		 mysql_query("delete from groupmsg where id=".$row_recInbox['id'],$PTS) or die(mysql_error($PTS));
		 header("location:".$_SERVER['PHP_SELF']);
	 }
				   ?>
                    <tr>
                      <td>From</td>
                      <td>:<?php echo $row_recInbox['from']; ?></td>
                      <td>
                        <input type="submit" name="btnDelete<?php echo $c?>" id="btnDelete<?php echo $c?>" value="Delete" class="btn btn-primary">
                     </td>
                    </tr>
                    <tr>
                      <td>Subject</td>
                      <td><?php echo $row_recInbox['sub']; ?></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td colspan="2"><?php echo $row_recInbox['msg']; ?></td>
                    </tr>
                    <?php
					 $c++;
					 } while ($row_recInbox = mysql_fetch_assoc($recInbox)); ?>
                </table>
                 </form>
                <table border="0">
                  <tr>
                    <td><?php if ($pageNum_recInbox > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_recInbox=%d%s", $currentPage, 0, $queryString_recInbox); ?>"><img src="First.gif"></a>
                        <?php } // Show if not first page ?></td>
                    <td><?php if ($pageNum_recInbox > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_recInbox=%d%s", $currentPage, max(0, $pageNum_recInbox - 1), $queryString_recInbox); ?>"><img src="Previous.gif"></a>
                        <?php } // Show if not first page ?></td>
                    <td><?php if ($pageNum_recInbox < $totalPages_recInbox) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_recInbox=%d%s", $currentPage, min($totalPages_recInbox, $pageNum_recInbox + 1), $queryString_recInbox); ?>"><img src="Next.gif"></a>
                        <?php } // Show if not last page ?></td>
                    <td><?php if ($pageNum_recInbox < $totalPages_recInbox) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_recInbox=%d%s", $currentPage, $totalPages_recInbox, $queryString_recInbox); ?>"><img src="Last.gif"></a>
                        <?php } // Show if not last page ?></td>
                  </tr>
                </table>
                </div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>
<?php
mysql_free_result($recInbox);
?>
