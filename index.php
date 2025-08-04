<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header-flash.php"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {box-sizing: border-box}
body {font-family: Verdana, sans-serif; margin:0}
.mySlides {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
}
</style>
</head>
<body>


          <h2>Welcome to Master of Science in Engineering Management (EGMT)</h2>
         <h3> <p>The Master of Science in Engineering Management, MEM, program is appropriate for engineers, scientists, and business and technical individuals who have previously earned a four-year degree in engineering, technology, or sciences. Students with a four-year business degree can be conditionally admitted to the program with additional undergraduate engineering/science credit hours as a pre-requirement that should be completed within one year of enrolment. The MEM program meets the needs of engineers and business and technical professionals seeking an advanced degree to prepare them for a natural progression into management-level positions.</p>

<p><center>
<img src="../em/images/news/onlinet.jpg" alt="Online Inperson" style="width:458px;height:229px;"></p></center><p>

The MEM program enables students to achieve a new balance from object-focused engineers to people-focused managers, from solving well-structured to unstructured problems, from managing single aspects to multi-aspect issues, and from perfectionism to outcome satisfaction. Using a balanced approach to quantitative and qualitative concepts, the MEM program at Eastern Michigan University (EMU) is designed to meet the needs of engineers and technical professionals and to learn the management skill set needed to manage engineering projects and human resources. The MEM Program concentrates on engineering and technical project management from a managerial perspective, engineering process management, planning design and manufacturing, engineering resource management and systems, and enterprise integration. The program also provides an opportunity to acquire leadership skills in quality and lean enterprise systems. Knowledge in these areas helps engineers and technical specialists to do their current jobs more effectively while earning a graduate degree that is often necessary for promotion to management-level positions.</p>

<p><center>
<img src="../em/images/news/International1.jpg" alt="International" style="width:458px;height:389px;"></p>
</center><p>

Our MEM program is offered in traditional and online formats. Students can complete the whole program online or prefer to come on campus for traditional class offerings. With the fully online program, our MEM program caters to the needs of professionals busy with their careers and personal lives and may be unable to schedule the time to attend classes on campus - military personnel also have appreciated the availability of all online courses from outside the country.<.p>
<p>

<p><center>
<img src="../em/images/news/Jason.png" alt="Jason" style="width:450px;height:157px;"><img src="../em/images/news/Eniada1.png" alt="Eniada" style="width:450px;height:169px;"></p>
</center><p>


At the same time, our traditional classroom setting format allows us to attract international students. Eastern Michigan University is famous for its welcoming nature to international students. We are near cities like Detroit, Dearborn, Ann Arbor, and Canton. Detroit is known as the motor city and is the headquarters of General Motors and Ford Motor Company, along with hundreds of their suppliers. International students can work on internships while on their CPT and can work for two years in any major company on their OPT after graduation. The City of Dearborn has the largest Middle Eastern decedent population outside the Middle East, a warm, welcoming nature, and fine halal food. The city of Ann Arbor is famous for the University of Michigan. And finally, the city of Canton has a large Muslim and Hindu population.</p><p>

In addition to earning an advanced degree in Engineering Management, many of our MEM students attain professional certification in one or more specialty areas of Engineering Management. </p><p>

Our MEM program is a 36-credit-hour program and requires only coursework.</p><p>

This is a STEM-designated program (see OPT Extension).</p></h3>

 
<p>



<div class="slideshow-container">

<div class="mySlides fade">
  <div class="numbertext">1 / 3</div>
  <img src="../em/images/news/GM33.jpg" style="width:100%">
  <div class="text">GM</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">2 / 3</div>
  <img src="../em/images/news/honeywell33.jpg" style="width:100%">
  <div class="text">Honeywell</div>
</div>

<div class="mySlides fade">
  <div class="numbertext">3 / 3</div>
  <img src="../em/images/news/nestle33.jpg" style="width:100%">
  <div class="text">Nestle</div>
</div>

<a class="prev" onclick="plusSlides(-1)">❮</a>
<a class="next" onclick="plusSlides(1)">❯</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>

<script>
let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>
<p>
</p>
<p>


</p>

<?php include("includes/footer-old.php"); ?>