<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BOOSTRAP CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css"/>
    <!-- Boxicons CDN -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <!-- Easy Button Plugin -->
    <link href="../css/plugin/easy-button.css" rel="stylesheet">
    <!-- Side Bar Plugin -->
    <link href="../css/plugin/L.Control.Sidebar.css" rel="stylesheet" />
    <!-- Coordinates Plugin -->
    <link href="../css/plugin/L.Control.MousePosition.css" rel="stylesheet">
    <!-- Polyline Measure Tool Plugin -->
    <link href="../css/plugin/Leaflet.PolylineMeasure.css" rel="stylesheet">
    <!-- Style Editor Tool Plugin -->
    <link href="../css/plugin/Leaflet.StyleEditor.css" rel="stylesheet">
    <!-- Draw Tool -->
    <link href="../css/plugin/draw.css" rel="stylesheet" />
    <!-- jQuery UI Autocomplete -->
    <link href="../css/plugin/jquery-ui.min.css" rel="stylesheet">
    <!-- Laoding GeoJSON file on Leaflet map -->
    <link href="../css/plugin/leaflet.filelayer.css" rel="stylesheet">

    <!--Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap" rel="stylesheet">

    <!--CSS connection -->
    <link href="../css/style.css" rel="stylesheet">

    <title>Web Map Application</title>
</head>
<body>

<!-- Side bar container -->
<div id="sidebar" class="col-md-12">
<h4 id="options">Settings</h4>

<div id="divProject" class="col-xs-12">
    <div id="divProjectLabel" class="text-center col-xs-12">
        <h4>Looking for Project</h4>
    </div>
    
<div id="divProjectError" class="errorMsg col-xs-12"></div>
    <div id="divFindProject" class="form-group has-error">
        <div class="col-xs-6">
            <input type="text" id="txtFindProject" class="form-control" placeholder="Project Id">
        </div>
            <div class="col-xs-6">
                <button id="btnFindProject" class="btn btn-primary" >Find project</button>
            </div>
        </div>
<div id="divProjectData" class=""></div>
    </div>
        <br>
            <div>
<button><a href="#" id="btnExportGeojson"> Export Data in GeoJSON</a></button >
<button><a href="#" id="btnClear"> Clear Data</a></button>
</div><br>
<button id="btnZoomOut" class="btn btn-primary">Zoom out</button><br><br> 
</div>
 
<!-- Map -->
<div id='map' class="col-md-12">
</div>

<!-- Loading page -->
<div id="setMapReady" class="container_text">
<div><p>Map Failed to Load...!!</p></div>
</div> 

<!--Leaflet Map-->
<script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js"></script>
<!--Leaflet Providers -->
<script src="../js/plugins/leaflet-providers.js"></script>
<!-- Boxicons -->
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<!-- Easy Button Plugin -->
<script src="../js/plugins/easy-button.js"></script> 
<!-- Side Bar Plugin -->
<script src="../js/plugins/L.Control.Sidebar.js"></script>
<!-- Coordinates Plugin -->
<script src="../js/plugins/L.Control.MousePosition.js"></script>
<!-- Polyline Measure Tool Plugin -->
<script src="../js/plugins/Leaflet.PolylineMeasure.js"></script>
<!-- Sytle Editor Tool CDN -->
<script src="https://cdn.jsdelivr.net/npm/leaflet-styleeditor@latest/dist/javascript/Leaflet.StyleEditor.min.js"></script>
<!-- Draw Tool CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>
<!-- AJAX Plugin -->
<script src="../js/plugins/leaflet.ajax.min.js"></script>
<!-- JQuery UI Autocomplete -->
<script src="../js/plugins/jquery-ui.min.js"></script>
<!-- Converting the GeoJSON to CSV -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
        
<!-- Turf JS -->
<script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>

<!-- Laoding files on Leaflet map -->
<script src="https://unpkg.com/togeojson@0.16.0"></script>
<script src="../js/plugins/leaflet.filelayer.js"></script>

<!-- JavaScript File Connection  -->
<script src="../js/index.js"></script> 

</body>
</html>