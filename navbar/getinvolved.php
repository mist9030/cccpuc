<?php

include('session.php');
// get-involved.php
// Define the different ways to get involved with university clubs
$involvement_options = [
    [
        'title' => 'Join a Club',
        'icon' => 'fa-users',
        'description' => 'Become a member of any of our vibrant student clubs. Develop your skills, make new friends, and enhance your university experience.',
        'cta' => 'Find Your Club',
        'link' => 'clubs-directory.php'
    ],
    [
        'title' => 'Lead a Club',
        'icon' => 'fa-user-tie',
        'description' => 'Take on leadership roles within clubs as president, secretary, or committee member. Great for building your resume and leadership skills.',
        'cta' => 'Leadership Opportunities',
        'link' => 'leadership-positions.php'
    ],
    [
        'title' => 'Start a New Club',
        'icon' => 'fa-lightbulb',
        'description' => 'Have a unique interest not represented? Propose a new club at Premier University and gather like-minded students.',
        'cta' => 'Proposal Guidelines',
        'link' => 'new-club-proposal.php'
    ],
    [
        'title' => 'Inter-Club Collaboration',
        'icon' => 'fa-handshake',
        'description' => 'Bring clubs together for joint events and initiatives. Create bigger impact through collaborative projects.',
        'cta' => 'Collaboration Portal',
        'link' => 'inter-club-collaboration.php'
    ]
];

// Featured university clubs
$featured_clubs = [
    [
        'name' => 'PUC Computer Club',
        'logo' => '../upload/clubs/computerclub.jpg',
        'description' => 'Fostering innovation in technology through workshops, hackathons, and tech talks. Open to all students interested in programming, cybersecurity, and digital creation.',
        'president' => 'Rahman Ahmed',
        'members' => '120+',
        'link' => 'computer-club.php'
    ],
    [
        'name' => 'PUC Law Club',
        'logo' => '../upload/clubs/law.jpg',
        'description' => 'Premier University, Chittagong Law Club enriches law students education through extracurricular activities, fostering legal knowledge, practical skills, and professional networking via seminars, debates, and workshops.',
        'president' => 'Nusrat Jahan',
        'members' => '85+',
        'link' => 'cultural-club.php'
    ],
    [
        'name' => 'PUC Robotics Club',
        'logo' => '../upload/clubs/robotics.jpg',
        'description' => 'Hands-on experience with robotics design, programming, and competition. Our members regularly participate in national and international robotics competitions.',
        'president' => 'Farid Khan',
        'members' => '60+',
        'link' => 'robotics-club.php'
    ],
    [
        'name' => 'PUC Debate Club',
        'logo' => '../upload/clubs/debate.jpg',
        'description' => 'Enhancing critical thinking and public speaking skills through regular debates, competitions, and workshops on current affairs and academic topics.',
        'president' => 'Taslima Akter',
        'members' => '75+',
        'link' => 'debate-club.php'
    ]
];

// Upcoming club events
$upcoming_events = [
    [
        'title' => 'Inter-University Coding Competition',
        'host' => 'PUC Computer Club',
        'date' => 'March 25, 2025',
        'time' => '10:00 AM - 6:00 PM',
        'location' => 'Computer Lab 3, Engineering Building',
        'description' => 'Annual coding competition with participants from universities across Chittagong.'
    ],
    [
        'title' => 'Pohela Boishakh Cultural Festival',
        'host' => 'PUC Cultural Club',
        'date' => 'April 14, 2025',
        'time' => '11:00 AM - 8:00 PM',
        'location' => 'University Auditorium',
        'description' => 'Bengali New Year celebration featuring traditional music, dance performances, and food stalls.'
    ],
    [
        'title' => 'Robotics Workshop Series',
        'host' => 'PUC Robotics Club',
        'date' => 'April 5-7, 2025',
        'time' => '2:00 PM - 5:00 PM',
        'location' => 'Engineering Lab Complex',
        'description' => 'Three-day workshop on Arduino programming and basic robot construction for beginners.'
    ]
];

