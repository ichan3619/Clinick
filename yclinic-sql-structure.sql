CREATE TABLE address (
  AddressID bigint(20) NOT NULL AUTO_INCREMENT,
  Barangay varchar(255) DEFAULT NULL,
  City varchar(100) DEFAULT NULL,
  Province varchar(100) DEFAULT NULL,
  PRIMARY KEY (AddressID)
);

CREATE TABLE campus_table (
  campusID int(11) NOT NULL AUTO_INCREMENT,
  campus_name varchar(100) DEFAULT NULL,
  PRIMARY KEY (campusID),
  CONSTRAINT campus CHECK (campus_name in ('Ellida','Marciano'))
);

CREATE TABLE clinicstaff_name (
  Name_Id int(11) NOT NULL AUTO_INCREMENT,
  EmployeeLName varchar(20) NOT NULL,
  EmployeeFName varchar(20) NOT NULL,
  EmployeeMName varchar(20) DEFAULT NULL,
  EmployeeSufix varchar(20) DEFAULT NULL,
  PRIMARY KEY (Name_Id),
  UNIQUE KEY unique_employee (EmployeeLName,EmployeeFName,EmployeeMName,EmployeeSufix)
);

CREATE TABLE clinicstaff_info (
  Info_Id int(11) NOT NULL AUTO_INCREMENT,
  ContactNum varchar(15) DEFAULT NULL,
  BDate date NOT NULL,
  Emp_Gender varchar(10) DEFAULT NULL,
  clinic_roles varchar(20) DEFAULT NULL,
  Name_Id int(11) DEFAULT NULL,
  PRIMARY KEY (Info_Id),
  UNIQUE KEY ContactNum (ContactNum),
  KEY Name_Id (Name_Id),
  CONSTRAINT clinicstaff_info_ibfk_1 FOREIGN KEY (Name_Id) REFERENCES clinicstaff_name (Name_Id),
  CONSTRAINT roles CHECK (clinic_roles in ('Doctor','Nurse','Clinic Staff')),
  CONSTRAINT gender CHECK (Emp_Gender in ('MALE','FEMALE'))
);

CREATE TABLE patient_positions (
  position_id tinyint(4) NOT NULL AUTO_INCREMENT,
  position_name varchar(50) DEFAULT NULL,
  PRIMARY KEY (position_id),
  CONSTRAINT position CHECK (position_name in ('Student','Staff','Faculty'))
);

CREATE TABLE patient_departments (
  depID bigint(20) NOT NULL AUTO_INCREMENT,
  dep_name varchar(100) NOT NULL,
  position_id tinyint(4) NOT NULL,
  PRIMARY KEY (depID),
  KEY position_id (position_id),
  CONSTRAINT patient_departments_ibfk_1 FOREIGN KEY (position_id) REFERENCES patient_positions (position_id)
);

CREATE TABLE patient_name (
  PatientName_Id int(11) NOT NULL AUTO_INCREMENT,
  PatientLName varchar(20) NOT NULL,
  PatientFName varchar(20) NOT NULL,
  PatientMName varchar(20) DEFAULT NULL,
  PatientSufix varchar(20) DEFAULT NULL,
  PRIMARY KEY (PatientName_Id),
  UNIQUE KEY unique_employee (PatientLName,PatientFName,PatientMName,PatientSufix)
);

