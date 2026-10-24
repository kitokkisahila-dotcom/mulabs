<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>MULABS</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f5f7fa;
    color:#333;
}

/* HEADER */

header{
    background:black;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 60px;
    border-bottom: 3px solid tomato;
}

.logo-area{
    display:flex;
    align-items:center;
    gap:15px;
}

.logo-area img{
    width:70px;
}

.logo-text h2{
    font-size:22px;
}

.logo-text p{
    font-size:14px;
    color:tomato;
}

nav a{
    color:white;
    text-decoration:none;
    margin-left:25px;
    font-weight:bold;
    transition:.3s;
}

nav a:hover{
    color:tomato;
}

/* HERO */

.hero{
    height: 85vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    animation: slider 15s infinite;

    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
}

@keyframes slider{
    0%,30%{
        background-image:
            linear-gradient(rgba(5, 5, 8, 0.85), rgba(11, 14, 14, 0.85)),
            url("{{ asset('images/lab2.png') }}");
    }

    20%,63%{
        background-image:
            linear-gradient(rgba(45,45,48,0.85), rgba(23,24,24,0.85)),
            url("{{ asset('images/lab3.png') }}");
    }

    40%,100%{
        background-image:
            linear-gradient(rgba(12, 12, 14, 0.85), rgba(7, 8, 8, 0.85)),
            url("{{ asset('images/lab4.jpg') }}");
    }
}

.hero-content{
    max-width:850px;
}

.hero h1{
    font-size:55px;
    margin-bottom:15px;
}

.hero h3{
    font-size:28px;
    color:tomato;
    margin-bottom:20px;
}

.hero p{
    font-size:20px;
    line-height:1.8;
    margin-bottom:35px;
}

.btn{
    display:inline-block;
    padding:14px 35px;
    background:tomato;
    color:black;
    text-decoration:none;
    font-weight:bold;
    border-radius:5px;
}

.btn:hover{
    background:white;
}

/* ABOUT */

.about{

    padding:70px;
    background:white;
    text-align:center;
}

.about h2{

    color:#005b49;
    margin-bottom:20px;
}

.about p{

    max-width:900px;
    margin:auto;
    line-height:1.9;
}

/* FEATURES */

.features{

    padding:70px;
    background:#eef5f3;
}

.features h2{

    text-align:center;
    color:#005b49;
    margin-bottom:40px;
}

.feature-grid{

    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}

.card{

    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(6, 39, 88, 0.12);
}

.card img{

    width:100%;
    height:220px;
    object-fit:cover;
}

.card h3{

    padding:15px;
    color:#005b49;
}

.card p{

    padding:0 15px 20px;
    line-height:1.7;
}

/* STATISTICS */

.stats{

    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));

    background:tomato;
    color:white;
    text-align:center;
}

.stat{

    padding:40px;
}

.stat h2{

    font-size:38px;
    margin-bottom:10px;
}

/* FOOTER */

footer{

    background:#000;
    color:white;
    padding:50px 60px 20px;
}

.footer-grid{

    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:40px;
}

footer h3{

    margin-bottom:15px;
    color:tomato;
}

footer p,
footer li{

    line-height:2;
    list-style:none;
}

footer a{

    color:white;
    text-decoration:none;
}

footer a:hover{

    color:tomato;
}

.copyright{

    margin-top:40px;
    border-top:1px solid rgba(255,255,255,.2);
    text-align:center;
    padding-top:20px;
}

.popup{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.6);
    justify-content:center;
    align-items:center;
    z-index:9999;
}

.popup-content{
    width:450px;
    max-width:95%;
    background:#fff;
    border-radius:8px;
    padding:25px;
    position:relative;
}

.close{
    position:absolute;
    top:10px;
    right:15px;
    font-size:28px;
    cursor:pointer;
}

</style>

</head>

<body>

<!-- HEADER -->

<header>

<div class="logo-area">

<img src="{{ asset('images/logo.png') }}" alt="Mzumbe Logo">

<div class="logo-text">

<h2>MZUMBE UNIVERSITY</h2>

<p><strong><i> Tujifunze kwa maendeleo ya watu</i></strong></p>

