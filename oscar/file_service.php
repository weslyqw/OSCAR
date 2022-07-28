<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once './api/config/database.php';
  
// instantiate car object
include_once './api/objects/cars.php';
  
$database = new Database();
$db = $database->getConnection();
  
$car = new Car($db);

// convert csv to json format
function csvToJson($fname) {
    // open csv file
    if (!($fp = fopen($fname, 'r'))) {
        die("Can't open file...");
    }
    
    //read csv headers
    $key = fgetcsv($fp,"1024",",");
    
    // parse csv rows into array
    $json = array();
        while ($row = fgetcsv($fp,"1024",",")) {
        $json[] = array_combine($key, $row);
    }
    
    // release file handle
    fclose($fp);
    
    // encode array to json
    return json_encode($json);
}

$source_1 = csvToJson("source-1.csv");
$source_2 = file_get_contents("source-2.json");
$source_3 = file_get_contents("source-3.json");
$source_1_json_array  = json_decode($source_1, true);
$source_2_json_array  = json_decode($source_2, true);
$source_3_json_array  = json_decode($source_3, true);

$combined_array1 = array_merge((array)$source_1_json_array , (array)$source_2_json_array, (array)$source_3_json_array) ;
$combined_array1_count = count($combined_array1);

for($e=0;$e<$combined_array1_count;$e++)
{
    if(($combined_array1[$e]["Number of doors"] > 1) && ($combined_array1[$e]["Number of seats"] > 0))
    {
        $car->location = $combined_array1[$e]["Location"]?? false;
        $car->car_brand = $combined_array1[$e]["Car Brand"]?? false;
        $car->car_model = $combined_array1[$e]["Car Model"]?? false;
        $car->license_plate = $combined_array1[$e]["License plate"]?? false;
        $car->car_year = $combined_array1[$e]["Car year"]?? false;
        $car->number_of_doors = $combined_array1[$e]["Number of doors"]?? false;
        $car->number_of_seats = $combined_array1[$e]["Number of seats"]?? false;
        $car->inside_height = $combined_array1[$e]["Inside height"]?? false;
        $car->inside_length = $combined_array1[$e]["Inside width"]?? false;
        $car->inside_width = $combined_array1[$e]["Inside length"]?? false;
        $car->car_km = $combined_array1[$e]["Car km"]?? false;
        $car->fuel_type = $combined_array1[$e]["Fuel type"]?? false;
        $car->transmission = $combined_array1[$e]["Transmission"]?? false;
        $car->car_type_group = $combined_array1[$e]["Car Type Group"]?? false;
        $car->car_type = $combined_array1[$e]["Car Type"]?? false;
        $car->created = date("Y-m-d H:i:s");    

    }
    elseif($combined_array1[$e]["Number of doors"] < 0 || $combined_array1[$e]["Number of seats"] < 0) 
    {
        // set response code - 400 created
        http_response_code(400);
  
        // tell the user
        echo json_encode(array(
                                "message" => "Please enter a positive number of doors and seats for this car:", 
                                "location" => $combined_array1[$e]["Location"],
                                "Car Brand" => $combined_array1[$e]["Car Brand"],
                                "Car Model" => $combined_array1[$e]["Car Model"],
                                "Number of doors" => $combined_array1[$e]["Number of doors"],
                                "Number of seats" => $combined_array1[$e]["Number of seats"],
                                "Car year" => $combined_array1[$e]["Car year"]
                              ));
        continue; 
    }
    else
    {
         // set response code - 400 created
         http_response_code(400);
  
         // tell the user
         echo json_encode(array("message" => "Doors and seats must be specified to create a car"));   
         continue;
    }
    

    // create the car
    if($car->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Car was created. \n" ));
    }
  
    // if unable to create the car, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create car."));
    }
    
}
?>