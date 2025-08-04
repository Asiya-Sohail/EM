<!doctype html>
<html lang="zxx">

<!-- Mirrored from demo.alhikmahsoft.com/template/canyon/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Feb 2025 08:15:06 GMT -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Links of CSS files -->
    <link rel="stylesheet" href="assets/css/aos.html">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/boxicons.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <title>EMUEM</title>
    <link rel="icon" type="image/png" href="assets/img/all-img/favicon.png">
    <style>
    .testimonials-area {
        padding: 80px 0;
        background-color: #fff;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .section-title {
        margin-bottom: 50px;
        text-align: center;
    }

    .section-title h2 {
        font-size: 32px;
        margin-bottom: 16px;
        color: #333;
    }

    .section-title p {
        color: #666;
        font-size: 16px;
        max-width: 600px;
        margin: 0 auto;
    }

    .testimonial-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 30px;
        margin: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .quote-icon {
        font-size: 42px;
        color: #36B37E;
        
        font-family: Georgia, serif;
        line-height: 1;
    }

    .testimonial-text {
        font-size: 15px;
        line-height: 1.7;
        color: #555;
        margin-bottom: 20px;
        font-style: italic;
    }

    .testimonial-bio {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .bio-image {
        width: 65px!important;            /* Reduced size */
    height: 65px;           /* Equal to width to maintain circle */
    border-radius: 50%;     /* Makes it circular */
    object-fit: cover;      /* Maintains image aspect ratio */
    display: block;         /* Prevents inline display issues */
    overflow: hidden;       /* Ensures image stays within bounds */
    min-width: 50px;        /* Prevents stretching */
    min-height: 50px; 
    }

    .bio-info {
        flex: 1;
    }

    .bio-info h4 {
        margin: 0;
        font-size: 17px;
        color: #333;
        margin-bottom: 4px;
        width: max-content;
    }

    .bio-info span {
        color: #36B37E;
        font-size: 14px;
        display: block;
    }

    .owl-dots {
        margin-top: 30px;
        text-align: center;
    }

    .owl-dot span {
        background: #ddd !important;
        width: 10px;
        height: 10px;
        margin: 5px;
        display: inline-block;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .owl-dot.active span {
        background: #36B37E !important;
        width: 20px;
        border-radius: 5px;
    }

    .testimonial-slider {
        margin: 0 -10px;
    }

    .scrolling-image-container {
      width: 100%;
      overflow: hidden;
      background: #f0f0f0; /* Optional: sets a background for better visibility */
    }
    .image-wrapper {
      display: inline-block;
      white-space: nowrap;
      animation: scroll 10s linear infinite;
    }
    .image-wrapper img {
      width: 150px;    /* Fixed width */
      height: 150px;   /* Fixed height */
      object-fit: cover; /* Ensures the image fills the area while preserving aspect ratio */
      margin-right: 20px; /* Space between images */
    }
    @keyframes scroll {
      0% {
        transform: translateX(100%);
      }
      100% {
        transform: translateX(-100%);
      }
    }

 

  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-utbXrQIPhDImB7aVlfGF1Z+/YcyJw6vJ+0kcl8EM0w9SldpZ+4N2Aef3brwbrMyB1FwljkX+OIT+FvPStSxUug==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-9CWPHk4sjx1UUTGeyRkd6Vz9H87Vd7+Zohz0c0kGq7ocpJCZLMrJw5tB68lH4qA6a4O16LzGOnVq5ABaMmb/hA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      margin: 0;
      padding: 0;
      text-align: center; /* Center the carousel container horizontally */
    }
    /* Center and restrict carousel width */
    .carousel-container {
      max-width: 800px;
      margin: 0 auto;
    }
    /* Ensure all images display at a fixed size and remain responsive */
    .image-carousel .item img {
      display: block;
      width: 100%;
      height: 300px;       /* Fixed height for all images */
      object-fit: cover;   /* Crop images as needed to fill the container */
    }
  </style>

  
<style>
    /* Responsive container for scrolling text */
    .scrolling-text-container {
      width: 90%;               /* Adjusts to 90% of the viewport width */
      max-width: 600px;         /* Limits the container width on larger screens */
      margin: 20px auto;        /* Centers the container */
      border: 2px solid #333;   /* Adds a border */
      background: #f9f9f9;      /* Light background for contrast */
      overflow: hidden;         /* Hides overflow for smooth scrolling */
      box-sizing: border-box;
    }
    
    /* Inner container holding the duplicated text */
    .scrolling-text {
      display: inline-block;
      white-space: nowrap;      
      animation: scroll-text 10s linear infinite; /* Continuous scrolling */
    }
    
    /* Duplicate text elements placed inline with no extra gap */
    .scrolling-text span {
      /* No additional margins or padding to prevent any gap */
    }
    
    /* Keyframes for seamless scrolling */
    @keyframes scroll-text {
      0% {
        transform: translateX(0);
      }
      100% {
        transform: translateX(-50%);
      }
    }
  </style>


</style>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }

        #demo {
            font-size: 1.2rem;  /* Adjust size dynamically */
            width: 100%;         /* Responsive width */
            max-width: 600px;   /* Limit width for readability */
            margin: 0 auto;     /* Center the text */
            word-wrap: break-word;
            overflow: hidden;
            white-space: normal; /* Allow text wrapping */
            border-right: 3px solid black; /* Simulate cursor */
        }
    </style>
