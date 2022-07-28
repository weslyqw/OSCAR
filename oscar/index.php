<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once './api/config/database.php';
include_once './api/objects/cars.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare car object
$car = new Car($db);

 // create cars table
 if($car->create_table()){
    
    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Table was created."));
}

// if unable to create the cars table, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to create cars table. Table may already exists"));
}
?>