<?php require_once('../Connections/travelo.php');
// Start the session
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
  header('Location: /travelo/');
}


$currentPage = $_SERVER["PHP_SELF"];

$query_bookings = "SELECT * FROM bookings";

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query_bookings .= " WHERE id = $id";
}

if (isset($_GET['today'])) {
  $query_bookings .= " WHERE DATE(created) = CURRENT_DATE";
}

if (isset($_GET['user'])) {
  $query_bookings .= " WHERE user = ".$_GET['user'];
}

$bookings = mysql_query($query_bookings, $travelo) or die(mysql_error());
$row_bookings = mysql_fetch_assoc($bookings);
$totalRows_bookings = mysql_num_rows($bookings);

require_once('../sidenav.php');
?>

<div class="d-print-none">
  <a href="?today=true" class="btn btn-warning">اليوم</a>
  <a href="?all" class="btn btn-info">الكل</a>
  <a href="#" onClick="print()" class="mt-2 btn btn-dark">طباعة</a>
</div>

  <table class="table table-bordered mt-2">
    <tr>
      <td>#</td>
      <td>المستخدم</td>
      <td>الأسم رباعي</td>
      <td>الهاتف</td>
      <td>الرحلات</td>
      <td>البصات</td>
      <td>الدفع</td>
      <td>المقعد</td>
      <td>الأمتعة</td>
      <td>السعر</td>
      <td>الموقع</td>
      <td>التوقيت</td>
      <td>تاريخ التسجيل</td>
    </tr>
    <?php if ($totalRows_bookings > 0) { // Show if recordset not empty 
    ?>
      <?php do { ?>
        <tr class=" <?php
        if ($row_bookings['payed'] == 1) {
          echo 'bg-secondary';
        }
        ?>">
          <td><?php echo $row_bookings['id'];?></td>
          <td><?php echo $row_bookings['user']; ?></td>
          <td><?php echo $row_bookings['fullname']; ?></td>
          <td><?php echo $row_bookings['phone']; ?></td>
          <td><?php echo $row_bookings['trip']; ?></td>
          <td><?php echo $row_bookings['bus']; ?></td>
          <td>
            <?php
            if ($row_bookings['payed'] == 1) {
              echo 'دافع';
            }else{
              echo 'ما دافع';

            }
             ?>
        </td>
          <td><?php echo $row_bookings['seat']; ?></td>
          <td><?php echo $row_bookings['luggage']; ?></td>
          <td><?php echo $row_bookings['price']; ?></td>
          <td><?php echo $row_bookings['location']; ?></td>
          <td><?php echo $row_bookings['due']; ?></td>
          <td><?php echo $row_bookings['created']; ?></td>
        </tr>
      <?php } while ($row_bookings = mysql_fetch_assoc($bookings)); ?>
    <?php } else {
    ?>
      <tr>
        <td colspan="13" class="text-center">لا توجد سجلات</td>
      </tr>
    <?php
    }
    ?>
</div>
</table>
</main>
<!--Main layout-->
<!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($bookings);
?>