<?php
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$conn = getDBConnection();

$stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$patient = $result->fetch_assoc();
$stmt->close();
closeDBConnection($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Patient Details</h1>
        
        <div class="patient-details">
            <div class="detail-row">
                <span class="label">ID:</span>
                <span class="value"><?php echo htmlspecialchars($patient['id']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="label">First Name:</span>
                <span class="value"><?php echo htmlspecialchars($patient['first_name']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Last Name:</span>
                <span class="value"><?php echo htmlspecialchars($patient['last_name']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value"><?php echo htmlspecialchars($patient['email']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Phone:</span>
                <span class="value"><?php echo htmlspecialchars($patient['phone']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Date of Birth:</span>
                <span class="value"><?php echo htmlspecialchars($patient['date_of_birth']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Address:</span>
                <span class="value"><?php echo nl2br(htmlspecialchars($patient['address'])); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Created At:</span>
                <span class="value"><?php echo htmlspecialchars($patient['created_at']); ?></span>
            </div>
            
            <div class="detail-row">
                <span class="label">Last Updated:</span>
                <span class="value"><?php echo htmlspecialchars($patient['updated_at']); ?></span>
            </div>
        </div>
        
        <div class="form-actions">
            <a href="edit.php?id=<?php echo $patient['id']; ?>" class="btn btn-warning">Edit Patient</a>
            <a href="index.php" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</body>
</html>