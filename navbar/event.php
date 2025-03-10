<?php 
include('session.php');

// Default query parameters
$where_conditions = [];
$params = [];
$types = "";

// Handle search form submission
if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['club_name']) || isset($_GET['status']))) {
    // Filter by club name
    if (!empty($_GET['club_name'])) {
        $where_conditions[] = "c.club_name LIKE ?";
        $params[] = "%" . $_GET['club_name'] . "%";
        $types .= "s";
    }
    
    // Filter by status
    if (!empty($_GET['status'])) {
        $where_conditions[] = "e.status = ?";
        $params[] = $_GET['status'];
        $types .= "s";
    }
}

// Build the SQL query
$sql = "SELECT e.id, e.event_title, e.description, e.event_date, e.location, e.image, e.status, c.club_name, c.logo as club_logo 
        FROM events e
        LEFT JOIN clubs c ON e.club_id = c.id";

// Add WHERE clause if filters are applied
if (!empty($where_conditions)) {
    $sql .= " WHERE " . implode(" AND ", $where_conditions);
}

$sql .= " ORDER BY e.event_date DESC";

// Prepare and execute the statement
$stmt = $con->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Get all statuses for the dropdown
$status_query = "SELECT DISTINCT status FROM events ORDER BY status";
$status_result = $con->query($status_query);

// Get all clubs for the dropdown
$clubs_query = "SELECT id, club_name FROM clubs ORDER BY club_name";
$clubs_result = $con->query($clubs_query);
?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
 <script src="https://cdn.tailwindcss.com"></script>
 <?php include('navbar.php');?> 

