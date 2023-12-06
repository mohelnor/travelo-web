<?php
require_once('Connections/travelo.php');

// Start the session
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: /travelo/');
}

$query_allbookings = "SELECT * FROM bookings";
$allbookings = mysql_query($query_allbookings, $travelo) or die(mysql_error());
$row_allbookings = mysql_fetch_assoc($allbookings);
$totalRows_allbookings = mysql_num_rows($allbookings);

$query_bookings = "SELECT * FROM bookings WHERE DATE(created) = CURRENT_DATE";
$bookings = mysql_query($query_bookings, $travelo) or die(mysql_error());
$row_bookings = mysql_fetch_assoc($bookings);
$totalRows_bookings = mysql_num_rows($bookings);

$query_users = "SELECT * FROM users";
$users = mysql_query($query_users, $travelo) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

$query_customers = "SELECT * FROM users WHERE users.`role`= 2";
$customers = mysql_query($query_customers, $travelo) or die(mysql_error());
$row_customers = mysql_fetch_assoc($customers);
$totalRows_customers = mysql_num_rows($customers);

$query_cities = "SELECT * FROM cities";
$cities = mysql_query($query_cities, $travelo) or die(mysql_error());
$row_cities = mysql_fetch_assoc($cities);
$totalRows_cities = mysql_num_rows($cities);

$query_trips = "SELECT * FROM trips WHERE DATE(trips.due) = CURRENT_DATE";
$trips = mysql_query($query_trips, $travelo) or die(mysql_error());
$row_trips = mysql_fetch_assoc($trips);
$totalRows_trips = mysql_num_rows($trips);

$query_alltrips = "SELECT * FROM trips";
$alltrips = mysql_query($query_alltrips, $travelo) or die(mysql_error());
$row_alltrips = mysql_fetch_assoc($alltrips);
$totalRows_alltrips = mysql_num_rows($alltrips);

$query_allbuses = "SELECT * FROM bus";
$allbuses = mysql_query($query_allbuses, $travelo) or die(mysql_error());
$row_allbuses = mysql_fetch_assoc($allbuses);
$totalRows_allbuses = mysql_num_rows($allbuses);

$query_buses = "SELECT * FROM bus WHERE DATE(bus.`date`) = CURRENT_DATE";
$buses = mysql_query($query_buses, $travelo) or die(mysql_error());
$row_buses = mysql_fetch_assoc($buses);
$totalRows_buses = mysql_num_rows($buses);

