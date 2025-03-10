<?php
// Start session for authentication
include('session.php');

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Initialize message variables
$success_message = "";
$error_message = "";

// Check if ID is provided in URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: events.php");
    exit();
}

$event_id = intval($_GET['id']);

// Fetch event data
$stmt = $con->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: events.php");
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data with prepared statements
    $event_title = trim($_POST['event_title']);
    $description = trim($_POST['description']);
    $club_id = isset($_POST['club_id']) && $_POST['club_id'] !== "" ? intval($_POST['club_id']) : NULL;
    $event_date = $_POST['event_date'];
    $start_time = isset($_POST['start_time']) && !empty($_POST['start_time']) ? $_POST['start_time'] : NULL;
    $end_time = isset($_POST['end_time']) && !empty($_POST['end_time']) ? $_POST['end_time'] : NULL;
    $location = trim($_POST['location']);
    $max_participants = isset($_POST['max_participants']) && !empty($_POST['max_participants']) ? intval($_POST['max_participants']) : NULL;
    $registration_deadline = isset($_POST['registration_deadline']) && !empty($_POST['registration_deadline']) ? $_POST['registration_deadline'] : NULL;
    $registration_link = isset($_POST['registration_link']) ? trim($_POST['registration_link']) : NULL;
    $contact_person = isset($_POST['contact_person']) ? trim($_POST['contact_person']) : NULL;
    $contact_email = isset($_POST['contact_email']) ? trim($_POST['contact_email']) : NULL;
    $contact_phone = isset($_POST['contact_phone']) ? trim($_POST['contact_phone']) : NULL;
    $status = isset($_POST['status']) ? trim($_POST['status']) : 'upcoming';

    // Handle image upload
    $image_path = $event['image']; // Keep existing image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "../upload/events/";

        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        // Check file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($file_extension, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Delete old image if exists and not default
                if (!empty($event['image']) && file_exists($event['image'])) {
                    unlink($event['image']);
                }
                $image_path = $target_file;
            } else {
                $error_message = "Error uploading file.";
            }
        } else {
            $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    // If no errors, update database using prepared statement
    if (empty($error_message)) {
        $stmt = $con->prepare("UPDATE events SET event_title = ?, description = ?, club_id = ?, event_date = ?, start_time = ?, end_time = ?, location = ?, image = ?, max_participants = ?, registration_deadline = ?, registration_link = ?, contact_person = ?, contact_email = ?, contact_phone = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssisssssissssssi", $event_title, $description, $club_id, $event_date, $start_time, $end_time, $location, $image_path, $max_participants, $registration_deadline, $registration_link, $contact_person, $contact_email, $contact_phone, $status, $event_id);

        if ($stmt->execute()) {
            $success_message = "Event updated successfully!";
            
            // Refresh event data
            $result = $con->query("SELECT * FROM events WHERE id = $event_id");
            $event = $result->fetch_assoc();
        } else {
            $error_message = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Get all clubs for dropdown
$clubs_query = "SELECT id, club_name FROM clubs ORDER BY club_name";
$clubs_result = $con->query($clubs_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - Premier University Club Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --dark-color: #34495e;
            --light-color: #ecf0f1;
            --danger-color: #e74c3c;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --info-color: #1abc9c;
            --sidebar-width: 250px;
            --header-height: 60px;
            --transition-speed: 0.3s;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            overflow-x: hidden;
        }
        
        /* Header */
        .header {
            background-color: var(--primary-color);
            color: white;
            height: var(--header-height);
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .header .logo {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .header .logo img {
            height: 40px;
            margin-right: 10px;
        }
        
        .header .user-menu {
            display: flex;
            align-items: center;
        }
        
        .header .user-menu .user-info {
            margin-right: 15px;
            font-size: 0.9rem;
        }
        
        .header .user-menu img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .toggle-menu {
            display: none;
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        /* Sidebar */
        .sidebar {
            background-color: var(--dark-color);
            color: white;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            position: fixed;
            top: var(--header-height);
            left: 0;
            overflow-y: auto;
            transition: transform var(--transition-speed) ease;
            z-index: 99;
        }
        
        .sidebar-closed {
            transform: translateX(-100%);
        }
        
        .sidebar .admin-info {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .admin-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid var(--primary-color);
        }
        
        .sidebar .menu-section {
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .menu-section h3 {
            padding: 0 20px;
            font-size: 0.9rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 10px;
        }
        
        .sidebar .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .sidebar .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar .menu-item.active {
            background-color: var(--primary-color);
            color: white;
            border-left: 4px solid var(--light-color);
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 20px;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left var(--transition-speed) ease;
        }
        
        .main-content.full-width {
            margin-left: 0;
        }
        
        .page-title {
            margin-bottom: 20px;
            color: var(--dark-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }
        
        /* Content Sections */
        .content-section {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .content-section h2 {
            color: var(--dark-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        /* Forms */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        select.form-control {
            height: 42px;
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .image-preview {
            width: 100%;
            max-width: 300px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .image-preview img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        
        .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
        }
        
        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
            text-decoration: none;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-success {
            background-color: var(--success-color);
        }
        
        .btn-success:hover {
            background-color: #27ae60;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        /* Alert messages */
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Editor styling */
        .ck-editor__editable_inline {
            min-height: 300px;
        }
        
        /* Media Queries for Responsiveness */
        @media (max-width: 992px) {
            .toggle-menu {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .header .logo span {
                display: none;
            }
            
            .header .user-menu .user-info {
                display: none;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .action-buttons .btn {
                width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
   <?php include('admin_header.php');?>
    
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <h1 class="page-title">Edit Event</h1>
        
        <?php if(!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if(!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="content-section">
            <h2>Event Information</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="event_title">Event Title *</label>
                        <input type="text" class="form-control" id="event_title" name="event_title" required value="<?php echo htmlspecialchars($event['event_title']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="club_id">Organizing Club</label>
                        <select class="form-control" id="club_id" name="club_id">
                            <option value="">-- Central University Event --</option>
                            <?php
                            if ($clubs_result->num_rows > 0) {
                                while($club = $clubs_result->fetch_assoc()) {
                                    $selected = ($event['club_id'] == $club['id']) ? 'selected' : '';
                                    echo "<option value='" . $club['id'] . "' $selected>" . $club['club_name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="event_date">Event Date *</label>
                        <input type="date" class="form-control" id="event_date" name="event_date" required value="<?php echo htmlspecialchars($event['event_date']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo htmlspecialchars($event['start_time'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo htmlspecialchars($event['end_time'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" class="form-control" id="location" name="location" required value="<?php echo htmlspecialchars($event['location']); ?>">
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="max_participants">Maximum Participants</label>
                        <input type="number" class="form-control" id="max_participants" name="max_participants" min="1" value="<?php echo htmlspecialchars($event['max_participants'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="registration_deadline">Registration Deadline</label>
                        <input type="date" class="form-control" id="registration_deadline" name="registration_deadline" value="<?php echo htmlspecialchars($event['registration_deadline'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="registration_link">Registration Link</label>
                    <input type="url" class="form-control" id="registration_link" name="registration_link" value="<?php echo htmlspecialchars($event['registration_link'] ?? ''); ?>">
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="contact_person">Contact Person</label>
                        <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo htmlspecialchars($event['contact_person'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_email">Contact Email</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($event['contact_email'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_phone">Contact Phone</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo htmlspecialchars($event['contact_phone'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Event Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    <div class="image-preview" id="imagePreview" style="<?php echo empty($event['image']) ? 'display: none;' : ''; ?>">
                        <img src="<?php echo htmlspecialchars($event['image'] ?? '#'); ?>" alt="Current Event Image" id="img-preview">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Event Description *</label>
                    <textarea class="form-control" id="description" name="description" rows="10" required><?php echo htmlspecialchars($event['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="upcoming" <?php echo ($event['status'] == 'upcoming') ? 'selected' : ''; ?>>Upcoming</option>
                        <option value="ongoing" <?php echo ($event['status'] == 'ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                        <option value="completed" <?php echo ($event['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo ($event['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
                
                <div class="action-buttons">
                    <button type="submit" name="submit" class="btn btn-success">Update Event</button>
                    <a href="events.php" class="btn">Cancel</a>
                </div>
            </form>
        </div>
    </main>
    
    <!-- CKEditor 5 for rich text editing -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    
    <script>
        // Toggle sidebar
        const toggleMenu = document.getElementById('toggleMenu');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        toggleMenu.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        
        // Responsive behavior
        function checkWidth() {
            if (window.innerWidth <= 992) {
                sidebar.classList.remove('active');
                mainContent.classList.add('full-width');
            } else {
                sidebar.classList.add('active');
                mainContent.classList.remove('full-width');
            }
        }
        
        // Initial check
        checkWidth();
        
        // Check on resize
        window.addEventListener('resize', checkWidth);
        
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
        
        // Image preview functionality
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const imgPreview = document.getElementById('img-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                // Don't reset preview if there's an existing image
                if (!imgPreview.getAttribute('src') || imgPreview.getAttribute('src') === '#') {
                    preview.style.display = 'none';
                }
            }
        }
        
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>
<?php
// Close database connection
$con->close();
?>