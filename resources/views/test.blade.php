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

        /* ... (rest of your styles) */
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
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            }).addTo(map);


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
                    "silver" :
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
                    "azure" :
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
            let currentLgaCode = null;
            let currentTooltip = "";
            const lgaMarkers = {};
            const markerLayerGroup = L.layerGroup().addTo(map);

            L.geoJSON(jigawaWards, {
                onEachFeature: function(feature, layer) {
                    if (feature.properties && feature.properties.lga_code) {
                        const lgaCode = feature.properties.lga_code;

                        if (currentLgaCode !== lgaCode) {
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
                                    percentage: ward.percentage,
                                };
                                lgaMarkers[lgaCode].hospitals += ward.teachingHospitals;
                                lgaMarkers[lgaCode].primaryHealthCares += ward.primaryHealthCares;
                                lgaMarkers[lgaCode].secondaryHealthCares += ward.secondaryHealthCares;
                            }
                        });

                        if (!lgaMarkers[lgaCode].marker) {
                            const hospitalIcon = L.divIcon({
                                className: "marker-icon",
                                iconSize: [20, 20],
                                iconAnchor: [15, 15],
                                html: lgaMarkers[lgaCode].percentage + "%",
                            });

                            const marker = L.marker(
                                layer.getBounds().getCenter(), {
                                    icon: hospitalIcon
                                }
                            ).bindTooltip(
                                `
                                    Hospitals: ${lgaMarkers[lgaCode].hospitals}<br>
                                    Primary Health Cares: ${lgaMarkers[lgaCode].primaryHealthCares}<br>
                                    city id: ${lgaMarkers[lgaCode].cityId}<br>
                                    Secondary Health Cares: ${lgaMarkers[lgaCode].secondaryHealthCares}
                                `
                            );
                            lgaMarkers[lgaCode] = marker;
                            markerLayerGroup.addLayer(marker);
                        } else {
                            markerLayerGroup.addLayer(lgaMarkers[lgaCode]); // Add existing marker to layer group
                        }
                    }
                },
                style: style,
            }).addTo(map);

            map.fitBounds(markerLayerGroup.getBounds()); // Fit to markers

            // ... (legend code remains the same)
        }

        getLgas();
    </script>
</body>

</html>