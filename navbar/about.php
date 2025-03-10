<?php 
include('session.php');?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central Club Community of Premier University</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 m-0 p-0 leading-normal bg-gray-50">
    <header class="bg-gray-900 text-white w-full">
    
        <?php include('../navbar/navbar.php');?> 
        <?php
// what-we-do.php
// Define the core functions of the Premier University Clubs System
$core_functions = [
    [
        'title' => 'Club Coordination',
        'icon' => 'fa-sync-alt',
        'description' => 'We serve as the central hub that coordinates all registered student clubs at Premier University, Chittagong. Our platform facilitates communication between club leadership, administration, and students, ensuring smooth operations across all university clubs.',
        'color' => '#4299e1'
    ],
    [
        'title' => 'Resource Allocation',
        'icon' => 'fa-hands-helping',
        'description' => 'We manage and distribute university resources including funding, venues, equipment, and promotional channels to support club activities. Through our fair allocation system, we ensure all clubs have access to the resources they need to thrive.',
        'color' => '#38b2ac'
    ],
    [
        'title' => 'Event Management',
        'icon' => 'fa-calendar-check',
        'description' => 'We provide a centralized event planning and promotion system for all club activities. Our platform helps prevent scheduling conflicts, coordinates campus-wide events, and ensures maximum student participation through effective promotion.',
        'color' => '#ed8936'
    ],
    [
        'title' => 'Student Development',
        'icon' => 'fa-user-graduate',
        'description' => 'We foster student leadership, professional growth, and skill development through club activities. Our system supports workshops, training sessions, and competitions that complement academic learning with practical experience.',
        'color' => '#9f7aea'
    ]
];

// Define the types of clubs at Premier University
$club_categories = [
    [
        'title' => 'Academic & Departmental',
        'icon' => 'fa-book',
        'description' => 'Clubs focused on specific academic disciplines including Computer Science, Business, Engineering, and more. These clubs organize subject-related activities, workshops, and industry connections.',
        'examples' => 'Computer Club, Business Club, Civil Engineering Club',
        'color' => '#3182ce'
    ],
    [
        'title' => 'Cultural & Arts',
        'icon' => 'fa-paint-brush',
        'description' => 'Clubs dedicated to promoting cultural heritage, artistic expression, and creative talent among students through performances, exhibitions, and cultural celebrations.',
        'examples' => 'Cultural Club, Photography Club, Drama Club',
        'color' => '#d53f8c'
    ],
    [
        'title' => 'Innovation & Technology',
        'icon' => 'fa-microchip',
        'description' => 'Clubs focused on cutting-edge technologies, innovation, and practical application of technical knowledge through projects, competitions, and research initiatives.',
        'examples' => 'Robotics Club, IoT Club, Mobile App Development Club',
        'color' => '#319795'
    ],
    [
        'title' => 'Debate & Literary',
        'icon' => 'fa-comments',
        'description' => 'Clubs that foster critical thinking, communication skills, and literary talent through debates, public speaking, writing workshops, and publishing initiatives.',
        'examples' => 'Debate Club, English Language Club, Literary Society',
        'color' => '#805ad5'
    ],
    [
        'title' => 'Sports & Recreation',
        'icon' => 'fa-volleyball-ball',
        'description' => 'Clubs dedicated to physical wellness, sports competitions, and recreational activities that promote teamwork, fitness, and healthy competition among students.',
        'examples' => 'Cricket Club, Football Club, Chess Club',
        'color' => '#dd6b20'
    ],
    [
        'title' => 'Social Impact & Community',
        'icon' => 'fa-globe-asia',
        'description' => 'Clubs focused on social service, community development, and addressing social issues through volunteer work, awareness campaigns, and outreach programs.',
        'examples' => 'Social Service Club, Environmental Club, Blood Donation Club',
        'color' => '#38a169'
    ]
];