<!-- Main content wrapper with additional top padding to prevent navbar overlap -->
<div class="main-content-wrapper">
    <div class="event-container">
        <!-- Compact Search Form -->
        <div class="search-container">
            <form method="GET" action="" class="search-form">
                <div class="search-fields">
                    <div class="search-field">
                        <select id="club_name" name="club_name" class="search-input" placeholder="Club">
                            <option value="">All Clubs</option>
                            <?php while($club = $clubs_result->fetch_assoc()): ?>
                                <option value="<?php echo $club['club_name']; ?>" <?php echo (isset($_GET['club_name']) && $_GET['club_name'] == $club['club_name']) ? 'selected' : ''; ?>>
                                    <?php echo $club['club_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="search-field">
                        <select id="status" name="status" class="search-input">
                            <option value="">All Statuses</option>
                            <?php while($status = $status_result->fetch_assoc()): ?>
                                <option value="<?php echo $status['status']; ?>" <?php echo (isset($_GET['status']) && $_GET['status'] == $status['status']) ? 'selected' : ''; ?>>
                                    <?php echo $status['status']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="search-buttons">
                        <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                        <a href="event.php" class="reset-button"><i class="fas fa-undo"></i></a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results count -->
        <div class="results-count">
            <?php 
            $result_count = $result->num_rows;
            $filter_text = "";
            
            if (isset($_GET['club_name']) && !empty($_GET['club_name'])) {
                $filter_text .= " for club '" . htmlspecialchars($_GET['club_name']) . "'";
            }
            
            if (isset($_GET['status']) && !empty($_GET['status'])) {
                $filter_text .= (!empty($filter_text) ? " and" : " for") . " status '" . htmlspecialchars($_GET['status']) . "'";
            }
            
            echo "<p>Showing {$result_count} event" . ($result_count != 1 ? "s" : "") . $filter_text . "</p>";
            ?>
        </div>

        <!-- Events Display -->
        <?php
        if ($result->num_rows > 0) {
            $count = 0;
            while ($row = $result->fetch_assoc()) {
                // Start a new row after every 3 cards
                if ($count % 3 == 0) {
                    echo '<div class="event-row">';
                }
                
                // Limit description to 100 characters for preview
                $short_desc = strlen($row["description"]) > 100 ? substr($row["description"], 0, 100) . "..." : $row["description"];
                
                // Format the date
                $event_date = date("F d, Y", strtotime($row["event_date"]));
                
                // Default image if none provided
                $image_path = !empty($row["image"]) ? $row["image"] : "assets/images/default-event.jpg";
                
                // Status badge
                $status_class = "status-" . strtolower($row["status"]);
                
                // Output card HTML
                ?>
                <div class="event-card" data-id="<?php echo $row["id"]; ?>">
                    <div class="card-image">
                        <img src="<?php echo $image_path; ?>" alt="<?php echo $row["event_title"]; ?>">
                        <span class="status-badge <?php echo $status_class; ?>"><?php echo $row["status"]; ?></span>
                    </div>
                    <div class="card-content">
                        <h3><?php echo $row["event_title"]; ?></h3>
                        <?php if(!empty($row["club_name"])): ?>
                        <div class="club-info">
                            <?php if(!empty($row["club_logo"])): ?>
                            <img src="<?php echo '../upload/clubs/' .$row["club_logo"]; ?>" alt="<?php echo $row["club_name"]; ?> logo" class="club-logo">
                            <?php endif; ?>
                            <span class="club-name"><?php echo $row["club_name"]; ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="event-meta">
                            <p><i class="fa fa-calendar"></i> <?php echo $event_date; ?></p>
                            <p><i class="fa fa-map-marker"></i> <?php echo $row["location"]; ?></p>
                        </div>
                        <p class="card-description"><?php echo $short_desc; ?></p>
                        <?php if (strlen($row["description"]) > 100) { ?>
                            <button class="read-more-btn">Read More</button>
                        <?php } ?>
                    </div>
                </div>
                <?php
                $count++;
                
                // Close the row div after every 3 cards or at the end
                if ($count % 3 == 0 || $count == $result->num_rows) {
                    echo '</div>';
                }
            }
        } else {
            echo "<div class='no-results'><p>No events found matching your search criteria</p></div>";
        }
        
        $stmt->close();
        $con->close();
        ?>
    </div>
</div>

<!-- Modal Popup for Full eventt -->
<div id="eventModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <div id="modalContent"></div>
    </div>
</div>

<style>
/* Main content wrapper with padding to prevent navbar overlap */
.main-content-wrapper {
    padding-top: 80px; /* Adjust this value based on your navbar height */
    padding-bottom: 80px; /* Add padding at bottom to prevent footer overlap */
    min-height: calc(100vh - 200px); /* Ensure content takes minimum height to push footer down */
    position: relative;
    z-index: 1; /* Keep content below navbar but above other elements */
}

/* Main container */
.event-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    box-sizing: border-box;
}

/* Compact Search Container Styles */
.search-container {
    background-color: #f5f8fa;
    border-radius: 8px;
    padding: 12px 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.search-form {
    width: 100%;
}

.search-fields {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
}

.search-field {
    flex: 1;
    min-width: 120px;
}

.search-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    background-color: white;
}

.search-buttons {
    display: flex;
    gap: 5px;
}

.search-button, .reset-button {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.search-button {
    background-color: #3498db;
    color: white;
    border: none;
}

.search-button:hover {
    background-color: #2980b9;
}

.reset-button {
    background-color: #f1f1f1;
    color: #555;
    border: 1px solid #ddd;
    text-decoration: none;
}

.reset-button:hover {
    background-color: #e1e1e1;
}

.results-count {
    margin-bottom: 20px;
    font-size: 14px;
    color: #666;
}

.no-results {
    text-align: center;
    padding: 30px 0;
    color: #666;
    font-size: 16px;
    background-color: #f9f9f9;
    border-radius: 8px;
}

/* Club info styles */
.club-info {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.club-logo {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    margin-right: 8px;
    object-fit: cover;
}

.club-name {
    font-size: 14px;
    color: #555;
    font-weight: 500;
}

/* Row of cards */
.event-row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px 30px;
}

/* Card styles */
.event-card {
    flex: 0 0 calc(33.333% - 30px);
    margin: 0 15px 30px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background-color: #fff;
    cursor: pointer;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.card-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.event-card:hover .card-image img {
    transform: scale(1.05);
}

.status-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
    color: #fff;
}

.status-upcoming {
    background-color: #4CAF50;
}

.status-ongoing {
    background-color: #2196F3;
}

.status-completed {
    background-color: #9E9E9E;
}

.status-cancelled {
    background-color: #F44336;
}

.card-content {
    padding: 15px;
}

.card-content h3 {
    margin: 0 0 10px;
    font-size: 18px;
    color: #333;
}

.event-meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
    color: #666;
}

