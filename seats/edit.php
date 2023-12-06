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
  $updateSQL = sprintf("UPDATE seats SET seat=%s, bus=%s,  taken=%s WHERE id=%s",
                       GetSQLValueString($_POST['seat'], "int"),
                       GetSQLValueString($_POST['bus'], "int"),
                       GetSQLValueString($_POST['taken'], "int"),
                       GetSQLValueString($_POST['id'], "int"));


  $Result1 = mysql_query($updateSQL, $travelo) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}


$query_trips = "SELECT * FROM trips";
$trips = mysql_query($query_trips, $travelo) or die(mysql_error());
$row_trips = mysql_fetch_assoc($trips);
$totalRows_trips = mysql_num_rows($trips);


$query_bus = "SELECT * FROM bus";
$bus = mysql_query($query_bus, $travelo) or die(mysql_error());
$row_bus = mysql_fetch_assoc($bus);
$totalRows_bus = mysql_num_rows($bus);

$colname_seat = "-1";
if (isset($_GET['id'])) {
  $colname_seat = $_GET['id'];
}

$query_seat = sprintf("SELECT * FROM seats WHERE id = %s", GetSQLValueString($colname_seat, "int"));
$seat = mysql_query($query_seat, $travelo) or die(mysql_error());
$row_seat = mysql_fetch_assoc($seat);
$totalRows_seat = mysql_num_rows($seat);
?>
  <?php
  require_once('../sidenav.php');
  ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">المقاعد:</td>
      <td><input type="text" name="seat" value="<?php echo htmlentities($row_seat['seat'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الباص:</td>
      <td><select name="bus">
        <?php 
do {  
?>
        <option value="<?php echo $row_bus['id']?>" <?php if (!(strcmp($row_bus['id'], htmlentities($row_seat['bus'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_bus['name']?></option>
        <?php
} while ($row_bus = mysql_fetch_assoc($bus));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">محجوز:</td>
      <td><select name="taken">
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_seat['taken'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>محجوز</option>
        <option value="0" <?php if (!(strcmp(0, htmlentities($row_seat['taken'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>غير محجوز</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" class="btn btn-info" value="تعديل"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_seat['id']; ?>">
</form>
<p>&nbsp;</p>
        </div>
    </main>
    <!--Main layout-->
    <!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($trips);

mysql_free_result($bus);

mysql_free_result($seat);
?>
