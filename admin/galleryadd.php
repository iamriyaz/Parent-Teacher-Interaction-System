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

$maxRows_recgallery = 10;
$pageNum_recgallery = 0;
if (isset($_GET['pageNum_recgallery'])) {
  $pageNum_recgallery = $_GET['pageNum_recgallery'];
}
$startRow_recgallery = $pageNum_recgallery * $maxRows_recgallery;

mysqli_select_db($database_PTS, $PTS);
$query_recgallery = "SELECT * FROM gallery ORDER BY gallery.id desc";
$query_limit_recgallery = sprintf("%s LIMIT %d, %d", $query_recgallery, $startRow_recgallery, $maxRows_recgallery);
$recgallery = mysqli_query($query_limit_recgallery, $PTS) or die(mysqli_error());
$row_recgallery = mysqli_fetch_assoc($recgallery);

if (isset($_GET['totalRows_recgallery'])) {
  $totalRows_recgallery = $_GET['totalRows_recgallery'];
} else {
  $all_recgallery = mysqli_query($query_recgallery);
  $totalRows_recgallery = mysqli_num_rows($all_recgallery);
}
$totalPages_recgallery = ceil($totalRows_recgallery/$maxRows_recgallery)-1;

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$error="";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if($_FILES['filegallery']['size']>0 && $_FILES['filegallery']['type']=="image/jpeg")
	{
		
		move_uploaded_file($_FILES['filegallery']['tmp_name'],getcwd()."/gallery/".$_FILES['filegallery']['name']);
  $insertSQL = sprintf("INSERT INTO gallery (photo, `description`) VALUES (%s, %s)",
                       GetSQLValueString($_FILES['filegallery']['name'], "text"),
                       GetSQLValueString($_POST['txtDesc'], "text"));

  mysqli_select_db($database_PTS, $PTS);
  $Result1 = mysqli_query($insertSQL, $PTS) or die(mysqli_error($PTS));
  header("location:".$_SERVER['PHP_SELF']);
}
else
{
	$error="please choose jpeg file";
}
}
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
								<h2 class="section-heading animated" data-animation="bounceInUp">GALLERY</h2>
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
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
  <table width="325" border="0" align="center">
    <tr>
      <td>Choose Photo</td>
      <td><input type="file" name="filegallery" id="filegallery" /><font color="#FF0000"><?php echo $error?></font></td>
    </tr>
    <tr>
      <td>Description</td>
      <td><label for="txtDesc"></label>
      <textarea name="txtDesc" id="txtDesc" cols="45" rows="5" class="form-control"></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnupload" id="btnupload" value="Upload" class="btn btn-primary"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
</form>
<form id="form2" name="form2" method="post" action="">
  <table border="0" align="center" class="table table-striped">
    <?php
	$c=1;
	
	 do { 
	 //Delete a record
	 if(isset($_POST['btnDelete'.$c]))
	 {
		 mysqli_query("delete from gallery where id=".$row_recgallery['id'],$PTS);
		 header("location:".$_SERVER['PHP_SELF']);
	 }
	 ?>
      <tr>
        <td><img src="gallery/<?php echo $row_recgallery['photo']; ?>"  width="100" height="100"/></td>
        <td align="left" valign="top"><?php echo $row_recgallery['description']; ?></td>
        <td align="left" valign="top"><input type="submit" name="btnDelete<?php echo $c?>" id="btnDelete<?php echo $c?>" value="Delete" class="btn btn-primary"/></td>
      </tr>
      <?php 
	  $c++;
	  } while ($row_recgallery = mysqli_fetch_assoc($recgallery)); ?>
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
mysqli_free_result($recgallery);
?>
