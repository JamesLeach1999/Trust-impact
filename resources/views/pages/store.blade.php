<!DOCTYPE html>

<html>
  <head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=API_KEY&callback=initMap"
      defer
    ></script>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>


    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    
    <script>
      (function(exports) {

        "use strict";
        // initialising map
        function initMap() {
          exports.map = new google.maps.Map(document.getElementById("map"), {
            center: {
              lat: 	51.509865,
              lng: -0.118092

            },
            zoom: 12
          });
         
        }
        // exports map to the current window
        exports.initMap = initMap;
      })((this.window = this.window || {}));
    </script>
    // only accesses the values needed for the circle and geo location
@foreach($res as $posts => $t)
    

    <script>
    // accessing the values sent by parseFile through arrow notation
    var a = {!!json_encode($t->postcodes)!!};
    
  
          $.get(
                "https://maps.googleapis.com/maps/api/geocode/json?address=" +
                  a +
                  "&key=AIzaSyC6xrYHhT-_CeoktqgAwGjbOCNrmVUkXno", 

                null,
                function (data) {
                  // have to access this twice, once for the api call and once for the results
                  var j = {!!json_encode($t->postcodes)!!};

                  var p = data.results[0].geometry.location;
                  var cityCircle;
                  

                  var b = {!!json_encode($t->imd)!!};

                  var imd = b;


                  var color;
                  var decile;

                  if (imd > 30000) {
                    decile = 10;
                    color = "#17FF17";

                  } else if (imd > 27000) {
                    color = "#40FF14";
                    decile = 9;
                  } else if (imd > 24000) {
                    color = "#70FF14";
                    decile = 8;

                  } else if (imd > 21000) {
                    color = "#A0FF14";
                    decile = 7;

                  } else if (imd > 18000) {
                    color = "#D0FF14";
                    decile = 6;

                  } else if (imd > 15000) {
                    decile = 5;
                    var color = "#FFFD14";
                  } else if (imd > 12000) {
                    decile = 4;
                    var color = "#FFCD14";
                  } else if (imd > 9000) {
                    decile = 3;
                    var color = "#FF9D14";
                  } else if (imd > 6000) {
                    decile = 2;
                    var color = "#FF6D14";
                  } else if (imd > 3000) {
                    decile = 1;
                    var color = "#FF6D14";
                  } else {
                    decile = "";
                    var color = "#FF141A";
                  }

                  console.log(color);
                  // initialising and filling out details of the circle
                  var cityCircle = new google.maps.Circle({
                    strokeColor: "#FF0000",
                    strokeOpacity: 2,
                    strokeWeight: 0.3,
                    fillColor: color,
                    fillOpacity: 0.5,
                    map: map,
                    center: p,
                    radius: 200,
                    info:
                      "<strong>Postcode: </strong>" +
                      j +
                      "<br><strong>Decile: </strong>" +
                      decile,
                  });
                  // setting a small info window when you hover over the circle
                  var infoWindow = new google.maps.InfoWindow();

                  google.maps.event.addListener(
                    cityCircle,
                    "mouseover",
                    (function () {
                      return function () {
                        var content = infoWindow.setContent(cityCircle.info);
                        var position = infoWindow.setPosition(
                          cityCircle.center
                        );
                        infoWindow.open(map);
                      };
                    })()
                  );
                  google.maps.event.addListener(
                    cityCircle,
                    "mouseout",
                    function () {
                      infoWindow.close();
                    }
                  );
                
          });


    
    </script>
    @endforeach

  </head>
  <body>
    <div id="map"></div>
  </body>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=API_KEY&callback=initMap">
    </script>
</html>
