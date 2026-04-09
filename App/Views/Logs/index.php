<?php include 'App/Views/Layout/header.php'; ?>
<div class="content-wrapper">
  <div class="container">
    <h4 class="mb-4">
      <i class="bi bi-list-check"></i> Journal des actions
    </h4>

    <div class="saas-card">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>Utilisateur</th>
            <th>Module</th>
            <th>Action</th>
            <th>Description</th>
            <th>IP</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($logs as $log): ?>
            <tr>
              <td><?= $log['created_at'] ?></td>
              <td><?= htmlspecialchars($log['name'] ?? '—') ?></td>
              <td><?= $log['module'] ?></td>
              <td><?= $log['action'] ?></td>
              <td><?= htmlspecialchars($log['description']) ?></td>
              <td><?= $log['ip_address'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include 'App/Views/Layout/footer.php'; ?>