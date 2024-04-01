CREATE TABLE
    doctor (
        DocID INT PRIMARY KEY AUTO_INCREMENT,
        Name VARCHAR(50) NOT NULL,
        Designation VARCHAR(50),
        Specialisation VARCHAR(50),
        PhoneNo VARCHAR(15),
        Location VARCHAR(50)
    );

-- Inserting a general practitioner
INSERT INTO
    doctor (
        Name,
        Designation,
        Specialisation,
        PhoneNo,
        Location
    )
VALUES
    (
        'Dr. John Smith',
        'General Practitioner',
        'Family Medicine',
        '123-456-7890',
        'New York'
    );

-- Inserting a cardiologist
INSERT INTO
    doctor (
        Name,
        Designation,
        Specialisation,
        PhoneNo,
        Location
    )
VALUES
    (
        'Dr. Emily Johnson',
        'Cardiologist',
        'Cardiology',
        '987-654-3210',
        'Los Angeles'
    );

-- Inserting an orthopedic surgeon
INSERT INTO
    doctor (
        Name,
        Designation,
        Specialisation,
        PhoneNo,
        Location
    )
VALUES
    (
        'Dr. Michael Brown',
        'Orthopedic Surgeon',
        'Orthopedics',
        '555-123-4567',
        'Chicago'
    );

-- Inserting a pediatrician
INSERT INTO
    doctor (
        Name,
        Designation,
        Specialisation,
        PhoneNo,
        Location
    )
VALUES
    (
        'Dr. Sarah Lee',
        'Pediatrician',
        'Pediatrics',
        '444-222-3333',
        'Houston'
    );

-- Inserting a psychiatrist
INSERT INTO
    doctor (
        Name,
        Designation,
        Specialisation,
        PhoneNo,
        Location
    )
VALUES
    (
        'Dr. David Martinez',
        'Psychiatrist',
        'Psychiatry',
        '111-555-7777',
        'Miami'
    );





CREATE TABLE
  patient (
    PatientID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    PhoneNo VARCHAR(15),
    Address VARCHAR(100),
    Age INT,
    Sex VARCHAR(1), -- Assuming M or F
    DoctorID INT, -- Foreign key to doctor table
    CONSTRAINT fk_patient_doctor FOREIGN KEY (DoctorID) REFERENCES doctor (DocID)
  );

 SELECT * FROM patient; 


-- Inserting a patient with assigned doctor
INSERT INTO
  patient (Name, PhoneNo, Address, Age, Sex, DoctorID)
VALUES
  (
    'Alice Johnson',
    '5551234567',
    '123 Main St, New York',
    35,
    'F',
    1
  );

-- Assigned to Dr. John Smith
-- Inserting another patient with assigned doctor
INSERT INTO
  patient (Name, PhoneNo, Address, Age, Sex, DoctorID)
VALUES
  (
    'Bob Smith',
    4449876543,
    '456 Elm St, Los Angeles',
    45,
    'M',
    2
  );

-- Assigned to Dr. Emily Johnson
-- Inserting a patient with another assigned doctor
INSERT INTO
  patient (Name, PhoneNo, Address, Age, Sex, DoctorID)
VALUES
  (
    'Charlie Brown',
    3335557777,
    '789 Oak St, Chicago',
    25,
    'M',
    3
  );

-- Assigned to Dr. Michael Brown
-- Inserting a patient without an assigned doctor yet
INSERT INTO
  patient (Name, PhoneNo, Address, Age, Sex, DoctorID)
VALUES
  (
    'Eva Martinez',
    2223334444,
    '101 Pine St, Houston',
    30,
    'F',
    NULL
  );

-- Inserting another patient without an assigned doctor yet
INSERT INTO
  patient (Name, PhoneNo, Address, Age, Sex, DoctorID)
VALUES
  (
    'Grace Lee',
    1112223333,
    '202 Cedar St, Miami',
    40,
    'F',
    NULL
  );


CREATE TABLE
    bills (
        BillID INT PRIMARY KEY AUTO_INCREMENT,
        PatientName VARCHAR(50) NOT NULL,
        BillNo VARCHAR(20),
        Amount FLOAT
    );

SELECT * FROM bills;
    SELECT * FROM prescription where `PatientID` = 3;


WITH patient_price_per_medicine AS (
    SELECT 
        medicine.Name AS Name,
        medicine.price AS price,
        prescription.`PatientID` AS id,
        prescription.quantity,
        (medicine.price * prescription.quantity) AS price_quantity 
    FROM 
        medicine 
    INNER JOIN 
        prescription ON medicine.`Name` = prescription.`Medication`
    WHERE 
        prescription.`PatientID` = 1
)
SELECT 
    patient_price_per_medicine.id AS patient_id, 
    SUM(patient_price_per_medicine.price_quantity) AS total_price
