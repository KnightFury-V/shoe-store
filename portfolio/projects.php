<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kabita Choudhary's Projects - Web Development and Database Projects">
    <title>Projects | Kabita Choudhary</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="experience.php">Experience</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <main class="container py-2">
        <h1 class="text-center animate">My Projects</h1>
        
        <div class="projects-grid">
            <div class="card project-card animate">
                <img src="images/ecommerce-screenshot.png" alt="E-Commerce Website">
                <div class="project-content">
                    <h3>E-Commerce Website</h3>
                    <p>Developed a responsive shoe store using HTML/CSS, JavaScript, and Java backend. Integrated MySQL for product listings.</p>
                    <div class="mt-1">
                        <span class="tech-used">Java</span>
                        <span class="tech-used">MySQL</span>
                        <span class="tech-used">Agile</span>
                    </div>
                </div>
            </div>

            <div class="card project-card animate" style="animation-delay: 0.2s">
                <img src="images/student-management.png" alt="Student Management System">
                <div class="project-content">
                    <h3>Student Management System</h3>
                    <p>Designed a relational database schema for student records with optimized SQL queries.</p>
                    <div class="mt-1">
                        <span class="tech-used">SQL</span>
                        <span class="tech-used">Database Design</span>
                    </div>
                </div>
            </div>

            <div class="card project-card animate" style="animation-delay: 0.4s">
                <img src="images/algorithm-visualizer.png" alt="Algorithm Visualizer">
                <div class="project-content">
                    <h3>Algorithm Visualizer</h3>
                    <p>Built a Java application to demonstrate sorting algorithms (Bubble Sort, Quick Sort).</p>
                    <div class="mt-1">
                        <span class="tech-used">Java</span>
                        <span class="tech-used">Data Structures</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container text-center">
            <div class="social-links">
                <a href="mailto:jayguru021@gmail.com" aria-label="Email"><i class="fas fa-envelope"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                <a href="#" aria-label="GitHub"><i class="fab fa-github"></i></a>
            </div>
            <p>&copy; 2024 Kabita Choudhary. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>