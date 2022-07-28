<?php
class Car{
  
    // database connection and table name
    private $conn;
    private $table_name = "cars";
  
    // object properties
    public $id;
    public $location;
    public $car_brand;
    public $car_model;
    public $license_plate;
    public $car_year;
    public $number_of_doors;
    public $number_of_seats;
    public $inside_height;
    public $inside_length;
    public $inside_width;
    public $car_km;
    public $fuel_type;
    public $transmission;
    public $car_type_group;
    public $car_type;
    public $created;
    public $modified;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read cars
    function read(){
    
        // select all query
        $query = "SELECT*
                FROM
                    " . $this->table_name . " c
                   
                ORDER BY
                    c.id ASC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    function create_table(){
        $query = "CREATE TABLE IF NOT EXISTS cars (
            id int(250) AUTO_INCREMENT PRIMARY KEY,
            location text NOT NULL,
            car_brand text NOT NULL,
            car_model text NOT NULL,
            license_plate text NOT NULL,
            car_year int(11) NOT NULL,
            number_of_doors int(11) NOT NULL,
            number_of_seats int(11) NOT NULL,
            inside_height int(11) NOT NULL,
            inside_length int(11) NOT NULL,
            inside_width int(11) NOT NULL,
            car_km int(11) NOT NULL,
            fuel_type text NOT NULL,
            transmission text NOT NULL,
            car_type_group text NOT NULL,
            car_type text NOT NULL,
            created datetime NOT NULL,
            modified timestamp NOT NULL DEFAULT current_timestamp()
            )";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

           // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // create a car
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    location=:location,
                    car_brand=:car_brand,
                    car_model=:car_model,
                    license_plate=:license_plate,
                    car_year=:car_year,
                    number_of_doors=:number_of_doors,
                    number_of_seats=:number_of_seats,
                    inside_height=:inside_height,
                    inside_length=:inside_length,
                    inside_width=:inside_width,
                    car_km=:car_km,
                    fuel_type=:fuel_type,
                    transmission=:transmission,
                    car_type_group=:car_type_group,
                    car_type=:car_type,
                    created=:created"
                    ;
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->location=htmlspecialchars(strip_tags($this->location));
        $this->car_brand=htmlspecialchars(strip_tags($this->car_brand));
        $this->car_model=htmlspecialchars(strip_tags($this->car_model));
        $this->license_plate=htmlspecialchars(strip_tags($this->license_plate));
        $this->car_year=htmlspecialchars(strip_tags($this->car_year));
        $this->number_of_doors=htmlspecialchars(strip_tags($this->number_of_doors));
        $this->number_of_seats=htmlspecialchars(strip_tags($this->number_of_seats));
        $this->inside_height=htmlspecialchars(strip_tags($this->inside_height));
        $this->inside_length=htmlspecialchars(strip_tags($this->inside_length));
        $this->inside_width=htmlspecialchars(strip_tags($this->inside_width));
        $this->car_km=htmlspecialchars(strip_tags($this->car_km));
        $this->fuel_type=htmlspecialchars(strip_tags($this->fuel_type));
        $this->transmission=htmlspecialchars(strip_tags($this->transmission));
        $this->car_type_group=htmlspecialchars(strip_tags($this->car_type_group));
        $this->car_type=htmlspecialchars(strip_tags($this->car_type));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":car_brand", $this->car_brand);
        $stmt->bindParam(":car_model", $this->car_model);
        $stmt->bindParam(":license_plate", $this->license_plate);
        $stmt->bindParam(":car_year", $this->car_year);
        $stmt->bindParam(":number_of_doors", $this->number_of_doors);
        $stmt->bindParam(":number_of_seats", $this->number_of_seats);
        $stmt->bindParam(":inside_height", $this->inside_height);
        $stmt->bindParam(":inside_length", $this->inside_length);
        $stmt->bindParam(":inside_width", $this->inside_width);
        $stmt->bindParam(":car_km", $this->car_km);
        $stmt->bindParam(":fuel_type", $this->fuel_type);
        $stmt->bindParam(":transmission", $this->transmission);
        $stmt->bindParam(":car_type_group", $this->car_type_group);
        $stmt->bindParam(":car_type", $this->car_type);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;

    }
    
    // used to find a specific car
    function readOne(){
  
        // query to read single record
        $query = "SELECT*
                FROM
                    " . $this->table_name . " p
                    
                WHERE
                    p.id = ?
                LIMIT
                    0,1";
        
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
        
        // execute query
        $stmt->execute();
        
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // set values to object properties
        $this->id = $row['id'];
        $this->location = $row['location'];
        $this->car_brand = $row['car_brand'];
        $this->car_model = $row['car_model'];
        $this->license_plate = $row['license_plate'];
        $this->car_year = $row['car_year'];
        $this->number_of_doors = $row['number_of_doors'];
        $this->number_of_seats = $row['number_of_seats'];
        $this->inside_height = $row['inside_height'];
        $this->inside_length = $row['inside_length'];
        $this->inside_width = $row['inside_width'];
        $this->car_km = $row['car_km'];
        $this->fuel_type = $row['fuel_type'];
        $this->transmission = $row['transmission'];
        $this->car_type_group = $row['car_type_group'];
        $this->car_type = $row['car_type'];
        $this->created = $row['created'];
    }

    // update a car
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    location=:location,
                    car_brand=:car_brand,
                    car_model=:car_model,
                    license_plate=:license_plate,
                    car_year=:car_year,
                    number_of_doors=:number_of_doors,
                    number_of_seats=:number_of_seats,
                    inside_height=:inside_height,
                    inside_length=:inside_length,
                    inside_width=:inside_width,
                    car_km=:car_km,
                    fuel_type=:fuel_type,
                    transmission=:transmission,
                    car_type_group=:car_type_group,
                    car_type=:car_type,
                    modified=:modified
                WHERE
                    id = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->location=htmlspecialchars(strip_tags($this->location));
        $this->car_brand=htmlspecialchars(strip_tags($this->car_brand));
        $this->car_model=htmlspecialchars(strip_tags($this->car_model));
        $this->license_plate=htmlspecialchars(strip_tags($this->license_plate));
        $this->car_year=htmlspecialchars(strip_tags($this->car_year));
        $this->number_of_doors=htmlspecialchars(strip_tags($this->number_of_doors));
        $this->number_of_seats=htmlspecialchars(strip_tags($this->number_of_seats));
        $this->inside_height=htmlspecialchars(strip_tags($this->inside_height));
        $this->inside_length=htmlspecialchars(strip_tags($this->inside_length));
        $this->inside_width=htmlspecialchars(strip_tags($this->inside_width));
        $this->car_km=htmlspecialchars(strip_tags($this->car_km));
        $this->fuel_type=htmlspecialchars(strip_tags($this->fuel_type));
        $this->transmission=htmlspecialchars(strip_tags($this->transmission));
        $this->car_type_group=htmlspecialchars(strip_tags($this->car_type_group));
        $this->car_type=htmlspecialchars(strip_tags($this->car_type));
        $this->modified=htmlspecialchars(strip_tags($this->modified));
    
        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":car_brand", $this->car_brand);
        $stmt->bindParam(":car_model", $this->car_model);
        $stmt->bindParam(":license_plate", $this->license_plate);
        $stmt->bindParam(":car_year", $this->car_year);
        $stmt->bindParam(":number_of_doors", $this->number_of_doors);
        $stmt->bindParam(":number_of_seats", $this->number_of_seats);
        $stmt->bindParam(":inside_height", $this->inside_height);
        $stmt->bindParam(":inside_length", $this->inside_length);
        $stmt->bindParam(":inside_width", $this->inside_width);
        $stmt->bindParam(":car_km", $this->car_km);
        $stmt->bindParam(":fuel_type", $this->fuel_type);
        $stmt->bindParam(":transmission", $this->transmission);
        $stmt->bindParam(":car_type_group", $this->car_type_group);
        $stmt->bindParam(":car_type", $this->car_type);
        $stmt->bindParam(":modified", $this->modified);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete a car
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
}
?>