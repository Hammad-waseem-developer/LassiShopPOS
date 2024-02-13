<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
  public function points()
  {
    return view('point.index');
  }

  public function getPoints()
  {
    $points = Point::with('Clients')->get();
    return response()->json($points);
  }
}
