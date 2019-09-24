<?php require_once('Connections/PTS.php'); ?>
<?php
 mysqli_select_db($database_PTS, $PTS);

$un="";
if(!isset($_REQUEST['username']))
{
	exit();
}else
{
	$un=$_REQUEST['username'];

	
	$qry="select * from teacher where Username='$un'" or error_log(mysqlii_error($PTS));
	$res=mysqli_query($qry,$PTS);
	if(mysqli_num_rows($res)>0)
	{
		echo 0;
	}
	else
	{
			echo 1;
	}
}

?>