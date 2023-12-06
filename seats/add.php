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
  $insertSQL = sprintf("INSERT INTO seats (seat, bus,  taken) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['seat'], "int"),
                       GetSQLValueString($_POST['bus'], "int"),
                       GetSQLValueString($_POST['taken'], "int"));


  $Result1 = mysql_query($insertSQL, $travelo) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


$query_bus = "SELECT * FROM bus";
$bus = mysql_query($query_bus, $travelo) or die(mysql_error());
$row_bus = mysql_fetch_assoc($bus);
$totalRows_bus = mysql_num_rows($bus);
?>
  <?php
  require_once('../sidenav.php');
  ?>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">المقاعد:</td>
      <td><input type="text" name="seat" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">الباص:</td>
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
      <td nowrap align="right">محجوز:</td>
      <td><select name="taken">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>محجوز</option>
        <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>غير محجوز</option>
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
mysql_free_result($bus);
?>