</head>

<body>

    <!-- preloader -->
    <div class="preloader-container" id="preloader">
        <div class="preloader-dot"></div>
        <div class="preloader-dot"></div>
        <div class="preloader-dot"></div>
        <div class="preloader-dot"></div>
        <div class="preloader-dot"></div>
    </div>
    <!-- preloader -->

    <!-- Start Navbar Area Start -->
    <?php  include "header.php" ?>
    <!-- End Navbar Area Start -->

    <!-- Start Responsive Navbar Area -->
  
    <!-- End Responsive Navbar Area -->

    <!-- Start Clgun Searchbar Area -->
    <div class="clgun offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop">
        <div class="offcanvas-header">
            <a href="index.php" class="logo">
                <img src="assets/img/logo/EMU.jpg" alt="image">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="search-box">
                <div class="searchwrapper">
                    <div class="searchbox">
                        <div class="row align-items-center">
                            <div class="col-md-9"><input type="text" class="form-control" placeholder="Fiend Your Course Here!"></div>
                            <div class="col-lg-3">
                                <a class="btn" href="#">Search</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas-contact-info">
                <h4>Contact Info</h4>
                <ul class="contact-info list-style">
                    <li>
                        <i class="bx bxs-time"></i>
                        <p>Mon - Fri: 9:00 - 18:00</p>
                    </li>
                    <li><i class="bx bxs-phone-call"></i> General Inquiries - <a href="tel:+8495160885">(849) 516-0885</a></li>
                    <li>
                        <i class="bx bxs-envelope"></i>
                        <a href="contact%40Clgunme.html">contact@Clgunme.edu</a>
                    </li>
                    <li>
                        <i class="bx bxs-map"></i>
                        <p>111 Sull Hall, Eastern Michigan University Ypsilanti. MI 48197</p>
                    </li>
                </ul>
                <ul class="social-profile list-style">
                    <li><a href="https://www.fb.com/" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                    <li><a href="https://www.instagram.com/" target="_blank"><i class='bx bxl-instagram'></i></a></li>
                    <li><a href="https://www.twitter.com/" target="_blank"><i class='bx bxl-twitter'></i></a></li>
                    <li><a href="https://www.dribbble.com/" target="_blank"><i class='bx bxl-dribbble'></i></a></li>
                    <li><a href="https://www.linkedin.com/" target="_blank"><i class='bx bxl-linkedin'></i></a></li>
                </ul>
            </div>

        </div>
    </div>
    <!-- End Clgun Searchbar Area -->

    <!-- Start Clgun Banner 2 Area -->
    <div class="banner-area-2 big-bg-2">
        <div class="container">
            <div class="banner-content-2">
                <div class="content">
                    <span data-aos="fade-zoom-in" data-aos-delay="300">The Top Engineering Management Program</span>
                    <h1 data-aos="fade-up" data-aos-delay="200">Time To Advanced Your Career</h1>
                    <p data-aos="fade-up" data-aos-delay="200">The MEM program meets the needs of engineers, business and technical professionals who are seeking an advanced degree that will prepare them for a natural progression into management-level positions.</p>
                    <div class="buttons-action" data-aos="fade-up" data-aos-delay="100">
                        <a class="default-btn" href="application-form.html">How to Apply</a>
                        <a class="default-btn btn-style-2" href="contact-us.html">Contact Us</a>
                    </div>
                    <div class="vertical-lr" data-aos="fade-zoom-in" data-aos-delay="100">
                        <p>Transformative Education <span> Carrer</span></p>
                    </div>

                    <div class="scroll-down" data-aos="fade-down" data-aos-delay="100">
                        <a href="#about"><i class='bx bx-chevron-down'></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Clgun Banner 2 Area -->

    <!-- Start About Us Area 2 -->
    <div id="about" class="about-us-area-2 ptb-100">
        <div class="container">
            <div class="section-title" data-aos="fade-up" data-aos-delay="100">
                <h2>Our Program</h2>
                <p>Elevate your career with Eastern Michigan University’s Master of Science in Engineering Management (MEM) program—designed for engineers, scientists, and technical professionals with a four-year degree in engineering, technology, or the sciences. Our program offers unmatched flexibility to suit your lifestyle: busy professionals can excel through our fully online option, while international and on-campus students enjoy a dynamic, in-person learning experience on our beautiful main campus. Discover a transformative education that blends technical expertise with strategic leadership skills to propel you to success in today’s competitive global marketplace.</p>
            </div>

    <div id="about" class="about-us-area-2 ptb-50">
        <div class="container">
            <div class="section-title" data-aos="fade-up" data-aos-delay="100">
                <h2 style="color:red;">NEWS & EVENTS</h2>
                <img src="images/GM-33.png" alt="GM" style="width:50%; height:auto;">
            </div>