.event-meta p {
    margin: 0;
}

.card-description {
    margin: 0 0 15px;
    font-size: 14px;
    color: #555;
    line-height: 1.5;
}

.read-more-btn {
    display: inline-block;
    padding: 6px 12px;
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.read-more-btn:hover {
    background-color: #2980b9;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.7);
}

.modal-content {
    position: relative;
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 800px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    animation: modalFade 0.3s ease;
}

@keyframes modalFade {
    from {opacity: 0; transform: translateY(-30px);}
    to {opacity: 1; transform: translateY(0);}
}

.close-modal {
    position: absolute;
    top: 15px;
    right: 20px;
    color: #888;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.3s;
}

.close-modal:hover {
    color: #333;
}

.modal-image {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 20px;
}

.modal-title {
    margin: 0 0 15px;
    font-size: 24px;
    color: #333;
}

.modal-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
    font-size: 15px;
    color: #666;
}

.modal-description {
    line-height: 1.6;
    margin-bottom: 20px;
}

.modal-contact {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 6px;
    margin-top: 15px;
}

.modal-contact h4 {
    margin: 0 0 10px;
    font-size: 16px;
}

.modal-contact p {
    margin: 5px 0;
    font-size: 14px;
}

/* Fix for footer social icons - ensure they stay in position */
.footer .social-icons {
    position: relative !important;
    bottom: auto !important;
    right: auto !important;
    display: flex !important;
    justify-content: center !important;
    margin-top: 20px !important;
}

.footer .social-icons a {
    display: inline-block !important;
    margin: 0 10px !important;
}

/* Register button styling */
.register-btn {
    display: inline-block;
    padding: 8px 16px;
    background-color: #3498db;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-weight: bold;
    transition: background-color 0.3s;
}

.register-btn:hover {
    background-color: #2980b9;
}

/* Responsive styles */
@media screen and (max-width: 992px) {
    .event-card {
        flex: 0 0 calc(50% - 30px);
    }
}

@media screen and (max-width: 768px) {
    .main-content-wrapper {
        padding-top: 60px; /* Reduced padding for mobile */
    }
    
    .search-fields {
        flex-wrap: wrap;
    }
    
    .search-field {
        flex: 0 0 calc(50% - 5px);
        min-width: 0;
    }
    
    .search-buttons {
        margin-left: auto;
    }
    
    .event-card {
        flex: 0 0 calc(100% - 30px);
    }
    
    .modal-content {
        width: 90%;
        margin: 10% auto;
    }
    
    .modal-meta {
        flex-direction: column;
        gap: 10px;
    }
}

