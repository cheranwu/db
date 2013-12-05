<?php
include_once("db.php");

class users extends db {
    
    var $user_id;
    
    function __construct($u_id = 1){
        parent::__construct();
        $this->user_id = $u_id;
    }
	
	function run_sql($sql){
		return $this->db->GetArray($sql);
    }
	
	function run_sql_insert($sql) {
		return $this->db->Execute($sql);
	}
	
	function delete($table, $row) {
		$sql = "DELETE FROM $table WHERE ";
		$list = Array();
		foreach ($row as $key =>$value)
			$list[] = "$key = '$value'";
		$sql .= implode(' AND ', $list);
		$this->run_sql_insert($sql);
	}
	
	function insert($table,$row) {
		return $this->db->AutoExecute($table, $row, "INSERT");
	}
	
	function update($table, $row, $key) {
		return $this->db->AutoExecute($table, $row, "UPDATE", $key);
	}

	function reset_db() {
		$this->clear_db();
		$this->create_db();
		return "done";
	}
	
    function create_db(){		
        $sql = "CREATE TABLE IF NOT EXISTS Trip
			(
			  TripNum int NOT NULL AUTO_INCREMENT,
			  Airline varchar(255) NOT NULL,
			  Price int NOT NULL CHECK (Price > 0),
			  Departure varchar(255) NOT NULL,
			  Destination varchar(255) NOT NULL,
			  NumLegs int NOT NULL,
			  PRIMARY KEY (TripNum),
			  CHECK (Departure != Destination)
			)";
        $this->db->Execute($sql);
        
        $sql = "CREATE TABLE IF NOT EXISTS Reservation
			(
			  ReservationNum int NOT NULL AUTO_INCREMENT,
			  Email varchar(255) NOT NULL,
			  Name varchar(255) NOT NULL,
			  Addr varchar(255) NOT NULL,
			  Phone varchar(255) NOT NULL,
			  ReserveDate datetime NOT NULL,
			  PRIMARY KEY (ReservationNum)
			)";
        $this->db->Execute($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS Airport(
		  Code varchar(20) PRIMARY KEY,
		  City varchar(255),
		  State varchar(255),
		  Name varchar(255)
		)";
        $this->db->Execute($sql);
        
        $sql = "CREATE TABLE IF NOT EXISTS Airplane(
		  Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
		  Type varchar(255) NOT NULL,
		  NumSeat int NOT NULL CHECK (NumSeat>0)
		)";
        $this->db->Execute($sql);
        
        $sql = "CREATE TABLE IF NOT EXISTS FlightLeg(
			  LegNum int PRIMARY KEY AUTO_INCREMENT,
			  NumSeatsAvailable int NOT NULL,
			  Date datetime NOT NULL,
			  DepartureAirport varchar(10) NOT NULL,
			  DepartureTime datetime NOT NULL,
			  ArrivalAirport varchar(10) NOT NULL,
			  ArrivalTime datetime NOT NULL,
			  AirplaneNum int NOT NULL,
			  FOREIGN KEY (AirplaneNum) REFERENCES Airplane(Id),
			  FOREIGN KEY (DepartureAirport) REFERENCES Airport(Code),
			  FOREIGN KEY (ArrivalAirport) REFERENCES Airport(Code),
			  CHECK (ArrivalAirport != DepartureAirport),
			  CHECK (DepartureTime < ArrivalTime),
			  CHECK (NumSeatsAvailable > -1)
			)";
        $this->db->Execute($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS Leg(
		  TripNum int NOT NULL,
		  FlightLegNum int NOT NULL,
		  PRIMARY KEY(TripNum, FlightLegNum),
		  FOREIGN KEY (TripNum) REFERENCES Trip(TripNum),
		  FOREIGN KEY (FlightLegNum) REFERENCES FlightLeg(LegNum)
		)";
        $this->db->Execute($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS Payment(
		  TripNum int NOT NULL,
		  ReservationNum int NOT NULL,
		  TransactionNum int UNIQUE NOT NULL AUTO_INCREMENT,
		  PaymentDate datetime NOT NULL,
		  Account int NOT NULL,
		  Name varchar(255) NOT NULL,
		  PRIMARY KEY(TripNum, ReservationNum),
		  FOREIGN KEY (TripNum) REFERENCES Trip(TripNum),
		  FOREIGN KEY (ReservationNum) REFERENCES Reservation(ReservationNum)
		)";
        $this->db->Execute($sql);
    }
    
    function clear_db() {
    	$tables = array("Leg", "Payment", "Trip", "Reservation", "FlightLeg", "Airport", "Airplane");
		foreach ($tables as $table) {
            $this->clear_table($table);
        }
    }
    
    function clear_table($table) {
    	$sql = "DROP TABLE IF EXISTS `$table`";
    	$this->db->Execute($sql);
    }
}
?>