<h3>These Companies' Employees Will Also Get 33% Discount!</h3>

<p id="demo"></p>
<script>
var i = 0;
var txt = 'Here are other companies whose employees also qualified for 33% tuition discount. Altria - Applied Materials - Calpine - General Motors - Grainger - Honeywell - Gannett - Nestlé - CSX - Intuit - Synopsys - Worthington Industries - Xcel Energy or your HR use Edcore for tuition reimbursement.';


var speed = 50;
var delayBetweenLoops = 1000; // 1-second pause before restarting

function typeWriter() {
    if (i < txt.length) {
        document.getElementById("demo").innerHTML += txt.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
    } else {
        setTimeout(() => {
            i = 0;
            document.getElementById("demo").innerHTML = ""; // Clear text
            typeWriter(); // Restart typing
        }, delayBetweenLoops);
    }
}

// Start automatically when the page loads
window.onload = function() {
    typeWriter();
};
</script>

            <div class="about-content-courser owl-carousel owl-theme">
                <div class="content-items" data-dot="<button>01</button>">
                    <div class="image ct-bg-1" data-aos="fade-zoom-in" data-aos-delay="100">
                    </div>
                    <div class="content" data-aos="fade-up" data-aos-delay="200">
                        <span>Learn Your Way, Succeed Your Way</span>
                        <h2>Flexible Delivery Options</h2>
                        <p>Whether you’re a busy professional or an <b>international student</b>, choose the learning mode that fits your life. Enjoy the freedom of a fully online program or the vibrant experience of our traditional on-campus classes.</p>
