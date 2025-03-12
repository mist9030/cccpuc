<!-- footer.php -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-section about">
            <h3>Central Club Community</h3>
            <p>Premier University, Chittagong</p>
            <p>University Link:<a href="https://puc.ac.bd/"> Homepage.</a></p>
            <p>Connecting students through diverse clubs and activities since 2005.</p>
        </div>
        
        <div class="footer-section quick-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="/PUC/index.php">Home</a></li>
                <li><a href="/PUC/navbar/news.php">News</a></li>
                <li><a href="/PUC/navbar/event.php">Upcoming Events</a></li>
                <li><a href="/PUC/navbar/proud.php">Proud</a></li>
                <li><a href="/PUC/navbar/getinvolved.php">Get Involved</a></li>
            </ul>
        </div>
        
        <div class="footer-section categories">
            <h3>Club Categories</h3>
            <ul>
                <?php
                // Assuming you have a database connection and a function to get categories
                // This is a sample implementation
                $categories = array(
                    "Academic Clubs",
                    "Cultural Clubs",
                    "Sports Clubs",
                    "Social Service Clubs",
                    "Innovation Clubs"
                );
                
                foreach($categories as $category) {
                    echo '<li><a href="category.php?cat=' . urlencode($category) . '">' . $category . '</a></li>';
                }
                ?>
            </ul>
        </div>
        
        <div class="footer-section contact">
            <h3>Contact Us</h3>
            <p><a href="https://puc.ac.bd/"><i class="fas fa-map-marker-alt"></i><span> Premier University, Chittagong</span></a></p>
            <p><i class="fas fa-phone"></i> +880 123 456 7890</p>
            <p><i class="fas fa-envelope"></i> clubs@primeruniversity.edu.bd</p>
            
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Central Club Community - Premier University. All rights reserved.</p>
        <p>Designed by <a href="#">CodeCrew Team</a></p>
    </div>
</footer>

<!-- CSS for the footer -->
<style>
    .footer {
        background-color: #1a2a4a;
        color: #fff;
        padding: 50px 0 20px;
        font-family: 'Arial', sans-serif;
    }
    
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 0 20px;
    }
    
    .footer-section {
        flex: 1 1 250px;
        margin-bottom: 30px;
    }
    
    .footer-section h3 {
        color: #f1c40f;
        font-size: 18px;
        margin-bottom: 15px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .footer-section h3:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background-color: #f1c40f;
    }
    
    .footer-section p {
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 1.6;
    }
    
    .footer-section p i {
        margin-right: 10px;
        width: 16px;
        text-align: center;
    }
    
    .footer-section ul {
        list-style: none;
        padding: 0;
    }
    
    .footer-section ul li {
        margin-bottom: 8px;
    }
    
    .footer-section ul li a {
        color: #ddd;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .footer-section ul li a:hover {
        color: #f1c40f;
    }
    .footer-section p a span:hover {
        color: #f1c40f;
    }
    .footer-section p a:hover {
        color: #f1c40f;
    }
    
    .social-icons {
        margin-top: 15px;
    }
    
    .social-icons a {
        display: inline-block;
        width: 35px;
        height: 35px;
        background-color: rgba(255, 255, 255, 0.1);
        margin-right: 10px;
        text-align: center;
        line-height: 35px;
        border-radius: 50%;
        color: #fff;
        transition: all 0.3s ease;
    }
    
    .social-icons a:hover {
        background-color: #f1c40f;
        color: #1a2a4a;
    }
    
    .footer-bottom {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 20px;
        font-size: 13px;
    }
    
    .footer-bottom a {
        color: #f1c40f;
        text-decoration: none;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .footer-section {
            flex: 1 1 100%;
            text-align: center;
        }
        
        .footer-section h3:after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .footer-container {
            justify-content: center;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
        }
    }
</style>