<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="main-content">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <h2>Bookings</h2>
      <a href="booking_form.php" class="btn">+ Add Booking</a>
    </div>
    <div style="overflow-x:auto;">
      <table class="table">
        <thead><tr>
          <th>ID</th><th>User</th><th>Service</th><th>Date</th><th>Status</th><th>Actions</th>
        </tr></thead>
        <tbody>
        <?php
          $result = $conn->query("SELECT * FROM bookings");
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['user_id']}</td>
              <td>{$row['service_id']}</td>
              <td>{$row['date']}</td>
              <td>{$row['status']}</td>
              <td>
                <a href='booking_form.php?id={$row['id']}' class='btn btn-secondary btn-sm'>Edit</a>
                <a href='booking_delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this booking?')\">Delete</a>
              </td>
            </tr>";
          }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include '../includes/footer.php'; ?>
