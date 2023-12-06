<?php require_once('../Connections/travelo.php');
// Start the session
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /travelo/');
}

$currentPage = $_SERVER["PHP_SELF"];

$query_trips = "SELECT * FROM tripsv";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_trips .= " WHERE id = $id";
}
if (isset($_GET['city'])) {
  $city = $_GET['city'];
  $query_trips .= " WHERE location = '$city'";
}

if (isset($_GET['from']) or isset($_GET['to'])) {
  $from = isset($_GET['from']) ? $_GET['from'] : $_GET['to'];
  $to = $_GET['to'];
  $query_trips .= "  WHERE Date(due) BETWEEN '$from' AND '$to'";
  
}
$trips = mysql_query($query_trips, $travelo) or die(mysql_error());
$row_trips = mysql_fetch_assoc($trips);

require_once('../sidenav.php');
?>
<div class="d-print-none">  
  <form method="get">
    <div class="form row g-1">
      <div class="col">
        <a href="report.php" class="mx-2 btn btn-warning">الكل</a>
        <a href="#" onClick="print()" class="mx-1 btn btn-dark">طباعة</a>
      </div>        
      <div class="col">
        <input type="date" name="from" class="form-control" placeholder="from">
      </div>
      <div class="col">
        <input type="date" name="to" class="form-control" placeholder="to">
      </div>
      <div class="col">
        <button type="submit" class="btn btn-primary">بحث</button>
      </div>
    </div>
  </form>
</div>
<table class="table table-bordered table-responsive mt-2">
  <tr>
    <td>#</td>
    <td>الموقغ</td>
    <td>الوجهه</td>
    <td>الزمن</td>
    <td>التوقيت</td>
    <td>الشركات</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="../bus/report.php?trip=<?php echo $row_trips['id']; ?>"><?php echo $row_trips['id']; ?></a></td>
      <td><?php echo $row_trips['location']; ?></td>
      <td><?php echo $row_trips['destination']; ?></td>
      <td><?php echo $row_trips['time']; ?></td>
      <td><?php echo $row_trips['due']; ?></td>
      <td><?php echo $row_trips['company']; ?></td>
      </tr>
  <?php } while ($row_trips = mysql_fetch_assoc($trips)); ?>
</table>
</div>
</main>
</body>

</html>
<?php
mysql_free_result($trips);
?>