<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $name = $email = $phone = $profile_info = $status = '';
$edit = false;

// Edit mode: fetch provider data
if (isset($_GET['id'])) {
    $edit = true;
    $stmt = $conn->prepare("SELECT u.*, pp.profile_info FROM users u JOIN provider_profiles pp ON u.id = pp.user_id WHERE u.id=?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $profile_info = $row['profile_info'];
        $status = $row['status'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $profile_info = $_POST['profile_info'];
    $status = $_POST['status'];
    $password = $_POST['password'] ?? '';
    if (isset($_POST['id']) && $_POST['id'] != '') {
        // Update provider
        if ($password) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, status=?, password=? WHERE id=?");
            $stmt->bind_param('sssssi', $name, $email, $phone, $status, $hashed, $_POST['id']);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, status=? WHERE id=?");
            $stmt->bind_param('ssssi', $name, $email, $phone, $status, $_POST['id']);
            $stmt->execute();
        }
        // Update provider_profiles
        $stmt = $conn->prepare("UPDATE provider_profiles SET profile_info=? WHERE user_id=?");
        $stmt->bind_param('si', $profile_info, $_POST['id']);
        $stmt->execute();
    } else {
        // Create provider
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, role, status, password) VALUES (?, ?, ?, 'provider', ?, ?)");
        $stmt->bind_param('sssss', $name, $email, $phone, $status, $hashed);
        $stmt->execute();
        $new_id = $conn->insert_id;
        $stmt = $conn->prepare("INSERT INTO provider_profiles (user_id, profile_info) VALUES (?, ?)");
        $stmt->bind_param('is', $new_id, $profile_info);
        $stmt->execute();
    }
    header('Location: providers.php');
    exit();
}
?>
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid pt-4">
      <h2><?= $edit ? 'Edit' : 'Add' ?> Provider</h2>
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
          <label>Profile Info</label>
          <textarea name="profile_info" class="form-control" required><?= htmlspecialchars($profile_info) ?></textarea>
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
        <a href="providers.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </section>
</div>
<?php include '../includes/footer.php'; ?>
