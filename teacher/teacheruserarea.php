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

$maxRows_Recteacherpro = 1;
$pageNum_Recteacherpro = 0;
if (isset($_GET['pageNum_Recteacherpro'])) {
  $pageNum_Recteacherpro = $_GET['pageNum_Recteacherpro'];
}
$startRow_Recteacherpro = $pageNum_Recteacherpro * $maxRows_Recteacherpro;

mysqli_select_db($database_PTS, $PTS);
$query_Recteacherpro = "SELECT * FROM teacher WHERE teacher.username='$username'";
$query_limit_Recteacherpro = sprintf("%s LIMIT %d, %d", $query_Recteacherpro, $startRow_Recteacherpro, $maxRows_Recteacherpro);
$Recteacherpro = mysqli_query($query_limit_Recteacherpro, $PTS) or die(mysqli_error());
$row_Recteacherpro = mysqli_fetch_assoc($Recteacherpro);

if (isset($_GET['totalRows_Recteacherpro'])) {
  $totalRows_Recteacherpro = $_GET['totalRows_Recteacherpro'];
} else {
  $all_Recteacherpro = mysqli_query($query_Recteacherpro);
  $totalRows_Recteacherpro = mysqli_num_rows($all_Recteacherpro);
}
$totalPages_Recteacherpro = ceil($totalRows_Recteacherpro/$maxRows_Recteacherpro)-1;
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
								<h2 class="section-heading animated" data-animation="bounceInUp">Profile</h2>
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
  <table  border="0" class="table table-striped">
    <tr>
      <td width="284">&nbsp;</td>
      <td width="373">&nbsp;</td>
    </tr>
    <?php do { ?>
      <tr>
        <td>Faculty_no</td>
        <td><?php echo $row_Recteacherpro['faculty_no']; ?></td>
      </tr>
      <tr>
        <td>First_name</td>
        <td><?php echo $row_Recteacherpro['first_name']; ?></td>
      </tr>
      <tr>
        <td>Last_name</td>
        <td><?php echo $row_Recteacherpro['last_name']; ?></td>
      </tr>
      <tr>
        <td>Address</td>
        <td><?php echo $row_Recteacherpro['address']; ?></td>
      </tr>
      <tr>
        <td>Phone_no</td>
        <td><?php echo $row_Recteacherpro['phone_no']; ?></td>
      </tr>
      <tr>
        <td>E_mail</td>
        <td><?php echo $row_Recteacherpro['e_mail']; ?></td>
      </tr>
      <tr>
        <td>Experience</td>
        <td><?php echo $row_Recteacherpro['experience']; ?></td>
      </tr>
      <tr>
        <td>Qualification</td>
        <td><?php echo $row_Recteacherpro['qualification']; ?></td>
      </tr>
      <tr>
        <td>Gender</td>
        <td><?php echo $row_Recteacherpro['gender']; ?></td>
      </tr>
      <tr>
        <td>Is_class_teacher</td>
        <td><?php echo $row_Recteacherpro['is_class_teacher']; ?></td>
      </tr>
      <tr>
        <td>Standard</td>
        <td><?php echo $row_Recteacherpro['standard']; ?></td>
      </tr>
      <tr>
        <td>Division</td>
        <td><?php echo $row_Recteacherpro['division']; ?></td>
      </tr>
      <tr>
        <td>Username</td>
        <td><?php echo $row_Recteacherpro['username']; ?></td>
      </tr>
      <tr>
        <td>Subject</td>
        <td><?php echo $row_Recteacherpro['subject']; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><a href="updateteacher.php?faculty_no=<?php echo $row_Recteacherpro['faculty_no']; ?>">Update profile</a></td>
      </tr>
      <?php } while ($row_Recteacherpro = mysqli_fetch_assoc($Recteacherpro)); ?>
  </table>
</form>
</div>
</div>
               	</div>	
				</div>
					
			</div>
			
		</div>
	</section>
	<!--/about-->
<?php require_once('footer.php')?><?php
mysqli_free_result($Recteacherpro);
?>
