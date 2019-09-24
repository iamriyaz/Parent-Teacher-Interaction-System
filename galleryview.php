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

$maxRows_recgalleryview = 10;
$pageNum_recgalleryview = 0;
if (isset($_GET['pageNum_recgalleryview'])) {
  $pageNum_recgalleryview = $_GET['pageNum_recgalleryview'];
}
$startRow_recgalleryview = $pageNum_recgalleryview * $maxRows_recgalleryview;

mysql_select_db($database_PTS, $PTS);
$query_recgalleryview = "SELECT * FROM gallery ORDER BY gallery.id desc";
$query_limit_recgalleryview = sprintf("%s LIMIT %d, %d", $query_recgalleryview, $startRow_recgalleryview, $maxRows_recgalleryview);
$recgalleryview = mysql_query($query_limit_recgalleryview, $PTS) or die(mysql_error());
$row_recgalleryview = mysql_fetch_assoc($recgalleryview);

if (isset($_GET['totalRows_recgalleryview'])) {
  $totalRows_recgalleryview = $_GET['totalRows_recgalleryview'];
} else {
  $all_recgalleryview = mysql_query($query_recgalleryview);
  $totalRows_recgalleryview = mysql_num_rows($all_recgalleryview);
}
$totalPages_recgalleryview = ceil($totalRows_recgalleryview/$maxRows_recgalleryview)-1;
?>
<?php require_once('header1.php')?>
<?php require_once('header2.php')?>
<section id="section-about">
		<div class="container">
			<div class="about">
				
				<div class="row">
                
<!--<form id="form1" name="form1" method="post" action="">
  <table border="0">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <?php //do { ?>
      <tr>
        <td><img src="admin/gallery/<?php //echo $row_recgalleryview['photo']; ?>"  width="100" height="100"/></td>
        <td><?php //echo $row_recgalleryview['description']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <?php //} while ($row_recgalleryview = mysql_fetch_assoc($recgalleryview)); ?>
  </table>
</form>-->


<section id="section-works" class="section appear clearfix">
			<div class="container">
				
				<div class="row mar-bot40">
					<div class="col-md-offset-3 col-md-6">
						<div class="section-header">
							<h2 class="section-heading animated" data-animation="bounceInUp">Gallery</h2>
							<p></p>
						</div>
					</div>
				</div>
					
                        <div class="row">
                         
                          <div class="col-md-12">
                            <div class="row">
                              <div class="portfolio-items isotopeWrapper clearfix" id="3">
							  
                               <?php do { ?>
                                <article class="col-md-4 isotopeItem webdesign">
									<div class="portfolio-item">
									<div class="wow rotateInUpLeft" data-animation-delay="4.8s">
								   <img src="admin/gallery/<?php echo $row_recgalleryview['photo']; ?>" alt="" /> </div>
										 <div class="portfolio-desc align-center">
											<div class="folio-info">
												<h5><a href="#"><?php echo $row_recgalleryview['description']; ?></a></h5>
												<a href="admin/gallery/<?php echo $row_recgalleryview['photo']; ?>" class="fancybox"><i class="fa fa-external-link fa-2x"></i></a>
										   </div>										   
										 </div>
									</div>
                                </article>

				 <?php } while ($row_recgalleryview = mysql_fetch_assoc($recgalleryview)); ?>
                 
                               <!-- <article class="col-md-4 isotopeItem photography">
									<div class="portfolio-item">
									<div class="wow bounceIn">
										<img src="img/portfolio/2.jpg" alt="" />
									</div>
										 <div class="portfolio-desc align-center">
											<div class="folio-info">
												<h5><a href="#">Project name 2</a></h5>
												<a href="img/portfolio/2.jpg" class="fancybox"><i class="fa fa-external-link fa-2x"></i></a>
										   </div>										   
										 </div>
									</div>
                                </article>
								

                                <article class="col-md-4 isotopeItem photography">
									<div class="portfolio-item">
									<div class="wow rotateInDownRight">
										<img src="img/portfolio/3.jpg" alt="" />
									</div>	
										 <div class="portfolio-desc align-center">
											<div class="folio-info">
												<h5><a href="#">Project name 3</a></h5>
												<a href="img/portfolio/3.jpg" class="fancybox"><i class="fa fa-external-link fa-2x"></i></a>
										   </div>										   
										 </div>
									</div>
                                </article>

                                <article class="col-md-4 isotopeItem print">
									<div class="portfolio-item">
									<div class="wow rotateInUpLeft">
										<img src="img/portfolio/4.jpg" alt="" />
									 </div>	
										 <div class="portfolio-desc align-center">
											<div class="folio-info">
												<h5><a href="#">Project name 4</a></h5>
												<a href="img/portfolio/4.jpg" class="fancybox"><i class="fa fa-external-link fa-2x"></i></a>
										   </div>										   
										 </div>
									</div>
                                </article>

                                <article class="col-md-4 isotopeItem photography">
									<div class="portfolio-item">
									<div class="wow bounceIn">
										<img src="img/portfolio/5.jpg" alt="" />
									</div>
										 <div class="portfolio-desc align-center">
											<div class="folio-info">
												<h5><a href="#">Project name 5</a></h5>
												<a href="img/portfolio/5.jpg" class="fancybox"><i class="fa fa-external-link fa-2x"></i></a>
										   </div>										   
										 </div>
									</div>
                                </article>

                                <article class="col-md-4 isotopeItem webdesign">
									<div class="portfolio-item">
									<div class="wow rotateInDownRight">
										<img src="img/portfolio/6.jpg" alt="" />
									 </div>		
										 <div class="portfolio-desc align-center">
											<div class="folio-info">
												<h5><a href="#">Project name 6</a></h5>
												<a href="img/portfolio/6.jpg" class="fancybox"><i class="fa fa-external-link fa-2x"></i></a>
										   </div>										   
										 </div>
									</div>
                                </article>

                                <article class="col-md-4 isotopeItem print">
									<div class="portfolio-item">
									<div class="wow rotateInUpLeft">
										<img src="img/portfolio/7.jpg" alt="" />
									</div>
										 <div class="portfolio-desc align-center">
											<div class="folio-info">
												<h5><a href="#">Project name 7</a></h5>
												<a href="img/portfolio/7.jpg" class="fancybox"><i class="fa fa-external-link fa-2x"></i></a>
										   </div>										   
										 </div>
									</div>
                                </article>

                                <article class="col-md-4 isotopeItem photography">
									<div class="portfolio-item">
									<div class="wow bounceIn">
										<img src="img/portfolio/8.jpg" alt="" />
									</div>	
										 <div class="portfolio-desc align-center">
											<div class="folio-info">
												<h5><a href="#">Project name 8</a></h5>
												<a href="img/portfolio/8.jpg" class="fancybox"><i class="fa fa-external-link fa-2x"></i></a>
										   </div>										   
										 </div>
									</div>
                                </article>

                                <article class="col-md-4 isotopeItem print">
									<div class="portfolio-item">
									<div class="wow rotateInDownRight">
										<img src="img/portfolio/9.jpg" alt="" />
									</div>
										 <div class="portfolio-desc align-center">
											<div class="folio-info">
												<h5><a href="#">Project name 9</a></h5>
												<a href="img/portfolio/9.jpg" class="fancybox"><i class="fa fa-external-link fa-2x"></i></a>
										   </div>										   
										 </div>
									</div>
                                </article>-->
                              </div>
                                        
							</div>
                                     

						  </div>
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
mysql_free_result($recgalleryview);
?>
