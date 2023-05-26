
// Declaring variables 
let lyrSearch;
let autoCompleteSearch = [];

// Map initialization and OSM Map
$(document).ready(() => {
    let map = L.map('map', {center:[53.45126, -2.23022], zoom:10,
    zoomAnimation: true,
    zoomControl: false,
    });

    // OSM map
    let osm = L.tileLayer.provider('OpenStreetMap.Mapnik', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxNativeZoom:19,
        maxZoom:30
        });
        $('#setMapReady').text("The map i'll be ready soon...").fadeOut(5000);

    // Topo Imagery into Leaflet map
    let topo = L.tileLayer.provider('OpenTopoMap', {
        maxNativeZoom:19,
        maxZoom:30
    });
    // ESRI Imagery into Leaflet map
    let imagery = L.tileLayer.provider('Esri.WorldImagery', {
        maxNativeZoom:19,
        maxZoom:30
    });
    // ESRI Imagery into Leaflet map, Defalut map
    let esriWroldStreet = L.tileLayer.provider('Esri.WorldTopoMap', {
        maxNativeZoom:19,
        maxZoom:30
    }).addTo(map);
    // Carto DB Imagery into Leaflet map
    let cartoDB = L.tileLayer.provider('CartoDB.Positron', {
        maxNativeZoom:19,
        maxZoom:30
    });
    
    // Adding the initials of the map to control layers
    let baseMaps = {
        "Open Street Maps": osm,
        "Topo Map": topo,
        "Imagery Map": imagery,
        "Carto Map": cartoDB,
        "Esri": esriWroldStreet,
    };

    // Addind the Manchester GeoJSON layers into the map
    let manchester = L.geoJSON.ajax('../data/manchester.geojson',{onEachFeature:returnPopUp, style:{color:'orange'}}).addTo(map);
    manchester.on('data:loaded', () => {
        autoCompleteSearch.sort((a,b) => {return a-b});
        $("#txtFindProject").autocomplete({
            source:autoCompleteSearch,
            minLength: 0,
            scroll: true
        }).focus(function() {
            $(this).autocomplete("search", '');
        });
    });

    // Addind the Wales and England GeoJSON layers into the map
    let walesEngland = L.geoJSON.ajax('../data/wales_and_england.geojson',{onEachFeature:returnPopUp, style: function (feature){
        switch (feature.properties.country) {
            case 'wales': return {color: 'blue'};
            case 'england': return {color: 'purple'};
            default: return {color: 'grey'};
        }
    }}).addTo(map);
    walesEngland.on('data:loaded', () => {
        autoCompleteSearch.sort((a,b) => {return a-b});
        $("#txtFindProject").autocomplete({
            source:autoCompleteSearch,
            minLength: 0,
            scroll: true
        }).focus(function() {
            $(this).autocomplete("search", '');
        });
    });

    // Addind the Buffer GeoJSON layers into the map
    let buffer = L.geoJSON.ajax('../data/1_km_buffer.geojson',{onEachFeature:returnPopUp, style:{color:'red'}}).addTo(map);
    buffer.on('data:loaded', () => {
        autoCompleteSearch.sort((a,b) => {return a-b});
        $("#txtFindProject").autocomplete({
            source:autoCompleteSearch,
            minLength: 0,
            scroll: true
        }).focus(function() {
            $(this).autocomplete("search", '');
        });
    });

    // Addind the Wales and England GeoJSON layers into the map
    let oldHome = L.geoJSON.ajax('../data/old_home.geojson', {onEachFeature:returnPopUp}).addTo(map);
    oldHome.on('data:loaded', () => {
        autoCompleteSearch.sort((a,b) => {return a-b});
        $("#txtFindProject").autocomplete({
            source:autoCompleteSearch,
            minLength: 0,
            scroll: true
        }).focus(function() {
            $(this).autocomplete("search", '');
        });
    });
    
    // Adding the layers into control 
    overLayers = {
        "Manchester": manchester,
        "Wales and England": walesEngland,
        "1 Km buffer": buffer,
        "Old home": oldHome,
    };
    
    // Adding the maps into leaflet object
    let addLayerMaps = L.control.layers(baseMaps, overLayers).addTo(map);
    
    // Event handler for coordinates
    let mapCoordinatesPosition = L.control.mousePosition().addTo(map);

    // Side bar 
    let sideBar = L.control.sidebar("sidebar").addTo(map);

    // Zoom box control
    let zoomControl = L.control.zoom({zoomInText:"+", zoomOutText:"-", position:"bottomright"}).addTo(map);

    // Zoom out control
    $("#btnZoomOut").click(() => {
        map.setView([52.65, -7.49], 6)
    });
   
    // Scale bar
    let scaleBar = L.control.scale({position:"bottomleft", imperial:false, maxWidth:200}).addTo(map);

    // Polyline measure tool
    let polylineMeasure = L.control.polylineMeasure({
        position: 'topright', 
        unit: 'kilometres',
        clearMeasurementsOnStop: true,
        tooltipTextFinish: 'Click to <b>finish line</b><br>',
        tooltipTextDelete: 'Press SHIFT-key and click to <b>delete point</b>',
        tooltipTextMove: 'Click and drag to <b>move point</b><br>',
        tooltipTextResume: '<br>Press CTRL-key and click to <b>resume line</b>',
        tooltipTextAdd: 'Press CTRL-key and click to <b>add point</b>',
        measureControlTitleOn: 'Click to turn on PolylineMeasure tool, use ESC once you are done to remove the measure tool..!!',   
        measureControlTitleOff: 'Click to turn off PolylineMeasure',
        startCircle: {                  // Style settings for circle marker indicating the starting point of the polyline
            color: '#000',              // Color of the border of the circle
            weight: 1,                  // Weight of the circle
            fillColor: '#0f0',          // Fill color of the circle
            fillOpacity: 1,             // Fill opacity of the circle
            radius: 10                   // Radius of the circle
        },
        intermedCircle: {               // Style settings for all circle markers between startCircle and endCircle
            color: '#000',              // Color of the border of the circle
            weight: 1,                  // Weight of the circle
            fillColor: '#0f0',          // Fill color of the circle
            fillOpacity: 1,             // Fill opacity of the circle
            radius: 5                   // Radius of the circle
        },
    }).addTo(map);

    // Easy Button for side bar
    let easyButton = L.easyButton({
        states: [{
            icon: 'fa-solid fa-bars',
            title: 'Click to open and close side bar',
            onClick: () => {
                sideBar.toggle();
            },
        }]
    }).addTo(map);
    
        L.DomEvent.on(easyButton.button, 'mouseover', function() {
            easyButton.button.title = 'Click to open and close side bar';
    });

    // Creating an new element and add some CSS to change the size of icon
    easyButton.button.classList.add('open_close_side_bar');

    // Easy Button for returning at Home page
    let returnHome = L.easyButton({
        states: [{
            icon: 'fa-solid fa-house',
            title: 'Return to Home',
            onClick: () => {
                window.location.href = '/webapp/includes/index.php';
            },
        }]
    }).addTo(map).setPosition('bottomright');
    
        L.DomEvent.on(returnHome.button, 'mouseover', function() {
            returnHome.button.title = 'Click to return to home page';
    });

    // Creating an new element and add some CSS to change the size of icon
    returnHome.button.classList.add('return_home');

    // Creating a feature group for all the added layers
    let creatingFeatureGroup = new L.FeatureGroup().addTo(map);
    let uploadedFeatureGroup = L.featureGroup().addTo(map);

    // Draw control plugin
    let drawControl = new L.Control.Draw({
        position:"topleft",
        draw:{
            circle:false
        }, 
        edit:{
            featureGroup:creatingFeatureGroup,
        }}).addTo(map);
  
        map.on("draw:created", (e) =>{
        let type = e.layerType;
        let layer = e.layer;
        creatingFeatureGroup.addLayer(layer);
      });

    // Creating a clear method data to clear all the draw layers
    document.getElementById('btnClear').onclick = function(e) {
        // Clear uploaded features layer
        if (uploadedFeatureGroup) {
            uploadedFeatureGroup.clearLayers();
        }
        // Clear drawn features layer
        if (creatingFeatureGroup) {
            creatingFeatureGroup.clearLayers();
        }
    };

    // Creating a download method to download the data in GeoJSON format 
    document.getElementById('btnExportGeojson').onclick = function(e) {
        // Extract GeoJson from featureGroup
        var data = creatingFeatureGroup.toGeoJSON();
        console.log("Creating data" + data)
        // Stringify the GeoJson
        const convertedData = 'text/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(data));
        // Create export
        document.getElementById('btnExportGeojson').setAttribute('href', 'data:' + convertedData);
        document.getElementById('btnExportGeojson').setAttribute('download','data.geojson')
    };

    // Adding Style Editor control on the map 
    let styleEditor = L.control.styleEditor({
        position: 'topright',
    });
    map.addControl(styleEditor)

    // Addinf GeoJSON file layers to the map
    L.Control.FileLayerLoad.LABEL = "";
    L.Control.fileLayerLoad({
        // Allows you to use a customized version of L.geoJson.
        // For example if you are using the Proj4Leaflet leaflet plugin,
        // you can pass L.Proj.geoJson and load the files into the
        // L.Proj.GeoJson instead of the L.geoJson.
        layer: L.geoJson, creatingFeatureGroup,
        // See http://leafletjs.com/reference.html#geojson-options
        layerOptions: {
            style: {color:'purple', weight: 2, opacity: 0.5},
            onEachFeature: returnPopUp
        },
        // Add to map after loading (default: true) ?
        addToMap: true,
        // File size limit in kb (default: 1024) ?
        fileSizeLimit: 1024,
        // Restrict accepted file formats (default: .geojson, .json, .kml, and .gpx) ?
        formats: [
            '.geojson',
            '.kml',
        ]
    }).addTo(map);  
    
//************************ General Functions  ****************************//

    // Return the popUp of layers
    function returnPopUp(json, lyr) {
        let att = json.properties;
        let popupContent = "<table>";
        
        // check if there are any attributes in the layer
        if (Object.keys(att).length === 0) {
          lyr.bindTooltip("No data on this layer");
          return;
        }
        
        for (let prop in att) {
          popupContent += "<tr><td>" + prop + "</td><td>" + att[prop] + "</td></tr>";
        }
      
        if (att.plot_no && att.id) {
          autoCompleteSearch.push(att.id.toString());
        }
      
        popupContent += "</table>";
        lyr.bindTooltip(popupContent);
    
      }
       
    // Return id of layers by search
    function returnIdBySearch(id) {
        let arrLayers = manchester.getLayers();
            for (i = 0; i < arrLayers.length-1; i++){
                let featureID = arrLayers[i].feature.properties.id;
                if (featureID == id){
                    return arrLayers[i];
            }       
        }
        return false;
    }

    // Test if the Id exists
    function testProjectId(id){
        if (autoCompleteSearch.indexOf(id) < 0){
            $("#divFindProject").addClass("has-error");
            $("#divProjectError").html("Project ID Not Found");
            
        } else {
            $("#divFindProject").removeClass("has-error");
            $("#divProjectError").html("");
            
        }
    }
    $("#txtFindProject").on("keyup paste", function(){
        let id = $("#txtFindProject").val();
        testProjectId(id);
    });

    // Return the buttons request finding the project ID
    $("#btnFindProject").click( ()=> {
        let id = $("#txtFindProject").val();
        let lyr = returnIdBySearch(id);
        if (lyr){
            if (lyrSearch){
                lyrSearch.remove();
            }
            lyrSearch = L.geoJSON(lyr.toGeoJSON(), 
            {style:{color:'#8900ae', weight:3,
            }}).addTo(map);
            map.fitBounds(lyr.getBounds().pad(0.5))
            let att = lyr.feature.properties;
            $("#divProjectData").html();
            
        } else {
            $("#divProjectError").html("The Value you entered was Not Found..!!").fadeOut(8000);
        }
    });
    
    // Return length of lines ..........NOT IN USE
    function returnLength(arr){
        let total = 0;
        for (let i = 1; i < arr.length; i++){
            total = total + arr[i-1].distanceTo(arr[i]);
        }
        return total;
    } 
    
    // Return Multi Line Length of lines ...............NOT IN USE
    function returnMultilength(arrMuL){
        let total = 0;
        for (let i = 0; i < arrMuL.length; i++){
            total = total + returnLength(arrMuL[i]);
        }
        return total;
    }   
}); 

  
