<?php
// Start session for authentication
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
    <title>Premier University Club Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <?php include('admin_header.php'); ?>
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
    <div class="content-section">
            <h2>Add/Edit Club</h2>
            <form class="add-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="club_id" value="<?php echo $edit_club['id'] ?? ''; ?>">
                <input type="text" name="club_name" placeholder="Club Name" required value="<?php echo $edit_club['club_name'] ?? ''; ?>">
                <textarea name="description" placeholder="Description" required><?php echo $edit_club['description'] ?? ''; ?></textarea>
                <input type="date" name="founded_date" value="<?php echo $edit_club['founded_date'] ?? ''; ?>">
                <input type="text" name="website" placeholder="Website" value="<?php echo $edit_club['website'] ?? ''; ?>">
                <input type="text" name="social_media" placeholder="Social Media Links" value="<?php echo $edit_club['social_media'] ?? ''; ?>">
                <input type="hidden" name="existing_logo" value="<?php echo $edit_club['logo'] ?? ''; ?>">
                
                <div class="form-group">
                    <input type="file" name="logo" accept="image/*">
                    <?php if (!empty($edit_club['logo'])): ?>
                        <div style="margin-top: 10px;">
                            <p>Current Logo:</p>
                            <img src="../upload/clubs/<?php echo $edit_club['logo']; ?>" width="50">
                        </div>
                    <?php endif; ?>
                </div>
                
                <button type="submit" name="add_club">Save Club</button>
            </form>
        </div>
</main>
</body>
</html>
<?php
$con->close();
?>
<style>.add-form {
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
    }</style>