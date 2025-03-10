<?php
include('session.php');
include('admin_scripts.php');

// Handle direct delete request
if(isset($_POST['action']) && $_POST['action'] == 'delete_news') {
    if(isset($_POST['news_id']) && !empty($_POST['news_id'])) {
        $news_id = $con->real_escape_string($_POST['news_id']);
        
        // Delete the news article
        $delete_query = "DELETE FROM news WHERE id = '$news_id'";
        if($con->query($delete_query)) {
            // Success - redirect back to the same page with success message
            echo "<script>window.location = 'news.php?delete_success=1';</script>";
            exit();
        } else {
            // Failed - redirect back with error
            echo "<script>window.location = 'news.php?delete_error=1';</script>";
            exit();
        }
    }
}

// Display success/error messages if present
$deleteMessage = "";
if(isset($_GET['delete_success'])) {
    $deleteMessage = '<div class="alert alert-success">News article deleted successfully!</div>';
} else if(isset($_GET['delete_error'])) {
    $deleteMessage = '<div class="alert alert-danger">Failed to delete news article. Please try again.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All News - Premier University Club Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 5px;
            width: 50%;
            max-width: 500px;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .modal-header h3 {
            margin: 0;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        
        .modal-footer {
            margin-top: 20px;
            text-align: right;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        /* Alert messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php include('admin_header.php'); ?>
    
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- All News Section -->
        <div class="content-section">
            <div class="section-header">
                <h2>All News Articles</h2>
                <div class="section-actions">
                    <a href="add_news.php" class="btn btn-success"><i class="fas fa-plus"></i> Add News Article</a>
                </div>
            </div>
            
            <!-- Success/Error Messages -->
            <?php echo $deleteMessage; ?>
            
            <!-- Filter Options -->
            <div class="filter-section">
                <form method="GET" action="news.php" class="filter-form">
                    <div class="form-group">
                        <label for="club">Club:</label>
                        <select name="club" id="club" class="form-control">
                            <option value="">All Clubs</option>
                            <?php
                            $clubs_query = "SELECT id, club_name FROM clubs ORDER BY club_name ASC";
                            $clubs_result = $con->query($clubs_query);
                            
                            if ($clubs_result->num_rows > 0) {
                                while($club = $clubs_result->fetch_assoc()) {
                                    $selected = (isset($_GET['club']) && $_GET['club'] == $club['id']) ? 'selected' : '';
                                    echo "<option value='" . $club['id'] . "' " . $selected . ">" . $club['club_name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="date_filter">Date:</label>
                        <select name="date_filter" id="date_filter" class="form-control">
                            <option value="">All Time</option>
                            <option value="today" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] == 'today') ? 'selected' : ''; ?>>Today</option>
                            <option value="this_week" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] == 'this_week') ? 'selected' : ''; ?>>This Week</option>
                            <option value="this_month" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] == 'this_month') ? 'selected' : ''; ?>>This Month</option>
                            <option value="last_month" <?php echo (isset($_GET['date_filter']) && $_GET['date_filter'] == 'last_month') ? 'selected' : ''; ?>>Last Month</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="search">Search:</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                               placeholder="Search by title or author">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="news.php" class="btn">Reset</a>
                </form>
            </div>
            
            <!-- News Table -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Club</th>
                        <th>Published Date</th>
                        <th>Author</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Build the query with filters
                    $query = "SELECT n.*, c.club_name FROM news n 
                              LEFT JOIN clubs c ON n.club_id = c.id WHERE 1=1";
                    
                    // Apply filters
                    if (isset($_GET['club']) && !empty($_GET['club'])) {
                        $club_id = $con->real_escape_string($_GET['club']);
                        $query .= " AND n.club_id = '$club_id'";
                    }
                    
                    if (isset($_GET['date_filter'])) {
                        if ($_GET['date_filter'] == 'today') {
                            $query .= " AND DATE(n.published_date) = CURDATE()";
                        } elseif ($_GET['date_filter'] == 'this_week') {
                            $query .= " AND YEARWEEK(n.published_date, 1) = YEARWEEK(CURDATE(), 1)";
                        } elseif ($_GET['date_filter'] == 'this_month') {
                            $query .= " AND MONTH(n.published_date) = MONTH(CURDATE()) AND YEAR(n.published_date) = YEAR(CURDATE())";
                        } elseif ($_GET['date_filter'] == 'last_month') {
                            $query .= " AND MONTH(n.published_date) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                                       AND YEAR(n.published_date) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
                        }
                    }
                    
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = $con->real_escape_string($_GET['search']);
                        $query .= " AND (n.title LIKE '%$search%' OR n.author LIKE '%$search%')";
                    }
                    
                    $query .= " ORDER BY n.published_date DESC";
                    
                    $result = $con->query($query);
                    
                    if ($result->num_rows > 0) {
                        while($news = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($news['title']) . "</td>";
                            echo "<td>" . (isset($news['club_name']) ? htmlspecialchars($news['club_name']) : 'Central Club') . "</td>";
                            echo "<td>" . date('M d, Y', strtotime($news['published_date'])) . "</td>";
                            echo "<td>" . htmlspecialchars($news['author']) . "</td>";
                            
                            // Featured status
                            $featured_status = isset($news['is_featured']) && $news['is_featured'] == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-secondary">No</span>';
                            echo "<td>" . $featured_status . "</td>";
                            
                            echo "<td class='actions'>
                                    <a href='edit_news.php?id=" . $news['id'] . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                                    <a href='view_news.php?id=" . $news['id'] . "' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a>
                                    <a href='javascript:void(0)' onclick='confirmDelete(" . $news['id'] . ")' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No news articles found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
                    <input type="hidden" id="news_id_input" name="news_id" value="">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Get modal elements
        var modal = document.getElementById('deleteModal');
        var newsIdInput = document.getElementById('news_id_input');
        var closeBtn = document.getElementsByClassName("close")[0];
        var cancelBtn = document.getElementsByClassName("close-modal")[0];
        
        // Function to display modal and set the news ID
        function confirmDelete(newsId) {
            modal.style.display = "block";
            newsIdInput.value = newsId;
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
        
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
</body>
</html>
<?php
$con->close();
// Flush the output buffer and send content to browser
ob_end_flush();
?>