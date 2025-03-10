<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Central Club Community of Premier University</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 m-0 p-0 leading-normal">
    <header class="bg-black text-white w-full">
    
        <?php include('navbar/navbar.php');?> 
    </header>

    <main class="max-w-6xl mx-auto p-8">
        
    </main>

    <?php include('footer.php'); ?>

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
    </script>
</body>
</html>