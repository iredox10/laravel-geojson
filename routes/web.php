<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\WardController;
use App\Models\Wards;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/geojson', function () {
    return view('geojson');
});

Route::get('/info', function () {
    phpinfo();
});

Route::get(
    'geojson-wards',
    function () {
        try {
            $wards = Wards::all();
            return view('geojson',['wards' => $wards]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
);
Route::get(
    'get-lgas',
    function () {
        try {
            $wards = Wards::all();
            return response()->json($wards);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
);

Route::get(
    '/add-hospitals',
    function () {
        try {
            // Read GeoJSON file
            $inputFile = public_path('outfil.geojson');
            // $inputFile = public_path('Kano.geojson');
            $geojsonString = file_get_contents($inputFile);
            $geojson = json_decode($geojsonString, true);
            // return response()->json($geojson['features']);
            // Modify GeoJSON object
            foreach ($geojson['features'] as $feature) {
                $pr = rand(0, 100);
                $sr = rand(0, 40);
                $th = rand(0, 20);
                // var_dump($pr);
                //    Example of saving data to the database (if using Eloquent)
                Wards::create([
                    'cityId' => $feature['properties']['city_id'],
                    'wardId' => $feature['properties']['ward_id'],
                    'primaryHealthCares' => $pr,
                    'secondaryHealthCares' => $sr,
                    'teachingHospitals' => $th,
                ]);
            }
            // Convert back to GeoJSON string
            // $updatedGeojsonString = json_encode($geojson, JSON_PRETTY_PRINT);

            // // Write the updated GeoJSON to a file
            // $outputFile = public_path('updated_outfil.geojson');
            // file_put_contents($outputFile, $updatedGeojsonString);

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
                'line' => $e->getLine(),
            ], 500);
        }
    }
);
