<?php
// Start session for authentication
include('session.php');
include('admin_scripts.php');

// Check if delete is requested
if (isset($_GET['delete'])) {
    $delete_roll = $_GET['delete'];
    
    // Delete user query
    $delete_query = "DELETE FROM users WHERE roll = ?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("i", $delete_roll);
    
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting user!');</script>";
    }
    $stmt->close();
}

// Check if view user is requested
$user_data = null;
if (isset($_GET['view'])) {
    $view_roll = $_GET['view'];
    
    // Fetch user details query
    $user_query = "SELECT * FROM users WHERE roll = ?";
    $stmt = $con->prepare($user_query);
    $stmt->bind_param("i", $view_roll);
    $stmt->execute();
    $user_result = $stmt->get_result();
    
    if ($user_result->num_rows > 0) {
        $user_data = $user_result->fetch_assoc();
    } else {
        echo "<script>alert('User not found!');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier University Club Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Basic modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            width: 400px;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }
        .cancel-btn {
            margin-top: 10px;
            background-color: #f44336;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include('admin_header.php'); ?>
    
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Members Section -->
        <div class="content-section">
            <h2>All Members</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Roll Number</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Batch</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all users
                    $users_query = "SELECT * FROM users ORDER BY name ASC";
                    $users_result = $con->query($users_query);

                    if ($users_result->num_rows > 0) {
                        while($user = $users_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $user['roll'] . "</td>";
                            echo "<td>" . $user['name'] . "</td>";
                            echo "<td>" . $user['dept'] . "</td>";
                            echo "<td>" . $user['batch'] . "</td>";
                            echo "<td>" . $user['email'] . "</td>";
                            echo "<td class='actions'>
                                    <a href='members.php?view=" . $user['roll'] . "' class='btn btn-sm'>View</a>
                                    <a href='members.php?delete=" . $user['roll'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- User View Modal -->
        <?php if ($user_data) { ?>
        <div id="userModal" class="modal" style="display: flex;">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h3>User Details</h3>
                <p><strong>Roll Number:</strong> <?php echo $user_data['roll']; ?></p>
                <p><strong>Name:</strong> <?php echo $user_data['name']; ?></p>
                <p><strong>Department:</strong> <?php echo $user_data['dept']; ?></p>
                <p><strong>Batch:</strong> <?php echo $user_data['batch']; ?></p>
                <p><strong>Email:</strong> <?php echo $user_data['email']; ?></p>
                <p><strong>Password:</strong> <?php echo $user_data['password']; ?></p> <!-- You may want to hide this for security reasons -->
                <button class="cancel-btn" onclick="closeModal()">Cancel</button>
            </div>
        </div>
        <?php } ?>
    </main>

    <script>
        // Close modal when cancel button or close (×) button is clicked
        function closeModal() {
            document.getElementById('userModal').style.display = 'none';
        }
    </script>
</body>
</html>

<?php
$con->close();
?>