@media screen and (max-width: 480px) {
    .search-field {
        flex: 0 0 100%;
    }
    
    .search-buttons {
        width: 100%;
        justify-content: space-between;
        margin-top: 10px;
    }
    
    .search-button, .reset-button {
        flex: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables
    const eventCards = document.querySelectorAll('.event-card');
    const readMoreBtns = document.querySelectorAll('.read-more-btn');
    const modal = document.getElementById('eventModal');
    const modalContent = document.getElementById('modalContent');
    const closeModal = document.querySelector('.close-modal');
    
    // Open modal when card is clicked
    eventCards.forEach(card => {
        card.addEventListener('click', function(event) {
            // Don't trigger if read more button was clicked
            if (event.target.classList.contains('read-more-btn')) {
                return;
            }
            
            const eventId = this.getAttribute('data-id');
            fetchEventDetails(eventId);
        });
    });
    
    // Open modal when read more button is clicked
    readMoreBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const eventId = this.closest('.event-card').getAttribute('data-id');
            fetchEventDetails(eventId);
        });
    });
    
    // Close modal when X is clicked
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Close modal when clicking outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
    
    // Fix for any potential footer social icon positioning issues
    // This ensures social icons maintain proper position
    const adjustFooterSocialIcons = () => {
        const socialIcons = document.querySelectorAll('.footer .social-icons');
        if (socialIcons.length > 0) {
            socialIcons.forEach(iconSet => {
                iconSet.style.position = 'relative';
                iconSet.style.display = 'flex';
                iconSet.style.justifyContent = 'center';
                iconSet.style.marginTop = '20px';
            });
        }
    };
    
    // Run social icon adjustment after page load
    window.addEventListener('load', adjustFooterSocialIcons);
    
    // Fetch event details
    function fetchEventDetails(eventId) {
        // AJAX request to get event details
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_event_details.php?id=' + eventId, true);
        
        xhr.onload = function() {
            if (this.status == 200) {
                const event = JSON.parse(this.responseText);
                displayEventDetails(event);
            }
        }
        
        xhr.send();
    }
    
    // Display event details in modal
    function displayEventDetails(event) {
        // Format the date
        const eventDate = new Date(event.event_date);
        const formattedDate = eventDate.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Default image if none provided
        const imagePath = event.image ? event.image : 'assets/images/default-event.jpg';
        
        // Generate HTML for modal content
        let html = `
            <img src="${imagePath}" alt="${event.event_title}" class="modal-image">
            <h2 class="modal-title">${event.event_title}</h2>`;
            
        // Add club info if available
        if (event.club_name) {
            const clubLogoHtml = event.club_logo ? 
                `<img src="${event.club_logo}" alt="${event.club_name} logo" style="width: 24px; height: 24px; border-radius: 50%; margin-right: 8px;">` : '';
            
            html += `<p class="modal-club">
                ${clubLogoHtml}
                <strong>Organized by:</strong> ${event.club_name}
            </p>`;
        }
            
        html += `<div class="modal-meta">
                <p><i class="fa fa-calendar"></i> <strong>Date:</strong> ${formattedDate}</p>
                <p><i class="fa fa-clock-o"></i> <strong>Time:</strong> ${event.start_time || 'TBA'} ${event.end_time ? '- ' + event.end_time : ''}</p>
                <p><i class="fa fa-map-marker"></i> <strong>Location:</strong> ${event.location}</p>
                <p><i class="fa fa-user-o"></i> <strong>Status:</strong> <span class="status-${event.status.toLowerCase()}">${event.status}</span></p>
            </div>
            <div class="modal-description">
                ${event.description || 'No description available.'}
            </div>
        `;
        
        // Add registration info if available
        if (event.registration_deadline || event.registration_link) {
            html += `<div class="modal-registration">
                <h4>Registration Information</h4>`;
            
            if (event.registration_deadline) {
                const deadline = new Date(event.registration_deadline);
                const formattedDeadline = deadline.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                html += `<p><strong>Deadline:</strong> ${formattedDeadline}</p>`;
            }
            
            if (event.registration_link) {
                html += `<p><a href="${event.registration_link}" target="_blank" class="register-btn">Register Now</a></p>`;
            }
            
            html += `</div>`;
        }
        
        // Add contact info if available
        if (event.contact_person || event.contact_email || event.contact_phone) {
            html += `<div class="modal-contact">
                <h4>Contact Information</h4>`;
            
            if (event.contact_person) {
                html += `<p><strong>Contact Person:</strong> ${event.contact_person}</p>`;
            }
            
            if (event.contact_email) {
                html += `<p><strong>Email:</strong> <a href="mailto:${event.contact_email}">${event.contact_email}</a></p>`;
            }
            
            if (event.contact_phone) {
                html += `<p><strong>Phone:</strong> <a href="tel:${event.contact_phone}">${event.contact_phone}</a></p>`;
            }
            
            html += `</div>`;
        }
        
        // Update modal content and display modal
        modalContent.innerHTML = html;
        modal.style.display = 'block';
    }
});
</script>
    
<?php include('../footer.php'); ?>
</body>
</html>