-- testing para sa patientsList
INSERT INTO patient_positions (position_id, position_name) VALUES
(1, 'Student'),
(2, 'Staff'),
(3, 'Faculty');

INSERT INTO patient_departments (depID, dep_name, position_id) VALUES
(1, 'CCS', 1),
(2, 'CHS', 2),
(3, 'MARINE', 3),
(4, 'CAS', 1),
(5, 'NURSING', 2);

INSERT INTO patient_name (PatientName_Id, PatientLName, PatientFName, PatientMName, PatientSufix) VALUES
(1, 'Chang', 'Megan', 'R.', 'III'),
(2, 'Bowman', 'Leslie', 'J.', 'III'),
(3, 'Flores', 'Christopher', 'W.', NULL),
(4, 'Douglas', 'Chloe', 'T.', NULL),
(5, 'Matthews', 'Darrell', NULL, NULL);

INSERT INTO patient_name (PatientName_Id, PatientLName, PatientFName, PatientMName, PatientSufix) VALUES
(1, 'Chang', 'Megan', 'R.', 'III'),
(2, 'Bowman', 'Leslie', 'J.', 'III'),
(3, 'Flores', 'Christopher', 'W.', NULL),
(4, 'Douglas', 'Chloe', 'T.', NULL),
(5, 'Matthews', 'Darrell', NULL, NULL);

INSERT INTO patient_info (PatientInfo_Id, age, Patient_ContactNum, emergencyContact, Patient_BDate, Patient_Gender, position_id, depID, PatientName_Id) VALUES
(1, 20, '876-475-9382x421', '+1-489-241-1578x156', '2005-01-02', 'FEMALE', 1, 5, 1),
(2, 31, '+1-778-408-0160', '+1-753-513-9332x871', '1993-09-01', 'MALE', 1, 2, 2),
(3, 34, '148.418.5839x8947', '965-934-2320', '1990-08-19', 'MALE', 3, 2, 3),
(4, 39, '220-186-8483', '969.477.5159', '1985-09-20', 'MALE', 1, 5, 4),
(5, 31, '330-413-5256x01230', '001-891-013-9916', '1993-08-08', 'FEMALE', 3, 5, 5);