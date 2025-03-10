<?php
include('session.php');

// Initialize search variables
$search_date = isset($_GET['date']) ? $_GET['date'] : '';
$search_club = isset($_GET['club']) ? $_GET['club'] : '';

// Build the query
$query = "SELECT n.*, c.club_name, c.logo as club_logo 
          FROM news n 
          LEFT JOIN clubs c ON n.club_id = c.id 
          WHERE 1=1";

// Add search filters
if (!empty($search_date)) {
    $query .= " AND n.published_date = '$search_date'";
}
if (!empty($search_club)) {
    $query .= " AND c.club_name LIKE '%$search_club%'";
}

$query .= " ORDER BY n.published_date DESC";

// Execute query
$result = $con->query($query);

// Get all clubs for search dropdown
$clubs_query = "SELECT id, club_name FROM clubs ORDER BY club_name";
$clubs_result = $con->query($clubs_query);
$clubs = array();
while ($club = $clubs_result->fetch_assoc()) {
    $clubs[] = $club;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>News</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            padding: 0;
            margin: 0;
        }
        
        .content-wrapper {
            padding: 20px;
            padding-bottom: 0;
        }
        
        .news-container-wrapper {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .navbar-spacer {
            margin-bottom: 30px;
        }
        
        .search-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .search-form .form-group {
            flex: 1;
            min-width: 200px;
        }
        
        .search-form input, 
        .search-form select, 
        .search-form button {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .search-form button {
            background-color: #0056b3;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            max-width: 150px;
        }
        
        .search-form button:hover {
            background-color: #003d82;
        }
        
        .news-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .news-card {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .news-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .news-content {
            padding: 15px;
        }
        
        .news-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .club-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .club-logo {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .news-date {
            font-size: 12px;
            color: #666;
        }
        
        .news-title {
            font-size: 18px;
            margin-bottom: 10px;
            color: #0056b3;
        }
        
        .news-excerpt {
            font-size: 14px;
            color: #555;
            line-height: 1.4;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .read-more {
            color: #0056b3;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .modal.active {
            display: block;
            opacity: 1;
        }
        
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            width: 90%;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.3s;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        @keyframes modalFadeIn {
            from {transform: translateY(-50px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        
        .modal-header {
            position: relative;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .modal-title {
            font-size: 24px;
            color: #0056b3;
            margin-right: 40px;
        }
        
        .close-modal {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            color: #888;
            background: none;
            border: none;
            cursor: pointer;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .modal-metadata {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .modal-club-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .modal-club-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .modal-news-content {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .news-container {
                grid-template-columns: 1fr;
            }
            
            .search-form {
                flex-direction: column;
            }
            
            .search-form .form-group {
                width: 100%;
            }
            
            .search-form button {
                max-width: 100%;
            }
            
            .modal-content {
                width: 95%;
                margin: 10% auto;
            }
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="news-container-wrapper">
            <?php include('navbar.php');?>
            
            <!-- Added spacer for navbar -->
            <div class="navbar-spacer"></div>
            
            <!-- Search Section -->
            <div class="search-container">
                <form class="search-form" action="" method="GET">
                    <div class="form-group">
                        <input type="date" name="date" placeholder="Search by date" value="<?php echo $search_date; ?>">
                    </div>
                    <div class="form-group">
                        <select name="club">
                            <option value="">Select Club</option>
                            <?php foreach ($clubs as $club): ?>
                            <option value="<?php echo $club['club_name']; ?>" <?php if($search_club == $club['club_name']) echo 'selected'; ?>>
                                <?php echo $club['club_name']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit">Search</button>
                    <?php if(!empty($search_date) || !empty($search_club)): ?>
                    <button type="button" id="reset-search" onclick="window.location.href='news.php'">Reset</button>
                    <?php endif; ?>
                </form>
            </div>
            
            <!-- News Cards Section -->
            <div class="news-container">
                <?php 
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        // Get excerpt from content
                        $excerpt = strip_tags($row['content']);
                        $excerpt = substr($excerpt, 0, 150);
                        $needReadMore = strlen(strip_tags($row['content'])) > 150;
                        // Default image if none provided
                        $image = !empty($row['image']) ? '../upload/news/' . $row['image'] : 'https://via.placeholder.com/600x400';
                        $club_logo = !empty($row['club_logo']) ? '../upload/clubs/' . $row['club_logo'] : 'https://via.placeholder.com/50';
                        
                        // Format date
                        $news_date = date("M d, Y", strtotime($row['published_date']));
                ?>
                <div class="news-card" data-id="<?php echo $row['id']; ?>">
                    <img src="<?php echo $image; ?>" alt="<?php echo $row['title']; ?>" class="news-image">
                    <div class="news-content">
                        <div class="news-header">
                            <div class="club-info">
                                <img src="<?php echo $club_logo; ?>" alt="<?php echo $row['club_name']; ?>" class="club-logo">
                                <span><?php echo $row['club_name']; ?></span>
                            </div>
                            <span class="news-date"><?php echo $news_date; ?></span>
                        </div>
                        <h3 class="news-title"><?php echo $row['title']; ?></h3>
                        <p class="news-excerpt">
                            <?php echo $excerpt; ?>
                            <?php if($needReadMore): ?>...<?php endif; ?>
                        </p>
                        <?php if($needReadMore): ?>
                        <a href="javascript:void(0)" class="read-more">Read more</a>
                        <?php endif; ?>
                    </div>
                    <!-- Hidden content for modal -->
                    <div class="hidden-content" style="display: none;">
                        <div class="news-full-content"><?php echo $row['content']; ?></div>
                        <div class="news-author"><?php echo $row['author']; ?></div>
                    </div>
                </div>
                <?php 
                    }
                } else {
                    echo "<div class='no-results' style='grid-column: span 2; text-align: center; padding: 50px;'><h3>No news articles found</h3></div>";
                }
                ?>
            </div>
        </div>
    </div>
    
    <!-- News Modal -->
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">News Title</h2>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <img src="" alt="" class="modal-image">
                <div class="modal-metadata">
                    <div class="modal-club-info">
                        <img src="" alt="" class="modal-club-logo">
                        <span class="modal-club-name">Club Name</span>
                    </div>
                    <div>
                        <span class="modal-date">Date</span> | 
                        <span class="modal-author">Author</span>
                    </div>
                </div>
                <div class="modal-news-content"></div>
            </div>
        </div>
    </div>
    
    <script>
        // Modal functionality
        const modal = document.getElementById('newsModal');
        const closeBtn = document.querySelector('.close-modal');
        const newsCards = document.querySelectorAll('.news-card');
        
        // Open modal when clicking a news card
        newsCards.forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('.news-title').textContent;
                const image = this.querySelector('.news-image').src;
                const clubLogo = this.querySelector('.club-logo').src;
                const clubName = this.querySelector('.club-info span').textContent;
                const date = this.querySelector('.news-date').textContent;
                const content = this.querySelector('.hidden-content .news-full-content').textContent;
                const author = this.querySelector('.hidden-content .news-author').textContent;
                
                // Populate modal
                document.querySelector('.modal-title').textContent = title;
                document.querySelector('.modal-image').src = image;
                document.querySelector('.modal-club-logo').src = clubLogo;
                document.querySelector('.modal-club-name').textContent = clubName;
                document.querySelector('.modal-date').textContent = date;
                document.querySelector('.modal-author').textContent = author;
                document.querySelector('.modal-news-content').innerHTML = content;
                
                // Show modal
                modal.classList.add('active');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            });
        });
        
        // Close modal when clicking close button
        closeBtn.addEventListener('click', function() {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        });
        
        // Close modal when clicking outside of content
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && modal.classList.contains('active')) {
                modal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
        
        // Read more links
        const readMoreLinks = document.querySelectorAll('.read-more');
        readMoreLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent card click event
                const card = this.closest('.news-card');
                card.click(); // Trigger card click to open modal
            });
        });
    </script>
</body>
</html>

<?php
// Include footer directly, no wrapper div
include('../footer.php');
// Close database connection
$con->close();
?>