<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leaflet GeoJSON Example</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="jw.js"></script>
    <style>
      #map {
        height: 100vh;
        width: 100vw;
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
        const res = await fetch("http://localhost:8000/get-lgas");
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

      // Add GeoJSON data to the map
      L.geoJSON(jigawaWards, {
        onEachFeature: function (feature, layer) {
          if (feature.properties && feature.properties.ward_name) {
            feature.properties.lga_code == "18030"
              ? (feature.properties.lga_name = "sule tankarkar")
              : "";
            feature.properties.lga_code == "18016"
              ? (feature.properties.lga_name = "gagarawa")
              : "";
            feature.properties.lga_code == "18022"
              ? (feature.properties.lga_name = "Birnin Kudu")
              : "";
            feature.properties.lga_code == "18001"
              ? (feature.properties.lga_name = "Kaugama")
              : "";
            feature.properties.lga_code == "18018"
              ? (feature.properties.lga_name = "Buji")
              : "";
            feature.properties.lga_code == "18009"
              ? (feature.properties.lga_name = "Gwiwa")
              : "";
            feature.properties.lga_code == "18013"
              ? (feature.properties.lga_name = "Auyo")
              : "";
            feature.properties.lga_code == "18008"
              ? (feature.properties.lga_name = "Gwaram")
              : "";
            feature.properties.lga_code == "18014"
              ? (feature.properties.lga_name = "Miga")
              : "";
            feature.properties.lga_code == "18021"
              ? (feature.properties.lga_name = "Birniwa")
              : "";
            feature.properties.lga_code == "18012"
              ? (feature.properties.lga_name = "Dutse")
              : "";
            feature.properties.lga_code == "18010"
              ? (feature.properties.lga_name = "Kazaure")
              : "";
            feature.properties.lga_code == "18025"
              ? (feature.properties.lga_name = "Kiyawa")
              : "";
            feature.properties.lga_code == "18015"
              ? (feature.properties.lga_name = "Roni")
              : "";
            feature.properties.lga_code == "18007"
              ? (feature.properties.lga_name = "Kiri Kasama")
              : "";
            feature.properties.lga_code == "18004"
              ? (feature.properties.lga_name = "Babura")
              : "";
            feature.properties.lga_code == "18005"
              ? (feature.properties.lga_name = "Guri")
              : "";
            feature.properties.lga_code == "18002"
              ? (feature.properties.lga_name = "Taura")
              : "";
            feature.properties.lga_code == "18011"
              ? (feature.properties.lga_name = "Hadejia")
              : "";
            feature.properties.lga_code == "18022"
              ? (feature.properties.lga_name = "Birnin Kudi")
              : "";
            feature.properties.lga_code == "18001"
              ? (feature.properties.lga_name = "Kaugama")
              : "";
            feature.properties.lga_code == "18009"
              ? (feature.properties.lga_name = "Gwiwa")
              : "";
            feature.properties.lga_code == "18027"
              ? (feature.properties.lga_name = "Kafin Hausa")
              : "";
            feature.properties.lga_code == "18020"
              ? (feature.properties.lga_name = "Ringim")
              : "";
            feature.properties.lga_code == "18001"
              ? (feature.properties.lga_name = "Kaugama")
              : "";
            feature.properties.lga_code == "18017"
              ? (feature.properties.lga_name = "Malam Madori")
              : "";
            feature.properties.lga_code == "18024"
              ? (feature.properties.lga_name = "Garki")
              : "";
            feature.properties.lga_code == "18019"
              ? (feature.properties.lga_name = "Yankwashi")
              : "";
            feature.properties.lga_code == "18019"
              ? (feature.properties.lga_name = "Yankwashi")
              : "";
            feature.properties.lga_code == "18023"
              ? (feature.properties.lga_name = "Maigatari")
              : "";
            feature.properties.lga_code == "18026"
              ? (feature.properties.lga_name = "Jahun")
              : "";
            const toolTip = `<b style="font-size: 1.3rem; text-transform:capitalize">ward name:<b> ${feature.properties.ward_name} <br />
                         <b>lga code: <b>${feature.properties.lga_code} <br />
                          <b> lga name <b> ${feature.properties.lga_name}`;
            layer.bindTooltip(toolTip);
          }
          console.log(feature.properties);
          wards.forEach((ward) => {
            // console.log(ward)
            if (feature.properties.city_id == ward.city_id) {
              // feature.properties.hospitals = ward.teachingHospitals;
              feature.properties.primaryHealthCares = ward.primaryHealthCares;
              feature.properties.secondaryHealthCares = ward.secondaryHealthCares;
              feature.properties.teachingHospitals = ward.teachingHospitals;
            }
          });
          
          // Add a marker with the hospital count
          if (feature.properties.teachingHospitals > 0) {
            var hospitalIcon = L.divIcon({
              className: "hospital-marker",
              iconSize: [30, 30],
              iconAnchor: [15, 15],
              html: feature.properties.teachingHospitals.toString(),
            });
            var marker = L.marker(layer.getBounds().getCenter(), {
              icon: hospitalIcon,
            })
              .bindPopup("Teaching Hospital: " + feature.properties.teachingHospitals)
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
              layer.getBounds().getCenter(),
              { icon: secondaryHealthCareIcon }
            )
              .bindPopup(
                "Secondary Health Care Centers: " +
                  feature.properties.secondaryHealthCares
              )
              .addTo(map);
        }

          if (feature.properties.primaryHealthCares > 0) {
            console.log(feature);
            var secondaryHealthCareIcon = L.divIcon({
              className: "primary-healthcare-marker",
              iconSize: [20, 20],
              iconAnchor: [60, 60],
              html: feature.properties.primaryHealthCares.toString(),
            });
            var secondaryHealthCareMarker = L.marker(
              layer.getBounds().getCenter(),
              { icon: secondaryHealthCareIcon }
            )
              .bindPopup(
                "Primary Health Care " +
                  feature.properties.primaryHealthCares
              )
              .addTo(map);
          }
        },
        style: style,
      }).addTo(map);}
      getLgas();

    </script>
  </body>
</html>