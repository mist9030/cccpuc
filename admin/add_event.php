<?php
// Start session for authentication
include('session.php');
include('admin_scripts.php');
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Initialize message variables
$success_message = "";
$error_message = "";

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
    $image_path = NULL;
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
                $image_path = $target_file;
            } else {
                $error_message = "Error uploading file.";
            }
        } else {
            $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    // If no errors, insert into database using prepared statement
    if (empty($error_message)) {
        $stmt = $con->prepare("INSERT INTO events (event_title, description, club_id, event_date, start_time, end_time, location, image, max_participants, registration_deadline, registration_link, contact_person, contact_email, contact_phone, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssssissssss", $event_title, $description, $club_id, $event_date, $start_time, $end_time, $location, $image_path, $max_participants, $registration_deadline, $registration_link, $contact_person, $contact_email, $contact_phone, $status);

        if ($stmt->execute()) {
            $success_message = "Event added successfully!";
            $_POST = [];
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
    <title>Add Event - Premier University Club Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
   <?php include('admin_header.php');?>
    
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <h1 class="page-title">Add Event</h1>
        
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
                        <input type="text" class="form-control" id="event_title" name="event_title" required value="<?php echo isset($_POST['event_title']) ? htmlspecialchars($_POST['event_title']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="club_id">Organizing Club</label>
                        <select class="form-control" id="club_id" name="club_id">
                            <option value="">-- Central University Event --</option>
                            <?php
                            if ($clubs_result->num_rows > 0) {
                                while($club = $clubs_result->fetch_assoc()) {
                                    $selected = (isset($_POST['club_id']) && $_POST['club_id'] == $club['id']) ? 'selected' : '';
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
                        <input type="date" class="form-control" id="event_date" name="event_date" required value="<?php echo isset($_POST['event_date']) ? htmlspecialchars($_POST['event_date']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" value="<?php echo isset($_POST['start_time']) ? htmlspecialchars($_POST['start_time']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" value="<?php echo isset($_POST['end_time']) ? htmlspecialchars($_POST['end_time']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="location">Location *</label>
                    <input type="text" class="form-control" id="location" name="location" required value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>">
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="max_participants">Maximum Participants</label>
                        <input type="number" class="form-control" id="max_participants" name="max_participants" min="1" value="<?php echo isset($_POST['max_participants']) ? htmlspecialchars($_POST['max_participants']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="registration_deadline">Registration Deadline</label>
                        <input type="date" class="form-control" id="registration_deadline" name="registration_deadline" value="<?php echo isset($_POST['registration_deadline']) ? htmlspecialchars($_POST['registration_deadline']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="registration_link">Registration Link</label>
                    <input type="url" class="form-control" id="registration_link" name="registration_link" value="<?php echo isset($_POST['registration_link']) ? htmlspecialchars($_POST['registration_link']) : ''; ?>">
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="contact_person">Contact Person</label>
                        <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo isset($_POST['contact_person']) ? htmlspecialchars($_POST['contact_person']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_email">Contact Email</label>
                        <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo isset($_POST['contact_email']) ? htmlspecialchars($_POST['contact_email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_phone">Contact Phone</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="<?php echo isset($_POST['contact_phone']) ? htmlspecialchars($_POST['contact_phone']) : ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Event Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    <div class="image-preview" id="imagePreview">
                        <img src="#" alt="Image Preview" id="img-preview">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Event Description *</label>
                    <textarea class="form-control" id="description" name="description" rows="10" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="upcoming" <?php echo (!isset($_POST['status']) || $_POST['status'] == 'upcoming') ? 'selected' : ''; ?>>Upcoming</option>
                        <option value="ongoing" <?php echo (isset($_POST['status']) && $_POST['status'] == 'ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                        <option value="completed" <?php echo (isset($_POST['status']) && $_POST['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="cancelled" <?php echo (isset($_POST['status']) && $_POST['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
                
                <div class="action-buttons">
                    <button type="submit" name="submit" class="btn btn-success">Add Event</button>
                    <a href="events.php" class="btn">Cancel</a>
                </div>
            </form>
        </div>
    </main>
    
    <!-- CKEditor 5 for rich text editing -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    
    <script>
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
                imgPreview.src = '#';
                preview.style.display = 'none';
            }
        }
        
        // Initialize CKEditor
        // ClassicEditor
        //     .create(document.querySelector('#description'))
        //     .catch(error => {
        //         console.error(error);
        //     });
            
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