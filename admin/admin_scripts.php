<?php
$total_members = $con->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_clubs = $con->query("SELECT COUNT(*) as count FROM clubs")->fetch_assoc()['count'];
$total_events = $con->query("SELECT COUNT(*) as count FROM events")->fetch_assoc()['count'];
$total_news = $con->query("SELECT COUNT(*) as count FROM news")->fetch_assoc()['count'];

// Get current page for active menu marking
$current_page = basename($_SERVER['PHP_SELF']);
?>

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
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) var(--dark-color);
        }
        
        /* Scrollbar styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: var(--dark-color);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background-color: var(--primary-color);
            border-radius: 6px;
        }
        
        /* Changed the sidebar-closed to be the default state and active to be the open state */
        .sidebar {
            transform: translateX(-100%);
        }
        
        .sidebar.active {
            transform: translateX(0);
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
            margin-left: 0; /* Default to full width */
            margin-top: var(--header-height);
            padding: 20px;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left var(--transition-speed) ease;
        }
        
        .main-content.sidebar-active {
            margin-left: var(--sidebar-width);
        }
        
        .dashboard-title {
            margin-bottom: 20px;
            color: var(--dark-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }
        
        /* Overlay for small screens when sidebar is open */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: var(--header-height);
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 98;
        }
        
        .sidebar-overlay.active {
            display: block;
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
            
            /* Let the JavaScript handle the sidebar visibility */
            .main-content {
                margin-left: 0;
            }
            
            /* Show the toggle menu button at all times on small screens */
            .toggle-menu {
                display: block;
            }
        }
        
        @media (min-width: 993px) {
            /* On larger screens, keep the sidebar open by default */
            .sidebar {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: var(--sidebar-width);
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

<!-- Add the overlay div -->
<div id="sidebarOverlay" class="sidebar-overlay"></div>

<!-- Add this script at the end of the body -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get DOM elements
        const toggleMenu = document.getElementById('toggleMenu');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        // Function to toggle sidebar
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('sidebar-active');
            sidebarOverlay.classList.toggle('active');
        }
        
        // Event listener for toggle button
        if (toggleMenu) {
            toggleMenu.addEventListener('click', toggleSidebar);
        }
        
        // Close sidebar when clicking on overlay (on small screens)
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                if (sidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            });
        }
        
        // Auto-detect current page and highlight it in the sidebar
        function highlightCurrentPage() {
            // Get current page URL (or filename)
            const currentPage = window.location.pathname.split('/').pop() || 'index.php';
            
            // Remove active class from all menu items
            const menuItems = document.querySelectorAll('.sidebar .menu-item');
            menuItems.forEach(item => {
                item.classList.remove('active');
            });
            
            // Find the menu item that matches the current page and add active class
            let activeItem = null;
            
            menuItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href) {
                    // Extract the filename from the href
                    const hrefPage = href.split('/').pop();
                    
                    // Check if the current page matches the href
                    if (hrefPage === currentPage || 
                        (currentPage === 'index.php' && (hrefPage === '' || hrefPage === 'index.php' || hrefPage === 'dashboard.php')) ||
                        (item.dataset.page && item.dataset.page === currentPage)) {
                        
                        item.classList.add('active');
                        activeItem = item;
                    }
                }
            });
            
            // Special handling for PHP variables
            const phpCurrentPage = "<?php echo $current_page; ?>";
            if (phpCurrentPage) {
                menuItems.forEach(item => {
                    const itemPage = item.dataset.page || '';
                    if (itemPage === phpCurrentPage) {
                        item.classList.add('active');
                        activeItem = item;
                    }
                });
            }
            
            return activeItem;
        }
        
        // Scroll to the active menu item
        function scrollToActiveItem(activeItem) {
            if (activeItem && sidebar) {
                // Wait a bit for any animations to complete
                setTimeout(() => {
                    // Calculate the item's position relative to the sidebar
                    const itemTop = activeItem.offsetTop;
                    const sidebarHeight = sidebar.clientHeight;
                    
                    // Scroll to position the active item in the middle of the sidebar if possible
                    const scrollTo = itemTop - (sidebarHeight / 2) + (activeItem.clientHeight / 2);
                    
                    // Smooth scroll to the item
                    sidebar.scrollTo({
                        top: Math.max(0, scrollTo),
                        behavior: 'smooth'
                    });
                }, 300);
            }
        }
        
        // Add data-page attribute to menu items
        function addDataAttributes() {
            const menuItems = document.querySelectorAll('.sidebar .menu-item');
            menuItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href) {
                    const hrefPage = href.split('/').pop();
                    if (hrefPage) {
                        item.setAttribute('data-page', hrefPage);
                    }
                }
            });
        }
        
        // Close sidebar when clicking on menu items (on small screens)
        const menuItems = document.querySelectorAll('.sidebar .menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 992 && sidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            });
        });
        
        // Handle responsive behavior based on screen size
        function handleResponsive() {
            if (window.innerWidth > 992) {
                sidebar.classList.add('active');
                mainContent.classList.add('sidebar-active');
                sidebarOverlay.classList.remove('active');
            } else {
                sidebar.classList.remove('active');
                mainContent.classList.remove('sidebar-active');
            }
        }
        
        // Initialize everything
        function init() {
            handleResponsive();
            addDataAttributes();
            const activeItem = highlightCurrentPage();
            scrollToActiveItem(activeItem);
        }
        
        // Initial setup
        init();
        
        // Check on resize
        window.addEventListener('resize', handleResponsive);
        
        // Check on hash change
        window.addEventListener('hashchange', function() {
            const activeItem = highlightCurrentPage();
            scrollToActiveItem(activeItem);
        });
    });
</script>