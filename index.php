<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central Club Community of Premier University</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 m-0 p-0 leading-normal">
    <header class="bg-black text-white w-full">
    
        <?php include('navbar/navbar.php');?> 
    </header>

    <main class="max-w-6xl mx-auto p-8 mt-20">
        <section class="text-center relative bg-cover bg-center text-white p-12 mb-8 min-h-[45vh] flex flex-col justify-center items-center overflow-hidden transition-transform duration-300 ease-in-out hover:scale-[1.02] group" style="background-image: url('/PUC/upload/cover.jpg')">
            <div class="absolute inset-0 bg-black bg-opacity-40 transition-all duration-300 group-hover:bg-opacity-60"></div>
            <h1 class="relative z-10 text-4xl font-bold mb-4 transition-transform duration-300 group-hover:-translate-y-1">Welcome to Central Club Community of Premier University</h1>
            <p class="relative z-10 text-xl mb-6 transition-transform duration-300 group-hover:-translate-y-1">Empowering students, enriching experiences.</p>
            <a href="/PUC/navbar/getinvolved.php" class="relative z-10 inline-block px-5 py-2 bg-amber-500 text-white font-bold rounded transition-all duration-300 hover:bg-amber-600 hover:scale-110">Get Involved</a>
        </section>

        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-4">About Us</h2>
            <p class="mb-6">The Central Club Community of PUC is a vibrant, student-led organization dedicated to enhancing the university experience for all. We strive to represent, support, and empower our diverse community of students.</p>
            <div class="flex flex-col md:flex-row gap-8">
                <div class="flex-1">
                    <h3 class="text-2xl font-semibold mb-3">Our Mission</h3>
                    <p>To create a thriving, inclusive, and engaging environment that fosters personal growth, academic success, and community impact.</p>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-semibold mb-3">Core Values</h3>
                    <ul class="list-disc pl-5">
                        <li>Inclusivity</li>
                        <li>Integrity</li>
                        <li>Innovation</li>
                        <li>Empowerment</li>
                        <li>Collaboration</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-6">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="border border-gray-200 p-6 text-center">
                    <img src="/PUC/upload/a&s.JPG" alt="Advice and Support" class="w-full h-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Advice and Support</h3>
                    <p class="mb-4">Providing guidance and assistance on a wide range of student-related issues.</p>
                    <a href="#" class="inline-block px-5 py-2 bg-blue-500 text-white rounded transition-all duration-300 hover:bg-blue-600">Learn More</a>
                </div>
                <div class="border border-gray-200 p-6 text-center">
                    <img src="/PUC/upload/c&s.jpg" alt="Clubs and Societies" class="w-full h-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Clubs and Societies</h3>
                    <p class="mb-4">Explore your interests and connect with like-minded students through our diverse range of clubs and societies.</p>
                    <a href="/PUC/navbar/clublist.php" class="inline-block px-5 py-2 bg-blue-500 text-white rounded transition-all duration-300 hover:bg-blue-600">Explore Clubs</a>
                </div>
                <div class="border border-gray-200 p-6 text-center">
                    <img src="/PUC/upload/e&a.jpg" alt="Events and Activities" class="w-full h-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Events and Activities</h3>
                    <p class="mb-4">Engage in a vibrant calendar of social, educational, and recreational events.</p>
                    <a href="/PUC/navbar/event.php" class="inline-block px-5 py-2 bg-blue-500 text-white rounded transition-all duration-300 hover:bg-blue-600">Upcoming Events</a>
                </div>
            </div>
        </section>

        <?php
include 'connection.php';

// Query to get only the latest 2 news items
$sql = "SELECT n.id, n.title, n.content, n.image, n.published_date, n.author, c.club_name, c.logo as club_logo 
        FROM news n 
        LEFT JOIN clubs c ON n.club_id = c.id 
        WHERE featured = 1 
        ORDER BY n.id DESC 
        LIMIT 2";
$result = $con->query($sql);
?>

