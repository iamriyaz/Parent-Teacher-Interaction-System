<?php require_once('Connections/PTS.php'); ?>
<?php
 mysql_select_db($database_PTS, $PTS);

$un="";
if(!isset($_REQUEST['username']))
{
	exit();
}else
{
	$un=$_REQUEST['username'];

	
	$qry="select * from teacher where Username='$un'" or error_log(mysqli_error($PTS));
	$res=mysql_query($qry,$PTS);
	if(mysql_num_rows($res)>0)
	{
		echo 0;
	}
	else
	{
			echo 1;
	}
}

?>