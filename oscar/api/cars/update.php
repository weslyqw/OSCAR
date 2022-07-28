<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/cars.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare car object
$car = new Car($db);
  
// get id of car to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of car to be edited
$car->id = $data->id;
echo $data->id;
  
if(!empty($data->id))
{
    echo "in the if";
    // set car property values
    $car->location = $data->location;
    $car->car_brand = $data->car_brand ?? false;
    $car->car_model = $data->car_model ?? false;
    $car->license_plate = $data->license_plate ?? false;
    $car->car_year = $data->car_year ?? false;
    $car->number_of_doors = $data->number_of_doors ?? false;
    $car->number_of_seats = $data->number_of_seats ?? false;
    $car->inside_height = $data->inside_height ?? false;
    $car->inside_length = $data->inside_length ?? false;
    $car->inside_width = $data->inside_width ?? false;
    $car->car_km = $data->car_km ?? false;
    $car->fuel_type = $data->fuel_type ?? false;
    $car->transmission = $data->transmission ?? false;
    $car->car_type_group = $data->car_type_group ?? false;
    $car->car_type = $data->car_type ?? false;
    $car->updated = date("Y-m-d H:i:s");
  
    // update the car
    if($car->update()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "car was updated."));
    }
    
    // if unable to update the car, tell the user
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update car."));
    }

}
?>