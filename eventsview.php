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

$maxRows_recevent1 = 10;
$pageNum_recevent1 = 0;
if (isset($_GET['pageNum_recevent1'])) {
  $pageNum_recevent1 = $_GET['pageNum_recevent1'];
}
$startRow_recevent1 = $pageNum_recevent1 * $maxRows_recevent1;

mysql_select_db($database_PTS, $PTS);
$query_recevent1 = "SELECT * FROM event ORDER BY event.id desc";
$query_limit_recevent1 = sprintf("%s LIMIT %d, %d", $query_recevent1, $startRow_recevent1, $maxRows_recevent1);
$recevent1 = mysql_query($query_limit_recevent1, $PTS) or die(mysql_error());
$row_recevent1 = mysql_fetch_assoc($recevent1);
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
						
							<h2 class="section-heading animated" data-animation="bounceInUp">EVENTS</h2>
							
						
							</div>
						</div>
					</div>
				</div>
				<div class="row">
<form id="form1" name="form1" method="post" action="">
  <div align="center">
    <table border="0" class="table table-striped">
      <?php
	  
	 do { 
	 
	 ?>
      <tr>
        <td valign="top"><p><strong><?php echo $row_recevent1['caption']; ?></strong></p>
          <p><img src="admin/event/<?php echo $row_recevent1['photo']; ?>" width="100" height="100"'/></p></td>
        <td>Date:<?php echo $row_recevent1['date']; ?>
          <p align="justify"><?php echo $row_recevent1['description']; ?></p></td>
        
      </tr>
      <?php 
		
		} while ($row_recevent1 = mysql_fetch_assoc($recevent1)); ?>
    </table>
  </div>
</form>
	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>