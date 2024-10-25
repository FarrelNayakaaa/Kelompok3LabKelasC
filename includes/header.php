<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online To-Do List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(to bottom, #b2e0b2, #ffffff); 
            min-height: 100vh; 
            transition: margin-left 0.3s ease; 
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0);
            color: black; 
            position: relative;
            padding: 10px 0;  
        }

        .bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
        }

        .hamburger {
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            height: 30px;
            width: 30px;
        }

        .hamburger div {
            height: 4px;
            width: 100%;
            background-color: #8B4513; 
            transition: all 0.3s ease;
        }

        nav {
            display: block;
            position: fixed;
            top: 0;
            left: -250px; 
            width: 250px;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            transition: left 0.3s ease; 
        }

        nav ul {
            list-style-type: none;
            padding: 20px;
        }

        nav ul li {
            padding: 15px 0;
            text-align: left;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 18px;
        }

        nav.active {
            left: 0; 
        }

        .hamburger.active div:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active div:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active div:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        body.nav-active {
            margin-left: 250px; 
        }

    </style>
</head>
<body>

    <header class="navbar">
        <div class="bar">
            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <nav>
                <ul>
                    <li><a href="/beraam_utslab/user/dashboard.php">Dashboard</a></li>
                    <li><a href="/beraam_utslab/user/profile.php">Profile</a></li>
                    <li><a href="/beraam_utslab/user/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hamburger = document.querySelector('.hamburger');
            const nav = document.querySelector('nav');
            const body = document.body;

            hamburger.addEventListener('click', function() {
                nav.classList.toggle('active');
                hamburger.classList.toggle('active');
                body.classList.toggle('nav-active'); 
            });

            document.addEventListener('click', function(event) {
                if (!hamburger.contains(event.target) && !nav.contains(event.target)) {
                    nav.classList.remove('active');
                    hamburger.classList.remove('active');
                    body.classList.remove('nav-active'); 
                }
            });
        });
    </script>
</body>
</html>
