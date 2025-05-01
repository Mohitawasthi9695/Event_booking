<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div id="wrapper">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <h2>Ticket Booking</h2>
    </div>
    <ul class="sidebar-nav">
      <li class="<?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
        <a href="dashboard.php"><i class="fa fa-home"></i>Events</a>
      </li>
      <li class="<?= ($current_page == 'booked_event.php') ? 'active' : '' ?>">
        <a href="booked_event.php"><i class="fa fa-plug"></i>Booked Event</a>
      </li>
      <li class="<?= ($current_page == 'logout.php') ? 'active' : '' ?>">
        <a href="logout.php"><i class="fa fa-user"></i>Logout</a>
      </li>
    </ul>
  </aside>
</div>