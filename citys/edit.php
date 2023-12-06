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
  $updateSQL = sprintf("UPDATE cities SET name=%s, details=%s WHERE id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['details'], "text"),
                       GetSQLValueString($_POST['id'], "int"));


  $Result1 = mysql_query($updateSQL, $travelo) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_cities = "-1";
if (isset($_GET['id'])) {
  $colname_cities = $_GET['id'];
}

$query_cities = sprintf("SELECT * FROM cities WHERE id = %s", GetSQLValueString($colname_cities, "int"));
$cities = mysql_query($query_cities, $travelo) or die(mysql_error());
$row_cities = mysql_fetch_assoc($cities);
$totalRows_cities = mysql_num_rows($cities);
?>
  <?php
  require_once('../sidenav.php');
  ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">الاسم:</td>
      <td><input type="text" name="name" value="<?php echo htmlentities($row_cities['name'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">التفاصيل:</td>
      <td><textarea name="details" cols="50" rows="5"><?php echo htmlentities($row_cities['details'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" class="btn btn-info" value="تعديل"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_cities['id']; ?>">
</form>
<p>&nbsp;</p>
        </div>
    </main>
    <!--Main layout-->
    <!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($cities);
?>
