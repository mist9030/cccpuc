<?php

include('session.php');
// This is the main content for the "Proud" page
// You'll add your own header and footer

// Sample achievements data - you can replace this with database content later
$achievements = [
    [
        'icon' => 'fa-trophy',
        'title' => 'Award Winning Club',
        'description' => 'Recognized as the best student-led club for three consecutive years (2022-2024).',
    ],
    [
        'icon' => 'fa-users',
        'title' => 'Growing Community',
        'description' => 'Over 500 active members from various departments across the university.',
    ],
    [
        'icon' => 'fa-handshake',
        'title' => 'Industry Partnerships',
        'description' => 'Established partnerships with leading companies providing internship opportunities for members.',
    ],
    [
        'icon' => 'fa-lightbulb',
        'title' => 'Innovation Hub',
        'description' => 'Created a platform for students to showcase their innovative ideas and prototypes.',
    ]
];

// Sample testimonials from members
$testimonials = [
    [
        'quote' => 'Being part of this club has been the highlight of my university experience. Ive developed skills that I couldnt learn in a classroom.',
        'name' => 'Alex Smith',
        'position' => 'Computer Science, 3rd Year',
        'image' => '/PUC/upload/testimonial1.jpg'
    ],
    [
        'quote' => 'The mentorship program run by senior members completely changed my career trajectory. I secured an internship thanks to the connections I made here.',
        'name' => 'Jamie Taylor',
        'position' => 'Electrical Engineering, 4th Year',
        'image' => '/PUC/upload/testimonial2.jpg'
    ],
    [
        'quote' => 'From a shy first-year to presenting at national competitions - this club helped me discover my potential and build confidence.',
        'name' => 'Riley Johnson',
        'position' => 'Robotics, 2nd Year',
        'image' => '/PUC/upload/testimonial3.jpg'
    ]
];