</div>

</div>

<nav>

<a href="{{ route('home') }}">Home</a>

<a href="#about">About</a>

<a href="#features">Features</a>

<a href="{{ route('login') }}">Login</a>

<a href="{{ route('user') }}">Register</a>

</nav>

</header>

<!-- HERO -->

<section class="hero">

<div class="hero-content">

<h1>Mzumbe Computer Laboratory Management System</h1>

<h3>MULABS</h3>

<p>

A web-based system developed to simplify laboratory administration,
equipment monitoring,maintenance reporting, and
computer resource management within Mzumbe University.

</p>

<a href="{{ route('login') }}" class="btn">

Login 

</a>

</div>

</section>

<!-- ABOUT -->

<section class="about" id="about">

<h2>About MU-LABS</h2>

<p>

The Mzumbe University Laboratory Management System (MULABS) is designed
to improve the management of university computer laboratories by
providing an efficient platform for laboratory scheduling, equipment
tracking, fault reporting, maintenance management, and user
administration. The system enhances accountability, minimizes manual
operations, and supports effective utilization of ICT resources.

</p>

</section>

<!-- FEATURES -->

<section class="features" id="features">

<h2>System Features</h2>

<div class="feature-grid">

<div class="card">

<img src="{{ asset('images/lab4.jpg') }}">

<h3>Laboratory Management</h3>

<p>
Create and manage computer laboratories, assign laboratory administrators,
maintain laboratory records, and organize available resources for efficient
operation.
</p>

</div>

<div class="card">

<img src="{{ asset('images/lab2.png') }}">

<h3>Computer & Device Monitoring</h3>

<p>
Monitor computers, printers, projectors, networking equipment, and other
ICT devices. Record faults, monitor maintenance activities, and keep the
status of every device updated.
</p>

</div>

<div class="card">

<img src="{{ asset('images/lab3.png') }}">

<h3>User Registration</h3>

<p>
The system supports user registration by allowing users to create accounts,
store their personal information securely, and access the Computer
Laboratory Management System through authenticated login credentials.
</p>

</div>
</div>

</section>



<section class="about" id="contact">

<h2>Contact Us</h2>

<p>
For inquiries, technical support, or information regarding the Computer
Laboratory Management System, please contact the Directorate of ICT
Services at Mzumbe University.
</p>

<br>

<p><strong>Email:</strong> ict@mzumbe.ac.tz</p>

<p><strong>Telephone:</strong> +255 023 2604380/1/3/4</p>

<p><strong>Location:</strong> Mzumbe University, Morogoro Campus, Tanzania</p>

<p><strong>Office Hours:</strong> Monday – Friday, 8:00 AM – 4:30 PM</p>

</section>
<!-- FOOTER -->

<footer>

<div class="footer-grid">

<div>

<h3>MU-LABS</h3>

<p>

Computer Laboratory Management System

</p>

<p>

Mzumbe University

</p>

<p>

Morogoro, Tanzania

</p>

</div>

<div>

<h3>Quick Links</h3>

<ul>

<li><a href="{{ route('home') }}">Home</a></li>

<li><a href="#about">About</a></li>

<li><a href="#features">Features</a></li>
<li><a href="#contact">Contact</a></li>
<li><a href="#" onclick="openLogin(); return false;">Login</a></li>
<li><a href="#" onclick="openRegister(); return false;">Register</a></li>



</ul>

</div>

<div>

<h3>Contact</h3>

<p>Email: ict@mzumbe.ac.tz</p>

<p>Phone: +255 023 2604380/1/3/4</p>

<p>Website: www.mzumbe.ac.tz</p>

</div>

</div>

<div class="copyright">

  
|Computer Laboratory Management System 
Mzumbe University | MU-LABS @2026 

</div>

</footer>

</body>

<script>
    function openLogin(){
    document.getElementById('loginPopup').style.display='flex';
   }

    function closeLogin(){
    document.getElementById('loginPopup').style.display='none';
   }

function openRegister(){
    document.getElementById('registerPopup').style.display='flex';
}

function closeRegister(){
    document.getElementById('registerPopup').style.display='none';
}
</script>
</html>
