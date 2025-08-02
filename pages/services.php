<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="main-content">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <h2>Services</h2>
      <a href="service_form.php" class="btn">+ Add Service</a>
    </div>
    <div style="overflow-x:auto;">
      <table class="table">
        <thead><tr>
          <th>ID</th><th>Name</th><th>Description</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th>
        </tr></thead>
        <tbody>
        <?php
          $result = $conn->query("SELECT * FROM services");
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['description']}</td>
              <td>{$row['category_id']}</td>
              <td>{$row['price']}</td>
              <td>{$row['status']}</td>
              <td>
                <a href='service_form.php?id={$row['id']}' class='btn btn-secondary btn-sm'>Edit</a>
                <a href='service_delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this service?')\">Delete</a>
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
