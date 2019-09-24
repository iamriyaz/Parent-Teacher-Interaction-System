<?php require_once('../Connections/PTS.php'); ?>
<?php
  mysqli_select_db($database_PTS, $PTS);
  $cmd="";
if(!isset($_REQUEST['cmd']))
{
	exit();
}else
{
	
	$class=$_REQUEST['cmd'];
	$qry="select * from subject where standard=".$class;
	$res=mysqli_query($qry,$PTS);
	while($row=mysqli_fetch_assoc($res))
	{
	?>
	<option value="<?php echo($row['sub_code']); ?>"><?php echo($row['sub_name']); ?></option>
	<?php
	}
}

?>
