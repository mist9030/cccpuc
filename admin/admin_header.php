 <!-- Header -->
 <header class="header">
        <div class="logo">
            <button class="toggle-menu" id="toggleMenu">
                <i class="fas fa-bars"></i>
            </button>
            <img src="/PUC/upload/cccpuclogoustom.png" alt="Logo">
            <span>Premier University Clubs</span>
        </div>
        <div class="user-menu">
            <div class="user-info">
                <div>Welcome, <?php echo 'Admin' ?? 'Admin'; ?></div>
            </div>
            <img src="/PUC/upload/admin.png" alt="Admin">
        </div>
    </header>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="admin-info">
            <img src="/PUC/upload/admin.png" alt="Admin Avatar">
            <h3><?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></h3>
            <p>Central Club Administrator</p>
        </div>
        
        <div class="menu-section">
            <h3>Main Navigation</h3>
            <a href="testdb.php" class="menu-item <?php echo $current_page == 'testdb.php' ? 'active' : ''; ?>">
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