// Success stories from club members
$success_stories = [
    [
        'name' => 'Imran Hossain',
        'image' => '../upload/avatar.png',
        'quote' => 'Being part of the Computer Club opened doors to internships and job opportunities. The skills I gained through hackathons and projects helped me secure a position at a leading tech company in Bangladesh.',
        'club' => 'Computer Club Alumni, 2023',
        'current' => 'Software Engineer at TechBD'
    ],
    [
        'name' => 'Sabrina Rahman',
        'image' => '../upload/avatar2.png',
        'quote' => 'My leadership experience as Cultural Club President taught me valuable organizational and management skills. The confidence I gained through cultural performances has been invaluable in my professional life.',
        'club' => 'Cultural Club President, 2022-2023',
        'current' => 'Communications Officer at NGO Forum'
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
    <style>/* university-clubs-styles.css */

/* General Styles */
.get-involved-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    font-family: 'Arial', sans-serif;
    color: #333;
}

section {
    margin-bottom: 60px;
}

h1, h2, h3 {
    font-weight: 700;
    color: #1a365d;
    margin-bottom: 20px;
}

h1 {
    font-size: 2.5rem;
}

h2 {
    font-size: 2rem;
    text-align: center;
    position: relative;
    padding-bottom: 15px;
}

h2:after {
    content: '';
    position: absolute;
    width: 60px;
    height: 3px;
    background-color: #2b6cb0;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
}

/* Hero Section */
.hero-section {
    background: linear-gradient(rgba(26, 54, 93, 0.8), rgba(26, 54, 93, 0.8)), url('images/puc-campus.jpg');
    background-size: cover;
    background-position: center;
    color: white;
    text-align: center;
    padding: 100px 20px;
    border-radius: 8px;
    margin-top: 30px;
}

.hero-content {
    max-width: 800px;
    margin: 0 auto;
}

.hero-content h1 {
    color: white;
    font-size: 3rem;
    margin-bottom: 20px;
}

.hero-content p {
    font-size: 1.2rem;
    margin-bottom: 30px;
}

.cta-button {
    display: inline-block;
    background-color: #38b2ac;
    color: white;
    padding: 12px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.cta-button:hover {
    background-color: #319795;
    transform: translateY(-2px);
}

/* Involvement Options */
.involvement-options {
    padding: 40px 0;
}

.options-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.option-card {
    background-color: #f8fafc;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    text-align: center;
}

.option-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.option-icon {
    font-size: 2.5rem;
    color: #2b6cb0;
    margin-bottom: 20px;
}

.option-card h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.option-card p {
    color: #4a5568;
    margin-bottom: 20px;
    line-height: 1.6;
}

.option-cta {
    display: inline-block;
    color: #2b6cb0;
    font-weight: 600;
    text-decoration: none;
    padding: 8px 15px;
    border: 2px solid #2b6cb0;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.option-cta:hover {
    background-color: #2b6cb0;
    color: white;
}

/* Featured Clubs */
.featured-clubs {
    padding: 40px 0;
}

.clubs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.club-card {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    display: flex;
}

.club-card:hover {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.club-logo {
    width: 150px;
    height: 150px;
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f7fafc;
}

.club-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.club-details {
    padding: 20px;
    flex-grow: 1;
}

.club-details h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: #2b6cb0;
}

.club-description {
    color: #4a5568;
    margin-bottom: 15px;
    line-height: 1.6;
}

.club-meta {
    color: #718096;
    margin-bottom: 15px;
}

.club-meta p {
    margin-bottom: 5px;
}

.club-cta {
    display: inline-block;
    color: #2b6cb0;
    font-weight: 600;
    text-decoration: none;
    padding: 8px 15px;
    border: 2px solid #2b6cb0;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.club-cta:hover {
    background-color: #2b6cb0;
    color: white;
}

/* Events Section */
.events-section {
    padding: 40px 0;
}

.events-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.event-card {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.event-card:hover {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.event-details {
    padding: 20px;
}

.event-details h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
}

.event-host {
    color: #38b2ac;
    margin-bottom: 10px;
    font-size: 0.95rem;
}

.event-meta {
    color: #718096;
    margin-bottom: 15px;
}

.event-meta p {
    margin-bottom: 5px;
    display: flex;
    align-items: center;
}

.event-meta i {
    margin-right: 10px;
    color: #2b6cb0;
}

.event-description {
    color: #4a5568;
    margin-bottom: 20px;
    line-height: 1.6;
}

.event-cta {
    display: inline-block;
    color: #2b6cb0;
    font-weight: 600;
    text-decoration: none;
}

.view-all {
    text-align: center;
    margin-top: 30px;
}

.view-all a {
    display: inline-block;
    color: #2b6cb0;
    font-weight: 600;
    text-decoration: none;
    padding: 10px 20px;
    border: 2px solid #2b6cb0;
    border-radius: 30px;
    transition: all 0.3s ease;
}

.view-all a:hover {
    background-color: #2b6cb0;
    color: white;
}

/* Impact Section */
.impact-section {
    background-color: #ebf8ff;
    padding: 60px 30px;
    border-radius: 8px;
    text-align: center;
}

.impact-stats {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    margin-top: 40px;
}

.stat-box {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 200px;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2b6cb0;
    margin-bottom: 10px;
}

.stat-label {
    color: #4a5568;
    font-weight: 600;
}

/* Testimonials Section */
.testimonials-section {
    padding: 40px 0;
}

.testimonials-slider {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.testimonial-card {
    background-color: #f8fafc;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.testimonial-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.testimonial-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.testimonial-content {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.testimonial-content blockquote {
    font-style: italic;
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 20px;
    flex-grow: 1;
}

.testimonial-author {
    display: flex;
    flex-direction: column;
}

.testimonial-author strong {
    color: #1a365d;
    margin-bottom: 5px;
}

.testimonial-author span {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 3px;
}

/* Contact Section */
.contact-section {
    background-color: #1a365d;
    color: white;
    text-align: center;
    padding: 60px 30px;
    border-radius: 8px;
    margin-bottom: 0;
}

.contact-section h2 {
    color: white;
}

.contact-section h2:after {
    background-color: white;
}

.contact-section p {
    font-size: 1.2rem;
    margin-bottom: 30px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.contact-cta {
    display: inline-block;
    background-color: white;
    color: #1a365d;
    padding: 12px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.contact-cta:hover {
    background-color: #f7fafc;
    transform: translateY(-2px);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2.2rem;
    }
    
    .options-grid, .events-list, .testimonials-slider {
        grid-template-columns: 1fr;
    }
    
    .clubs-grid {
        grid-template-columns: 1fr;
    }
    
    .club-card {
        flex-direction: column;
    }
    
    .club-logo {
        width: 100%;
        height: 120px;
    }
    
    .impact-stats {
        flex-direction: column;
        align-items: center;
    }
    
    .stat-box {
        width: 100%;
        max-width: 300px;
    }
}</style>
</head>
<body class="font-sans text-gray-800 m-0 p-0 leading-normal">
    <header class="bg-black text-white w-full">
    
        <?php include('../navbar/navbar.php');?> 
    </header>

    <main class="max-w-6xl mx-auto p-8">
    <main class="get-involved-container">
    <section class="hero-section">
        <div class="hero-content">
            <h1>Get Involved at Premier University Clubs</h1>
            <p>Discover your passion, develop new skills, and make lasting connections through our diverse range of student clubs and organizations at Premier University, Chittagong.</p>
            <a href="#options" class="cta-button">Explore Opportunities</a>
        </div>
    </section>

    <section id="options" class="involvement-options">
        <h2>Ways to Get Involved</h2>
        <div class="options-grid">
            <?php foreach($involvement_options as $option): ?>
                <div class="option-card">
                    <div class="option-icon">
                        <i class="fas <?php echo $option['icon']; ?>"></i>
                    </div>
                    <h3><?php echo $option['title']; ?></h3>
                    <p><?php echo $option['description']; ?></p>
                    <a href="<?php echo $option['link']; ?>" class="option-cta"><?php echo $option['cta']; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="featured-clubs">
        <h2>Featured Clubs</h2>
        <div class="clubs-grid">
            <?php foreach($featured_clubs as $club): ?>
                <div class="club-card">
                    <div class="club-logo">
                        <img src="<?php echo $club['logo']; ?>" alt="<?php echo $club['name']; ?> Logo">
                    </div>
                    <div class="club-details">
                        <h3><?php echo $club['name']; ?></h3>
                        <p class="club-description"><?php echo $club['description']; ?></p>
                        <div class="club-meta">
                            <p><strong>President:</strong> <?php echo $club['president']; ?></p>
                            <p><strong>Members:</strong> <?php echo $club['members']; ?></p>
                        </div>
                        <a href="<?php echo $club['link']; ?>" class="club-cta">Learn More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="view-all">
            <a href="/PUC/navbar/clublist.php">View All Clubs</a>
        </div>
    </section>

    <section class="events-section">
        <h2>Upcoming Club Events</h2>

        <div class="events-list">
            <?php foreach($upcoming_events as $event): ?>
                <div class="event-card">
                    <div class="event-details">
                        <h3><?php echo $event['title']; ?></h3>
                        <p class="event-host"><strong>Hosted by:</strong> <?php echo $event['host']; ?></p>
                        <div class="event-meta">
                            <p><i class="far fa-calendar-alt"></i> <?php echo $event['date']; ?></p>
                            <p><i class="far fa-clock"></i> <?php echo $event['time']; ?></p>
                            <p><i class="fas fa-map-marker-alt"></i> <?php echo $event['location']; ?></p>
                        </div>
                        <p class="event-description"><?php echo $event['description']; ?></p>
                        <a href="event.php" class="event-cta">Learn More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="view-all">
            <a href="event.php">View All Events</a>
        </div>
    </section>

    <section class="impact-section">
        <h2>PUC Clubs Impact</h2>
        <div class="impact-stats">
            <div class="stat-box">
                <span class="stat-number">15+</span>
                <span class="stat-label">Active Clubs</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">1,200+</span>
                <span class="stat-label">Student Members</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">50+</span>
                <span class="stat-label">Events Per Year</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">25+</span>
                <span class="stat-label">Awards Won</span>
            </div>
        </div>
    </section>

    <section class="testimonials-section">
        <h2>Success Stories</h2>
        <div class="testimonials-slider">
            <?php foreach($success_stories as $story): ?>
                <div class="testimonial-card">
                    <div class="testimonial-image">
                        <img src="<?php echo $story['image']; ?>" alt="<?php echo $story['name']; ?>">
                    </div>
                    <div class="testimonial-content">
                        <blockquote>"<?php echo $story['quote']; ?>"</blockquote>
                        <div class="testimonial-author">
                            <strong><?php echo $story['name']; ?></strong>
                            <span><?php echo $story['club']; ?></span>
                            <span><?php echo $story['current']; ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="contact-section">
        <h2>Have Questions?</h2>
        <p>Reach out to the Club Coordination Office or contact specific clubs directly for more information about getting involved.</p>
        <a href="contact.php" class="contact-cta">Contact Club Office</a>
    </section>
</main>
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