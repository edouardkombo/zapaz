<?php

class SpatialManager {
  
  private static $a = 6378137.0; // distance from the center to the equator (meters)
  private static $b = 6356752.3; // distance from the center to the north/south pole (meters)
  
  public static function getGreatSquareAround($lat, $lng) {
    $array = array();
    if (filter_var($lat, FILTER_VALIDATE_FLOAT) && filter_var($lng, FILTER_VALIDATE_EMAIL)) {
      $d = M_SQRT2 * MAX_HORIZON;
      
      $ne = Spatial::moveGeoPoint($lat, $lng, $d, deg2rad(-45));
      $sw = Spatial::moveGeoPoint($lat, $lng, $d, deg2rad(135));
      array_push($array, $ne);
      array_push($array, $sw);
    }
    return $array;
  }
  
  /**
   * Moves a geo point by the givcen distance in meters and bearing in degrees
   * @param type $lat1 Beginning latitude in radians
   * @param type $lng1 Beginning longitude in radians
   * @param type $distance Distance in meters
   * @param type $theta Bearing in radians
   * @return type A couple (lat,lng) in degrees
   * @see http://www.movable-type.co.uk/scripts/latlong.html
   */
  private static function moveGeoPoint($lat1, $lng1, $distance, $theta) {
//    var lat2 = Math.asin( Math.sin(lat1)*Math.cos(d/R) + 
//                          Math.cos(lat1)*Math.sin(d/R)*Math.cos(theta) );
//    var lon2 = lon1 + Math.atan2(Math.sin(theta)*Math.sin(d/R)*Math.cos(lat1), 
//                      Math.cos(d/R)-Math.sin(lat1)*Math.sin(lat2));
    $r = Spatial::getRadiusOfEarth($lat1);
    $dr = $distance / $r;
    
    $lat2 = asin(sin($lat1) * cos($dr) + cos($lat1) * sin($dr) * cos($theta));
    $lng2 = $lng1 + atan2(sin($theta) * sin($dr) * cos($lat1), cos($dr) - sin($lat1) * sin($lat2));
    
    $lng2 = fmod($lng2 + 3 * M_PI, 2 * M_PI) - M_PI;  // normalise to -180...+180
    
    return array(rad2deg($lat2), rad2deg($lng2));
  }
  
  /**
   * Get distance in meters between two spots
   * @param type $lat1 The latitude of the first point in degrees
   * @param type $lng1 The longitude of the first point in degrees
   * @param type $lat2 The latitude of the second point in degrees
   * @param type $lng2 The longitude of the second point in degrees
   * @return type The distance in meters. -1 if failed.
   * @see Formula here: http://en.wikipedia.org/wiki/Haversine_formula
   */
  public static function getDistanceBetween($lat1, $lng1, $lat2, $lng2) {
    if ($lat1 != null && $lng1 != null && $lat2 != null && $lng2 != null) {
      $lat1 = deg2rad($lat1);
      $lng1 = deg2rad($lng1);
      $lat2 = deg2rad($lat2);
      $lng2 = deg2rad($lng2);
      
      $r1 = Spatial::getRadiusOfEarth($lat1);
      $r2 = Spatial::getRadiusOfEarth($lat2);
      $r  = ($r1 + $r2) / 2;
      
      $deltaLambda = $lng2 - $lng1;
      $h = Spatial::haversine($lat2 - $lat1) + cos($lat1) * cos($lat2) * Spatial::haversine($deltaLambda);
      $rh = sqrt($h);
      return 2 * $r * asin($rh);
    }
    return -1;
    
  }
  
  private static function haversine($theta) {
    return (1 - cos($theta)) / 2;
  }
  
  /**
   * Get the radius of the earth, in meters, depending on the latitude
   * @param type $phi The latitude in radians
   * @return type The radius of the earth in meters.
   * @see Formula here: http://en.wikipedia.org/wiki/Earth_radius
   */
  private static function getRadiusOfEarth($phi) {
    $cphi   = cos($phi);
    $sphi   = sin($phi);
    $acphi  = Spatial::$a * $cphi;
    $bsphi  = Spatial::$b * $sphi;
    $aacphi = Spatial::$a * $acphi;
    $bbsphi = Spatial::$b * $bsphi;
    
    $num  = $aacphi * $aacphi + $bbsphi * $bbsphi;
    $den  = $acphi  * $acphi  + $bsphi  * $bsphi;
    $frac = $num / $den;
    return sqrt($frac);
  }
}

?>
