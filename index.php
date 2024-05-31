<?php 
session_start();
require_once('header.php'); 
require_once('navbar.php'); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="media/css/style.css"/>
    <link rel="stylesheet" href="media/css/home_page.css"/>
    <title>RamShare</title>
</head>
<body>
    <section id="banner">
        <h1 class="poppins-bold">Welcome to RamShare</h1>
        <h3>Whether you're heading to school, visiting friends, or traveling home for the holidays, connect with your classmates to arrange rides hassle-free.</h3>
        <a href="register.php" class="button primary">Sign Up Now!</a>
        <a href="#info" class="button primary">Learn More</a>
    </section>
    <div id="info">
        <section id="main" class="container">
        <section class="box special features">
            <div class="features-row">
                <section>
                    <span class="icon solid major fa-bolt accent2"></span>
                    <h3>Sign up at no cost</h3>
                    <p>Drivers and passengers don’t pay any fees as long as they are a VCU student!</p>
                </section>
                <section>
                    <span class="icon solid major fa-chart-area accent3"></span>
                    <h3>Everyday travel to campus</h3>
                    <p>Find a fellow ram to drive with for your daily commute to classes.</p>
                </section>
            </div>
            <div class="features-row">
                <section>
                    <span class="icon solid major fa-cloud accent4"></span>
                    <h3>Going home for the holidays</h3>
                    <p>It has never been easier! Find or host a ride and save some money!</p>
                </section>
                <section>
                    <span class="icon solid major fa-lock accent5"></span>
                    <h3>Make some new connections</h3>
                    <p>Expand your network while reducing carbon footprint through shared rides.</p>
                </section>
            </div>
        </section>
        </section>
    </div>  
</body>
</html>