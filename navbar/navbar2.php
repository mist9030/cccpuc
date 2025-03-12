<div class="fixed top-0 left-0 right-0 bg-black z-50 p-2 md:p-4">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-2 md:gap-3">
            <div class="max-w-[120px] md:max-w-[140px]">
                <img src="/PUC/upload/logopuc1.PNG" alt="CCCPUC" class="w-full h-auto">
            </div>
            <div class="max-w-[30px] md:max-w-[40px]">
                <img src="/PUC/upload/cccpuclogoustom.PNG" alt="Proud to be STARS" class="w-full h-auto">
            </div>
        </div>
        
        <button id="navToggle" class="md:hidden bg-transparent border-0 text-white text-xl cursor-pointer z-50">
            <i class="fas fa-bars"></i>
        </button>
        
        <nav id="mainNav" class="fixed md:static top-0 -right-[300px] md:right-0 w-[300px] md:w-auto h-screen md:h-auto bg-black md:bg-transparent p-16 md:p-0 transition-all duration-300 ease-in-out z-40 md:z-auto shadow-lg md:shadow-none">
        <ul class="flex flex-col md:flex-row list-none gap-0 md:gap-4">
    <li><a href="/PUC/index2.php" class="text-white font-semibold hover:text-gray-300 text-lg md:text-base block py-3 md:py-0 border-b border-gray-700 md:border-0">Home</a></li>
    <li><a href="/PUC/navbar/about.php" class="text-white font-semibold hover:text-gray-300 text-lg md:text-base block py-3 md:py-0 border-b border-gray-700 md:border-0">What We Do</a></li>
    <li><a href="/PUC/navbar/event.php" class="text-white font-semibold hover:text-gray-300 text-lg md:text-base block py-3 md:py-0 border-b border-gray-700 md:border-0">What's On</a></li>
    <li><a href="/PUC/navbar/news.php" class="text-white font-semibold hover:text-gray-300 text-lg md:text-base block py-3 md:py-0 border-b border-gray-700 md:border-0">News</a></li>
    <li><a href="/PUC/navbar/getinvolved.php" class="text-white font-semibold hover:text-gray-300 text-lg md:text-base block py-3 md:py-0 border-b border-gray-700 md:border-0">Get Involved</a></li>
    <li><a href="/PUC/navbar/clublist.php" class="text-white font-semibold hover:text-gray-300 text-lg md:text-base block py-3 md:py-0 border-b border-gray-700 md:border-0">Clubs</a></li>
    <li><a href="/PUC/navbar/proud.php" class="text-white font-semibold hover:text-gray-300 text-lg md:text-base block py-3 md:py-0 border-b border-gray-700 md:border-0">Proud</a></li>
    <li><a href="/PUC/profile.php" class="text-white font-semibold hover:text-gray-300 text-lg md:text-base block py-3 md:py-0">Profile</a></li>

                <li>
  <a href="/PUC/login.php" class="bg-blue-500 text-white font-medium py-2 px-6 rounded-md hover:bg-blue-600 transition-colors">Login</a>
</li>
<li>
  <a href="/PUC/register.php" class="bg-blue-500 text-white font-medium py-2 px-6 rounded-md hover:bg-blue-600 transition-colors">Register</a>
</li>
            </ul>
        </nav>
    </div>
</div>
<div id="navOverlay" class="fixed inset-0 bg-black bg-opacity-50 opacity-0 invisible transition-all duration-300 ease-in-out z-30"></div>

<!-- Add padding to the body or main content to prevent overlap with fixed navbar -->
<div class="pt-16 md:pt-20">
    <!-- Your page content goes here -->
</div>
<script>
        // Navigation toggle
        const navToggle = document.getElementById('navToggle');
        const mainNav = document.getElementById('mainNav');
        const navOverlay = document.getElementById('navOverlay');

        function toggleMenu() {
            mainNav.classList.toggle('-right-[300px]');
            mainNav.classList.toggle('right-0');
            navOverlay.classList.toggle('opacity-0');
            navOverlay.classList.toggle('invisible');
            
            const icon = navToggle.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        }

        navToggle.addEventListener('click', toggleMenu);
        navOverlay.addEventListener('click', toggleMenu);

        // Dropdown handling
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
        
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const dropdownContent = this.nextElementSibling;
                    const dropdownIcon = this.querySelector('.dropdown-icon');
                    
                    dropdownContent.classList.toggle('hidden');
                    dropdownIcon.classList.toggle('rotate-180');
                    
                    // Close other dropdowns
                    document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                        if (dropdown !== dropdownContent) {
                            dropdown.classList.add('hidden');
                        }
                    });
                    
                    document.querySelectorAll('.dropdown-icon').forEach(icon => {
                        if (icon !== dropdownIcon) {
                            icon.classList.remove('rotate-180');
                        }
                    });
                }
            });
        });

        // Desktop hover behavior for dropdowns
        if (window.innerWidth > 768) {
            const navItems = document.querySelectorAll('.relative');
            
            navItems.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    const dropdown = item.querySelector('.dropdown-content');
                    if (dropdown) dropdown.classList.remove('hidden');
                });
                
                item.addEventListener('mouseleave', () => {
                    const dropdown = item.querySelector('.dropdown-content');
                    if (dropdown) dropdown.classList.add('hidden');
                });
            });
        }

        // Close menu on link click
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768 && !link.classList.contains('dropdown-toggle')) {
                    toggleMenu();
                }
            });
        });

        // Reset menu on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                mainNav.classList.remove('right-0');
                mainNav.classList.add('-right-[300px]');
                navOverlay.classList.add('opacity-0', 'invisible');
                
                const icon = navToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
                
                // Reset dropdowns
                document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
                
                document.querySelectorAll('.dropdown-icon').forEach(icon => {
                    icon.classList.remove('rotate-180');
                });
            }
        });
        // Function to detect current page and highlight the corresponding nav link
document.addEventListener('DOMContentLoaded', function() {
    // Get current page URL path
    const currentPath = window.location.pathname;
    
    // Get all navigation links
    const navLinks = document.querySelectorAll('#mainNav a');
    
    // Active class styling
    const activeClass = 'text-blue-400';
    
    // Loop through all links and check if their href matches the current path
    navLinks.forEach(link => {
        const linkPath = link.getAttribute('href');
        
        // Remove any previous active classes
        link.classList.remove(activeClass);
        
        // Check if current path contains the link path
        // This works for both exact matches and parent pages
        if (currentPath === linkPath || 
            (linkPath !== '/PUC/index.php' && currentPath.includes(linkPath))) {
            // Add active class to highlight the current page in navigation
            link.classList.add(activeClass);
        }
        
        // Special case for index
        if (currentPath === '/PUC/' || currentPath === '/PUC/index.php') {
            if (linkPath === '/PUC/index.php') {
                link.classList.add(activeClass);
            }
        }
    });
});
    </script>