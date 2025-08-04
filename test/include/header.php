<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Master of Science in Engineering Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
         .navbar {
            background: #516d4d !important;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .hero {
            background: url('./images/background.png') no-repeat center center;
            background-size: contain;
            width: 100%;
            height: 394px;
       }
        .section-title {
            background: #516d4d;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }
        .news-item, .testimonial {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 5px;
            background: white;
            margin-bottom: 15px;
        }
        .testimonial-slider-container {
            width: 75%;
            overflow: hidden;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .testimonial-slider {
            display: flex;
            width: 70%;
            animation: slideTestimonial 45s infinite ease-in-out;
        }
        .testimonial-img {
            width: 70%;
            flex-shrink: 0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        @keyframes slideTestimonial {
            0% { transform: translateX(0); }
            33% { transform: translateX(-100%); }
            66% { transform: translateX(-200%); }
            100% { transform: translateX(0); }
        }
        footer {
            background: #516d4d;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">M.S. Engineering Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Student</a></li>
                <li class="nav-item"><a class="nav-link" href="gnrlinfo.php">Info</a></li>
                <li class="nav-item"><a class="nav-link" href="member.php">Students</a></li>
                <li class="nav-item"><a class="nav-link" href="faculty.php">Faculty</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimonials">Alumni</a></li>
                <li class="nav-item"><a class="nav-link" href="memberevaluation.php">Team</a></li>
                <li class="nav-item"><a class="nav-link" href="idea.emuem.org">Idea</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="hero"></div>