// Sample values that the club is proud of
$values = [
    [
        'icon' => 'fa-graduation-cap',
        'title' => 'Academic Excellence',
        'description' => 'We promote scholarly achievement while balancing practical application of knowledge.',
    ],
    [
        'icon' => 'fa-people-group',
        'title' => 'Inclusivity',
        'description' => 'We welcome students from all backgrounds, creating a diverse and supportive community.',
    ],
    [
        'icon' => 'fa-code',
        'title' => 'Innovation',
        'description' => 'We encourage creative thinking and exploring cutting-edge technologies.',
    ],
    [
        'icon' => 'fa-hands-helping',
        'title' => 'Mentorship',
        'description' => 'We believe in lifting each other up through knowledge sharing and guidance.',
    ],
    [
        'icon' => 'fa-globe',
        'title' => 'Global Perspective',
        'description' => 'We prepare members to succeed in an interconnected, international landscape.',
    ],
    [
        'icon' => 'fa-heart',
        'title' => 'Community Service',
        'description' => 'We give back to our university and local community through volunteer initiatives.',
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central Club Community of Premier University</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Base styles */
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-bg: #f5f7fa;
            --dark-bg: #2c3e50;
            --text-color: #333;
            --light-text: #f5f5f5;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: var(--text-color);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        /* Page header */
        .page-header {
            background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.8)), 
                        url('/PUC/upload/header-bg.jpg') no-repeat center center/cover;
            color: var(--light-text);
            text-align: center;
            padding: 4rem 2rem;
            margin-bottom: 2rem;
        }
        
        .page-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .page-subtitle {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.9;
        }
        
        /* Section styling */
        .section {
            padding: 3rem 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }
        
        .section-title h2 {
            font-size: 2rem;
            color: var(--secondary-color);
            display: inline-block;
        }
        
        .section-title h2:after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: var(--primary-color);
            margin: 0.5rem auto 0;
        }
        
        /* Achievements section */
        .achievements {
            background-color: var(--light-bg);
        }
        
        .achievements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .achievement-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .achievement-card:hover {
            transform: translateY(-5px);
        }
        
        .achievement-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .achievement-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }
        
        /* Values section */
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .value-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            transition: transform 0.3s ease;
            border-bottom: 2px solid transparent;
        }
        
        .value-card:hover {
            transform: translateX(5px);
            border-bottom: 2px solid var(--primary-color);
        }
        
        .value-icon {
            font-size: 1.8rem;
            color: var(--primary-color);
            flex-shrink: 0;
        }
        
        .value-content {
            flex-grow: 1;
        }
        
        .value-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }
        
        /* Testimonials section */
        .testimonials {
            background-color: var(--dark-bg);
            color: var(--light-text);
        }
        
        .testimonials .section-title h2 {
            color: var(--light-text);
        }
        
        .testimonials-slider {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding: 1rem 0;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none; /* Firefox */
        }
        
        .testimonials-slider::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Edge */
        }
        
        .testimonial-card {
            flex: 0 0 auto;
            width: 90%;
            max-width: 500px;
            margin-right: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 1.5rem;
            scroll-snap-align: start;
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .author-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }
        
        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .author-details .name {
            font-weight: bold;
            font-size: 1.1rem;
        }
        
        .author-details .position {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(to right, var(--primary-color), #2980b9);
            color: white;
            text-align: center;
            padding: 3rem 1rem;
        }
        
        .cta-title {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .cta-text {
            max-width: 700px;
            margin: 0 auto 2rem;
            font-size: 1.1rem;
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: white;
            color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .achievements-grid,
            .values-grid {
                grid-template-columns: 1fr;
            }
            
            .testimonial-card {
                width: 85%;
            }
            
            .page-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="font-sans text-gray-800 m-0 p-0 leading-normal">
    <header class="bg-black text-white w-full">
    
        <?php include('navbar.php');?> 
    </header>

    <main class="max-w-6xl mx-auto p-8 mt-20">
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">We're Proud of Our Club</h1>
            <p class="page-subtitle">Celebrating our achievements, values, and the incredible community we've built together.</p>
        </div>
    </div>
    
    <section class="section achievements">
        <div class="container">
            <div class="section-title">
                <h2>Our Achievements</h2>
            </div>
            
            <div class="achievements-grid">
                <?php foreach($achievements as $achievement): ?>
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fa <?php echo $achievement['icon']; ?>"></i>
                    </div>
                    <h3 class="achievement-title"><?php echo $achievement['title']; ?></h3>
                    <p><?php echo $achievement['description']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <section class="section values">
        <div class="container">
            <div class="section-title">
                <h2>Our Values</h2>
            </div>
            
            <div class="values-grid">
                <?php foreach($values as $value): ?>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa <?php echo $value['icon']; ?>"></i>
                    </div>
                    <div class="value-content">
                        <h3 class="value-title"><?php echo $value['title']; ?></h3>
                        <p><?php echo $value['description']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <section class="section testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Member Testimonials</h2>
            </div>
            
            <div class="testimonials-slider">
                <?php foreach($testimonials as $testimonial): ?>
                <div class="testimonial-card">
                    <p class="testimonial-text"><?php echo $testimonial['quote']; ?></p>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="<?php echo $testimonial['image']; ?>" alt="<?php echo $testimonial['name']; ?>">
                        </div>
                        <div class="author-details">
                            <div class="name"><?php echo $testimonial['name']; ?></div>
                            <div class="position"><?php echo $testimonial['position']; ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Join Our Proud Community</h2>
            <p class="cta-text">Become part of a club that inspires excellence, fosters innovation, and builds lifelong connections. We're looking for passionate students like you!</p>
            <div class="cta-buttons">
                <a href="#" class="btn btn-primary">Join Now</a>
                <a href="#" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </section>
    </main>

    <?php include('../footer.php'); ?>

    <script>
        // Navigation toggle
        const navToggle = document.getElementById('navToggle');
        const mainNav = document.getElementById('mainNav');
        const navOverlay = document.getElementById('navOverlay');

        function toggleMenu() {
            mainNav.classList.toggle('-right-[300px]');
            mainNav.classList.toggle('right-0');
            navOverlay.classList.toggle('opacity-0');
            navOverlay.classList.toggle('invisible');
            
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
        navOverlay.addEventListener('click', toggleMenu);

        // Dropdown handling
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const dropdownContent = this.nextElementSibling;
                    const dropdownIcon = this.querySelector('.dropdown-icon');
                    
                    dropdownContent.classList.toggle('hidden');
                    dropdownIcon.classList.toggle('rotate-180');
                    
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                        if (dropdown !== dropdownContent) {
                            dropdown.classList.add('hidden');
                        }
                    });
                    
                    document.querySelectorAll('.dropdown-icon').forEach(icon => {
                        if (icon !== dropdownIcon) {
                            icon.classList.remove('rotate-180');
                        }
                    });
                }
            });
        });

        // Desktop hover behavior for dropdowns
        if (window.innerWidth > 768) {
            const navItems = document.querySelectorAll('.relative');
            
            navItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    const dropdown = item.querySelector('.dropdown-content');
                    if (dropdown) dropdown.classList.remove('hidden');
                });
                
                item.addEventListener('mouseleave', () => {
                    const dropdown = item.querySelector('.dropdown-content');
                    if (dropdown) dropdown.classList.add('hidden');
                });
            });
        }

        // Close menu on link click
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768 && !link.classList.contains('dropdown-toggle')) {
                    toggleMenu();
                }
            });
        });

        // Reset menu on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                mainNav.classList.remove('right-0');
                mainNav.classList.add('-right-[300px]');
                navOverlay.classList.add('opacity-0', 'invisible');
                
                const icon = navToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                
                // Reset dropdowns
                document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
                
                document.querySelectorAll('.dropdown-icon').forEach(icon => {
                    icon.classList.remove('rotate-180');
                });
            }
        });
    </script>
</body>
</html>