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
    "INSERT INTO trips (location, destination, `time`, due, company) VALUES (%s, %s, %s, %s, %s)",
    GetSQLValueString($_POST['location'], "int"),
    GetSQLValueString($_POST['destination'], "int"),
    GetSQLValueString($_POST['time'], "text"),
    GetSQLValueString($_POST['due'], "date"),
    GetSQLValueString($_POST['company'], "int")
  );


  $Result1 = mysql_query($insertSQL, $travelo) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


$query_cities = "SELECT * FROM cities";
$cities = mysql_query($query_cities, $travelo) or die(mysql_error());
$cities2 = mysql_query($query_cities, $travelo) or die(mysql_error());
$row_cities = mysql_fetch_assoc($cities);
$totalRows_cities = mysql_num_rows($cities);


$query_company = "SELECT * FROM company";
$company = mysql_query($query_company, $travelo) or die(mysql_error());
$row_company = mysql_fetch_assoc($company);
$totalRows_company = mysql_num_rows($company);
?>
  <?php
  require_once('../sidenav.php');
  ?>

  <?php
  require_once('../sidenav.php');
  ?>  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <table align="center">
      <tr valign="baseline">
        <td nowrap align="right">الموقع الحالي:</td>
        <td><select name="location">
            <?php
            do {
            ?>
              <option value="<?php echo $row_cities['id'] ?>"><?php echo $row_cities['name'] ?></option>
            <?php
            } while ($row_cities = mysql_fetch_assoc($cities));
            ?>
          </select></td>
      <tr>
      <tr valign="baseline">
        <td nowrap align="right">الوجهة:</td>
        <td><select name="destination">
            <?php
            do {
            ?>
              <option value="<?php echo $row_cities['id'] ?>"><?php echo $row_cities['name'] ?></option>
            <?php
            } while ($row_cities = mysql_fetch_assoc($cities2));
            ?>
          </select></td>
      <tr>
      <tr valign="baseline">
        <td nowrap align="right">زمن:</td>
        <td>
          <select name="time">
            <option value="1">صباح</option>
            <option value="2">الليل</option>
          </select>
        </td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">زمن القيام:</td>
        <td><input type="datetime-local" name="due" value="" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">الشركة:</td>
        <td><select name="company">
            <?php
            do {
            ?>
              <option value="<?php echo $row_company['id'] ?>"><?php echo $row_company['name'] ?></option>
            <?php
            } while ($row_company = mysql_fetch_assoc($company));
            ?>
          </select></td>
      <tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit"  class="btn btn-success" value="اضافة"></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1">
  </form>
  <p>&nbsp;</p>
</body>

</html>
<?php
mysql_free_result($cities);
mysql_free_result($company);
?>