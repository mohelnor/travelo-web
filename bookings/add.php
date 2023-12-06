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
  $insertSQL = sprintf("INSERT INTO bookings (`user`, fullname, phone, trip, bus, seat, luggage, price, location,notes, due) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user'], "int"),
                       GetSQLValueString($_POST['fullname'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['trip'], "int"),
                       GetSQLValueString($_POST['bus'], "int"),
                       GetSQLValueString($_POST['seat'], "int"),
                       GetSQLValueString(isset($_POST['luggage']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['price'], "int"),
                       GetSQLValueString($_POST['location'], "int"),
                       GetSQLValueString($_POST['notes'], "text"),
                       GetSQLValueString($_POST['due'], "date"));


  $Result1 = mysql_query($insertSQL, $travelo) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
        <option value="<?php echo $row_users['id']?>" ><?php echo $row_users['name']?></option>
        <?php
} while ($row_users = mysql_fetch_assoc($users));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">الاسم رباعي:</td>
      <td><input type="text" name="fullname" value="<?php echo $row_users['name']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الهاتف:</td>
      <td><input type="text" name="phone" value="<?php echo $row_users['phone']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الرحلات:</td>
      <td><select name="trip">
        <?php 
do {  
?>
        <option value="<?php echo $row_trips['id']?>" ><?php echo $row_trips['due']?></option>
        <?php
} while ($row_trips = mysql_fetch_assoc($trips));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">البصات:</td>
      <td><select name="bus">
        <?php 
do {  
?>
        <option value="<?php echo $row_bus['id']?>" ><?php echo $row_bus['name']?></option>
        <?php
} while ($row_bus = mysql_fetch_assoc($bus));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">المقعد:</td>
      <td><input type="text" name="seat" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الحقائب:</td>
      <td><input type="checkbox" name="luggage" value="" ></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">السعر:</td>
      <td><input type="text" name="price" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الموقع:</td>
      <td><select name="location">
        <?php 
do {  
?>
        <option value="<?php echo $row_location['id']?>" ><?php echo $row_location['name']?></option>
        <?php
} while ($row_location = mysql_fetch_assoc($location));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">الاقلاع:</td>
      <td><input type="datetime-local" name="due" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الملاحظات:</td>
      <td><input type="text" name="notes" value="" size="32"></td>
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
mysql_free_result($location);

mysql_free_result($trips);

mysql_free_result($seats);

mysql_free_result($bus);

mysql_free_result($users);
?>
