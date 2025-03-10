<?php
include('session.php');
include('admin_scripts.php');

// Handle direct delete request
if(isset($_POST['action']) && $_POST['action'] == 'delete_event') {
    if(isset($_POST['event_id']) && !empty($_POST['event_id'])) {
        $event_id = $con->real_escape_string($_POST['event_id']);
        
        // Delete the event
        $delete_query = "DELETE FROM events WHERE id = '$event_id'";
        if($con->query($delete_query)) {
            // Success - redirect back to the same page with success message
            echo "<script>window.location = 'events.php?delete_success=1';</script>";
            exit();
        } else {
            // Failed - redirect back with error
            echo "<script>window.location = 'events.php?delete_error=1';</script>";
            exit();
        }
    }
}

// Display success/error messages if present
$deleteMessage = "";
if(isset($_GET['delete_success'])) {
    $deleteMessage = '<div class="alert alert-success">Event deleted successfully!</div>';
} else if(isset($_GET['delete_error'])) {
    $deleteMessage = '<div class="alert alert-danger">Failed to delete event. Please try again.</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events - Premier University Club Admin Panel</title>
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
        <!-- All Events Section -->
        <div class="content-section">
            <div class="section-header">
                <h2>All Events</h2>
                <div class="section-actions">
                    <a href="add_event.php" class="btn btn-success"><i class="fas fa-plus"></i> Add New Event</a>
                </div>
            </div>
            
            <!-- Success/Error Messages -->
            <?php echo $deleteMessage; ?>
            
            <!-- Filter Options -->
            <div class="filter-section">
                <form method="GET" action="events.php" class="filter-form">
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
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">All</option>
                            <option value="upcoming" <?php echo (isset($_GET['status']) && $_GET['status'] == 'upcoming') ? 'selected' : ''; ?>>Upcoming</option>
                            <option value="today" <?php echo (isset($_GET['status']) && $_GET['status'] == 'today') ? 'selected' : ''; ?>>Today</option>
                            <option value="past" <?php echo (isset($_GET['status']) && $_GET['status'] == 'past') ? 'selected' : ''; ?>>Past</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="search">Search:</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                               placeholder="Search by title or location">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="events.php" class="btn">Reset</a>
                </form>
            </div>
            
            <!-- Events Table -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Club</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Build the query with filters
                    $query = "SELECT e.*, c.club_name FROM events e 
                              JOIN clubs c ON e.club_id = c.id WHERE 1=1";
                    
                    // Apply filters
                    if (isset($_GET['club']) && !empty($_GET['club'])) {
                        $club_id = $con->real_escape_string($_GET['club']);
                        $query .= " AND e.club_id = '$club_id'";
                    }
                    
                    if (isset($_GET['status'])) {
                        if ($_GET['status'] == 'upcoming') {
                            $query .= " AND e.event_date > CURDATE()";
                        } elseif ($_GET['status'] == 'today') {
                            $query .= " AND e.event_date = CURDATE()";
                        } elseif ($_GET['status'] == 'past') {
                            $query .= " AND e.event_date < CURDATE()";
                        }
                    }
                    
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = $con->real_escape_string($_GET['search']);
                        $query .= " AND (e.event_title LIKE '%$search%' OR e.location LIKE '%$search%')";
                    }
                    
                    $query .= " ORDER BY e.event_date DESC";
                    
                    $result = $con->query($query);
                    
                    if ($result->num_rows > 0) {
                        while($event = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($event['event_title']) . "</td>";
                            echo "<td>" . htmlspecialchars($event['club_name']) . "</td>";
                            echo "<td>" . date('M d, Y', strtotime($event['event_date'])) . "</td>";
                            echo "<td>" . (isset($event['event_time']) ? date('h:i A', strtotime($event['event_time'])) : 'N/A') . "</td>";
                            echo "<td>" . htmlspecialchars($event['location']) . "</td>";
                            
                            $status_class = "";
                            $status_text = "";
                            
                            if (strtotime($event['event_date']) > time()) {
                                $status_class = "badge-primary";
                                $status_text = "Upcoming";
                            } elseif (strtotime($event['event_date']) == strtotime(date('Y-m-d'))) {
                                $status_class = "badge-warning";
                                $status_text = "Today";
                            } else {
                                $status_class = "badge-success";
                                $status_text = "Past";
                            }
                            
                            echo "<td><span class='badge " . $status_class . "'>" . $status_text . "</span></td>";
                            echo "<td class='actions'>
                                    <a href='edit_event.php?id=" . $event['id'] . "' class='btn btn-warning btn-sm'><i class='fas fa-edit'></i></a>
                                    <a href='view_event.php?id=" . $event['id'] . "' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a>
                                    <a href='javascript:void(0)' onclick='confirmDelete(" . $event['id'] . ")' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No events found</td></tr>";
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
                <p>Are you sure you want to delete this event? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary close-modal">Cancel</button>
                <form id="deleteForm" method="POST" action="events.php">
                    <input type="hidden" name="action" value="delete_event">
                    <input type="hidden" id="event_id_input" name="event_id" value="">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Get modal elements
        var modal = document.getElementById('deleteModal');
        var eventIdInput = document.getElementById('event_id_input');
        var closeBtn = document.getElementsByClassName("close")[0];
        var cancelBtn = document.getElementsByClassName("close-modal")[0];
        
        // Function to display modal and set the event ID
        function confirmDelete(eventId) {
            modal.style.display = "block";
            eventIdInput.value = eventId;
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
// Flush the output buffer and send content to browser
ob_end_flush();
?>