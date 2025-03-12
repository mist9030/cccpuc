<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            color: white;
            padding: 0.8rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: bold;
            z-index: 3;
        }
        
        .navbar-logo i {
            font-size: 1.8rem;
        }
        
        .navbar-menu {
            display: flex;
            gap: 20px;
        }
        
        .navbar-menu a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .navbar-menu a:hover {
            background-color: #34495e;
        }
        
        .navbar-menu a.active {
            background-color: #3498db;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .help-icon {
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 3;
        }
        
        @media (max-width: 992px) {
            .navbar-menu a {
                font-size: 0.9rem;
                padding: 0.4rem 0.8rem;
            }
        }
        
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            .navbar {
                justify-content: space-between;
                padding: 1rem;
            }
            
            .navbar-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 70%;
                max-width: 300px;
                height: 100vh;
                background-color: #2c3e50;
                flex-direction: column;
                padding: 5rem 2rem 2rem;
                z-index: 2;
                transition: right 0.3s ease-in-out;
                box-shadow: -2px 0 5px rgba(0,0,0,0.2);
            }
            
            .navbar-menu.active {
                right: 0;
            }
            
            .navbar-menu a {
                display: block;
                width: 100%;
                text-align: left;
                padding: 1rem;
                border-bottom: 1px solid #34495e;
            }
            
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 1;
            }
            
            .overlay.active {
                display: block;
            }
        }
    
        
        @media (max-width: 480px) {
            .navbar-right {
                gap: 10px;
            }
            
            .navbar-logo {
                font-size: 1.2rem;
            }
            
            .navbar-logo i {
                font-size: 1.5rem;
            }
            
            select {
                max-width: 100px;
                font-size: 0.8rem;
            }
        }
    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-logo">
            <i class="fas fa-shield-alt"></i>
            <span>Admin Portal</span>
        </div>
        
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="navbar-menu" id="navMenu">
            <a href="#" class="active">Login</a>
            <a href="#">Reset Password</a>
        </div>
        
        <div class="navbar-right">
            <div class="help-icon">
                <i class="fas fa-question-circle"></i>
            </div>
            <select name="language" id="language">
                <option value="en">English</option>
                <option value="es">Spanish</option>
                <option value="fr">French</option>
                <option value="de">German</option>
            </select>
        </div>
    </nav>
    
    <div class="overlay" id="overlay"></div>
     
    <script>
        // Script for mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
        const overlay = document.getElementById('overlay');
        
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            overlay.classList.toggle('active');
        });
        
        overlay.addEventListener('click', () => {
            navMenu.classList.remove('active');
            overlay.classList.remove('active');
        });
        
        // Close menu when clicking a link
        const navLinks = document.querySelectorAll('.navbar-menu a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                overlay.classList.remove('active');
            });
        });
        
        // Close menu when window is resized to desktop view
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                navMenu.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    </script>
</body>
</html>