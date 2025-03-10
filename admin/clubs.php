<?php
include('session.php');
include('admin_scripts.php');

// Handle club addition or update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $club_id = $_POST['club_id'] ?? '';
    $club_name = $_POST['club_name'];
    $description = $_POST['description'];
    $founded_date = $_POST['founded_date'];
    $website = $_POST['website'];
    $social_media = $_POST['social_media'];
    $logo = $_POST['existing_logo'] ?? '';

    if (!empty($_FILES['logo']['name'])) {
        $target_dir = "../upload/clubs/";
        $logo = basename($_FILES['logo']['name']);
        $target_file = $target_dir . $logo;
        move_uploaded_file($_FILES['logo']['tmp_name'], $target_file);
    }

    if ($club_id) {
        // Update existing club
        $stmt = $con->prepare("UPDATE clubs SET logo = ?, club_name = ?, description = ?, founded_date = ?, website = ?, social_media = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $logo, $club_name, $description, $founded_date, $website, $social_media, $club_id);
    } else {
        // Insert new club
        $stmt = $con->prepare("INSERT INTO clubs (logo, club_name, description, founded_date, website, social_media) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $logo, $club_name, $description, $founded_date, $website, $social_media);
    }
    $stmt->execute();
}

// Handle club deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $con->prepare("DELETE FROM clubs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Fetch clubs
$result = $con->query("SELECT * FROM clubs");
$edit_club = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_club = $con->query("SELECT * FROM clubs WHERE id = $id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clubs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Your custom CSS will be inserted here by admin_scripts.php -->
</head>
<body>
    <?php include('admin_header.php'); ?>
    
    <div class="main-content">
        <h1 class="page-title">Manage Clubs</h1>
        
        
        
        <div class="content-section">
            <h2>Club List</h2>
            <div style="overflow-x: auto;">
                <table>
                    <tr>
                        <th>Logo</th>
                        <th>Club Name</th>
                        <th>Description</th>
                        <th>Founded Date</th>
                        <th>Website</th>
                        <th>Social Media</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="../upload/clubs/<?php echo $row['logo']; ?>" alt="Club Logo"></td>
                        <td><?php echo $row['club_name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['founded_date']; ?></td>
                        <td><a href="<?php echo $row['website']; ?>" target="_blank">Website</a></td>
                        <td><a href="<?php echo $row['social_media']; ?>" target="_blank">Social</a></td>
                        <td>
                            <a href="add_club.php?edit=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                            <a href="clubs.php?delete=<?php echo $row['id']; ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this club?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php $con->close(); ?>
<style>
    /* Club Management Specific Styles */
    .add-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        max-width: 100%;
    }
    
    .add-form input,
    .add-form textarea {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }
    
    .add-form input:focus,
    .add-form textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    }
    
    .add-form textarea {
        min-height: 120px;
        resize: vertical;
    }
    
    .add-form button[type="submit"] {
        padding: 10px 20px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
        align-self: flex-start;
    }
    
    .add-form button[type="submit"]:hover {
        background-color: var(--secondary-color);
    }
    
    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    
    th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 500;
    }
    
    tr:last-child td {
        border-bottom: none;
    }
    
    tr:hover {
        background-color: #f9f9f9;
    }
    
    td img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }
    
    /* Button styles for table actions */
    .btn {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 4px;
        color: white;
        text-decoration: none;
        font-size: 0.9rem;
        margin-right: 5px;
        text-align: center;
    }
    
    .btn.edit {
        background-color: var(--primary-color);
    }
    
    .btn.edit:hover {
        background-color: var(--secondary-color);
    }
    
    .btn.delete {
        background-color: var(--danger-color);
    }
    
    .btn.delete:hover {
        background-color: #c0392b;
    }
    
    /* Container modifications */
    .container {
        width: 100%;
        padding: 0;
    }
    
    /* Responsive styles */
    @media (max-width: 992px) {
        .container {
            padding: 0;
        }
    }
    
    @media (max-width: 768px) {
        th, td {
            padding: 10px;
        }
        
        td img {
            width: 40px;
            height: 40px;
        }
        
        .btn {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 576px) {
        table {
            display: block;
            overflow-x: auto;
        }
        
        th, td {
            white-space: nowrap;
            padding: 8px;
        }
        
        td img {
            width: 30px;
            height: 30px;
        }
    }
</style>