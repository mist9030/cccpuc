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

// Get news ID from URL
$news_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// If no ID provided, redirect to news page
if ($news_id == 0) {
    header("Location: news.php");
    exit();
}

// Fetch the existing news article
$news_query = "SELECT * FROM news WHERE id = $news_id";
$news_result = $con->query($news_query);

// Check if news article exists
if ($news_result->num_rows == 0) {
    header("Location: news.php");
    exit();
}

$news = $news_result->fetch_assoc();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = $con->real_escape_string($_POST['title']);
    $content = $con->real_escape_string($_POST['content']);
    $club_id = isset($_POST['club_id']) && $_POST['club_id'] != "" ? intval($_POST['club_id']) : NULL;
    $author = $con->real_escape_string($_POST['author']);
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    // Get existing image path
    $image_path = $news['image'];
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../upload/news/";
    
        // Create directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
    
        $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
    
        // Check file type
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($file_extension), $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Change $image_path to only store the filename
                $image_path = $new_filename; // Only store the filename, not the full path.
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }
    
    // If no errors, update database
    if (empty($error_message)) {
        $sql = "UPDATE news SET 
                title = '$title', 
                content = '$content', 
                club_id = " . ($club_id ? $club_id : "NULL") . ", 
                author = '$author', 
                image = '$image_path',
                featured = $featured
                WHERE id = $news_id";
        
        if ($con->query($sql) === TRUE) {
            $success_message = "News article updated successfully!";
            // Refresh news data
            $news_result = $con->query($news_query);
            $news = $news_result->fetch_assoc();
        } else {
            $error_message = "Error: " . $sql . "<br>" . $con->error;
        }
    }
}

// Get all clubs for dropdown
$clubs_query = "SELECT id, club_name FROM clubs ORDER BY club_name";
$clubs_result = $con->query($clubs_query);

// Get current page for active menu marking
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News Article - Premier University Club Admin</title>
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
        <h1 class="page-title">Edit News Article</h1>
        
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
            <h2>Edit News Article</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $news_id); ?>" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="title">Article Title *</label>
                        <input type="text" class="form-control" id="title" name="title" required value="<?php echo htmlspecialchars($news['title']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="club_id">Related Club</label>
                        <select class="form-control" id="club_id" name="club_id">
                            <option value="">-- Central Club News --</option>
                            <?php
                            if ($clubs_result->num_rows > 0) {
                                while($club = $clubs_result->fetch_assoc()) {
                                    $selected = ($news['club_id'] == $club['id']) ? 'selected' : '';
                                    echo "<option value='" . $club['id'] . "' $selected>" . $club['club_name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" class="form-control" id="author" name="author" required value="<?php echo htmlspecialchars($news['author']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="image">Featured Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                    <?php if (!empty($news['image'])): ?>
                        <div class="image-preview" id="currentImagePreview">
                            <p>Current Image:</p>
                            <img src="../upload/news/<?php echo $news['image']; ?>" alt="Current News Image">
                        </div>
                    <?php endif; ?>
                    <div class="image-preview" id="imagePreview" style="display: none;">
                        <p>New Image:</p>
                        <img src="#" alt="Image Preview" id="img-preview">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="content">Article Content *</label>
                    <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($news['content']); ?></textarea>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="featured" name="featured" <?php echo ($news['featured'] == 1) ? 'checked' : ''; ?>>
                    <label for="featured">Feature this article on homepage</label>
                </div>
                
                <div class="action-buttons">
                    <button type="submit" class="btn btn-success">Update News Article</button>
                    <a href="news.php" class="btn">Back to News List</a>
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
        // ClassicEditor
        //     .create(document.querySelector('#content'))
        //     .catch(error => {
        //         console.error(error);
        //     });
        
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