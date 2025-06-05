<?php
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

// Initialize date filter variables
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// Build the query with optional date filtering
$sql = "
    SELECT l.LogID, l.Timestamp, l.Action, a.FullName AS AdminName
    FROM tblAdminLogs l
    JOIN tblAdmins ad ON l.AdminID = ad.AdminID
    JOIN tblUsers a ON ad.UserID = a.UserID
    WHERE 1=1
";

$params = [];
if (!empty($start_date)) {
    $sql .= " AND l.Timestamp >= ?";
    $params[] = $start_date;
}
if (!empty($end_date)) {
    $sql .= " AND l.Timestamp <= ?";
    $params[] = $end_date;
}

$sql .= " ORDER BY l.Timestamp DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll();

require_once '../admin/admin_header.php';
?>

<h2>Admin Activity Logs</h2>

<!-- Date Filter Form -->
<form method="GET" style="margin-bottom: 20px; display: flex; gap: 10px; align-items: center;">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
    <button type="submit">Filter</button>
    <a href="logs.php" class="clear-filter-button" style="text-decoration: none; padding: 8px 15px; background-color: #ccc; color: #000; border: 1px solid #999; border-radius: 5px;">Clear Filter</a>
</form>

<?php if (empty($logs)): ?>
    <p>No logs found for the selected date range.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Log ID</th>
                <th>Timestamp</th>
                <th>Admin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['LogID']) ?></td>
                    <td><?= htmlspecialchars($log['Timestamp']) ?></td>
                    <td><?= htmlspecialchars($log['AdminName']) ?></td>
                    <td><?= htmlspecialchars($log['Action']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>