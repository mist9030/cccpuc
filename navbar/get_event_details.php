<?php
include('session.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare statement to get event details including club information
    $stmt = $con->prepare("SELECT e.*, c.club_name, c.logo as club_logo 
                          FROM events e 
                          LEFT JOIN clubs c ON e.club_id = c.id
                          WHERE e.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        
        // Convert to JSON and output
        header('Content-Type: application/json');
        echo json_encode($event);
    } else {
        // Return error if event not found
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Event not found']);
    }
    
    $stmt->close();
} else {
    
    // Invalid ID parameter
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid event ID']);
}

$con->close();
?>