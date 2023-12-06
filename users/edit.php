<?php require_once('../Connections/travelo.php');
// Start the session
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /travelo/');
}
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf(
    "UPDATE users SET `user`=%s, name=%s, password=%s, phone=%s, address=%s, city=%s, `role`=%s WHERE id=%s",
    GetSQLValueString($_POST['user'], "text"),
    GetSQLValueString($_POST['name'], "text"),
    GetSQLValueString($_POST['password'], "text"),
    GetSQLValueString($_POST['phone'], "text"),
    GetSQLValueString($_POST['address'], "text"),
    GetSQLValueString($_POST['city'], "int"),
    GetSQLValueString($_POST['role'], "text"),
    GetSQLValueString($_POST['id'], "int")
  );


  $Result1 = mysql_query($updateSQL, $travelo) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_user = "-1";
if (isset($_GET['id'])) {
  $colname_user = $_GET['id'];
}

$query_user = sprintf("SELECT * FROM users WHERE id = %s", GetSQLValueString($colname_user, "int"));
$user = mysql_query($query_user, $travelo) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);


$query_citys = "SELECT * FROM cities";
$citys = mysql_query($query_citys, $travelo) or die(mysql_error());
$row_citys = mysql_fetch_assoc($citys);
$totalRows_citys = mysql_num_rows($citys);
?>
<?php
require_once('../sidenav.php');
?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">المستخدم:</td>
      <td><input type="text" name="user" value="<?php echo htmlentities($row_user['user'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الاسم:</td>
      <td><input type="text" name="name" value="<?php echo htmlentities($row_user['name'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">كلمة السر:</td>
      <td><input type="text" name="password" value="<?php echo htmlentities($row_user['password'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الهاتف:</td>
      <td><input type="text" name="phone" value="<?php echo htmlentities($row_user['phone'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">العنوان:</td>
      <td><input type="text" name="address" value="<?php echo htmlentities($row_user['address'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">المدينة:</td>
      <td><select name="city">
          <?php
          do {
          ?>
            <option value="<?php echo $row_citys['id'] ?>" <?php if (!(strcmp($row_citys['id'], htmlentities($row_user['city'], ENT_COMPAT, 'utf-8')))) {
                                                            echo "SELECTED";
                                                          } ?>><?php echo $row_citys['name'] ?></option>
          <?php
          } while ($row_citys = mysql_fetch_assoc($citys));
          ?>
        </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">الصلاحية:</td>
      <td><select name="role">
          <option value="1" <?php if (!(strcmp(1, htmlentities($row_user['role'], ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                            } ?>>admin</option>
          <option value="2" <?php if (!(strcmp(2, htmlentities($row_user['role'], ENT_COMPAT, 'utf-8')))) {
                              echo "SELECTED";
                            } ?>>client</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" class="btn btn-info" value="تعديل"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_user['id']; ?>">
</form>
<p>&nbsp;</p>
</div>
</main>
<!--Main layout-->
<!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($user);

mysql_free_result($citys);
?>