<p> <ul>
  <li>Balance work, life, and education with our <en> online, hybrid, and evening class </en> options.</li>
  <li>International Students can complete their degree while taking courses on campus and be able to get a two year of <en> Optional Practical Training </en> to work in the USA.</li>
  <li>Designed for working engineers who need the flexibility of "Online Education" without compromising quality.</li>
</ul></p>

<!-- 
                        <a class="default-btn" href="schedule-tour.html">Schedule A Tour</a>

 -->
                    </div>
                </div>
                <div class="content-items" data-dot="<button>02</button>">
                    <div class="image ct-bg-2" data-aos="fade-zoom-in" data-aos-delay="100">
                    </div>
                    <div class="content" data-aos="fade-up" data-aos-delay="200">
                        <span>Empower Tomorrow’s Engineering Leaders</span>
                        <h2>Engineers Ready to Lead</h2>
                        <p>Designed exclusively for engineers, scientists, and technical professionals with a four-year degree, our MEM program transforms your technical expertise into strategic leadership. Step up, innovate, and drive success in your industry.</p>
<p> <ul>
  <li>Tailored for engineers with technical backgrounds who aspire to move into management roles.</li>
  <li>Ideal for mid-career professionals seeking to enhance their leadership and business skills.</li>
  <li>Whether you're in manufacturing, tech, or energy, this program is built for your career trajectory.</li>
</ul></p>

<!-- 
                        <a class="default-btn" href="schedule-tour.html">Schedule A Tour</a>
 -->

                    </div>
                </div>


                <div class="content-items" data-dot="<button>03</button>">
                    <div class="image ct-bg-3" data-aos="fade-zoom-in" data-aos-delay="100">
                    </div>



                    <div class="content" data-aos="fade-up" data-aos-delay="200">
                        <span>A Balanced Curriculum</span>
                        <h2>Master the Art of Management & Innovation</h2>
                        <p>Our curriculum integrates rigorous technical training with essential management skills. Develop expertise in project management, systems analysis, and strategic decision-making to lead complex engineering projects with confidence.</p>
<p> <ul>
  <li>Hands-on learning through real-world projects and case studies.</li>
  <li>Master the intersection of technical expertise and business acumen.</li>
</ul></p>

<!-- 

                        <a class="default-btn" href="schedule-tour.html">Schedule A Tour</a>
 -->

                    </div>
                </div>
                <div class="content-items" data-dot="<button>04</button>">
                    <div class="image ct-bg-2" data-aos="fade-zoom-in" data-aos-delay="100">
                    </div>
                    <div class="content" data-aos="fade-up" data-aos-delay="200">
                        <span>Lead with Vision in a Competitive World</span>
                        <h2>Advance Your Career, Command the Future</h2>
                        <p>Graduates of our MEM program emerge as industry leaders equipped with both deep technical knowledge and powerful leadership skills. Propel your career forward and make an impact in today’s dynamic, technology-driven marketplace.</p>
<p> <ul>
  <li>Unlock roles like Engineering Manager, Project Manager, and Operations Director.</li>
  <li>Gain the skills to lead teams, drive innovation, and manage complex projects.</li>
  <li>Join a network of alumni who are shaping the future of engineering and technology.</li>
</ul></p>

<!-- 


                        <a class="default-btn" href="schedule-tour.html">Schedule A Tour</a>
 -->

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End About Us Area 2 -->

