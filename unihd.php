<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>

        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.6;
    color: #333;
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
                /* width: 300px; */
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
    transition: transform 0.3s ease-in-out; /* Smooth transition */
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

/* Hover effect: slight zoom and darker overlay */
.hero:hover {
    transform: scale(1.02); /* Slight zoom-in effect */
}

.hero:hover::before {
    background: rgba(0, 0, 0, 0.6); /* Darken overlay */
}

.hero:hover h1,
.hero:hover p,
.hero:hover .btn {
    transform: translateY(-3px); /* Move text up slightly */
}

/* Button Animation */
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
    transform: scale(1.1); /* Slightly enlarge button */
}

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

        /* Desktop dropdown behavior */
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

        /* Mobile Styles */
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
    </style>
</head>
<body>
<header class="header1">
       
        <div class="bottom-header1">
            <div class="main-header1">
                <div class="logo-container1">
                    <div class="logo1">
                        <img src="/PUC/upload/logopuc1.PNG" alt="CCCPUC">
                    </div>
                    <div class="stars-badge1">
                        <img src="/PUC/upload/cccpuclogoustom.PNG" alt="Proud to be STARS">
                    </div>
                </div>
                <button class="nav-toggle1">
                    <i class="fas fa-bars"></i>
                </button>
                <nav class="nav1">
                    <ul class="nav-list1">
                        <li><a href="#" class="nav-link1">Representing You</a></li>
                        <li><a href="#" class="nav-link1">What We Do</a></li>
                        <li><a href="/PUC/navbar/news.php" class="nav-link1">News</a></li>
                        <li><a href="#" class="nav-link1">What's On</a></li>
                        <li><a href="#" class="nav-link1">Get Involved</a></li>
                        <li class="nav-item">
                <a href="#" class="nav-link has-dropdown">Clubs<i class="dropdown-icon"></i></a>
                <div class="dropdown-content">
                    <a href="https://pucc.vercel.app/">PUC Computer Club</a>
                    <a href="https://www.facebook.com/share/1HashtuyDn/">PUC Robotics Club</a>
                    <a href="#">PUC Debating Club</a>
                    <a href="#">PUC Cultural Club</a>
                </div>
            </li>
                        <li><a href="#" class="nav-link1">Advice</a></li>
                        <li><a href="#" class="nav-link1">Proud </a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="overlay1"></div>
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
   

        <!-- Add this to your existing JavaScript -->
        <script>
        // Previous JavaScript remains the same

        // Handle dropdown on mobile
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
    

    <script src="script.js"></script>
</body>
</html>