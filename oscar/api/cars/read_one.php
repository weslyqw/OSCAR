<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/cars.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare car object
$car = new Car($db);
  
// set ID property of record to read
$car->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of car to be edited
$car->readOne();
  
if($car->id!=null){
    // create array
    $car_arr = array(
        "id" => $car->id,
        "Location" => $car->location,
        "Car brand" => $car->car_brand,
        "Car Model" => $car->car_model,
        "License plate" => $car->license_plate,
        "Car year" => $car->car_year,
        "Number of doors" => $car->number_of_doors,
        "Number of seats" => $car->number_of_seats,
        "Inside height" => $car->inside_height,
        "Inside lenght" => $car->inside_length,
        "Inside width" => $car->inside_width,
        "Km" => $car->car_km,
        "Fuel type" => $car->fuel_type,
        "Transmission" => $car->transmission,
        "Car group" => $car->car_type_group,
        "Car type" => $car->car_type,
        "Created on" => $car->created
        
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($car_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user car does not exist
    echo json_encode(array("message" => "car does not exist."));
}
?>