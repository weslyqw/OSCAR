# OSCAR
OSCAR
* Clone this repo: ``` git clone https://github.com/weslyqw/OSCAR.git```
* In MySQL create a database called ``` oscar_car_db ```
* Run index.php to create "cars" table ``` /index.php ```
* To populate the cars table with the data provided in the csv and json files run``` /file_service.php ```
* Now that that data is populated you can now go to the specific endpoints. The endpoint details are below

* # Read Endpoint
* ``` http://localhost/oscar/api/cars/read.php ```
* This endpoint returns all cars in the cars table and sorts them by ascending order based on the car id

* # Read One Endpoint
* ``` http://localhost/oscar/api/cars/read_one.php?id=2 ```
* Returns a specific car record based on the car id

* # Create Endpoint
* ``` http://localhost/oscar/api/cars/create.php ```
* Creates one car 
* Enter json data in "Body" using "raw" formatting 
* Mandatory fields are ``` location, car_brand, car_model, number_of_doors, number_of_seats and car_year ```
* Example: ``` {
    "location" : "Cdffsonda",
    "car_brand" : "Astra",
    "car_model" : "Opel",
    "number_of_doors" : "5",
    "number_of_seats" : "5",
    "car_year" : "2012"
} ```
* Here is a list of all field names available ``` 
              location, 
              car_brand, 
              car_model, 
              license_plate, 
              car_year, 
              number_of_doors, 
              number_of_seats, 
              inside_height,
              inside_length,
              inside_width,
              car_km,
              fuel_type,
              transmission,
              car_type_group,
              car_type
              ```

* # Update Endpoint
* ``` http://localhost/oscar/api/cars/update.php ```
* Updates an existing car record
* Example: ``` {
    "id" : "580",
    "location" : "Trinidad",
	  "car_type" : "car"
} ```
* Affects all field names listed in the create endpoint

* # Delete Endpoint
* ``` http://localhost/oscar/api/cars/delete.php ```
* Deletes a record based on the car id
* Example: ``` {
    "id" : "80"
} ```
