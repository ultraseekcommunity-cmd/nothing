<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $name = $description = $category_id = $price = $status = '';
$edit = false;

// Fetch categories for dropdown
$categories = [];
$result = $conn->query("SELECT id, name FROM categories");
while ($cat = $result->fetch_assoc()) {
    $categories[] = $cat;
}

if (isset($_GET['id'])) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM services WHERE id=?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        $description = $row['description'];
        $category_id = $row['category_id'];
        $price = $row['price'];
        $status = $row['status'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    if (isset($_POST['id']) && $_POST['id'] != '') {
        $stmt = $conn->prepare("UPDATE services SET name=?, description=?, category_id=?, price=?, status=? WHERE id=?");
        $stmt->bind_param('ssidsi', $name, $description, $category_id, $price, $status, $_POST['id']);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO services (name, description, category_id, price, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssids', $name, $description, $category_id, $price, $status);
        $stmt->execute();
    }
    header('Location: services.php');
    exit();
}
?>
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid pt-4">
      <h2><?= $edit ? 'Edit' : 'Add' ?> Service</h2>
      <form method="post">
        <?php if ($edit): ?><input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>"><?php endif; ?>
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($name) ?>">
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" required><?= htmlspecialchars($description) ?></textarea>
        </div>
        <div class="form-group">
          <label>Category</label>
          <select name="category_id" class="form-control" required>
            <option value="">Select</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>" <?= $category_id==$cat['id']?'selected':'' ?>><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Price</label>
          <input type="number" step="0.01" name="price" class="form-control" required value="<?= htmlspecialchars($price) ?>">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="active" <?= $status==='active'?'selected':'' ?>>Active</option>
            <option value="inactive" <?= $status==='inactive'?'selected':'' ?>>Inactive</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="services.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </section>
</div>
<?php include '../includes/footer.php'; ?>
