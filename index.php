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

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
            color: #ffffff;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .video-background video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-text {
            width: 100%;
            padding: 30px 0;
            color: #8B4513;
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 2px solid #8B4513; 
            border-radius: 10px;
            margin-top: 100px;
        }

        /* Horizontal box for login and sign up */
        .box {
            border: 2px solid #8B4513; 
            padding: 30px;
            width: 100%;
            max-width: 700px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            margin-top: 30px;
            position: relative;
            z-index: 1;
        }

        .box h2 {
            font-size: 1.8rem;
            color: #8B4513;
            margin-bottom: 0;
        }

        .links {
            display: flex;
            gap: 20px;
        }

        .links a {
            color: #8B4513;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            border: 2px solid #8B4513;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .links a:hover {
            background-color: #8B4513;
            color: #fff;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            .header-text {
                font-size: 2rem;
                padding: 20px 0;
            }

            .box {
                width: 90%;
                padding: 20px;
                flex-direction: column;
                gap: 15px;
            }

            .box h2 {
                font-size: 1.5rem;
            }

            .links a {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Video Background -->
    <div class="video-background">
        <video autoplay loop muted>
            <source src="assets/videos/Starry Night Time-Lapse 4K UHD | Free Stock Video - BULLAKI (1080p, h264, youtube).mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Full-width Header Text -->
    <div class="header-text">
        Welcome to the Online To-Do List
    </div>

    <!-- Content Container -->
    <div class="box">
        <h2>Manage Your Tasks Easily</h2>
        <div class="links">
            <a href="user/login.php">Login</a>
            <a href="user/register.php">Sign Up</a>
        </div>
    </div>
</body>
</html>
