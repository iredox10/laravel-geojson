<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Local Government GeoJSON</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="jw.js"></script>
    <style>
      #map {
        height: 100vh;
        width: 100vw;
      }
      /* ... (rest of your styles remain the same) */
      .marker-icon {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgb(166, 166, 226);
        color: black;
        border-radius: 50%;
        padding: 9px;
        text-align: center;
        font-size: 0.5rem;
      }
      .legend {
        background-color: aliceblue;
        padding: 1rem;
        max-height: 60vh;
        overflow-y: scroll;
        margin: 4rem 3rem;
      }
      .legend span {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 8px;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
      let wards;

      async function getLgas() {
        const res = await fetch("/get-lgas");
        wards = await res.json();
        console.log(wards);
        var map = L.map("map").setView([12.5, 9.5], 7);
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
          attribution:
            '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        console.log(wards);

        function getColor(lgaCode) {
          // Customize the colors based on your requirements
          return lgaCode === "18026"
            ? "red"
            : lgaCode === "18001"
            ? "yellow"
            : lgaCode === "18002"
            ? "green"
            : lgaCode === "18003"
            ? "purple"
            : lgaCode === "18004"
            ? "tan"
            : lgaCode === "18005"
            ? "cyan"
            : lgaCode === "18006"
            ? "coral"
            : lgaCode === "18007"
            ? "linen"
            : lgaCode === "18008"
            ? "violet"
            : lgaCode === "18009"
            ? "tomato"
            : lgaCode === "18010"
            ? "gold"
            : lgaCode === "18011"
            ? "olive"
            : lgaCode === "18012"
            ? "indigo"
            : lgaCode === "18013"
            ? "brown"
            : lgaCode === "18014"
            ? "silver"
            : lgaCode === "18015"
            ? "wheat"
            : lgaCode === "18016"
            ? "chocolate"
            : lgaCode === "18017"
            ? "plum"
            : lgaCode === "18018"
            ? "orchid"
            : lgaCode === "18019"
            ? "teal"
            : lgaCode === "18020"
            ? "white"
            : lgaCode === "18021"
            ? "pink"
            : lgaCode === "18022"
            ? "aqua"
            : lgaCode === "18023"
            ? "azure"
            : lgaCode === "18024"
            ? "magenta"
            : lgaCode === "18025"
            ? "crimson"
            : lgaCode === "18026"
            ? "lemon"
            : lgaCode === "18030"
            ? "lime"
            : lgaCode === "18027"
            ? "blue"
            : "gray";
        }
        // Define a function to set the style based on the "lga_code" property
        function style(feature) {
          var lgaCode = feature.properties.lga_code;
          // Customize the colors based on your requirements
          return {
            fillColor: getColor(lgaCode),
            weight: 2,
            opacity: 1,
            color: "white",
            fillOpacity: 0.7,
          };
        }
        // ... (style and getColor functions remain the same)

        // Marker Placement Optimization
        // const lgaMarkers = {}; // Store markers to prevent duplicates
        let currentLgaCode = null;
        let currentTooltip = "";
 // Initialize lgaMarkers before GeoJSON processing
    const lgaMarkers = {}; 
    wards.forEach((ward) => {  // <-- Initialize based on ward data
        lgaMarkers[ward.lga_code] = {
            hospitals: 0,
            primaryHealthCares: 0,
            secondaryHealthCares: 0,
            percentage: ward.percentage,
            marker: null, // Initially set marker to null
        };
    });

        L.geoJSON(jigawaWards, {
          onEachFeature: function (feature, layer) {
            if (feature.properties && feature.properties.lga_code) {
              const lgaCode = feature.properties.lga_code;

              if (currentLgaCode !== lgaCode) {
                // New LGA found
                currentLgaCode = lgaCode;
                const toolTip = `<b style="font-size: 0.8rem; text-transform:capitalize">lga code:<b> ${lgaCode} <br />
                                             <b> lga name: <b> ${feature.properties.lga_name}<br />
                                              <b> ward name: <b> ${feature.properties.ward_name}`;
                currentTooltip = toolTip;
              }
              layer.bindTooltip(currentTooltip);

              // Aggregate counts for the LGA
              wards.forEach((ward) => {
                if (feature.properties.ward_code == ward.wardCode) {
                  lgaMarkers[lgaCode] = lgaMarkers[lgaCode] || {
                    hospitals: 0,
                    primaryHealthCares: 0,
                    secondaryHealthCares: 0,
                  };
                  lgaMarkers[lgaCode].hospitals += ward.teachingHospitals;
                  lgaMarkers[lgaCode].primaryHealthCares +=
                    ward.primaryHealthCares;
                  lgaMarkers[lgaCode].secondaryHealthCares +=
                    ward.secondaryHealthCares;
                  lgaMarkers[lgaCode].percentage = ward.percentage;
                }
              });

              // If this is the first ward of the LGA, add the marker
              if (!lgaMarkers[lgaCode].marker) {
                const hospitalIcon = L.divIcon({
                  className: "marker-icon",
                  iconSize: [20, 20],
                  iconAnchor: [15, 15],
                  html: lgaMarkers[lgaCode].percentage + "%",
                });
                lgaMarkers[lgaCode].marker = L.marker(
                  layer.getBounds().getCenter(),
                  {
                    icon: hospitalIcon,
                    // Choose an icon type based on the counts
                    // (You'll need to implement this logic)
                  }
                )
                  .bindTooltip(
                    `
                                Hospitals: ${lgaMarkers[lgaCode].hospitals}<br>
                                Primary Health Cares: ${lgaMarkers[lgaCode].primaryHealthCares}<br>
                                city id: ${lgaMarkers[lgaCode].cityId}<br>
                                Secondary Health Cares: ${lgaMarkers[lgaCode].secondaryHealthCares}
                            `
                  )
                  .addTo(map);
              }
            }
          },
          style: style,
        }).addTo(map);
        map.fitBounds(L.geoJSON(jigawaWards).getBounds());
        // ... (legend code remains the same)
        // Create a custom control for the legend
        var legend = L.control({ position: "bottomright" });
        legend.onAdd = function (map) {
          var div = L.DomUtil.create("div", "legend");
          div.innerHTML = "<strong>Wards Color</strong><br>";
          const features = jigawaWards.features;
          console.log(features.length);

          // Create a Set to store unique lga_codes
          const uniqueLGAs = new Set();

          // Loop through the features and add unique items to the legend
          for (var i = 0; i < features.length; i++) {
            var feature = features[i];
            var lgaCode = feature.properties.lga_code;
            var lgaName = feature.properties.lga_name || "Unknown";

            // Check if this LGA code has been added before
            if (!uniqueLGAs.has(lgaCode)) {
              uniqueLGAs.add(lgaCode); // Add to the Set to ensure uniqueness

              // Add a new entry to the legend
              div.innerHTML +=
                '<span style="background:' +
                getColor(lgaCode) +
                '"></span>' +
                lgaName +
                "<br>";
            }
          }

          return div;
        };

        legend.addTo(map);
      }
      getLgas();
    </script>
  </body
</html>