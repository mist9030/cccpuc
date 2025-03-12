<?php
// Start the session to maintain user login state
session_start();
include_once('connection.php');
// Check if user is logged in, redirect to login if not
if (!isset($_SESSION['roll'])) {
    header("Location: login.php");
    exit();
}

// Get current user data
$roll = $_SESSION['roll'];
$sql = "SELECT * FROM users WHERE roll = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $roll);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated data from form
    $name = trim($_POST['name']);
    $dept = trim($_POST['dept']);
    $batch = trim($_POST['batch']);
    $email = trim($_POST['email']);
    
    // Optional password update
    $updatePassword = false;
    $newPassword = "";
    
    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        if ($_POST['new_password'] === $_POST['confirm_password']) {
            $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $updatePassword = true;
        } else {
            $message = "Passwords do not match!";
            $messageType = "error";
        }
    }
    
    // Update user data
    if (empty($message)) {
        if ($updatePassword) {
            $updateSql = "UPDATE users SET name=?, dept=?, batch=?, email=?, password=? WHERE roll=?";
            $updateStmt = $con->prepare($updateSql);
            $updateStmt->bind_param("sssssi", $name, $dept, $batch, $email, $newPassword, $roll);
        } else {
            $updateSql = "UPDATE users SET name=?, dept=?, batch=?, email=? WHERE roll=?";
            $updateStmt = $con->prepare($updateSql);
            $updateStmt->bind_param("ssssi", $name, $dept, $batch, $email, $roll);
        }
        
        if ($updateStmt->execute()) {
            $message = "Profile updated successfully!";
            $messageType = "success";
            
            // Refresh user data after update
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        } else {
            $message = "Error updating profile: " . $con->error;
            $messageType = "error";
        }
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
            background-color: #f7f9fc;
        }

        .header1 {
            background-color: #000;
            color: white;
            width: 100%;
        }

        .top-bar1 {
            padding: 0.5rem 2rem;
            display: flex;
            justify-content: flex-start;
            background-color: #111;
        }

        .social-icons1 a {
            color: white;
            margin-right: 1.5rem;
            font-size: 1.2rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .social-icons1 a:hover {
            color: #cccccc;
        }

        .bottom-header1 {
            padding: 1rem 2rem;
        }

        .main-header1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-container1 {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo1 {
            max-width: 180px;
        }

        .stars-badge1 {
            max-width: 60px;
        }

        .logo1 img, .stars-badge1 img {
            width: 100%;
            height: auto;
        }

        .nav-toggle1 {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .nav-list1 {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-link1 {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .nav-link1:hover {
            color: #cccccc;
        }

        /* Mobile Styles */
        @media (max-width: 1024px) {
            .nav-toggle1 {
                display: block;
                z-index: 1001;
            }

            .nav1 {
                position: fixed;
                top: 0;
                right: -300px;
                width: 300px;
                height: 100vh;
                background-color: #000;
                padding: 4rem 1rem 1rem;
                transition: right 0.3s ease;
                z-index: 1000;
                box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
            }

            .nav1.active {
                right: 0;
            }

            .nav-list1 {
                flex-direction: column;
                gap: 0;
            }

            .nav-link1 {
                display: block;
                padding: 1rem 0;
                border-bottom: 1px solid #333;
            }

            .overlay1 {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                z-index: 999;
            }

            .overlay1.active {
                opacity: 1;
                visibility: visible;
            }

            .logo1 {
                max-width: 140px;
            }

            .stars-badge1 {
                max-width: 40px;
            }
        }
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 2rem 5%;
            text-align: center;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
        }

        footer a {
            color: #3498db;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .key-highlights {
                flex-direction: column;
            }

            .service-grid, .news-grid {
                grid-template-columns: 1fr;
            }
        }
        .btn {
            text-decoration: none;
            color: white;
            background-color: #3498db;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .hero {
            text-align: center;
            position: relative;
            background: url('/PUC/upload/cover.jpg') no-repeat center center/cover;
            color: white;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            min-height: 45vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s ease-in-out;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            transition: background 0.3s ease-in-out;
        }

        .hero h1,
        .hero p,
        .hero .btn {
            position: relative;
            z-index: 2;
            transition: transform 0.3s ease-in-out;
        }

        .hero:hover {
            transform: scale(1.02);
        }

        .hero:hover::before {
            background: rgba(0, 0, 0, 0.6);
        }

        .hero:hover h1,
        .hero:hover p,
        .hero:hover .btn {
            transform: translateY(-3px);
        }

        .btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background: #ff9800;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background 0.3s, transform 0.3s ease-in-out;
        }

        .btn:hover {
            background: #e68900;
            transform: scale(1.1);
        }

        .about, .services, .news {
            margin-bottom: 3rem;
        }

        .key-highlights {
            display: flex;
            gap: 2rem;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .service-card, .news-card {
            border: 1px solid #ddd;
            padding: 1.5rem;
            text-align: center;
        }

        .service-card img, .news-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 1rem;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }
        .nav-item {
            position: relative;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #000;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1002;
        }

        @media (min-width: 1025px) {
            .nav-item:hover .dropdown-content {
                display: block;
            }
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #333;
        }

        @media (max-width: 1024px) {
            .dropdown-content {
                position: static;
                display: none;
                background-color: #111;
                padding-left: 1rem;
            }

            .dropdown-content.show {
                display: block;
            }

            .nav-link.has-dropdown {
                justify-content: space-between;
            }

            .dropdown-icon {
                transition: transform 0.3s ease;
            }

            .dropdown-icon.rotated {
                transform: rotate(180deg);
            }
        }

        /* Modern Profile Styles */
        .profile-card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        
        .profile-header {
            background: linear-gradient(135deg, #4a6cf7 0%, #2651e8 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .profile-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            transform: rotate(30deg);
        }
        
        .profile-avatar {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            font-weight: bold;
            border: 4px solid white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s;
        }
        
        .profile-card:hover .profile-avatar {
            transform: scale(1.05);
        }
        
        .profile-info {
            padding: 1.5rem;
            text-align: center;
        }
        
        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .profile-role {
            color: #6B7280;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        
        .profile-detail {
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            color: #4B5563;
        }
        
        .profile-detail i {
            width: 24px;
            margin-right: 0.75rem;
            color: #4a6cf7;
        }
        
        .form-container {
            padding: 2rem;
        }
        
        .section-title {
            position: relative;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            color: #111827;
        }
        
        .section-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #4a6cf7 0%, #2651e8 100%);
            border-radius: 3px;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4B5563;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            background-color: #F9FAFB;
            transition: all 0.3s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #4a6cf7;
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
            background-color: white;
        }
        
        .form-divider {
            margin: 2rem 0;
            height: 1px;
            background-color: #E5E7EB;
            position: relative;
        }
        
        .form-divider::before {
            content: attr(data-text);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 0 1rem;
            color: #6B7280;
            font-size: 0.875rem;
        }
        
        .update-btn {
            background: linear-gradient(135deg, #4a6cf7 0%, #2651e8 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .update-btn:hover {
            background: linear-gradient(135deg, #2651e8 0%, #1a3ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 108, 247, 0.2);
        }
        
        .alert {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-success {
            background-color: #ECFDF5;
            color: #065F46;
            border-left: 4px solid #10B981;
        }
        
        .alert-error {
            background-color: #FEF2F2;
            color: #991B1B;
            border-left: 4px solid #EF4444;
        }
    </style>
</head>
<body>
    <header class="header1">
       <?php include('navbar/navbar.php'); ?>
    </header>

    <script>
        const navToggle = document.querySelector('.nav-toggle1');
        const nav = document.querySelector('.nav1');
        const overlay = document.querySelector('.overlay1');

        function toggleMenu() {
            nav.classList.toggle('active');
            overlay.classList.toggle('active');
            
            const icon = navToggle.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }

        navToggle.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // Close menu when clicking a link on mobile
        document.querySelectorAll('.nav-link1').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 1024) {
                    toggleMenu();
                }
            });
        });

        // Reset menu state on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                nav.classList.remove('active');
                overlay.classList.remove('active');
                const icon = navToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    </script>
    
    <main>
        <div class="container mx-auto px-4 py-8">
            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $messageType === 'success' ? 'alert-success' : 'alert-error'; ?> max-w-3xl mx-auto">
                    <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="profile-card max-w-3xl mx-auto">
                <div class="profile-header">
                    <h1 class="text-2xl font-bold mb-2">Your Profile</h1>
                    <p class="text-sm opacity-80">Manage your personal information and account settings</p>
                </div>
                
                <div class="flex flex-col md:flex-row">
                    <!-- Profile sidebar -->
                    <div class="w-full md:w-1/3 border-r border-gray-200">
                        <div class="px-6 py-8">
                            <div class="profile-avatar">
                                <?php echo strtoupper(substr($user['name'] ?? 'U', 0, 1)); ?>
                            </div>
                            
                            <div class="profile-info">
                                <h2 class="profile-name"><?php echo htmlspecialchars($user['name'] ?? ''); ?></h2>
                                <p class="profile-role"><?php echo htmlspecialchars($user['dept'] ?? ''); ?> Student</p>
                                
                                <div class="mt-4 text-left">
                                    <div class="profile-detail">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span><?php echo htmlspecialchars($user['dept'] ?? ''); ?></span>
                                    </div>
                                    <div class="profile-detail">
                                        <i class="fas fa-users"></i>
                                        <span>Batch <?php echo htmlspecialchars($user['batch'] ?? ''); ?></span>
                                    </div>
                                    <div class="profile-detail">
                                        <i class="fas fa-envelope"></i>
                                        <span><?php echo htmlspecialchars($user['email'] ?? ''); ?></span>
                                    </div>
                                    <div class="profile-detail">
                                        <i class="fas fa-id-card"></i>
                                        <span>Roll: <?php echo htmlspecialchars($user['roll'] ?? ''); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile form -->
                    <div class="w-full md:w-2/3">
                        <div class="form-container">
                            <h3 class="section-title">Update Your Information</h3>
                            
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label for="dept" class="form-label">Department</label>
                                    <input type="text" id="dept" name="dept" value="<?php echo htmlspecialchars($user['dept'] ?? ''); ?>" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label for="batch" class="form-label">Batch</label>
                                    <input type="text" id="batch" name="batch" value="<?php echo htmlspecialchars($user['batch'] ?? ''); ?>" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" class="form-input">
                                </div>
                                
                                <div class="form-divider" data-text="Change Password"></div>
                                
                                <div class="form-group">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" id="new_password" name="new_password" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-input">
                                </div>
                                
                                <div class="flex justify-end mt-6">
                                    <button type="submit" class="update-btn">
                                        <i class="fas fa-save"></i>
                                        Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </main>

    <!-- Handle dropdown on mobile -->
    <script>
        document.querySelectorAll('.has-dropdown').forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 1024) {
                    e.preventDefault();
                    const dropdownContent = this.nextElementSibling;
                    const dropdownIcon = this.querySelector('.dropdown-icon');
                    
                    // Toggle dropdown
                    dropdownContent.classList.toggle('show');
                    dropdownIcon.classList.toggle('rotated');
                    
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                        if (dropdown !== dropdownContent) {
                            dropdown.classList.remove('show');
                        }
                    });
                    
                    document.querySelectorAll('.dropdown-icon').forEach(icon => {
                        if (icon !== dropdownIcon) {
                            icon.classList.remove('rotated');
                        }
                    });
                }
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-item')) {
                document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
                document.querySelectorAll('.dropdown-icon').forEach(icon => {
                    icon.classList.remove('rotated');
                });
            }
        });

        // Modified event listener for nav links
        document.querySelectorAll('.dropdown-content a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 1024) {
                    toggleMenu();
                }
            });
        });
    </script>
    
    <?php include 'footer.php'; ?>
</body>
</html>