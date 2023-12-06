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
  $insertSQL = sprintf("INSERT INTO bus ( name, plate, company, seats, ticketPrice, trip, status, `date`, details) VALUES (%s, %s, %s, %s, %s,%s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['plate'], "text"),
                       GetSQLValueString($_POST['company'], "int"),
                       GetSQLValueString($_POST['seats'], "int"),
                       GetSQLValueString($_POST['ticketPrice'], "int"),
                       GetSQLValueString($_POST['trip'], "int"),
                       GetSQLValueString($_POST['status'], "int"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['details'], "text"));


  $Result1 = mysql_query($insertSQL, $travelo) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


$query_company = "SELECT * FROM company";
$company = mysql_query($query_company, $travelo) or die(mysql_error());
$row_company = mysql_fetch_assoc($company);
$totalRows_company = mysql_num_rows($company);

$query_trips = "SELECT * FROM trips";
$trips = mysql_query($query_trips, $travelo) or die(mysql_error());
$row_trips = mysql_fetch_assoc($trips);
$totalRows_trips = mysql_num_rows($trips);
?>
  <?php
  require_once('../sidenav.php');
  ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">الاسم:</td>
      <td><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">اللوحة:</td>
      <td><input type="text" name="plate" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الشركة:</td>
      <td><select name="company">
        <?php 
do {  
?>
        <option value="<?php echo $row_company['id']?>" ><?php echo $row_company['name']?></option>
        <?php
} while ($row_company = mysql_fetch_assoc($company));
?>
      </select></td>
    <tr>
    <tr valign="baseline">
      <td nowrap align="right">المقاعد:</td>
      <td><input type="text" name="seats" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">سعر التذكرة:</td>
      <td><input type="text" name="ticketPrice" value="" size="32"></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">الرحلة:</td>
      <td><select name="trip">
        <?php 
do {  
?>
        <option value="<?php echo $row_trips['id']?>" ><?php echo $row_trips['due']?></option>
        <?php
} while ($row_trips = mysql_fetch_assoc($trips));
?>
      </select></td>
</tr>
    <tr valign="baseline">
      <td nowrap align="right">الحالة:</td>
      <td><input type="text" name="status" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">زمن القيام:</td>
      <td><input type="datetime-local" name="date" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">التفاصيل:</td>
      <td><input type="text" name="details" value="" size="32"></td>
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
mysql_free_result($company);
?>
