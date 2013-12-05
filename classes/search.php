<?php
include("route.php");
include("flight.php");

class Search {
    
    var $opts;
    var $depart_routes;
    var $user;
    var $default_opts;
    
    # params is an array containing
    # e_depart_time: date to depart in epoch time
    # e_return_time: date to return in epoch time(ignored if one way)
    # org: what airport (id) do you wish to arrive at
    # dest: what airport (id) do you wish to depart from
    public function __construct($params, $user) {
        $this->default_opts = array('passengers' => 1, 'max_results' => 10);
        $this->user = $user;
        $this->opts = array_merge($this->default_opts, $params);
        $this->route_opts = $this->opts;
        $this->set_routes();
	}
	
    private function set_routes() {
		$departDateMin = new DateTime();
		$departDateMin->setTimestamp($this->opts['e_depart_time'] - 60*60*24*2);
		$departDateMin = $departDateMin->format('Y-m-d H:i:s');
		$departDateMax = new DateTime();
		$departDateMax->setTimestamp($this->opts['e_depart_time'] + 60*60*24*2);
		$departDateMax = $departDateMax->format('Y-m-d H:i:s');
        $flights = Flight::getEntries($this->user,"WHERE DepartureTime > \"$departDateMin\" AND DepartureTime < \"$departDateMax\"");
        $this->depart_routes = $this->find_routes($this->opts['org'], $this->opts['dest'], $flights);
    }
    
	
    private function find_routes($org, $dest, &$flights) {
        $result = Array();
        $queue = new SplPriorityQueue();
        foreach($flights as $flight) {
            if($flight->DepartureAirport == $org) {
                $route = new Route($this->route_opts);
                $route->add_flight($flight);
                $queue->insert($route, $route->get_joy());
            }
        }
        $count = 0;
        while($queue->count() >0 && $count < $this->opts['max_results'])
        {
            $cur_route = $queue->extract();
            if($cur_route->get_dest() == $dest) {
                $result[] = $cur_route;
                $count++;
                continue;
            }
            foreach($flights as $flight) {
                if(!array_key_exists($flight->ArrivalAirport, $cur_route->visited) &&
					$flight->DepartureAirport == $cur_route->get_dest() &&
					strtotime($flight->DepartureTime) > 30*60 + $cur_route->get_arrival_time()) {
					
                    $new_route = $cur_route->copy();
                    $new_route->add_flight($flight);
                    if($new_route->get_trip_time() < 24*60*60 && $new_route->seats >= $this->opts['passengers']) {
                        $queue->insert($new_route,$new_route->get_joy());
                    }
                }
            }
        }
        return $result;
    }
}
?>
