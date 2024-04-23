<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Mongodb\Laravel\Eloquent\Model as Eloquent;
class Wards extends Eloquent
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'laravel-geojson';

    protected $fillable = ['cityId','wardId','primaryHealthCares', 'secondaryHealthCares', 'teachingHospitals'];
}
