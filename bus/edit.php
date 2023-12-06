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
  $updateSQL = sprintf("UPDATE bus SET name=%s, plate=%s, company=%s, seats=%s, ticketPrice=%s,trip=%s , status=%s, date=%s, details=%s WHERE id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['plate'], "text"),
                       GetSQLValueString($_POST['company'], "int"),
                       GetSQLValueString($_POST['seats'], "int"),
                       GetSQLValueString($_POST['ticketPrice'], "int"),
                       GetSQLValueString($_POST['trip'], "int"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['date'], "date"),
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


$query_company = "SELECT * FROM company";
$company = mysql_query($query_company, $travelo) or die(mysql_error());
$row_company = mysql_fetch_assoc($company);
$totalRows_company = mysql_num_rows($company);


$query_trips = "SELECT * FROM trips";
$trips = mysql_query($query_trips, $travelo) or die(mysql_error());
$row_trips = mysql_fetch_assoc($trips);
$totalRows_trips = mysql_num_rows($trips);

$colname_bus = "-1";
if (isset($_GET['id'])) {
  $colname_bus = $_GET['id'];
}

$query_bus = sprintf("SELECT * FROM bus WHERE id = %s", GetSQLValueString($colname_bus, "int"));
$bus = mysql_query($query_bus, $travelo) or die(mysql_error());
$row_bus = mysql_fetch_assoc($bus);
$totalRows_bus = mysql_num_rows($bus);
?>
  <?php
  require_once('../sidenav.php');
  ?>
</body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">الاسم:</td>
      <td><input type="text" name="name" value="<?php echo htmlentities($row_bus['name'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">اللوحة:</td>
      <td><input type="text" name="plate" value="<?php echo htmlentities($row_bus['plate'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الشركة:</td>
      <td><select name="company">
        <?php 
do {  
?>
        <option value="<?php echo $row_company['id']?>" <?php if (!(strcmp($row_company['id'], htmlentities($row_bus['bus'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_company['name']?></option>
        <?php
} while ($row_company = mysql_fetch_assoc($company));
?>
      </select></td>
    <tr>    
    <tr valign="baseline">
      <td nowrap align="right">المقاعد:</td>
      <td><input type="text" name="seats" value="<?php echo htmlentities($row_bus['seats'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">سعر التذكرة:</td>
      <td><input type="text" name="ticketPrice" value="<?php echo htmlentities($row_bus['ticketPrice'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">الرحلة:</td>
      <td><select name="trip">
        <?php 
do {  
?>
        <option value="<?php echo $row_trips['id']?>" <?php if (!(strcmp($row_trips['id'], htmlentities($row_bus['trip'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_trips['due']?></option>
        <?php
} while ($row_trips = mysql_fetch_assoc($trips));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">الحالة:</td>
      <td><input type="text" name="status" value="<?php echo htmlentities($row_bus['status'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">زمن القيام:</td>
      <td><input type="datetime-local" name="date" value="<?php echo htmlentities($row_bus['date'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">التفاصيل:</td>
      <td><input type="text" name="details" value="<?php echo htmlentities($row_bus['details'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" class="btn btn-info" value="تعديل"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_bus['id']; ?>">
</form>
<p>&nbsp;</p>
</html>
<?php
mysql_free_result($company);

mysql_free_result($bus);
?>
