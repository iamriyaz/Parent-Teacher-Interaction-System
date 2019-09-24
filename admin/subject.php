<?php require_once('../Connections/PTS.php'); ?>
<?php
  mysql_select_db($database_PTS, $PTS);
  $cmd="";
if(!isset($_REQUEST['cmd']))
{
	exit();
}else
{
	
	$class=$_REQUEST['cmd'];
	$qry="select * from subject where standard=".$class;
	$res=mysql_query($qry,$PTS);
	while($row=mysql_fetch_assoc($res))
	{
	?>
	<option value="<?php echo($row['sub_code']); ?>"><?php echo($row['sub_name']); ?></option>
	<?php
	}
}

?>
