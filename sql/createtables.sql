CREATE TABLE IF NOT EXISTS Trip
(
  TripNum int NOT NULL,
  Airline varchar(255) NOT NULL,
  Price int NOT NULL CHECK (Price > 0),
  Departure varchar(255) NOT NULL,
  Destination varchar(255) NOT NULL,
  NumLegs int NOT NULL,
  PRIMARY KEY (TripNum),
  CHECK (Departure != Destination)
);

CREATE TABLE IF NOT EXISTS Reservation
(
  ReservationNum int NOT NULL,
  Email varchar(255) NOT NULL,
  Name varchar(255) NOT NULL,
  Addr varchar(255) NOT NULL,
  Phone varchar(255) NOT NULL,
  ReserveDate datetime NOT NULL,
  PRIMARY KEY (ReservationNum)
);

CREATE TABLE IF NOT EXISTS FlightLeg
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
  CHECK (DepartureTime < ArrivalTime)
);

CREATE TABLE IF NOT EXISTS Airport(
  Code varchar(20) PRIMARY KEY,
  City varchar(255),
  State varchar(255),
  Name varchar(255)
);

CREATE TABLE IF NOT EXISTS Airplane(
  Id int PRIMARY KEY NOT NULL,
  Type varchar(255) NOT NULL,
  NumSeat int NOT NULL CHECK (NumSeat>0)
);

CREATE TABLE IF NOT EXISTS Leg(
  TripNum int NOT NULL,
  FlightLegNum int NOT NULL,
  PRIMARY KEY(TripNum, FlightLegNum),
  FOREIGN KEY (TripNum) REFERENCES Trip(TripNum),
  FOREIGN KEY (FlightLegNum) REFERENCES FlightLeg(LegNum)
);

CREATE TABLE IF NOT EXISTS Payment(
  TripNum int NOT NULL,
  ReservationNum int NOT NULL,
  TransactionNum int UNIQUE NOT NULL,
  PaymentDate datetime NOT NULL,
  Account int NOT NULL,
  Name varchar(255) NOT NULL,
  PRIMARY KEY(TripNum, ReservationNum),
  FOREIGN KEY (TripNum) REFERENCES Trip(TripNum),
  FOREIGN KEY (ReservationNum) REFERENCES Reservation(ReservationNum)
);
