<?php
class Route {
    var $avail_tickets;
    var $layover_time;
    var $num_flights;
    var $cost;
    var $seats;
    
    function __construct($opts) {
        $this->num_flights = 0;
        $this->flights = array();
        $this->opts = $opts;
        $this->visited = array();
        $this->seats = 100;
    }
    
    public function add_flight($flight) {
        $this->flights[] = $flight;
        $this->num_flights += 1;
        $this->visited[$flight->DepartureAirport] = true;
        $this->visited[$flight->ArrivalAirport] = true;
        if($flight->NumSeatsAvailable < $this->seats) {
            $this->seats = $flight->NumSeatsAvailable;
        }
    }
    
    public function get_trip_time() {
        if($this->num_flights == 0) return 0;
        else {
            return abs(strtotime($this->flights[$this->num_flights-1]->DepartureTime) - strtotime($this->flights[0]->ArrivalTime));
        }
    }
    
    public function get_layover_time() {
        return $this->layover_time;
    }
    
    public function get_flights() {
        return $this->flights;
    }
    
    public function get_dest() {
        return $this->flights[$this->num_flights-1]->ArrivalAirport;
    }
    
    public function get_arrival_time() {
        return $this->flights[$this->num_flights-1]->ArrivalTime;
    }
    
    public function copy() {
        $copy = new Route($this->opts);
        foreach($this->flights as $flight) {
            $copy->add_flight($flight, $this->seats);
        }
        return $copy;
    }
    
    public function get_Joy() {
        return -1*($this->cost + $this->get_trip_time()/60000 * $this->num_flights);
    }
    
    public function to_string() {
		date_default_timezone_set('America/New_York');
		$time = $this->flights[0]->DepartureTime;
		//$_SESSION['d_time']= $time;
		$res = "<td><center>$time</center></td>";    // depart time
		
		$time = $this->flights[$this->num_flights-1]->ArrivalTime;
		//$_SESSION['a_time']= $time;
        $res .= "<td><center>$time</center></td>";   // arrival time
        
        $layovers = $this->num_flights - 1;
        $res .= "<td><center>$layovers</center></td>";  // layovers
        
        $res .= "<td><center>$this->seats</center></td>";  // seats
        
        $id = "";
        foreach($this->flights as $flight){
            $id .= $flight->LegNum . "_";
        }
        
        $res .= "<td><center><input type='radio' name='Depart' value='$id'></center></td>";  // id of flights space delimited 
        return $res;
    }
}
?>