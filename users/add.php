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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf(
    "INSERT INTO users (user, name, password, phone, address, city, `role`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
    GetSQLValueString($_POST['user'], "text"),
    GetSQLValueString($_POST['name'], "text"),
    GetSQLValueString($_POST['password'], "text"),
    GetSQLValueString($_POST['phone'], "text"),
    GetSQLValueString($_POST['address'], "text"),
    GetSQLValueString($_POST['city'], "int"),
    GetSQLValueString($_POST['role'], "text")
  );

  $Result1 = mysql_query($insertSQL, $travelo) or die(mysql_error());
  
  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


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
      <td><input type="text" name="user" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الاسم:</td>
      <td><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">كلمة السر:</td>
      <td><input type="text" name="password" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الهاتف:</td>
      <td><input type="text" name="phone" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">العنوان:</td>
      <td><input type="text" name="address" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">المدينة:</td>
      <td><select name="city">
          <?php
          do {
          ?>
            <option value="<?php echo $row_citys['id'] ?>"><?php echo $row_citys['name'] ?></option>
          <?php
          } while ($row_citys = mysql_fetch_assoc($citys));
          ?>
        </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">الصلاحية:</td>
      <td><select name="role">
          <option value="1" <?php if (!(strcmp(1, ""))) {
                              echo "SELECTED";
                            } ?>>admin</option>
          <option value="2" <?php if (!(strcmp(2, ""))) {
                              echo "SELECTED";
                            } ?>>client</option>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit"  class="btn btn-success" value="اضافة"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</div>
</main>
<!--Main layout-->
<!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($citys);
?>