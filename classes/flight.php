<?php
class Flight {
    var $LegNum;
	var $NumSeatsAvailable;
	var $Date;
	var $DepartureAirport;
	var $DepartureTime;
	var $ArrivalAirport;
	var $ArrivalTime;
	var $AirplaneNum;
	
	function __construct($row) {
		$this->fromArray($row);
	}
	
	function save($user) {
		if($this->LegNum != 0) {
			$user->update("Flight", $this->toArray(), "LegNum = $LegNum");
		} else {
			$user->insert("Flight", $this->toArray());
		}
	}
	
	static function getEntry($id, $user) {
		return new Flight($user->run_sql("SELECT * FROM FlightLeg WHERE \"LegNum\"=$id"));
	}
	
	static function getEntries($user, $where="") {
		$rows = $user->run_sql("SELECT * FROM FlightLeg $where");
		$ret = array();
		foreach($rows as $row) {
			$ret[] = new Flight($row);
		}
		return $ret;
	}
	
	function fromArray($arr) {
		$this->LegNum = $arr["LegNum"];
		$this->NumSeatsAvailable = $arr["NumSeatsAvailable"];
		$this->Date = $arr["Date"];
		$this->DepartureAirport = $arr["DepartureAirport"];
		$this->DepartureTime = $arr["DepartureTime"];
		$this->ArrivalAirport = $arr["ArrivalAirport"];
		$this->ArrivalTime = $arr["ArrivalTime"];
		$this->AirplaneNum = $arr["AirplaneNum"];
	}
	
	function toArray() {
		return array("LegNum" => $this->LegNum,
					 "NumSeatsAvailable" => $this->NumSeatsAvailable,
					 "Date" => $this->Date,
					 "DepartureAirport" => $this->DepartureAirport,
					 "DepartureTime" => $this->DepartureTime,
					 "ArrivalAirport" => $this->ArrivalAirport,
					 "ArrivalTime" => $this->ArrivalTime,
					 "AirplaneNum" => $this->AirplaneNum);
	}
}
?>