<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<div class="main-content">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
      <h2>Categories</h2>
      <a href="category_form.php" class="btn">+ Add Category</a>
    </div>
    <div style="overflow-x:auto;">
      <table class="table">
        <thead><tr>
          <th>ID</th><th>Name</th><th>Description</th><th>Actions</th>
        </tr></thead>
        <tbody>
        <?php
          $result = $conn->query("SELECT * FROM categories");
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['description']}</td>
              <td>
                <a href='category_form.php?id={$row['id']}' class='btn btn-secondary btn-sm'>Edit</a>
                <a href='category_delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this category?')\">Delete</a>
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
