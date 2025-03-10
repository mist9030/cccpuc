<?php
// Start session for authentication
include('session.php');
include('admin_scripts.php');

// Check if event ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: events.php");
    exit();
}

$event_id = $_GET['id'];

// Fetch event details
$event_query = "SELECT e.*, c.club_name FROM events e 
                JOIN clubs c ON e.club_id = c.id 
                WHERE e.id = ?";
$stmt = $con->prepare($event_query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0) {
    header("Location: events.php");
    exit();
}

$event = $result->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $event['event_title']; ?> - Premier University Club Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <?php include('admin_header.php'); ?>
    
    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-calendar-day"></i> Event Details</h2>
                <div class="header-actions">
                    <a href="events.php" class="btn btn-sm"><i class="fas fa-arrow-left"></i> Back to Events</a>
                    <a href="edit_event.php?id=<?php echo $event_id; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit Event</a>
                </div>
            </div>
            
            <div class="event-details-container">
                <div class="event-info">
                    <h3><?php echo $event['event_title']; ?></h3>
                    
                    <?php
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
                        $status_text = "Completed";
                    }
                    ?>
                    
                    <span class="badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                    
                    <div class="event-meta">
                        <p><strong>Club:</strong> <?php echo $event['club_name']; ?></p>
                        <p><strong>Date:</strong> <?php echo date('F d, Y', strtotime($event['event_date'])); ?></p>
                        <p><strong>Time:</strong> <?php echo !empty($event['event_time']) ? date('h:i A', strtotime($event['event_time'])) : 'Not specified'; ?></p>
                        <p><strong>Location:</strong> <?php echo $event['location']; ?></p>
                        <p><strong>Maximum Capacity:</strong> <?php echo !empty($event['max_capacity']) ? $event['max_capacity'] : 'Unlimited'; ?></p>
                    </div>
                    
                    <div class="event-description">
                        <h4>Description</h4>
                        <div class="description-text">
                            <?php echo nl2br($event['description']); ?>
                        </div>
                    </div>
                </div>
                
            
                
                <?php if($status_text == "Upcoming" || $status_text == "Today"): ?>
                <div class="event-actions">
                    <a href="print_attendees.php?event_id=<?php echo $event_id; ?>" class="btn btn-sm" target="_blank">
                        <i class="fas fa-print"></i> Print Attendee List
                    </a>
                    <a href="email_attendees.php?event_id=<?php echo $event_id; ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-envelope"></i> Email Attendees
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
<?php
$con->close();
?>