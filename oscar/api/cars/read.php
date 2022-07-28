<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/cars.php';
  
// instantiate database and car object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$car = new Car($db);
  
// query cars
$stmt = $car->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // cars array
    $cars_arr=array();
    $cars_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $car_item=array(
            "id" => $id,
            "Location" => $location,
            "Car brand" => $car_brand,
            "Car Model" => $car_model,
            "License plate" => $license_plate,
            "Car year" => $car_year,
            "Number of doors" => $number_of_doors,
            "Number of seats" => $number_of_seats,
            "Inside height" => $inside_height,
            "Inside lenght" => $inside_length,
            "Inside width" => $inside_width,
            "Km" => $car_km,
            "Fuel type" => $fuel_type,
            "Transmission" => $transmission,
            "Car group" => $car_type_group,
            "Car type" => $car_type,
            "Created on" => $created,
            "Updated on" => $modified
        );
  
        array_push($cars_arr["records"], $car_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show cars data in json format
    echo json_encode($cars_arr);
}
 
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no cars found
    echo json_encode(
        array("message" => "No cars found.")
    );
}

?>