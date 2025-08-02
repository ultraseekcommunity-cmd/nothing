<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="main-content">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <h2>Users</h2>
      <a href="user_form.php" class="btn">+ Add User</a>
    </div>
    <div style="overflow-x:auto;">
      <table class="table">
        <thead><tr>
          <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Actions</th>
        </tr></thead>
        <tbody>
        <?php
          $result = $conn->query("SELECT * FROM users");
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['email']}</td>
              <td>{$row['phone']}</td>
              <td>{$row['role']}</td>
              <td>{$row['status']}</td>
              <td>
                <a href='user_form.php?id={$row['id']}' class='btn btn-secondary btn-sm'>Edit</a>
                <a href='user_delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this user?')\">Delete</a>
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
