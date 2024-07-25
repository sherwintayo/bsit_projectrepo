<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notificationId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    if ($notificationId > 0 && $status === 'read') {
        $stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE id = ?");
        $stmt->bind_param('i', $notificationId);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();
}
?>