FROM 
    patient_price_per_medicine;


CREATE TABLE
    department (
        DepartmentID INT PRIMARY KEY AUTO_INCREMENT,
        Name VARCHAR(50) NOT NULL,
        DocID INT, -- Foreign key to doctor table
        CONSTRAINT fk_department_doctor FOREIGN KEY (DocID) REFERENCES doctor (DocID)
    );

    -- Inserting departments with corresponding doctor IDs
INSERT INTO department (Name, DocID) VALUES ('Cardiology', 1);
INSERT INTO department (Name, DocID) VALUES ('Neurology', 2);
INSERT INTO department (Name, DocID) VALUES ('Orthopedics', 3);
INSERT INTO department (Name, DocID) VALUES ('Pediatrics', 4);



CREATE TABLE
    accountant (
        AccountID INT PRIMARY KEY AUTO_INCREMENT,
        Name VARCHAR(50) NOT NULL
    );

CREATE TABLE
    rooms (
        RoomID INT PRIMARY KEY AUTO_INCREMENT,
        Location VARCHAR(50) NOT NULL,
        PatientID INT UNIQUE,
        wardID INT,
        CONSTRAINT fk_room_patient Foreign Key (PatientID) REFERENCES patient (PatientID),
        CONSTRAINT fk_room_ward FOREIGN Key (wardID) REFERENCES ward (wardID)
    );

drop table rooms;



CREATE TABLE
    ward (
        wardID INT PRIMARY KEY AUTO_INCREMENT,
        Name VARCHAR(50) NOT NULL,
        Capacity INT,
        Location VARCHAR(50) NOT NULL
    );

   -- Inserting wards with their details
INSERT INTO ward (Name, Capacity, Location) VALUES ('General Ward', 20, 'East Wing, 3rd Floor');
INSERT INTO ward (Name, Capacity, Location) VALUES ('Intensive Care Unit', 10, 'West Wing, 1st Floor');
INSERT INTO ward (Name, Capacity, Location) VALUES ('Maternity Ward', 15, 'North Wing, 2nd Floor');
 

INSERT into
    rooms (`Location`, `PatientID`, `wardID`)
VALUES
    ('room 101',2, 1);

INSERT into
    rooms (`Location`, `PatientID`, `wardID`)
VALUES
    ('room 102', 3, 1);

INSERT into
    rooms (`Location`, `PatientID`, `wardID`)
VALUES
    ('room 103', 4, 1);

SELECT * from rooms;

select * from ward; 




CREATE TABLE nurse (
    NurseID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    PhoneNo VARCHAR(15),
    Email VARCHAR(100),
    DepartmentID INT,
    WardID INT,
    FOREIGN KEY (DepartmentID) REFERENCES department(DepartmentID),
    FOREIGN KEY (WardID) REFERENCES ward(WardID)
);

-- Inserting nurses with their details
INSERT INTO nurse (Name, PhoneNo, Email, DepartmentID, WardID) VALUES ('Alice Johnson', '123-456-7890', 'alice@example.com', 1, 1);
INSERT INTO nurse (Name, PhoneNo, Email, DepartmentID, WardID) VALUES ('Bob Smith', '987-654-3210', 'bob@example.com', 2, 2);
INSERT INTO nurse (Name, PhoneNo, Email, DepartmentID, WardID) VALUES ('Emily Davis', '555-123-4567', 'emily@example.com', 1, 3);


CREATE TABLE blood_bank (
    BloodID INT PRIMARY KEY AUTO_INCREMENT,
    BloodType VARCHAR(5) NOT NULL,
    Quantity INT NOT NULL,
    ExpiryDate DATE,
    Location VARCHAR(50)
);

-- Inserting blood and blood product information
INSERT INTO blood_bank (BloodType, Quantity, ExpiryDate, Location) VALUES ('A+', 100, '2024-04-30', 'Central Blood Bank');
INSERT INTO blood_bank (BloodType, Quantity, ExpiryDate, Location) VALUES ('O-', 50, '2024-05-15', 'Emergency Department Refrigerator');
INSERT INTO blood_bank (BloodType, Quantity, ExpiryDate, Location) VALUES ('AB+', 75, '2024-04-20', 'Maternity Ward Blood Bank');


CREATE TABLE operation_record (
    OperationID INT PRIMARY KEY AUTO_INCREMENT,
    PatientID INT,
    OperationType VARCHAR(100),
    OperationDate DATETIME,
    SurgeonID INT,
    Notes TEXT,
    FOREIGN KEY (PatientID) REFERENCES patient(PatientID),
    FOREIGN KEY (SurgeonID) REFERENCES doctor(DocID)
);

