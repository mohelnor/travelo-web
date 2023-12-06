<?php require_once('../Connections/travelo.php'); 
// Start the session
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /travelo/');
}

$query_seats = "SELECT * FROM seats";

if (isset($_GET['bus'])) {
  $colname_seats = $_GET['bus'];
  $query_seats = sprintf("SELECT * FROM seats WHERE bus = %s", $colname_seats);
}

$seats = mysql_query($query_seats, $travelo) or die(mysql_error());
$row_seats = mysql_fetch_assoc($seats);

?>
  <?php
  require_once('../sidenav.php');
  ?>

<div class="d-print-none">

  <a href="report.php" class="mx-2 btn btn-warning">الكل</a>
  <a href="#" onClick="print()" class="mt-2 btn btn-dark">طباعة</a>
</div>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>المقعد</td>
    <td>البصات</td>
    <td>محجوز</td>
    <td>التاريخ</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_seats['id']; ?></td>
      <td><?php echo $row_seats['seat']; ?></td>
      <td><?php echo $row_seats['bus']; ?></td>
      <td><?php echo $row_seats['taken']; ?></td>
      <td><?php echo $row_seats['date']; ?></td>
       </tr>
    <?php } while ($row_seats = mysql_fetch_assoc($seats)); ?>
</table>
        </div>
    </main>
</body>

</html>
<?php
mysql_free_result($seats);
?>
