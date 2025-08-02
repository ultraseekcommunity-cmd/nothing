<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $name = $description = '';
$edit = false;

if (isset($_GET['id'])) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id=?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        $description = $row['description'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    if (isset($_POST['id']) && $_POST['id'] != '') {
        $stmt = $conn->prepare("UPDATE categories SET name=?, description=? WHERE id=?");
        $stmt->bind_param('ssi', $name, $description, $_POST['id']);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        $stmt->bind_param('ss', $name, $description);
        $stmt->execute();
    }
    header('Location: categories.php');
    exit();
}
?>
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid pt-4">
      <h2><?= $edit ? 'Edit' : 'Add' ?> Category</h2>
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
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="categories.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </section>
</div>
<?php include '../includes/footer.php'; ?>
