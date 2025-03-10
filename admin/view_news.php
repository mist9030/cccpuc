<?php
include('session.php');
include('admin_scripts.php');

// Check if ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: news.php');
    exit();
}

$news_id = $con->real_escape_string($_GET['id']);

// Fetch news details
$query = "SELECT n.*, c.club_name FROM news n 
          LEFT JOIN clubs c ON n.club_id = c.id 
          WHERE n.id = '$news_id'";
$result = $con->query($query);

if($result->num_rows == 0) {
    // No news found with that ID
    header('Location: news.php');
    exit();
}

$news = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View News - Premier University Club Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .news-details {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .news-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .news-title {
            margin: 0 0 10px 0;
        }
        
        .news-meta {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        
        .meta-item {
            margin-right: 20px;
            margin-bottom: 10px;
        }
        
        .meta-label {
            font-weight: bold;
            margin-right: 5px;
        }
        
        .news-content {
            line-height: 1.6;
        }
        
        .news-image {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .featured-badge {
            display: inline-block;
            padding: 3px 8px;
            background-color: #28a745;
            color: white;
            border-radius: 3px;
            font-size: 0.8em;
            margin-left: 10px;
        }
        
        .action-buttons {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include('admin_header.php'); ?>
    
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <div class="content-section">
            <div class="section-header">
                <h2>News Details</h2>
                <div class="section-actions">
                    <a href="news.php" class="btn"><i class="fas fa-arrow-left"></i> Back to All News</a>
                </div>
            </div>
            
            <div class="news-details">
                <div class="news-header">
                    <h3 class="news-title">
                        <?php echo htmlspecialchars($news['title']); ?>
                        <?php if(isset($news['is_featured']) && $news['is_featured'] == 1): ?>
                            <span class="featured-badge">Featured</span>
                        <?php endif; ?>
                    </h3>
                </div>
                
                <div class="news-meta">
                    <div class="meta-item">
                        <span class="meta-label">Club:</span>
                        <span><?php echo isset($news['club_name']) ? htmlspecialchars($news['club_name']) : 'Central Club'; ?></span>
                    </div>
                    
                    <div class="meta-item">
                        <span class="meta-label">Published Date:</span>
                        <span><?php echo date('F d, Y', strtotime($news['published_date'])); ?></span>
                    </div>
                    
                    <div class="meta-item">
                        <span class="meta-label">Author:</span>
                        <span><?php echo htmlspecialchars($news['author']); ?></span>
                    </div>
                </div>
                
                <?php if(isset($news['image']) && !empty($news['image'])): ?>
                <div class="news-image-container">
                    <img src="../upload/news/<?php echo $news['image']; ?>" alt="<?php echo htmlspecialchars($news['title']); ?>" class="news-image">
                </div>
                <?php endif; ?>
                
                <div class="news-content">
                    <?php echo $news['content']; ?>
                </div>
                
                <div class="action-buttons">
                    <a href="edit_news.php?id=<?php echo $news['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                    <a href="javascript:void(0)" onclick="confirmDelete(<?php echo $news['id']; ?>)" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</a>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirm Delete</h3>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this news article? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary close-modal">Cancel</button>
                <form id="deleteForm" method="POST" action="news.php">
                    <input type="hidden" name="action" value="delete_news">
                    <input type="hidden" id="news_id_input" name="news_id" value="<?php echo $news['id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Get modal elements
        var modal = document.getElementById('deleteModal');
        var closeBtn = document.getElementsByClassName("close")[0];
        var cancelBtn = document.getElementsByClassName("close-modal")[0];
        
        // Function to display modal
        function confirmDelete(newsId) {
            modal.style.display = "block";
        }
        
        // Event handlers for closing the modal
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }
        
        cancelBtn.onclick = function() {
            modal.style.display = "none";
        }
        
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
<?php
$con->close();
?>