<!-- Start Testimonials Area -->
<div class="testimonials-area ptb-50">
    <div class="container">
        <div class="section-title text-center" data-aos="fade-up" data-aos-delay="100">
            <h2>What Our Alumni Say</h2>
            <p>Discover how our graduates are making an impact across different industries and continents</p>
        </div>

        <div class="testimonial-slider owl-carousel owl-theme">
            <!-- Testimonial Item 1 -->
            <div class="testimonial-card">
                <div class="quote-icon">"</div>
                <p class="testimonial-text">The courses in the Engineering Management program provided me the tools become a better project manager. Years later, as a COO, this program really was the foundation for where I am today.  The program taught me so many things that I still apply every day.</p>
                <div class="testimonial-bio">
                    <img src="./assets/img/all-img/JasonJ.jpg" alt="Jason Jaworski 
" class="bio-image">
                    <div class="bio-info">
                        <h4>Jason Jaworski </h4>
                        <span>COO, Stambaugh Ness</span>
                    </div>
                </div>
            </div>

            <!-- Testimonial Item 2 -->
            <div class="testimonial-card">
                <div class="quote-icon">"</div>
                <p class="testimonial-text">With the EMU Engineering Management program, I was able to obtain engineering and management skills that were applied to my job and utilized greatly not only by myself but by others in the company.</p>
                <div class="testimonial-bio">
                    <img src="./assets/img/all-img/ChrisP.jpg" alt="Chris Peuterbaugh
" class="bio-image">
                    <div class="bio-info">
                        <h4>Chris Peuterbaugh</h4>
                        <span>Project Manager</span>
                    </div>
                </div>
            </div>

            <!-- Testimonial Item 3 -->
            <div class="testimonial-card">
                <div class="quote-icon">"</div>
                <p class="testimonial-text">Emphasizing modern subjects like lean manufacturing, artificial intelligence, and enterprise integration guarantees graduates are ready to face the difficulties of current engineering management.
</p>
                <div class="testimonial-bio">
                    <img src="./assets/img/all-img/Eniada.jpg" alt="Eniada D" class="bio-image">
                    <div class="bio-info">
                        <h4>Eniada D</h4>
                        <span>Public Consulting Group</span>
                    </div>
                </div>
            </div>

            <!-- Testimonial Item 4 -->
            <div class="testimonial-card">
                <div class="quote-icon">"</div>
                <p class="testimonial-text">The knowledge I gained from the Graduate Engineering Management program at Eastern
Michigan University, is highly valuable to my work. I highly recommend this program to anyone who hope to gain management knowledge and experience.
</p>
                <div class="testimonial-bio">
                    <img src="./assets/img/all-img/KyeolP.jpg" alt="Kyeol P" class="bio-image">
                    <div class="bio-info">
                        <h4>Kyeol P</h4>
                        <span>Release Engineer, Lear S. Korea</span>
                    </div>
                </div>
            </div>


            <!-- Testimonial Item 5 -->
            <div class="testimonial-card">
                <div class="quote-icon">"</div>
                <p class="testimonial-text">The correlation to my day to day work and ease of seeing the value of what I was learning at EMU MEM program, made squeezing the course work into my busy schedule much less daunting task and kept me engaged throughout the program.</p>
                <div class="testimonial-bio">
                    <img src="./assets/img/all-img/JakeS.jpg" alt="Jake Sponsler" class="bio-image">
                    <div class="bio-info">
                        <h4>Jake Sponsler</h4>
                        <span>Plant & Engineering Manager, Orbitform</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

   <!-- Start Image Testimonials -->


