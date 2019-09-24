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

$maxRows_recFaculty = 9;
$pageNum_recFaculty = 0;
if (isset($_GET['pageNum_recFaculty'])) {
  $pageNum_recFaculty = $_GET['pageNum_recFaculty'];
}
$startRow_recFaculty = $pageNum_recFaculty * $maxRows_recFaculty;

mysqli_select_db($database_PTS, $PTS);
$query_recFaculty = "SELECT * FROM teacher";
$query_limit_recFaculty = sprintf("%s LIMIT %d, %d", $query_recFaculty, $startRow_recFaculty, $maxRows_recFaculty);
$recFaculty = mysqli_query($query_limit_recFaculty, $PTS) or die(mysqli_error());
$row_recFaculty = mysqli_fetch_assoc($recFaculty);

if (isset($_GET['totalRows_recFaculty'])) {
  $totalRows_recFaculty = $_GET['totalRows_recFaculty'];
} else {
  $all_recFaculty = mysqli_query($query_recFaculty);
  $totalRows_recFaculty = mysqli_num_rows($all_recFaculty);
}
$totalPages_recFaculty = ceil($totalRows_recFaculty/$maxRows_recFaculty)-1;
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
						
							<h2 class="section-heading animated" data-animation="bounceInUp">Teachers</h2>
							
						
							</div>
						</div>
					</div>
				</div>
				<div class="row">
                
                  
                  
                  <section id="services" class="section pad-bot5 bg-white">
		<div class="container"> 
				
			<div class="row mar-bot40">
              <?php do { ?>
				<div class="col-lg-4" >
					<div class="wow bounceIn">
						<div class="align-center">
					
							<div class="wow rotateIn">
								<div class="service-col">
									<!--<div class="service-icon">
										<figure><i class="fa fa-cog"></i></figure>
									</div>-->
										<h2><a href="#"><?php echo $row_recFaculty['first_name']; ?> <?php echo $row_recFaculty['last_name']; ?></a></h2>
										<p>Contact no :<?php echo $row_recFaculty['phone_no']; ?></p>
                                        <p>Email :<?php echo $row_recFaculty['e_mail']; ?></p>
                                        <p>Qualification :<?php echo $row_recFaculty['qualification']; ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
					 <?php } while ($row_recFaculty = mysqli_fetch_assoc($recFaculty)); ?>
				
				
			
			</div>	

		</div>
		</section>
                  
</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?>
<?php
mysqli_free_result($recFaculty);
?>