CREATE TABLE prescription (
    PrescriptionID INT PRIMARY KEY AUTO_INCREMENT,
    PatientID INT,
    DoctorID INT,
    PrescriptionDate DATE,
    Medication VARCHAR(100),
    Dosage VARCHAR(50),
    Instructions TEXT,
    quantity INT,
    FOREIGN KEY (PatientID) REFERENCES patient(PatientID),
    FOREIGN KEY (DoctorID) REFERENCES doctor(DocID)
);

INSERT INTO prescription (PatientID, DoctorID, PrescriptionDate, Medication, Dosage, Instructions,quantity)
VALUES (1, 3, '2024-03-30', 'Amoxicillin', '500mg', 'Take one tablet three times daily with food.',5);

INSERT INTO prescription (PatientID, DoctorID, PrescriptionDate, Medication, Dosage, Instructions,quantity)
VALUES (2, 4, '2024-03-31', 'Lisinopril', '10mg', 'Take one tablet daily in the morning.',3);

INSERT INTO prescription (PatientID, DoctorID, PrescriptionDate, Medication, Dosage, Instructions,quantity)
VALUES (3, 1, '2024-03-28', 'Ibuprofen', '400mg', 'Take two tablets every 6 hours as needed for pain.',1);

INSERT INTO prescription (PatientID, DoctorID, PrescriptionDate, Medication, Dosage, Instructions,quantity)
VALUES (1, 3, '2024-03-28', 'Ibuprofen', '400mg', 'Take two tablets every 6 hours as needed for pain.',1);

select * from prescription;

drop table prescription;

CREATE TABLE
  medicine (
    medicineID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL UNIQUE,
    Description TEXT,
    Manufacturer VARCHAR(100),
    DosageForm VARCHAR(50),
    Strength VARCHAR(50),
    stock int,
    categoryID INT,
    price DECIMAL(10, 2),
    CONSTRAINT unique_medicine_name UNIQUE (Name),
    CONSTRAINT medicine_category FOREIGN KEY (categoryID) REFERENCES medicine_category (id)
  );

drop Table medicine;

INSERT INTO
  medicine (
    Name,
    Description,
    Manufacturer,
    DosageForm,
    Strength,
    stock,
    `categoryID`,
    price
  )
VALUES
  (
    'Amoxicillin',
    'An antibiotic used to treat bacterial infections.',
    'ABC Pharmaceuticals',
    'Capsule',
    '500mg',
    50,
    1,
    40
  );

INSERT INTO
  medicine (
    Name,
    Description,
    Manufacturer,
    DosageForm,
    Strength,
    stock,
    `categoryID`,
    price
  )
VALUES
  (
    'Lisinopril',
    'An ACE inhibitor used to treat high blood pressure and heart failure.',
    'XYZ Pharma',
    'Tablet',
    '10mg',
    40,
    3,
    20
  );

INSERT INTO
  medicine (
    Name,
    Description,
    Manufacturer,
    DosageForm,
    Strength,
    stock,
    `categoryID`,
    price
  )
VALUES
  (
    'Ibuprofen',
    'A nonsteroidal anti-inflammatory drug (NSAID) used to relieve pain, fever, and inflammation.',
    'MediCo',
    'Tablet',
    '400mg',
    35,
    1,
    30
  );

INSERT INTO
  medicine (
    Name,
    Description,
    Manufacturer,
    DosageForm,
    Strength,
    stock,
    `categoryID`,
    price
  )
VALUES
  (
    'crocin',
    'Crocin  helps relieve pain and fever by blocking the release of certain chemical messengers responsible for fever and pain. It is used to treat headaches, migraine, toothaches, sore throats, period (menstrual) pains, arthritis, muscle aches, and the common cold.',
    'AXY Healthcare',
    'Tablet',
    '200mg',
    100,
    1,
    40
  );

SELECT
  *
FROM
  medicine;

drop table medicine;

SELECT
  *
FROM
  medicine
  inner join medicine_category on medicine.categoryID = medicine_category.
  



create table medicine_category
(
  id int PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(50) not NULL,
  Description text not null
)

INSERT into medicine_category (
  `Name`,`Description`
)VALUES(
  "General body care",
  "All frequently common used medicines "
)

INSERT into medicine_category (
  `Name`,`Description`
)VALUES(
  "Eye Care",
  "All Eye related medicines/drops  "
)

INSERT into medicine_category (
  `Name`,`Description`
)VALUES(
  "Critical Care",
  "All Critical operations related medicines  "
)

SELECT * FROM medicine_category;