<div class="carousel-container">
  <div class="image-carousel owl-carousel owl-theme">
    <div class="item">
      <img src="images/50top.png" alt="Image 1">
    </div>
    <div class="item">
      <img src="images/Admission2025.jpg" alt="Image 2">
    </div>
    <div class="item">
      <img src="images/bestcollege25.png" alt="Image 3">
    </div>
    <div class="item">
      <img src="images/webinar25.jpg" alt="Image 3">
    </div>
    <!-- Add additional items as needed -->
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-3fXiqwqozw7Zj+8ZCzJqVtOr4PO/gWfEkM0v9kE8VO19D8Cmq/n95J8/hSgHfBqJpFSJtON5Nfzoifn3zIO4lw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function(){
  $(".image-carousel").owlCarousel({
    items: 2,               // Display two full images side by side
    slideBy: 1,             // Slide one image at a time
    loop: true,             // Enable continuous looping
    margin: 10,             // Space between images
    nav: true,              // Show next/prev navigation arrows
    dots: true,             // Show pagination dots
    autoplay: true,         // Auto-slide enabled
    autoplayTimeout: 5000,  // 5-second delay between transitions
    autoplayHoverPause: true // Pause on hover
  });
});
</script>

   <!-- End Image Testimonials -->


    <!-- Start Features Area 2 -->
    <!-- <div class="features-area-2">
        <div class="features-content-2 ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="sub-title">
                            <p>Our Best Features</p>
                        </div>
                        <div class="content">
                            <h2>Our students create a vibrant and inclusive community</h2>
                            <div class="item">
                                <div class="item-content">
                                    <div class="icon">
                                        <img src="assets/img/icon/features-icon-2.png" alt="image">
                                    </div>
                                    <h3>Education Services</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusm tem incid idunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                            <div class="item">
                                <div class="item-content">
                                    <div class="icon">
                                        <img src="assets/img/icon/features-icon-1.png" alt="image">
                                    </div>
                                    <h3>Efficient & Flexible</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusm tem incid idunt ut labore et dolore magna aliqua.</p>
                                </div>
                            </div>
                            <a class="default-btn" href="admission.html">More on Admission</a>

                            <div class="arrow-icon">
                                <img src="assets/img/icon/shape-1.png" alt="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="academic-content">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-md-6 pt-25">
                                    <div class="academic-item" data-aos="fade-up" data-aos-delay="100">
                                        <div class="image">
                                            <img src="assets/img/all-img/academic-image-1.png" alt="image">
                                            <div class="number">
                                                <h3>01</h3>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4>International Hubs</h4>
                                            <a class="btn" href="fitness-athletics.html">Learn More <i class='bx bx-right-arrow-alt'></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6">
                                    <div class="academic-item" data-aos="fade-up" data-aos-delay="200">
                                        <div class="image">
                                            <img src="assets/img/all-img/academic-image-2.png" alt="image">
                                            <div class="number">
                                                <h3>02</h3>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4>Bachelor’s & Master’s</h4>
                                            <a class="btn" href="support-guidance.html">Learn More <i class='bx bx-right-arrow-alt'></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 pt-25">
                                    <div class="academic-item" data-aos="fade-up" data-aos-delay="300">
                                        <div class="image">
                                            <img src="assets/img/all-img/academic-image-3.png" alt="image">
                                            <div class="number">
                                                <h3>03</h3>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4>University Life</h4>
                                            <a class="btn" href="university-life.html">Learn More <i class='bx bx-right-arrow-alt'></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6">
                                    <div class="academic-item" data-aos="fade-up" data-aos-delay="400">
                                        <div class="image">
                                            <img src="assets/img/all-img/academic-image-4.png" alt="image">
                                            <div class="number">
                                                <h3>04</h3>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4>Education Services</h4>
                                            <a class="btn" href="the-campus-experience.html">Learn More <i class='bx bx-right-arrow-alt'></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- End Features Area 2 -->

    <!-- Start Video Area  -->
    <!-- <div class="video-area">
        <div class="container">
            <div class="video-play-btn" data-aos="fade-zoom-in" data-aos-delay="100">
                <a class="popup-youtube" href="https://www.youtube.com/watch?v=B03IqRlOhG0">Play</a>
            </div>
        </div>
    </div> -->
    <!-- End Video Area  -->

    <!-- Start News Area 2 -->
    <div class="news-area ptb-100">
        <div class="container">
            <div class="section-title section-title-2" data-aos="fade-up" data-aos-delay="100">
                <div class="sub-title">
                    <p>Campus News</p>
                </div>
                <h2>Stories About People, Research, and Innovation Across The Farm</h2>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="news-content">
                        <ul>
                            <li class="news-item" data-aos="fade-up" data-aos-delay="100">
                                <div class="image">
                                    <img src="assets/img/all-img/news-image-1.png" alt="image">
                                </div>
                                <div class="content">
                                    <div class="sub-title">
                                        <i class='bx bxs-graduation'></i>
                                        <p>Science and technology</p>
                                    </div>
                                    <h2><a href="blog-details.html">Robot Provides Personalized Room Cleanup</a></h2>
                                    <p>Lorem ipsum dolor sit amet conse ctetur adipiscingl sed do eiusm tem incid idunt ut labore.</p>
                                    <a class="btn" href="blog-details.html">Continue Reading...</a>
                                </div>
                            </li>
                            <li class="news-item" data-aos="fade-up" data-aos-delay="200">
                                <div class="image">
                                    <img src="assets/img/all-img/news-image-2.png" alt="image">
                                </div>
                                <div class="content">
                                    <div class="sub-title">
                                        <i class='bx bxs-graduation'></i>
                                        <p>Law and Policy</p>
                                    </div>
                                    <h2><a href="blog-details.html">Learning Network Webinars for Music Teachers</a></h2>
                                    <p>Lorem ipsum dolor sit amet conse ctetur adipiscingl sed do eiusm tem incid idunt ut labore.</p>
                                    <a class="btn" href="blog-details.html">Continue Reading...</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="news-content-right" data-aos="fade-up" data-aos-delay="100">
                        <div class="content-box">
                            <img src="assets/img/all-img/news-image-3.png" alt="iamge">
                            <div class="content">
                                <h3><a href="blog-details.html">Gender inequality in higher education persists</a></h3>
                                <p>Lorem ipsum dolor sit amet conse sed do eiusm tem incid idunt ut labore.</p>
                                <a class="btn" href="blog-details.html">Continue Reading...</a>
                            </div>
                        </div>
                    </div>
                    <div class="news-content-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="content-box">
                            <div class="image">
                                <img src="assets/img/all-img/news-image-4.png" alt="image">
                            </div>
                            <div class="content">
                                <div class="sub-title">
                                    <i class='bx bxs-graduation'></i>
                                    <p>Medicine</p>
                                </div>
                                <h3><a href="blog-details.html">Empowering Health, One Patient at a Time.</a></h3>
                            </div>
                        </div>
                        <div class="content-box">
                            <div class="image">
                                <img src="assets/img/all-img/news-image-5.png" alt="image">
                            </div>
                            <div class="content">
                                <div class="sub-title">
                                    <i class='bx bxs-graduation'></i>
                                    <p>Student Life</p>
                                </div>
                                <h3><a href="blog-details.html">Every Student, Every Dream, Every Success.</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-btn text-center" data-aos="fade-zoom-in" data-aos-delay="100">
                <p>Where Dreams Take Flight. <a href="news-and-blog.html">More Campus News <i class='bx bx-right-arrow-alt'></i></a></p>
            </div>
        </div>
    </div>
    <!-- End News Area 2 -->

    <!-- Start Faculty Area 2 -->
    <div class="faculty-area-2 ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="heading" data-aos="fade-up" data-aos-delay="100">
                        <h2>Scholarship Programs</h2>
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
                    <div class="content">
                        <p>It is a long established fact that a reader will be distracted by the readablecont of a page when looking at its layout. The point of using Lorem Ipsum is that it has more-or-less normal distribution of letters, as opposed to using.</p>
                    </div>
                </div>
                <div class="col-lg-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="button">
                        <a class="default-btn" href="financial-aid.html">Financial Aid</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Faculty Area 2 -->

    <!-- Start Quick Search Area -->
   
    <!-- End Quick Search Area -->

    <!-- Start Campus Area 2 -->
   
    <!-- End Campus Area -->

    <!-- Start Activities Area -->
    
    <!-- End Activities Area -->

    <!-- Start Events Area 2 -->
    
    <!-- End Events Area 2 -->

    <!-- Start Success Area 2 -->
    <div class="success-area success-area-2 ptb-100">
        <div class="container">
            <div class="section-title section-title-2" data-aos="fade-up" data-aos-delay="100">
                <div class="sub-title">
                    <p>Student, Faculty and Alumni Success</p>
                </div>
                <h2>Celebrating the Legacy, Embracing the Future</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6 col-md-6">
                    <div class="success-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="image">
                            <img src="assets/img/all-img/success-image-1.png" alt="image">
                        </div>
                        <div class="content">
                            <div class="play">
                                <a class="popup-youtube" href="https://www.youtube.com/watch?v=LlCwHnp3kL4"><i class='bx bx-play'></i></a>
                            </div>
                            <ul>
                                <li><a href="university-life.html">
                                        <h3>Amelia Harper ’23 (BA) </h3>
                                    </a></li>
                                <li class="link"><a href="university-life.html"><i class='bx bx-link-external'></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-md-6">
                    <div class="success-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="image">
                            <img src="assets/img/all-img/success-image-2.png" alt="image">
                        </div>
                        <div class="content">
                            <div class="play">
                                <a class="popup-youtube" href="https://www.youtube.com/watch?v=LlCwHnp3kL4"><i class='bx bx-play'></i></a>
                            </div>
                            <ul>
                                <li><a href="university-life.html">
                                        <h3>Oliver Elijah ’23 (BS/BA)</h3>
                                    </a></li>
                                <li class="link"><a href="university-life.html"><i class='bx bx-link-external'></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-md-6">
                    <div class="success-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="image">
                            <img src="assets/img/all-img/success-image-3.png" alt="image">
                        </div>
                        <div class="content">
                            <div class="play">
                                <a class="popup-youtube" href="https://www.youtube.com/watch?v=LlCwHnp3kL4"><i class='bx bx-play'></i></a>
                            </div>
                            <ul>
                                <li><a href="university-life.html">
                                        <h3>Sofia Grace ’15 (BA)</h3>
                                    </a></li>
                                <li class="link"><a href="university-life.html"><i class='bx bx-link-external'></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-btn text-center" data-aos="fade-zoom-in" data-aos-delay="100">
                <p>Inspiring Minds, Shaping Futures. <a href="undergraduate.html">Learn about the USD Honors Program <i class='bx bx-right-arrow-alt'></i></a></p>
            </div>
        </div>
    </div>
    <!-- End Success Area 2 -->

    <!-- Start Subscribe Area 2 -->
    <div class="subscribe-area subscribe-area-2">
        <div class="container">
            <div class="section-title section-title-2" data-aos="fade-up" data-aos-delay="100">
                <div class="sub-title">
                    <p>Subscribe to Our Newsletter</p>
                </div>
                <h2>Get the Latest Canyon News Delivered to You Inbox</h2>
            </div>

            <div class="subscribe-btn text-center" data-aos="fade-up" data-aos-delay="200">
                <a class="default-btn" href="#">Subscribe Now</a>
            </div>
        </div>
    </div>
    <!-- End Subscribe Area 2 -->

    <!-- Start Footer Area -->
    <?php   include 'footer.php';?>
    <!-- End Footer Area -->

    <div class="go-top active">
        <i class="bx bx-up-arrow-alt"></i>
    </div>

    <!-- Links of JS files -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/magnific-popup.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
 $(document).ready(function(){
            $(".testimonial-slider").owlCarousel({
                items: 3,
                margin: 30,
                loop: true,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });
        });
</script>
</body>

<!-- Mirrored from demo.alhikmahsoft.com/template/canyon/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Feb 2025 08:15:06 GMT -->

</html>