<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';

// Initialize variables
$id = $name = $email = $phone = $role = $status = '';
$edit = false;

// Edit mode: fetch user data
if (isset($_GET['id'])) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $role = $row['role'];
        $status = $row['status'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $password = $_POST['password'] ?? '';
    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update user
        if ($password) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, role=?, status=?, password=? WHERE id=?");
            $stmt->bind_param('ssssssi', $name, $email, $phone, $role, $status, $hashed, $_POST['id']);
        } else {
            $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, role=?, status=? WHERE id=?");
            $stmt->bind_param('sssssi', $name, $email, $phone, $role, $status, $_POST['id']);
        }
        $stmt->execute();
    } else {
        // Create user
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, role, status, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $name, $email, $phone, $role, $status, $hashed);
        $stmt->execute();
    }
    header('Location: users.php');
    exit();
}
?>
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid pt-4">
      <h2><?= $edit ? 'Edit' : 'Add' ?> User</h2>
      <form method="post">
        <?php if ($edit): ?><input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>"><?php endif; ?>
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($name) ?>">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($email) ?>">
        </div>
        <div class="form-group">
          <label>Phone</label>
          <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>">
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role" class="form-control">
            <option value="admin" <?= $role==='admin'?'selected':'' ?>>Admin</option>
            <option value="user" <?= $role==='user'?'selected':'' ?>>User</option>
            <option value="provider" <?= $role==='provider'?'selected':'' ?>>Provider</option>
          </select>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="active" <?= $status==='active'?'selected':'' ?>>Active</option>
            <option value="inactive" <?= $status==='inactive'?'selected':'' ?>>Inactive</option>
          </select>
        </div>
        <div class="form-group">
          <label>Password <?= $edit ? '(leave blank to keep unchanged)' : '' ?></label>
          <input type="password" name="password" class="form-control" <?= $edit ? '' : 'required' ?>>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="users.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </section>
</div>
<?php include '../includes/footer.php'; ?>
