<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

if(isset($_POST['btnlogout']))
{
	 $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['uname']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="279" border="0" align="center">
    <tr>
      <td height="51"><div align="left">
        <h2><strong>Log Out</strong></h2>
      </div></td>
    </tr>
    <tr>
      <td>Are u sure want to Log Out..?</td>
    </tr>
    <tr>
      <td><div align="right">
        <input type="submit" name="btnlogout" id="btnlogout" value="Log Out" />
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>