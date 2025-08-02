<?php
include '../includes/db.php';
include '../includes/header.php';
include '../includes/sidebar.php';

$id = $user_id = $service_id = $date = $status = '';
$edit = false;

// Fetch users and services for dropdowns
$users = [];
$result = $conn->query("SELECT id, name FROM users");
while ($u = $result->fetch_assoc()) {
    $users[] = $u;
}
$services = [];
$result = $conn->query("SELECT id, name FROM services");
while ($s = $result->fetch_assoc()) {
    $services[] = $s;
}

if (isset($_GET['id'])) {
    $edit = true;
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE id=?");
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $user_id = $row['user_id'];
        $service_id = $row['service_id'];
        $date = $row['date'];
        $status = $row['status'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $service_id = $_POST['service_id'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    if (isset($_POST['id']) && $_POST['id'] != '') {
        $stmt = $conn->prepare("UPDATE bookings SET user_id=?, service_id=?, date=?, status=? WHERE id=?");
        $stmt->bind_param('iissi', $user_id, $service_id, $date, $status, $_POST['id']);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, service_id, date, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iiss', $user_id, $service_id, $date, $status);
        $stmt->execute();
    }
    header('Location: bookings.php');
    exit();
}
?>
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid pt-4">
      <h2><?= $edit ? 'Edit' : 'Add' ?> Booking</h2>
      <form method="post">
        <?php if ($edit): ?><input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>"><?php endif; ?>
        <div class="form-group">
          <label>User</label>
          <select name="user_id" class="form-control" required>
            <option value="">Select</option>
            <?php foreach ($users as $u): ?>
              <option value="<?= $u['id'] ?>" <?= $user_id==$u['id']?'selected':'' ?>><?= htmlspecialchars($u['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Service</label>
          <select name="service_id" class="form-control" required>
            <option value="">Select</option>
            <?php foreach ($services as $s): ?>
              <option value="<?= $s['id'] ?>" <?= $service_id==$s['id']?'selected':'' ?>><?= htmlspecialchars($s['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Date</label>
          <input type="date" name="date" class="form-control" required value="<?= htmlspecialchars($date) ?>">
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="pending" <?= $status==='pending'?'selected':'' ?>>Pending</option>
            <option value="confirmed" <?= $status==='confirmed'?'selected':'' ?>>Confirmed</option>
            <option value="completed" <?= $status==='completed'?'selected':'' ?>>Completed</option>
            <option value="cancelled" <?= $status==='cancelled'?'selected':'' ?>>Cancelled</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="bookings.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </section>
</div>
<?php include '../includes/footer.php'; ?>