require_once('sidenav.php');
?>
<div class="p-0 m-0">
<a class="btn btn-secondary" href="/travelo/company/report.php">الشركات</a>
<a class="btn btn-secondary" href="/travelo/seats/report.php">المقاعد</a>
</div>
<div class="row p-2 gap-2">
    <div class="col col-md-3 card p-0">
        <div class="card-body text-center text-primary">
            <i class="fas mx-1 fa-city fa-fw me-3 fa-5x"></i>
            <span class="badge rounded-pill badge-notification bg-danger" style="font-size:24px;"><?php
            echo $totalRows_cities;
            ?></span>
        </div>
        <a href="/travelo/citys/report.php" class="list-group-item list-group-item-action py-2 ripple card-footer text-center">
            <span>المدن</span>
        </a>
    </div>
    <div class="col col-md-3 card p-0">
        <div class="card-body text-center text-warning">
            <i class="fas mx-1 fa-bus-alt fa-fw me-3 fa-5x"></i>
            <span class="badge rounded-pill badge-notification bg-danger" style="font-size:24px;"><?php
            echo $totalRows_allbuses;
            ?></span>
        </div>
        <a href="/travelo/bus/report.php" class="list-group-item list-group-item-action py-2 ripple card-footer text-center">
            <span>كل البصات</span>
        </a>
    </div>
  
    <div class="col col-md-3 card p-0">
        <div class="card-body text-center text-success">
            <i class="fas mx-1 fa-calendar-check fa-fw me-3 fa-5x"></i>
            <span class="badge rounded-pill badge-notification bg-danger" style="font-size:24px;"><?php
            echo $totalRows_allbookings;
            ?></span>
        </div>
        <a href="/travelo/bookings/report.php" class="list-group-item list-group-item-action py-2 ripple card-footer text-center">
            <span>الحجوزات</span>
        </a>
    </div> 
     <div class="col col-md-3 card p-0">
        <div class="card-body text-center text-secondary">
            <i class="fas mx-1 fa-calendar-check fa-fw me-3 fa-5x"></i>
            <span class="badge rounded-pill badge-notification bg-danger" style="font-size:24px;"><?php
            echo $totalRows_bookings;
            ?></span>
        </div>
        <a href="/travelo/bookings/report.php?today=true" class="list-group-item list-group-item-action py-2 ripple card-footer text-center">
            <span>حجوزات اليوم</span>
        </a>
    </div>
    <div class="col col-md-3 card p-0">
        <div class="card-body text-center text-black">
            <i class="fas mx-1 fa-bus-alt fa-fw me-3 fa-5x"></i>
            <span class="badge rounded-pill badge-notification bg-danger" style="font-size:24px;"><?php
            echo $totalRows_buses;
            ?></span>
        </div>
        <a href="/travelo/bus/report.php" class="list-group-item list-group-item-action py-2 ripple card-footer text-center">
            <span>بصات اليوم</span>
        </a>
    </div>
    <div class="col col-md-3 card p-0">
        <div class="card-body text-center text-info">
            <i class="fas mx-1 fa-route fa-fw me-3 fa-5x"></i>
            <span class="badge rounded-pill badge-notification bg-danger" style="font-size:24px;"><?php
            echo $totalRows_alltrips;
            ?></span>
        </div>
        <a href="/travelo/trips/report.php" class="list-group-item list-group-item-action py-2 ripple card-footer text-center">
            <span>كل الرحلات</span>
        </a>
    </div>
    <div class="col col-md-3 card p-0">
        <div class="card-body text-center">
            <i class="fas mx-1 fa-compass fa-fw me-3 fa-5x"></i>
            <span class="badge rounded-pill badge-notification bg-danger" style="font-size:24px;"><?php
            echo $totalRows_trips;
            ?></span>
        </div>
        <a href="/travelo/trips/report.php" class="list-group-item list-group-item-action py-2 ripple card-footer text-center">
            <span>الرحلات الحالية</span>
        </a>
    </div>
    <div class="col col-md-3 card p-0">
        <div class="card-body text-center text-danger">
            <i class="fas mx-1 fa-users fa-fw me-3 fa-5x"></i>
            <span class="badge rounded-pill badge-notification bg-danger" style="font-size:24px;"><?php
            echo $totalRows_customers;
            ?></span>
        </div>
        <a href="/travelo/users/report.php?role='client'" class="list-group-item list-group-item-action py-2 ripple card-footer text-center">
            <span>الزبائن</span>
        </a>
    </div>
    <div class="col col-md-3 card p-0">
        <div class="card-body text-center text-muted">
            <i class="fas mx-1 fa-users fa-fw me-3 fa-5x"></i>
            <span class="badge rounded-pill badge-notification bg-danger" style="font-size:24px;"><?php
            echo $totalRows_users;
            ?></span>
        </div>
        <a href="/travelo/users/report.php" class="list-group-item list-group-item-action py-2 ripple card-footer text-center">
            <span>المستخدمين</span>
        </a>
    </div>
</div>
</div>
</main>
<!--Main layout-->
<!-- End your project here-->
</body>

</html>
<?php
mysql_free_result($bookings);

mysql_free_result($users);

mysql_free_result($customers);

mysql_free_result($cities);

mysql_free_result($trips);

mysql_free_result($alltrips);

mysql_free_result($allbuses);

mysql_free_result($buses);
?>