<?php 
// Set the cache control header
header("Cache-Control: max-age=3600"); 
?>
<?php include "./database.php"; ?>
<?php include "./functions.php"; ?>
<?php include "./index_header.php"; ?>
<?php include "../cms/cms_includes/cms_check_activity.php"; UserCountActivity($cms_pdo);?>

<!-- Logo image with link to home page -->    
<div class="logo_container">
  <a href="index.php" class="logo">
  </a>
</div>

<!-- Nav bar creating the navbar with li elements -->    
<nav>
  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="../cms/index.php">Blog</a></li>
    <li><a href="../map_index/index.php">Map</a></li>
    <li><a href="#">Contact</a></li>
    <?php
    // Checking if the user is logged in and if user_role is admin or not
    if (logged_in()) {
      $email = $_SESSION['email'];
      $username = $_SESSION['username'];
      $user_role = $_SESSION['user_role'];
  
      if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
          echo "<li><a href='../cms/admin'>Admin</a></li>";
      }
    }
    ?>
    <li class="btnlogout"><a href="logout.php">Logout</a></li>
  </ul>
</nav>

<!-- Drop down burger -->
<div class="burger">
    <div class="line1"></div>
    <div class="line2"></div>
    <div class="line3"></div> 
</div>

<!-- Message container -->
<?php
show_msg('green_color'); 
?>

<!-- Welcome GIS container image and text, creating svg image --> 
<section class="info_head">
  <h1>Discover capabilities</h1>
  <svg
  class="curve"
  xmlns="http://www.w3.org/2000/svg"
  version="1.1"
  width="100%"
  height="100"
  viewBox="0 0 100 100"
  preserveAspectRatio="none">
  <path d="M0 100 C 20 0 50 0 100 100 Z"></path>
</svg>
</section>  

<!-- Welcome container image and text -->     
<section class="container_welcome">
<section class="welcome_text">
    <h1>Welcome to our GIS capabilities and maps section</h1>
    <p>A variety of interactive maps that showcase our data and allow you to 
      explore and analyze geographic information. Our maps are powered by the 
      Leaflet library, a lightweight and flexible mapping solution that allows
      us to customize the look and feel of our maps and add a variety of 
      interactive features. Whether you're interested in exploring the distribution 
      of our data, analyzing spatial relationships, or simply visualizing 
      geographic information, our maps are a powerful tool that can help you gain 
      insights and make informed decisions. 
      So take a look around and see what you can discover</p>
  </section> 
<div class="welcome_image">
</div>
</section>

<!-- GIS container image and text -->     
<section class="container_gis">
<div class="gis_image">
</div>
  <div class="gis_text">
  <h1>What GIS stands for and what it can offer to the modern era</h1>
  <p>Leaflet is a popular open-source JavaScript library for creating interactive maps. 
    It's lightweight, flexible, and easy to use, making it a popular choice for 
    web developers who need to add maps to their websites.</p>
    <h2>Here's what you'll find</h2>
          <ul>
            <li>Customizable maps</li><p>
                With Leaflet, you can customize almost every aspect of your map, 
                including the zoom level, the map tiles, the markers, and the popups.
            </p>
            <li>Mobile-friendly design</li><p>
                Leaflet's mobile-friendly design allows your maps to be easily viewed 
                on mobile devices, making it a great choice for responsive web design.
            </p>
            <li>Interactive features</li><p>
                Leaflet allows you to add interactivity to your maps, such as 
                clickable markers, popups, drawing polygons or lines, download or upload GeoJSON formats, 
                adjust the size and the colour, measuring distance, changeing the basedmap, searcing for area of intereset
                and tooltips hover.
            </p>
            <li>Customizable markers</li><p>
                You can add custom markers to your map, using images or icons 
                that match your branding or theme.
            </p>
            <li>Tile layers</li><p>
                Leaflet supports a variety of tile layers, including OpenStreetMap, Mapbox, and Google Maps.
            </p>
            <li>Plugins and extensions</li><p>
                Leaflet has a large and active community of developers who have created a wide variety of 
                plugins and extensions, which can add additional functionality to your maps.
            </p>
          </ul>
  </section>

<!-- GIS Button -->   
<div class="gis_button_container">
    <a href="../map_index/index.php">
        <button>Find out more</button>
    </a>
</div>

<!-- Script Connection -->  
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>

<!-- Scroll Reaveal --> 
<script src="https://unpkg.com/scrollreveal"></script>

<!-- JS connection --> 
<script src="../js/web_index.js"></script>
</body>
</html>

<?php include "./footer.php"; ?>

