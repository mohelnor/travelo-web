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
  $updateSQL = sprintf("UPDATE bookings SET user=%s, fullname=%s, phone=%s, trip=%s, bus=%s, seat=%s, luggage=%s, price=%s,payed=%s, location=%s,notes=%s, due=%s WHERE id=%s",
                       GetSQLValueString($_POST['user'], "int"),
                       GetSQLValueString($_POST['fullname'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['trip'], "int"),
                       GetSQLValueString($_POST['bus'], "int"),
                       GetSQLValueString($_POST['seat'], "int"),
                       GetSQLValueString(isset($_POST['luggage']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['price'], "int"),
                       GetSQLValueString($_POST['payed'], "int"),
                       GetSQLValueString($_POST['location'], "int"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['due'], "date"),
                       GetSQLValueString($_POST['id'], "int"));


                       echo $updateSQL;
  $Result1 = mysql_query($updateSQL, $travelo) or die(mysql_error());
  $updateGoTo = "index.php";
  header(sprintf("Location: %s", $updateGoTo));
}


$query_location = "SELECT * FROM cities";
$location = mysql_query($query_location, $travelo) or die(mysql_error());
$row_location = mysql_fetch_assoc($location);
$totalRows_location = mysql_num_rows($location);


$query_trips = "SELECT * FROM trips";
$trips = mysql_query($query_trips, $travelo) or die(mysql_error());
$row_trips = mysql_fetch_assoc($trips);
$totalRows_trips = mysql_num_rows($trips);


$query_seats = "SELECT * FROM seats";
$seats = mysql_query($query_seats, $travelo) or die(mysql_error());
$row_seats = mysql_fetch_assoc($seats);
$totalRows_seats = mysql_num_rows($seats);


$query_bus = "SELECT * FROM bus";
$bus = mysql_query($query_bus, $travelo) or die(mysql_error());
$row_bus = mysql_fetch_assoc($bus);
$totalRows_bus = mysql_num_rows($bus);


$query_users = "SELECT * FROM users";
$users = mysql_query($query_users, $travelo) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

$colname_bookings = "-1";
if (isset($_GET['id'])) {
  $colname_bookings = $_GET['id'];
}

$query_bookings = sprintf("SELECT * FROM bookings WHERE id = %s", GetSQLValueString($colname_bookings, "int"));
$bookings = mysql_query($query_bookings, $travelo) or die(mysql_error());
$row_bookings = mysql_fetch_assoc($bookings);
$totalRows_bookings = mysql_num_rows($bookings);
?>
  <?php
  require_once('../sidenav.php');
  ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">المستخدم:</td>
      <td><select name="user">
        <?php 
do {  
?>
        <option value="<?php echo $row_users['id']?>" <?php if (!(strcmp($row_users['id'], htmlentities($row_bookings['user'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_users['name']?></option>
        <?php
} while ($row_users = mysql_fetch_assoc($users));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">الاسم رباعي:</td>
      <td><input type="text" name="fullname" value="<?php echo htmlentities($row_bookings['fullname'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الهاتف:</td>
      <td><input type="text" name="phone" value="<?php echo htmlentities($row_bookings['phone'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الرحلة:</td>
      <td><select name="trip">
        <?php 
do {  
?>
        <option value="<?php echo $row_trips['id']?>" <?php if (!(strcmp($row_trips['id'], htmlentities($row_bookings['trip'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_trips['due']?></option>
        <?php
} while ($row_trips = mysql_fetch_assoc($trips));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">الباص:</td>
      <td><select name="bus">
        <?php 
do {  
?>
        <option value="<?php echo $row_bus['id']?>" <?php if (!(strcmp($row_bus['id'], htmlentities($row_bookings['bus'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_bus['seats']?></option>
        <?php
} while ($row_bus = mysql_fetch_assoc($bus));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">المقاعد:</td>
      <td><select name="seat">
        <?php 
do {  
?>
        <option value="<?php echo $row_seats['id']?>" <?php if (!(strcmp($row_seats['id'], htmlentities($row_bookings['seat'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_seats['seat']?></option>
        <?php
} while ($row_seats = mysql_fetch_assoc($seats));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">Luggage:</td>
      <td><input type="checkbox" name="luggage" value=""  <?php if (!(strcmp(htmlentities($row_bookings['luggage'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?>></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Price:</td>
      <td><input type="text" name="price" value="<?php echo htmlentities($row_bookings['price'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Payed:</td>
      <td><select name="payed">
     
        <option value="1" <?php if ($row_bookings['payed'] == 1) {echo "SELECTED";} ?>>مدفوع</option>
        <option value="0" <?php if ($row_bookings['payed'] == 0) {echo "SELECTED";} ?>>غير مدفوع</option>
       
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الموقع الحالي:</td>
      <td><select name="location">
        <?php 
do {  
?>
        <option value="<?php echo $row_location['id']?>" <?php if (!(strcmp($row_location['id'], htmlentities($row_bookings['bookings'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_location['name']?></option>
        <?php
} while ($row_location = mysql_fetch_assoc($location));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">زمن القيام:</td>
      <td><input type="text" name="due" value="<?php echo htmlentities($row_bookings['due'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الملاحظات:</td>
      <td><input type="text" name="notes" value="<?php echo htmlentities($row_bookings['notes'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" class="btn btn-info" value="تعديل"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_bookings['id']; ?>">
</form>
<p>&nbsp;</p>
        </div>
    </main>
    <!--Main layout-->
    <!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($location);

mysql_free_result($trips);

mysql_free_result($seats);

mysql_free_result($bus);

mysql_free_result($bookings);
?>
