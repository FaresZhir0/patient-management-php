<?php
require_once 'config.php';

$conn = getDBConnection();
$sql = "SELECT * FROM patients ORDER BY id DESC";
$result = $conn->query($sql);

// Handle delete action
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete_sql = "DELETE FROM patients WHERE id = $id";
    if ($conn->query($delete_sql)) {
        header("Location: index.php?msg=deleted");
        exit();
    }
}

$message = '';
if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'added':
            $message = '<div class="alert success">Patient added successfully!</div>';
            break;
        case 'updated':
            $message = '<div class="alert success">Patient updated successfully!</div>';
            break;
        case 'deleted':
            $message = '<div class="alert success">Patient deleted successfully!</div>';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="image.png">

</head>
<body>
    <div class="container">
        <h1>Patient Management System</h1>
        
        <?php echo $message; ?>
        
        <div class="actions">
            <a href="add.php" class="btn btn-primary">Add New Patient</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date of Birth</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                        echo "<td class='action-buttons'>
                                <a href='view.php?id=" . $row['id'] . "' class='btn btn-info'>View</a>
                                <a href='edit.php?id=" . $row['id'] . "' class='btn btn-warning'>Edit</a>
                                <a href='index.php?delete=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this patient?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align: center;'>No patients found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
closeDBConnection($conn);
?>