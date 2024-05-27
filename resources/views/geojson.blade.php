<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Leaflet GeoJSON Example</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- <script src="jw.js"></script> -->
  <script src="jw.js"></script>
  <style>
    #map {
      height: 100vh;
      width: 100vw;
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

    .hospital-marker {
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 6px;
      text-align: center;
    }

    .secondary-healthcare-marker {
      background-color: green;
      color: white;
      /* border-radius: 50%; */
      padding: 10px;
      text-align: center;
    }

    .primary-healthcare-marker {
      background-color: yellow;
      color: white;
      border-radius: 50%;
      padding: 10px;
      text-align: center;
      color: black;
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

      // console.log(wards && wards);
      var map = L.map("map").setView([0, 0], 2);
      // var map = L.map("map").setView({center: [51.505, -0.09], zoom: 13});

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

      // Define a function to get color based on "lga_code"
      function getColor(lgaCode) {
        // Customize the colors based on your requirements
        return lgaCode === "18026" ?
          "red" :
          lgaCode === "18001" ?
          "yellow" :
          lgaCode === "18002" ?
          "green" :
          lgaCode === "18003" ?
          "purple" :
          lgaCode === "18004" ?
          "tan" :
          lgaCode === "18005" ?
          "cyan" :
          lgaCode === "18006" ?
          "coral" :
          lgaCode === "18007" ?
          "linen" :
          lgaCode === "18008" ?
          "violet" :
          lgaCode === "18009" ?
          "tomato" :
          lgaCode === "18010" ?
          "gold" :
          lgaCode === "18011" ?
          "olive" :
          lgaCode === "18012" ?
          "indigo" :
          lgaCode === "18013" ?
          "brown" :
          lgaCode === "18014" ?
          "amber" :
          lgaCode === "18015" ?
          "wheat" :
          lgaCode === "18016" ?
          "chocolate" :
          lgaCode === "18017" ?
          "plum" :
          lgaCode === "18018" ?
          "orchid" :
          lgaCode === "18019" ?
          "teal" :
          lgaCode === "18020" ?
          "white" :
          lgaCode === "18021" ?
          "pink" :
          lgaCode === "18022" ?
          "aqua" :
          lgaCode === "18023" ?
          "maroon" :
          lgaCode === "18024" ?
          "magenta" :
          lgaCode === "18025" ?
          "crimson" :
          lgaCode === "18026" ?
          "lemon" :
          lgaCode === "18030" ?
          "lime" :
          lgaCode === "18027" ?
          "blue" :
          "gray";
      }

      console.log(jigawaWards.features.filter(j => j.properties.lga_name == undefined))

      // Add GeoJSON data to the map
      L.geoJSON(jigawaWards, {
        onEachFeature: function(feature, layer) {
          if (feature.properties && feature.properties.ward_name) {
            const toolTip = `<b style="font-size: 1.3rem; text-transform:capitalize">ward name:<b> ${feature.properties.ward_name} <br />
                               <b>lga code: <b>${feature.properties.lga_code} <br />
                                <b> lga name <b> ${feature.properties.lga_name}`;
            layer.bindTooltip(toolTip);
          }
          wards.forEach((ward) => {
            if (feature.properties.ward_id == ward.wardId) {
              feature.properties.hospitals = ward.teachingHospitals;
              feature.properties.primaryHealthCares = ward.primaryHealthCares;
              feature.properties.secondaryHealthCares =
                ward.secondaryHealthCares;
            }
          });

          // Add a marker with the hospital count
          if (feature.properties.hospitals > 0) {
            var hospitalIcon = L.divIcon({
              className: "hospital-marker",
              iconSize: [30, 30],
              iconAnchor: [15, 15],
              html: feature.properties.hospitals.toString(),
            });
            var marker = L.marker(layer.getBounds().getCenter(), {
                icon: hospitalIcon,
              })
              .bindPopup("Hospitals: " + feature.properties.hospitals)
              .addTo(map);
          }
          if (feature.properties.secondaryHealthCares > 0) {
            var secondaryHealthCareIcon = L.divIcon({
              className: "secondary-healthcare-marker",
              iconSize: [20, 20],
              iconAnchor: [-30, -30],
              html: feature.properties.secondaryHealthCares.toString(),
            });
            var secondaryHealthCareMarker = L.marker(
                layer.getBounds().getCenter(), {
                  icon: secondaryHealthCareIcon
                }
              )
              .bindPopup(
                "Secondary Health Care Centers: " +
                feature.properties.secondaryHealthCares
              )
              .addTo(map);
          }

          if (feature.properties.primaryHealthCares > 0) {
            var secondaryHealthCareIcon = L.divIcon({
              className: "primary-healthcare-marker",
              iconSize: [20, 20],
              iconAnchor: [60, 60],
              html: feature.properties.primaryHealthCares.toString(),
            });
            var secondaryHealthCareMarker = L.marker(
                layer.getBounds().getCenter(), {
                  icon: secondaryHealthCareIcon
                }
              )
              .bindPopup(
                "Secondary Health Care Centers: " +
                feature.properties.primaryHealthCares
              )
              .addTo(map);
          }
        },
        style: style,
      }).addTo(map);
      // Create a custom control for the legend
      var legend = L.control({
        position: "bottomright"
      });
      legend.onAdd = function(map) {
        var div = L.DomUtil.create("div", "legend");
        div.innerHTML = "<strong>Wards Color</strong><br>";
        const features = jigawaWards.features;
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
</body>

</html>