<?php
// Start session for authentication

include('session.php');

// Get statistics for dashboard
$total_members = $con->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_clubs = $con->query("SELECT COUNT(*) as count FROM clubs")->fetch_assoc()['count'];
$total_events = $con->query("SELECT COUNT(*) as count FROM events")->fetch_assoc()['count'];
$total_news = $con->query("SELECT COUNT(*) as count FROM news")->fetch_assoc()['count'];

// Get current page for active menu marking
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier University Club Admin Panel</title>
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
        
        .dashboard-title {
            margin-bottom: 20px;
            color: var(--dark-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }
        
        /* Stat Cards */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }
        
        .stat-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 15px;
            color: white;
        }
        
        .stat-card.primary .icon {
            background-color: var(--primary-color);
        }
        
        .stat-card.success .icon {
            background-color: var(--success-color);
        }
        
        .stat-card.warning .icon {
            background-color: var(--warning-color);
        }
        
        .stat-card.info .icon {
            background-color: var(--info-color);
        }
        
        .stat-card .data h3 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }
        
        .stat-card .data p {
            color: #777;
            font-size: 0.9rem;
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
        
        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th, .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .data-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        
        .data-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .data-table .actions {
            display: flex;
            gap: 10px;
        }
        
        .data-table .actions .btn {
            padding: 5px 10px;
            font-size: 0.8rem;
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
        
        .btn-warning {
            background-color: var(--warning-color);
        }
        
        .btn-warning:hover {
            background-color: #e67e22;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.8rem;
        }
        
        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
        }
        
        .badge-primary {
            background-color: var(--primary-color);
        }
        
        .badge-success {
            background-color: var(--success-color);
        }
        
        .badge-warning {
            background-color: var(--warning-color);
        }
        
        .badge-danger {
            background-color: var(--danger-color);
        }
        
        .badge-info {
            background-color: var(--info-color);
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
            .stat-cards {
                grid-template-columns: 1fr;
            }
            
            .header .logo span {
                display: none;
            }
            
            .header .user-menu .user-info {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 15px;
            }
            
            .data-table th, .data-table td {
                padding: 8px 10px;
                font-size: 0.9rem;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <button class="toggle-menu" id="toggleMenu">
                <i class="fas fa-bars"></i>
            </button>
            <img src="https://via.placeholder.com/40" alt="Logo">
            <span>Premier University Clubs</span>
        </div>
        <div class="user-menu">
            <div class="user-info">
                <div>Welcome, <?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></div>
            </div>
            <img src="https://via.placeholder.com/35" alt="Admin">
        </div>
    </header>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="admin-info">
            <img src="https://via.placeholder.com/80" alt="Admin Avatar">
            <h3><?php echo $_SESSION['admin_name'] ?? 'Admin User'; ?></h3>
            <p>Central Club Administrator</p>
        </div>
        
        <div class="menu-section">
            <h3>Main Navigation</h3>
            <a href="testdb.php" class="menu-item <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </div>
        
        <div class="menu-section">
            <h3>Club Management</h3>
            <a href="clubs.php" class="menu-item <?php echo $current_page == 'clubs.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Clubs
            </a>
            <a href="add_club.php" class="menu-item <?php echo $current_page == 'add_club.php' ? 'active' : ''; ?>">
                <i class="fas fa-plus-circle"></i> Add Club
            </a>
            <a href="members.php" class="menu-item <?php echo $current_page == 'members.php' ? 'active' : ''; ?>">
                <i class="fas fa-user-graduate"></i> Club Members
            </a>
        </div>
        
        <div class="menu-section">
            <h3>Content Management</h3>
            <a href="events.php" class="menu-item <?php echo $current_page == 'events.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-alt"></i> Events
            </a>
            <a href="add_event.php" class="menu-item <?php echo $current_page == 'add_event.php' ? 'active' : ''; ?>">
                <i class="fas fa-plus-circle"></i> Add Event
            </a>
            <a href="news.php" class="menu-item <?php echo $current_page == 'news.php' ? 'active' : ''; ?>">
                <i class="fas fa-newspaper"></i> News
            </a>
            <a href="add_news.php" class="menu-item <?php echo $current_page == 'add_news.php' ? 'active' : ''; ?>">
                <i class="fas fa-plus-circle"></i> Add News
            </a>
            <a href="achievements.php" class="menu-item <?php echo $current_page == 'achievements.php' ? 'active' : ''; ?>">
                <i class="fas fa-trophy"></i> Achievements
            </a>
        </div>
        
        <div class="menu-section">
            <h3>Settings</h3>
            <a href="profile.php" class="menu-item <?php echo $current_page == 'profile.php' ? 'active' : ''; ?>">
                <i class="fas fa-user-cog"></i> My Profile
            </a>
            <a href="settings.php" class="menu-item <?php echo $current_page == 'settings.php' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i> System Settings
            </a>
            <a href="logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <h1 class="dashboard-title">Dashboard</h1>
        
        <!-- Statistics Cards -->
        <div class="stat-cards">
            <div class="stat-card primary">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="data">
                    <h3><?php echo $total_members; ?></h3>
                    <p>Total Members</p>
                </div>
            </div>
            
            <div class="stat-card success">
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="data">
                    <h3><?php echo $total_clubs; ?></h3>
                    <p>Active Clubs</p>
                </div>
            </div>
            
            <div class="stat-card warning">
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="data">
                    <h3><?php echo $total_events; ?></h3>
                    <p>Upcoming Events</p>
                </div>
            </div>
            
            <div class="stat-card info">
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="data">
                    <h3><?php echo $total_news; ?></h3>
                    <p>News Articles</p>
                </div>
            </div>
        </div>
        
        <!-- Recent Events Section -->
        <div class="content-section">
            <h2>Upcoming Events</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Club</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch upcoming events
                    $events_query = "SELECT e.*, c.club_name FROM events e 
                                    JOIN clubs c ON e.club_id = c.id 
                                    WHERE e.event_date >= CURDATE() 
                                    ORDER BY e.event_date ASC LIMIT 5";
                    $events_result = $con->query($events_query);
                    
                    if ($events_result->num_rows > 0) {
                        while($event = $events_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $event['event_title'] . "</td>";
                            echo "<td>" . $event['club_name'] . "</td>";
                            echo "<td>" . date('M d, Y', strtotime($event['event_date'])) . "</td>";
                            echo "<td>" . $event['location'] . "</td>";
                            
                            $status_class = "";
                            $status_text = "";
                            
                            if (strtotime($event['event_date']) > time()) {
                                $status_class = "badge-primary";
                                $status_text = "Upcoming";
                            } elseif (strtotime($event['event_date']) == strtotime(date('Y-m-d'))) {
                                $status_class = "badge-warning";
                                $status_text = "Today";
                            } else {
                                $status_class = "badge-success";
                                $status_text = "Completed";
                            }
                            
                            echo "<td><span class='badge " . $status_class . "'>" . $status_text . "</span></td>";
                            echo "<td class='actions'>
                                    <a href='edit_event.php?id=" . $event['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='view_event.php?id=" . $event['id'] . "' class='btn btn-sm'>View</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No upcoming events found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;">
                <a href="events.php" class="btn">View All Events</a>
                <a href="upcoming.php" class="btn btn-success">Add New Event</a>
            </div>
        </div>
        
        <!-- Latest News Section -->
        <div class="content-section">
            <h2>Latest News</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Related Club</th>
                        <th>Published Date</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch latest news
                    $news_query = "SELECT n.*, c.club_name FROM news n 
                                  LEFT JOIN clubs c ON n.club_id = c.id 
                                  ORDER BY n.published_date DESC LIMIT 5";
                    $news_result = $con->query($news_query);
                    
                    if ($news_result->num_rows > 0) {
                        while($news = $news_result->fetch_assoc()) {
                            $club_name = $news['club_name'] ? $news['club_name'] : 'Central Club';
                            
                            echo "<tr>";
                            echo "<td>" . $news['title'] . "</td>";
                            echo "<td>" . $club_name . "</td>";
                            echo "<td>" . date('M d, Y', strtotime($news['published_date'])) . "</td>";
                            echo "<td>" . $news['author'] . "</td>";
                            echo "<td class='actions'>
                                    <a href='edit_news.php?id=" . $news['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='view_news.php?id=" . $news['id'] . "' class='btn btn-sm'>View</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No news articles found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div style="margin-top: 15px;">
                <a href="news.php" class="btn">View All News</a>
                <a href="addnews.php" class="btn btn-success">Add News Article</a>
            </div>
        </div>
    </main>
    
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
    </script>
</body>
</html>
<?php
// Close database connection
$con->close();
?>