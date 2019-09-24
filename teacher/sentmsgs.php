<?php require_once('../Connections/PTS.php'); ?>
<?php
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_recSentItems = 20;
$pageNum_recSentItems = 0;
if (isset($_GET['pageNum_recSentItems'])) {
  $pageNum_recSentItems = $_GET['pageNum_recSentItems'];
}
$startRow_recSentItems = $pageNum_recSentItems * $maxRows_recSentItems;

mysql_select_db($database_PTS, $PTS);
$query_recSentItems = "SELECT * FROM groupmsg WHERE groupmsg.`from`='$username'";
$query_limit_recSentItems = sprintf("%s LIMIT %d, %d", $query_recSentItems, $startRow_recSentItems, $maxRows_recSentItems);
$recSentItems = mysql_query($query_limit_recSentItems, $PTS) or die(mysql_error());
$row_recSentItems = mysql_fetch_assoc($recSentItems);

if (isset($_GET['totalRows_recSentItems'])) {
  $totalRows_recSentItems = $_GET['totalRows_recSentItems'];
} else {
  $all_recSentItems = mysql_query($query_recSentItems);
  $totalRows_recSentItems = mysql_num_rows($all_recSentItems);
}
$totalPages_recSentItems = ceil($totalRows_recSentItems/$maxRows_recSentItems)-1;

$queryString_recSentItems = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_recSentItems") == false && 
        stristr($param, "totalRows_recSentItems") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_recSentItems = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_recSentItems = sprintf("&totalRows_recSentItems=%d%s", $totalRows_recSentItems, $queryString_recSentItems);
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Sent Items</h2>
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
		 mysql_query("delete from groupmsg where id=".$row_recSentItems['id'],$PTS) or die(mysql_error($PTS));
		 header("location:".$_SERVER['PHP_SELF']);
	 }
					 ?>
                      <tr>
                        <td>Subject:<?php echo $row_recSentItems['sub']; ?></td>
                        <td>To :<?php echo $row_recSentItems['to']; ?> <?php echo $row_recSentItems['division']; ?></td>
                        <td>
                          <input type="submit" name="btnDelete<?php echo $c?>" id="btnDelete<?php echo $c?>" value="Delete" class="btn btn-primary">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3"><p><?php echo $row_recSentItems['msg']; ?></p></td>
                      </tr>
                      <tr>
                        <td colspan="3"><hr></td>
                      </tr>
                      <?php 
					  $c++;
					  } while ($row_recSentItems = mysql_fetch_assoc($recSentItems)); ?>
                  </table>
                  </form>
                  <p>&nbsp;                  
                  <table border="0">
                    <tr>
                      <td><?php if ($pageNum_recSentItems > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_recSentItems=%d%s", $currentPage, 0, $queryString_recSentItems); ?>"><img src="First.gif"></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_recSentItems > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_recSentItems=%d%s", $currentPage, max(0, $pageNum_recSentItems - 1), $queryString_recSentItems); ?>"><img src="Previous.gif"></a>
                          <?php } // Show if not first page ?></td>
                      <td><?php if ($pageNum_recSentItems < $totalPages_recSentItems) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_recSentItems=%d%s", $currentPage, min($totalPages_recSentItems, $pageNum_recSentItems + 1), $queryString_recSentItems); ?>"><img src="Next.gif"></a>
                          <?php } // Show if not last page ?></td>
                      <td><?php if ($pageNum_recSentItems < $totalPages_recSentItems) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_recSentItems=%d%s", $currentPage, $totalPages_recSentItems, $queryString_recSentItems); ?>"><img src="Last.gif"></a>
                          <?php } // Show if not last page ?></td>
                    </tr>
                  </table>
                  </p>
                </div>
               	</div>	
		  </div>
					
  </div>
			
</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>
<?php
mysql_free_result($recSentItems);
?>
