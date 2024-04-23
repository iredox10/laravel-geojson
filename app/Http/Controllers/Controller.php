<?php

namespace App\Http\Controllers;

use App\Models\Wards;

abstract class Controller
{
     public function addProperty(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'wards' => 'required|array', // Adjust validation rules as needed
        ]);

        // Example of reading a CSV file
        // $csvData = Storage::disk('local')->get('path/to/csv/file.csv');
        // $rows = array_map('str_getcsv', explode("\n", $csvData));
        // $headers = array_shift($rows);
        // $csvDataArray = array_map(function($row) use ($headers) {
        //     return array_combine($headers, $row);
        // }, $rows);

        // Example of processing data and saving to the database
        // foreach ($request->wards as $ward) {
        //     Property::create([
        //         'ward' => $ward['ward'],
        //         'city_id' => $ward['city_id'],
        //         'ward_id' => $ward['ward_id'],
        //         // Add more fields as needed
        //     ]);
        // }

        // Return a response
        return response()->json([
            'success' => true,
            'message' => 'Properties added successfully!',
        ]);
    }

     public function getLga(Request $request)
    {
        try {
            // Fetch LGAs from the database
            $lgas = Wards::all();

            // Return the fetched LGAs as JSON response
            return response()->json($lgas);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

     public function addHospitals(Request $request)
    {
        try {
            // Read GeoJSON file
            $inputFile = public_path('outfil.geojson');
            $geojsonString = file_get_contents($inputFile);
            $geojson = json_decode($geojsonString, true);

            // Modify GeoJSON object
            foreach ($geojson['features'] as &$feature) {
                $pr = rand(0, 100);
                $sr = rand(0, 40);
                $th = rand(0, 20);

                // Add new properties to each feature
                $feature['properties']['primaryHealthCares'] = $pr;
                $feature['properties']['secondaryHealthCares'] = $sr;
                $feature['properties']['teachingHospitals'] = $th;

                // Example of saving data to the database (if using Eloquent)
                Wards::create([
                    'city_id' => $feature['properties']['city_id'],
                    'ward_id' => $feature['properties']['ward_id'],
                    'primary_health_cares' => $pr,
                    'secondary_health_cares' => $sr,
                    'teaching_hospitals' => $th,
                ]);
            }

            // Convert back to GeoJSON string
            $updatedGeojsonString = json_encode($geojson, JSON_PRETTY_PRINT);

            // Write the updated GeoJSON to a file
            $outputFile = public_path('updated_outfil.geojson');
            file_put_contents($outputFile, $updatedGeojsonString);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Hospitals added successfully!',
            ]);
        } catch (\Exception $e) {
            // Return error response if an exception occurs
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