CREATE TABLE patient_info (
  PatientInfo_Id int(11) NOT NULL AUTO_INCREMENT,
  age int(11) DEFAULT NULL,
  Patient_ContactNum varchar(30) DEFAULT NULL,
  emergencyContact varchar(30) DEFAULT NULL,
  Patient_BDate date NOT NULL,
  Patient_Gender varchar(10) DEFAULT NULL,
  position_id tinyint(4) DEFAULT NULL,
  depID bigint(20) DEFAULT NULL,
  PatientName_Id int(11) DEFAULT NULL,
  PRIMARY KEY (PatientInfo_Id),
  UNIQUE KEY Patient_ContactNum (Patient_ContactNum,emergencyContact),
  KEY PatientName_Id (PatientName_Id),
  KEY position_id (position_id),
  KEY depID (depID),
  CONSTRAINT patient_info_ibfk_1 FOREIGN KEY (PatientName_Id) REFERENCES patient_name (PatientName_Id),
  CONSTRAINT patient_info_ibfk_2 FOREIGN KEY (position_id) REFERENCES patient_positions (position_id),
  CONSTRAINT patient_info_ibfk_3 FOREIGN KEY (depID) REFERENCES patient_departments (depID),
  CONSTRAINT PGender CHECK (Patient_Gender in ('MALE','FEMALE'))
);

CREATE TABLE user_account (
  ID_Acc int(11) NOT NULL AUTO_INCREMENT,
  clinic_Email varchar(255) NOT NULL,
  clinic_Password varchar(100) NOT NULL,
  account_roles enum('Patient','Admin','ClinicStaff') DEFAULT 'Admin',
  name varchar(100) DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (ID_Acc),
  UNIQUE KEY clinic_Email (clinic_Email)
);

-- idadagdag / to be added -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

-- Meron na nito sa taas eh, nilagay ko lang kasi magkaiba ng structure; kaso need mag lagay ng emergency contact info table, 
CREATE TABLE patientsInfo (
    patientID INT PRIMARY KEY AUTO_INCREMENT,
    campusID VARCHAR(100),
    firstName VARCHAR(100),
    lastName VARCHAR(100),
    birthDate DATE,
    age INT,
    address VARCHAR(500),
    contactNo VARCHAR(20),
    departmentID BIGINT,
    emergencyContact VARCHAR(100), -- pag may emergency contact info table na, magiging reference na to via ID
    emergencyContactNo VARCHAR(20), -- same dito
    FOREIGN KEY (departmentID) REFERENCES patient_departments(id)
);

CREATE TABLE consultReq (
    consultID INT PRIMARY KEY AUTO_INCREMENT,
    patientID INT,
    department VARCHAR(100),
    consultationType VARCHAR(100),
    campus ENUM('Marciano', 'Elida') NOT NULL,
    mode ENUM('Personal', 'Online'),
    consultationDate DATE,
    reason TEXT,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (patientID) REFERENCES patientsInfo(patientID)
);

CREATE TABLE consultationSummary (
    summaryID INT PRIMARY KEY AUTO_INCREMENT,
    consultID INT,
    summary TEXT,
    diagnosis TEXT,
    recommendations TEXT,
    summaryDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (consultID) REFERENCES consultReq(consultID)
);

-- imbis na imerge lahat ng staffs, doctors, nurses sa isang table (Clinicstaffs -- yung nasa taas na table), tingin ko maganda kung hiwahiwalay nalang, staffs table, doctors table, nurses table pero di pa ko sure don.
CREATE TABLE doctors (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    department_id BIGINT NOT NULL,
    user_id BIGINT NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    address_id BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES patient_departments(id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (address_id) REFERENCES addresses(id) ON DELETE SET NULL
);

CREATE TABLE appointments (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id BIGINT NOT NULL,
    dept_id BIGINT NOT NULL,
    appointment_date DATETIME NOT NULL,
    reason_of_visit VARCHAR(255) NOT NULL,
    type_of_admission VARCHAR(255) NOT NULL,
    status ENUM('Scheduled', 'Completed', 'Cancelled', 'No-show') NOT NULL DEFAULT 'Scheduled',
    cancel_reason VARCHAR(255),
    link VARCHAR(512),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patientsInfo(patientID) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
    FOREIGN KEY (dept_id) REFERENCES patient_departments(id) ON DELETE CASCADE,
    INDEX idx_appointment_date (appointment_date),
    INDEX idx_patient_doctor (patient_id, doctor_id)
);