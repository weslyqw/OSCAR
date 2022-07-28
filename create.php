<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate car object
include_once '../objects/cars.php';
  
$database = new Database();
$db = $database->getConnection();
  
$car = new Car($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->location) &&
    !empty($data->car_brand) &&
    !empty($data->car_model) &&
    !empty($data->number_of_doors)&&
    !empty($data->number_of_seats)&&
    !empty($data->car_year)
    ){
  
    // set car property values
    $car->location = $data->location;
    $car->car_brand = $data->car_brand;
    $car->car_model = $data->car_model;
    $car->license_plate = $data->license_plate ?? false;
    $car->car_year = $data->car_year;
    $car->number_of_doors = $data->number_of_doors;
    $car->number_of_seats = $data->number_of_seats;
    $car->inside_height = $data->inside_height ?? false;
    $car->inside_length = $data->inside_length ?? false;
    $car->inside_width = $data->inside_width ?? false;
    $car->car_km = $data->car_km ?? false;
    $car->fuel_type = $data->fuel_type ?? false;
    $car->transmission = $data->transmission ?? false;
    $car->car_type_group = $data->car_type_group ?? false;
    $car->car_type = $data->car_type ?? false;
    $car->created = date("Y-m-d H:i:s");
  
    // create the car
    if($car->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Car was created."));
    }
  
    // if unable to create the car, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create car."));
    }
}
  
// tell the user data is incomplete
else{
   
     // set response code - 400 created
     http_response_code(400);

     // tell the user
     echo json_encode(array("message" => "Unable to create car. Data is incomplete."));
    }
?>