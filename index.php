<?php
include 'includes/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="main-content">
  <div class="card">
    <h2>SHEMATECARE</h2>
    <p>Welcome to the SHEMATECARE Admin Panel Dashboard.</p>
    <div style="margin-top:32px;display:flex;gap:32px;flex-wrap:wrap;">
      <div style="flex:1 1 180px;background:#f7fafc;padding:22px 28px;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.03);">
        <div style="font-size:2.1rem;font-weight:600;color:#3182ce;">👤</div>
        <div style="font-size:1.2rem;">Users</div>
        <div style="font-size:2rem;font-weight:600;">-</div>
      </div>
      <div style="flex:1 1 180px;background:#f7fafc;padding:22px 28px;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.03);">
        <div style="font-size:2.1rem;font-weight:600;color:#38a169;">🛠️</div>
        <div style="font-size:1.2rem;">Services</div>
        <div style="font-size:2rem;font-weight:600;">-</div>
      </div>
      <div style="flex:1 1 180px;background:#f7fafc;padding:22px 28px;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.03);">
        <div style="font-size:2.1rem;font-weight:600;color:#d69e2e;">📦</div>
        <div style="font-size:1.2rem;">Bookings</div>
        <div style="font-size:2rem;font-weight:600;">-</div>
      </div>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
