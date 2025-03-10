<?php 
include('session.php');

$sql = "SELECT * FROM clubs";
$result = $con->query($sql);

?> 


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

        <main class="what-we-do-container pt-20">
<div class="club-container">
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            $description = $row['description'];
            $shortDesc = strlen($description) > 150 ? substr($description, 0, 150) . '...' : $description;
            $foundedDate = !empty($row['founded_date']) ? date("F j, Y", strtotime($row['founded_date'])) : 'N/A';
    ?>
    <div class="club-card">
        <div class="club-logo">
            <?php if(!empty($row['logo'])) { ?>
                <img src="<?php echo '../upload/clubs/' . htmlspecialchars($row['logo']); ?>" alt="<?php echo htmlspecialchars($row['club_name']); ?> Logo">            <?php } else { ?>
                <div class="default-logo"><?php echo substr($row['club_name'], 0, 2); ?></div>
            <?php } ?>
        </div>
        <div class="club-info">
            <h2 class="club-name"><?php echo htmlspecialchars($row['club_name']); ?></h2>
            <div class="club-description">
                <p class="description-text"><?php echo htmlspecialchars($shortDesc); ?></p>
                <?php if(strlen($description) > 150) { ?>
                    <div class="read-more-content" id="content-<?php echo $row['id']; ?>"><?php echo htmlspecialchars($description); ?></div>
                    <button class="read-more-btn" data-id="<?php echo $row['id']; ?>">Read More</button>
                <?php } ?>
            </div>
            <div class="club-details">
                <p><strong>Founded:</strong> <?php echo $foundedDate; ?></p>
                <?php if(!empty($row['website']) || !empty($row['social_media'])) { ?>
                <div class="club-links">
                    <?php if(!empty($row['website'])) { ?>
                        <a href="<?php echo htmlspecialchars($row['website']); ?>" target="_blank" class="website-link">
                            <i class="fas fa-globe"></i> Website
                        </a>
                    <?php } ?>
                    <?php if(!empty($row['social_media'])) { ?>
                        <a href="<?php echo htmlspecialchars($row['social_media']); ?>" target="_blank" class="social-link">
                            <i class="fab fa-facebook-f"></i> Social Media
                        </a>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
        }
    } else {
        echo "<p class='no-clubs'>No clubs found</p>";
    }
    $con->close();
    ?>
</div>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- CSS Styles -->
<style>
    .club-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .club-card {
        width: 100%;
        max-width: 350px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background-color: #fff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .club-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }
    
    .club-logo {
        height: 150px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f7fa;
    }
    
    .club-logo img {
        max-width: 100%;
        max-height: 120px;
        object-fit: contain;
    }
    
    .default-logo {
        width: 80px;
        height: 80px;
        background-color: #3498db;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        border-radius: 50%;
    }
    
    .club-info {
        padding: 20px;
    }
    
    .club-name {
        margin: 0 0 15px 0;
        color: #2c3e50;
        font-size: 1.5rem;
        border-bottom: 2px solid #3498db;
        padding-bottom: 8px;
    }
    
    .club-description {
        position: relative;
        margin-bottom: 20px;
        color: #5a5a5a;
    }
    
    .description-text {
        margin: 0;
        line-height: 1.6;
    }
    
    .read-more-content {
        display: none;
        margin-top: 10px;
        line-height: 1.6;
    }
    
    .read-more-btn {
        background-color: transparent;
        color: #3498db;
        border: none;
        padding: 5px 0;
        margin-top: 5px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        transition: color 0.2s ease;
    }
    
    .read-more-btn:hover {
        color: #2980b9;
        text-decoration: underline;
    }
    
    .club-details {
        margin-top: 15px;
        border-top: 1px solid #eee;
        padding-top: 15px;
    }
    
    .club-details p {
        margin: 8px 0;
        font-size: 0.95rem;
        color: #555;
    }
    
    .club-links {
        margin-top: 12px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    .social-link, .website-link {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        background-color: #f7f9fc;
        color: #3498db;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background-color 0.2s ease;
    }
    
    .social-link:hover, .website-link:hover {
        background-color: #e8f4fd;
    }
    
    .social-link i, .website-link i {
        margin-right: 6px;
    }
    
    /* Responsive styles */
    @media screen and (max-width: 768px) {
        .club-container {
            padding: 10px;
        }
        
        .club-card {
            max-width: 100%;
        }
    }
    
    .no-clubs {
        padding: 20px;
        text-align: center;
        width: 100%;
        color: #555;
        font-size: 1.1rem;
    }
</style>

<!-- JavaScript for read more functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const readMoreButtons = document.querySelectorAll('.read-more-btn');
    
    readMoreButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const content = document.getElementById('content-' + id);
            const descText = this.previousElementSibling.previousElementSibling;
            
            if (content.style.display === 'block') {
                content.style.display = 'none';
                descText.style.display = 'block';
                this.textContent = 'Read More';
            } else {
                content.style.display = 'block';
                descText.style.display = 'none';
                this.textContent = 'Read Less';
            }
        });
    });
});
</script>    
    
</main>
<?php include('../footer.php');?>
</body>
</html>