<section class="mb-12">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold">Latest News</h2>
        <a href="/PUC/navbar/news.php" class="inline-block px-5 py-2 bg-amber-500 text-white font-bold rounded transition-all duration-300 hover:bg-amber-600">View All News</a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php 
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Get excerpt from content
                $excerpt = strip_tags($row['content']);
                $excerpt = substr($excerpt, 0, 150);
                $needReadMore = strlen(strip_tags($row['content'])) > 150;
                
                // Default image if none provided
                $image = !empty($row['image']) ? 'upload/news/' . $row['image'] : 'https://via.placeholder.com/600x400';
                $club_logo = !empty($row['club_logo']) ? 'upload/clubs/' . $row['club_logo'] : 'https://via.placeholder.com/50';
                
                // Format date
                $news_date = date("M d, Y", strtotime($row['published_date']));
        ?>
        <div class="news-card group border border-gray-200 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 cursor-pointer" data-id="<?php echo $row['id']; ?>">
            <div class="relative h-48 overflow-hidden">
                <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-2">
                        <img src="<?php echo $club_logo; ?>" alt="<?php echo htmlspecialchars($row['club_name']); ?>" class="w-8 h-8 rounded-full object-cover">
                        <span class="text-sm font-medium text-gray-700"><?php echo htmlspecialchars($row['club_name']); ?></span>
                    </div>
                    <span class="text-sm text-gray-500"><?php echo $news_date; ?></span>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-blue-800 group-hover:text-blue-600"><?php echo htmlspecialchars($row['title']); ?></h3>
                <p class="text-gray-600 mb-4 line-clamp-3">
                    <?php echo $excerpt; ?>
                    <?php if($needReadMore): ?>...<?php endif; ?>
                </p>
                <div class="flex justify-end">
                    <span class="read-more text-amber-500 font-medium hover:text-amber-600 transition-colors duration-300 inline-flex items-center">
                        Read more
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </div>
                
                <!-- Hidden content for modal -->
                <div class="hidden-content hidden">
                    <div class="news-full-content"><?php echo $row['content']; ?></div>
                    <div class="news-author"><?php echo $row['author']; ?></div>
                    <div class="news-image"><?php echo $image; ?></div>
                    <div class="club-logo"><?php echo $club_logo; ?></div>
                    <div class="club-name"><?php echo htmlspecialchars($row['club_name']); ?></div>
                    <div class="news-date"><?php echo $news_date; ?></div>
                    <div class="news-title"><?php echo htmlspecialchars($row['title']); ?></div>
                </div>
            </div>
        </div>
        <?php 
            }
        } else {
            echo "<div class='col-span-2 text-center p-12 bg-gray-100 rounded-lg'><h3 class='text-xl font-semibold text-gray-600'>No news articles found</h3></div>";
        }
        ?>
    </div>
</section>

<!-- News Modal -->
<div id="newsModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-70 transition-opacity duration-300">
    <div class="bg-white rounded-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto m-4 transition-transform duration-300 transform scale-95 opacity-0" id="modalContent">
        <div class="relative">
            <img src="" alt="" class="modal-image w-full h-64 md:h-80 object-cover">
            <button class="close-modal absolute top-4 right-4 bg-white rounded-full p-1 shadow-lg text-gray-700 hover:text-red-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="p-6">
            <h2 class="modal-title text-2xl font-bold text-blue-800 mb-4"></h2>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-3 sm:mb-0">
                    <img src="" alt="" class="modal-club-logo w-10 h-10 rounded-full object-cover">
                    <span class="modal-club-name font-medium"></span>
                </div>
                <div class="text-sm text-gray-600">
                    <span class="modal-date"></span>
                    <span class="mx-2">|</span>
                    <span class="modal-author"></span>
                </div>
            </div>
            <div class="modal-news-content prose max-w-none text-gray-700"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('newsModal');
    const modalContent = document.getElementById('modalContent');
    const newsCards = document.querySelectorAll('.news-card');
    const closeBtn = document.querySelector('.close-modal');
    
    // Function to open modal
    function openModal() {
        modal.classList.remove('hidden');
        // Delay the animation slightly for the transition to work
        setTimeout(() => {
            modal.classList.add('opacity-100');
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }
    
    // Function to close modal
    function closeModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }, 300);
    }
    
    // Open modal when clicking a news card
    newsCards.forEach(card => {
        card.addEventListener('click', function() {
            const hiddenContent = this.querySelector('.hidden-content');
            
            // Extract data from hidden content
            const title = hiddenContent.querySelector('.news-title').textContent;
            const image = hiddenContent.querySelector('.news-image').textContent;
            const clubLogo = hiddenContent.querySelector('.club-logo').textContent;
            const clubName = hiddenContent.querySelector('.club-name').textContent;
            const date = hiddenContent.querySelector('.news-date').textContent;
            const content = hiddenContent.querySelector('.news-full-content').textContent;
            const author = hiddenContent.querySelector('.news-author').textContent;
            
            // Populate modal
            document.querySelector('.modal-title').textContent = title;
            document.querySelector('.modal-image').src = image;
            document.querySelector('.modal-club-logo').src = clubLogo;
            document.querySelector('.modal-club-name').textContent = clubName;
            document.querySelector('.modal-date').textContent = date;
            document.querySelector('.modal-author').textContent = author;
            document.querySelector('.modal-news-content').innerHTML = content;
            
            // Show modal
            openModal();
        });
    });
    
    // Close modal when clicking close button
    closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        closeModal();
    });
    
    // Close modal when clicking outside of content
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>
<?php $con->close(); ?>

    </main>
    <?php include('footer.php'); ?>
</body>
</html>