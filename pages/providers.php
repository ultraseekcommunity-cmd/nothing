<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="main-content">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <h2>Providers</h2>
      <a href="provider_form.php" class="btn">+ Add Provider</a>
    </div>
    <div style="overflow-x:auto;">
      <table class="table">
        <thead><tr>
          <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Profile</th><th>Status</th><th>Actions</th>
        </tr></thead>
        <tbody>
        <?php
          $sql = "SELECT u.id, u.name, u.email, u.phone, pp.profile_info, u.status FROM users u JOIN provider_profiles pp ON u.id = pp.user_id";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['email']}</td>
              <td>{$row['phone']}</td>
              <td>{$row['profile_info']}</td>
              <td>{$row['status']}</td>
              <td>
                <a href='provider_form.php?id={$row['id']}' class='btn btn-secondary btn-sm'>Edit</a>
                <a href='provider_delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this provider?')\">Delete</a>
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