// Define the club system benefits
$benefits = [
    [
        'title' => 'For Students',
        'icon' => 'fa-user-friends',
        'points' => [
            'Develop leadership and teamwork skills',
            'Build professional networks with industry connections',
            'Apply classroom knowledge in practical scenarios',
            'Explore interests beyond academic curriculum',
            'Enhance resume with extracurricular achievements',
            'Form lasting friendships with like-minded peers'
        ],
        'color' => '#4299e1'
    ],
    [
        'title' => 'For University',
        'icon' => 'fa-university',
        'points' => [
            'Enhance overall student experience and satisfaction',
            'Showcase student talents to broader community',
            'Strengthen university brand through club achievements',
            'Create stronger alumni connections through memorable experiences',
            'Support holistic development alongside academic excellence',
            'Attract prospective students with vibrant campus life'
        ],
        'color' => '#2c5282'
    ],
    [
        'title' => 'For Community',
        'icon' => 'fa-city',
        'points' => [
            'Access to educational events and workshops',
            'Collaboration opportunities with student talents',
            'Support for local causes through volunteer initiatives',
            'Cultural enrichment through performances and exhibitions',
            'Technology and innovation showcases',
            'Stronger connection between university and city'
        ],
        'color' => '#38a169'
    ]
];
?>

<main class="what-we-do-container">
    <section class="about-hero">
        <div class="about-hero-content">
            <h1>What We Do</h1>
            <p>The Premier University Clubs platform serves as the central coordination system for all student clubs and extracurricular activities at Premier University, Chittagong. We connect students with opportunities to explore their interests, develop new skills, and build lasting relationships outside the classroom.</p>
        </div>
    </section>

    <section class="mission-section">
        <div class="mission-box">
            <h2>Our Mission</h2>
            <p>To foster a vibrant and inclusive campus community through coordinated club activities that complement academic learning, develop student leadership, and create memorable university experiences.</p>
        </div>
        
        <div class="vision-box">
            <h2>Our Vision</h2>
            <p>To be the model university club system in Bangladesh, known for excellence in student engagement, leadership development, and creating graduates with both academic knowledge and practical skills.</p>
        </div>
    </section>

    <section class="core-functions">
        <h2>Core Functions</h2>
        <div class="functions-grid">
            <?php foreach($core_functions as $function): ?>
                <div class="function-card">
                    <div class="function-icon" style="background-color: <?php echo $function['color']; ?>">
                        <i class="fas <?php echo $function['icon']; ?>"></i>
                    </div>
                    <h3><?php echo $function['title']; ?></h3>
                    <p><?php echo $function['description']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="club-categories">
        <h2>Club Categories</h2>
        <div class="categories-grid">
            <?php foreach($club_categories as $category): ?>
                <div class="category-card">
                    <div class="category-header" style="background-color: <?php echo $category['color']; ?>">
                        <i class="fas <?php echo $category['icon']; ?>"></i>
                        <h3><?php echo $category['title']; ?></h3>
                    </div>
                    <div class="category-content">
                        <p><?php echo $category['description']; ?></p>
                        <div class="examples">
                            <strong>Examples:</strong> <?php echo $category['examples']; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="benefits-section">
        <h2>Benefits of Our Club System</h2>
        <div class="benefits-grid">
            <?php foreach($benefits as $benefit): ?>
                <div class="benefit-card">
                    <div class="benefit-header" style="background-color: <?php echo $benefit['color']; ?>">
                        <i class="fas <?php echo $benefit['icon']; ?>"></i>
                        <h3><?php echo $benefit['title']; ?></h3>
                    </div>
                    <div class="benefit-content">
                        <ul>
                            <?php foreach($benefit['points'] as $point): ?>
                                <li><?php echo $point; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="history-section">
        <h2>Our History</h2>
        <div class="history-content">
            <p>The Premier University Clubs system was established in 2010 to coordinate the growing number of student clubs and activities. What began with just five clubs has grown into a vibrant ecosystem of over 15 active clubs spanning various interests and disciplines.</p>
            <p>Over the years, our clubs have achieved national recognition in competitions, hosted impactful events, and produced graduates who attribute much of their professional success to their club experiences at Premier University.</p>
            <p>Today, we continue to expand and enhance our support for student-led initiatives, adapting to changing student interests and incorporating new technologies to better serve our university community.</p>
        </div>
    </section>

    <section class="administration-section">
        <h2>Club Administration</h2>
        <div class="admin-content">
            <p>The Premier University Clubs system is supervised by the Department of Student Affairs with guidance from faculty advisors. Each club operates with an elected student executive committee, typically including a President, Vice President, General Secretary, Treasurer, and additional roles specific to the club's needs.</p>
            <p>Club activities and budgets are approved through our centralized management system, ensuring transparency and fair resource allocation while maintaining the student-led nature of all clubs.</p>
            <a href="club-governance.php" class="learn-more">Learn More About Club Governance</a>
        </div>
    </section>
    <style>
    /* what-we-do-styles.css */

