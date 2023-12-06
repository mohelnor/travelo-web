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
    "UPDATE trips SET location=%s, destination=%s, `time`=%s, due=%s, company=%s WHERE id=%s",
    GetSQLValueString($_POST['location'], "int"),
    GetSQLValueString($_POST['destination'], "int"),
    GetSQLValueString($_POST['time'], "text"),
    GetSQLValueString($_POST['due'], "date"),
    GetSQLValueString($_POST['company'], "int"),
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


$query_cities = "SELECT * FROM cities";
$cities = mysql_query($query_cities, $travelo) or die(mysql_error());
$cities2 = mysql_query($query_cities, $travelo) or die(mysql_error());
$row_cities = mysql_fetch_assoc($cities);
$totalRows_cities = mysql_num_rows($cities);


$query_company = "SELECT * FROM company";
$company = mysql_query($query_company, $travelo) or die(mysql_error());
$row_company = mysql_fetch_assoc($company);
$totalRows_company = mysql_num_rows($company);

$colname_trips = "-1";
if (isset($_GET['id'])) {
  $colname_trips = $_GET['id'];
}

$query_trips = sprintf("SELECT * FROM trips WHERE id = %s", GetSQLValueString($colname_trips, "int"));
$trips = mysql_query($query_trips, $travelo) or die(mysql_error());
$row_trips = mysql_fetch_assoc($trips);
$totalRows_trips = mysql_num_rows($trips);
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
              <option value="<?php echo $row_cities['id'] ?>" <?php if (!(strcmp($row_cities['id'], htmlentities($row_trips['location'], ENT_COMPAT, 'utf-8')))) {
                                                                echo "SELECTED";
                                                              } ?>><?php echo $row_cities['name'] ?></option>
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
              <option value="<?php echo $row_cities['id'] ?>" <?php if (!(strcmp($row_cities['id'], htmlentities($row_trips['destination'], ENT_COMPAT, 'utf-8')))) {
                                                                echo "SELECTED";
                                                              } ?>><?php echo $row_cities['name'] ?></option>
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
        <td><input type="datetime-local" name="due" value="<?php echo htmlentities($row_trips['due'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">الشركة:</td>
        <td><select name="company">
            <?php
            do {
            ?>
              <option value="<?php echo $row_company['id'] ?>" <?php if (!(strcmp($row_company['id'], htmlentities($row_trips['company'], ENT_COMPAT, 'utf-8')))) {
                                                                echo "SELECTED";
                                                              } ?>><?php echo $row_company['name'] ?></option>
            <?php
            } while ($row_company = mysql_fetch_assoc($company));
            ?>
          </select></td>
      <tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit" class="btn btn-info" value="تعديل"></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1">
    <input type="hidden" name="id" value="<?php echo $row_trips['id']; ?>">
  </form>
  <p>&nbsp;</p>
</body>

</html>
<?php
mysql_free_result($cities);

mysql_free_result($company);

mysql_free_result($trips);
?>