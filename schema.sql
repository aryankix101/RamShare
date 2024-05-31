CREATE TABLE UserProfile (
    VCU_Email VARCHAR(255),  
    Birthdate DATE,
    UserPassword VARCHAR(255),
    First_Name VARCHAR(255),
    Middle_Name VARCHAR(255),
    Last_Name VARCHAR(255),
    Phone_Number CHAR(10),
    Date_Joined DATE,
    Gender VARCHAR(255),
    Profile_Picture MEDIUMBLOB,
    Bio TEXT,
    Type_Of_User VARCHAR(7),
    First_Time_User INT,
    PRIMARY KEY (VCU_Email),
    INDEX (Phone_Number)
);

CREATE TABLE Driver (
    VCU_Email VARCHAR(255) NOT NULL,
    Driver_ID INT AUTO_INCREMENT,
    Payment_Preferences TEXT,
    Driver_Rating DECIMAL,
    Number_Of_Rides INT,
    PRIMARY KEY (VCU_Email),
    FOREIGN KEY (VCU_Email) REFERENCES UserProfile (VCU_Email)
);

CREATE TABLE Rider (
    VCU_Email VARCHAR(255) NOT NULL,
    Rider_ID INT AUTO_INCREMENT,
    Rider_Rating DECIMAL,
    Number_Of_Rides INT,
    PRIMARY KEY (VCU_Email),
    FOREIGN KEY (VCU_Email) REFERENCES UserProfile (VCU_Email)
);

CREATE TABLE Vehicle (
    License_Plate VARCHAR(255) NOT NULL,
    Vehicle_State VARCHAR(255) NOT NULL,
    Model VARCHAR(255) NOT NULL,
    Vehicle_Year YEAR NOT NULL,
    Color VARCHAR(255) NOT NULL,
    Driver_ID INT,
    PRIMARY KEY (License_Plate, Vehicle_State),
    FOREIGN KEY (Driver_ID) REFERENCES Driver (Driver_ID)
);

CREATE TABLE Ride (
    Ride_ID INT AUTO_INCREMENT,
    Driver_ID INT,
    Trip_Status VARCHAR(255) NOT NULL,
    Distance FLOAT,
    Date_Time_Ride_Posted DATETIME NOT NULL,
    Date_Time_Of_Ride DATETIME NOT NULL,
    Cost FLOAT,
    Post_Content TEXT,
    Departure_Address TEXT,
    Destination_Address TEXT,
    Luggage TEXT,
    PRIMARY KEY Ride_ID,
    FOREIGN KEY (Driver_ID) REFERENCES Driver (Driver_ID)
);

CREATE TABLE Reviews_Ratings (
    Rider INT,
    Driver INT,
    Ride_ID INT AUTO_INCREMENT,
    Content TEXT,
    Rating INT,
    PRIMARY KEY(Rider, Driver, Ride_ID),
    FOREIGN KEY (Rider) REFERENCES Rider (Rider_ID),
    FOREIGN KEY (Driver) REFERENCES Driver (Driver_ID),
    FOREIGN KEY (Ride_ID) REFERENCES Ride (Ride_ID)
);

CREATE TABLE RamShare_Request (
    Ride_ID INT UNIQUE NOT NULL,
    Rider INT,
    Request_Status VARCHAR(255) NOT NULL,
    Time_Request_Was_Made DATETIME NOT NULL,
    PRIMARY KEY (Ride_ID, Rider),
    FOREIGN KEY (Rider) REFERENCES Rider (Rider_ID),
    FOREIGN KEY (Ride_ID) REFERENCES Ride (Ride_ID)
);

CREATE TABLE Notification (
    ID INT NOT NULL UNIQUE,
    Ride_ID INT UNIQUE NOT NULL,
    Type_Of_Notification VARCHAR(255) NOT NULL,
    Phone_Number CHAR(10) NOT NULL,
    VCU_Email VARCHAR(255) NOT NULL UNIQUE, 
    Notification_Text TEXT,
    PRIMARY KEY (ID, Ride_ID, Type_Of_Notification),
    FOREIGN KEY (Ride_ID) REFERENCES Ride (Ride_ID),
    FOREIGN KEY (VCU_Email) REFERENCES UserProfile (VCU_Email),
    FOREIGN KEY (Phone_Number) REFERENCES UserProfile (Phone_Number)
);

DELIMITER //

CREATE TRIGGER IncrementDriverRideCount
AFTER INSERT ON Ride
FOR EACH ROW
BEGIN
    UPDATE Driver
    SET Number_Of_Rides = Number_Of_Rides + 1
    WHERE Driver_ID = NEW.Driver_ID;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER IncrementRiderRideCount
AFTER INSERT ON RamShare_Request
FOR EACH ROW
BEGIN
    UPDATE Rider
    SET Number_Of_Rides = Number_Of_Rides + 1
    WHERE Rider_ID = NEW.Rider;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER UpdateDriverRating
AFTER INSERT ON Reviews_Ratings
FOR EACH ROW
BEGIN
    UPDATE Driver
    SET Driver_Rating = (SELECT AVG(Rating) FROM Reviews_Ratings WHERE Driver = NEW.Driver)
    WHERE Driver_ID = NEW.Driver;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER UpdateRiderRating
AFTER INSERT ON Reviews_Ratings
FOR EACH ROW
BEGIN
    UPDATE Rider
    SET Rider_Rating = (SELECT AVG(Rating) FROM Reviews_Ratings WHERE Rider = NEW.Rider)
    WHERE Rider_ID = NEW.Rider;
END //

DELIMITER ;

DELIMITER //

CREATE EVENT IF NOT EXISTS UpdateRideStatus
ON SCHEDULE EVERY 1 MINUTE
STARTS '2024-05-05 18:58:38'
DO
    BEGIN
        UPDATE Ride
        SET Trip_Status = 'In Progress'
        WHERE Date_Time_Of_Ride <= NOW() AND Trip_Status = 'not started';
    END //

DELIMITER ;