/* General Styles */
.what-we-do-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    font-family: 'Arial', sans-serif;
    color: #333;
    margin-top: 5rem; /* Added this line */
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

p1 {
    line-height: 1.6;
    color: #4a5568;
}

/* Hero Section */
.about-hero {
    background: linear-gradient(rgba(26, 54, 93, 0.8), rgba(26, 54, 93, 0.8)), url('images/puc-campus-life.jpg');
    background-size: cover;
    background-position: center;
    color: white;
    text-align: center;
    padding: 100px 20px;
    border-radius: 8px;
    margin-top: 30px;
}

.about-hero-content {
    max-width: 800px;
    margin: 0 auto;
}

.about-hero-content h1 {
    color: white;
    font-size: 3rem;
    margin-bottom: 20px;
}

.about-hero-content p {
    font-size: 1.2rem;
    margin-bottom: 30px;
    color: white;
}

/* Mission and Vision Section */
.mission-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-top: 50px;
}

.mission-box, .vision-box {
    background-color: #f8fafc;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.mission-box h2, .vision-box h2 {
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.mission-box h2:after, .vision-box h2:after {
    width: 40px;
}

.mission-box {
    border-top: 4px solid #3182ce;
}

.vision-box {
    border-top: 4px solid #38b2ac;
}

/* Core Functions Section */
.core-functions {
    padding: 40px 0;
}

.functions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.function-card {
    background-color: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.function-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.function-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.function-icon i {
    font-size: 2rem;
    color: white;
}

.function-card h3 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #2d3748;
}

.function-card p {
    color: #4a5568;
    line-height: 1.6;
}

/* Club Categories Section */
.club-categories {
    padding: 40px 0;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.category-card {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.category-header {
    padding: 20px;
    color: white;
    display: flex;
    align-items: center;
}

.category-header i {
    font-size: 1.8rem;
    margin-right: 15px;
}

.category-header h3 {
    margin: 0;
    color: white;
    font-size: 1.4rem;
}

.category-content {
    padding: 20px;
}

.category-content p {
    margin-bottom: 15px;
}

.examples {
    font-size: 0.95rem;
    color: #718096;
    font-style: italic;
}

/* Benefits Section */
.benefits-section {
    padding: 40px 0;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.benefit-card {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.benefit-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

.benefit-header {
    padding: 20px;
    color: white;
    display: flex;
    align-items: center;
}

.benefit-header i {
    font-size: 1.8rem;
    margin-right: 15px;
}

.benefit-header h3 {
    margin: 0;
    color: white;
    font-size: 1.4rem;
}

.benefit-content {
    padding: 20px;
}

.benefit-content ul {
    padding-left: 20px;
}

.benefit-content ul li {
    margin-bottom: 10px;
    color: #4a5568;
}

/* History Section */
.history-section {
    padding: 40px;
    background-color: #f8fafc;
    border-radius: 8px;
}

.history-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.history-content p {
    margin-bottom: 20px;
}

/* Administration Section */
.administration-section {
    padding: 40px;
    background-color: #ebf8ff;
    border-radius: 8px;
}

.admin-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.admin-content p {
    margin-bottom: 20px;
}

.learn-more {
    display: inline-block;
    color: #2b6cb0;
    font-weight: 600;
    text-decoration: none;
    padding: 10px 20px;
    border: 2px solid #2b6cb0;
    border-radius: 30px;
    margin-top: 20px;
    transition: all 0.3s ease;
}

.learn-more:hover {
    background-color: #2b6cb0;
    color: white;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .about-hero-content h1 {
        font-size: 2.2rem;
    }
    
    .mission-section {
        grid-template-columns: 1fr;
    }
    
    .categories-grid, .benefits-grid {
        grid-template-columns: 1fr;
    }
}
</style>
</main>
<?php include('../footer.php');?>
</body>
</html>