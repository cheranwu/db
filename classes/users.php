<?php
include_once("db.php");

class users extends db {
    
    var $user_id;
    
    function __construct($u_id = 1){
        parent::__construct();
        $this->user_id = $u_id;
    }
	
	function modify_vip($set, $key){
		$db_conflicts = $this->db_conflicts_vip($set, $key); // check for conflicts with the DB
		
		if ($db_conflicts == false)
		{
			$key = "vip_id = $key";
			$this->db->AutoExecute("vip", $set, "UPDATE", $key);
			$modify = true;
		}
		else
		{
			$modify = false;
		}
		return $modify; 
    }// end modify vip
	
	//------------------------------------------------ Delete functions ------------------------------------------------
	function delete_customers($obj){
		$sql = "DELETE FROM customers WHERE cid=$obj";
		$this->db->Execute($sql);
    }

	function reset_db() {
		$this->clear_db();
		$this->create_db();
	}
	
    function create_db(){		
        $sql = "CREATE TABLE IF NOT EXISTS Trip
			(
			  TripNum int NOT NULL,
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
			  ReservationNum int NOT NULL,
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
		  Id int PRIMARY KEY NOT NULL,
		  Type varchar(255) NOT NULL,
		  NumSeat int NOT NULL CHECK (NumSeat>0)
		)";
        $this->db->Execute($sql);
        
        $sql = "CREATE TABLE IF NOT EXISTS FlightLeg
			(
			  LegNum int PRIMARY KEY,
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
        
        $sql = "CREATE table if not exists flights (
            flight_id int auto_increment primary key,
            plane_id int,
            org_id int,
            dest_id int,
            first_class_cost int(4),
            coach_class_cost int(4),
            e_depart_time varchar(30),
            e_arrival_time varchar(30),
            depart_time varchar(30),
            arrival_time varchar(30),
            distance int(5)
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
		  TransactionNum int UNIQUE NOT NULL,
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
    	$tables = array("Trip", "Reservation", "FlightLeg", "Airport", "Airplane", "Leg", "Payment");
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

