-- MySQL Database Export
-- Generated: 2025-11-12 09:26:25
-- Database: CKC Clinic System

SET FOREIGN_KEY_CHECKS=0;

-- Table: users
TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (1, 'doctor@ckc.edu', 'Dr. John Smith', 3, '2025-08-19 04:12:29', '$2y$12$Af2m.bNxwMBCV6Wi970EmO62/kP2aYPFqNIQWgEKWHYqZgxYat486', 'oxQphwAy7RWoozysM8qiaVZI8Cmx3JlOB0BBLigJRnF27NvNQ4Ja4NBJj9ik', 'John', 'Medical', 'Smith', '1985-05-15', 'CKC Medical Center', 'Male', 09123456790, '2025-08-19 04:12:29', '2025-08-19 04:12:29');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (2, 'staff@ckc.edu', 'Jane Staff', 2, '2025-08-19 04:12:29', '$2y$12$DZvTTVpzHUWnKdRz/gO2XOKMiaxTvlCkTL6TibTSBeHtuGq6cOzQi', 'nAKNnWiytO', 'Jane', 'Office', 'Staff', '1992-08-20', 'CKC Administration', 'Female', 09123456791, '2025-08-19 04:12:29', '2025-08-19 04:12:29');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (3, 'student@ckc.edu', 'John Student', 1, '2025-08-19 04:12:30', '$2y$12$OZiKmdxkQXjy/pFTlMV7dujsSufAbwCn1qUKwlL6CPZ8wsOH3l0Rq', 'Z5LfiHnUA7nphPrXosZ9vwGrRlWwHjKXT3gxoE4GShsHEHPH9hlWE1VIEiEC', 'John', 'Academic', 'Student', '2000-12-10', 'CKC Dormitory', 'Male', 09123456792, '2025-08-19 04:12:30', '2025-08-19 04:12:30');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (4, 'ernestine01@example.org', 'Art Eloy Dooley', 2, '2025-08-19 04:12:30', '$2y$12$sM28E3Lan1Y6is7sbAAMxe0VwBqmioxmo4aHu7kNsiVot3VbT8XbW', 'nXiVmMsKn0', 'Art', 'Eloy', 'Dooley', '1973-02-02', '160 Marquise Well Apt. 876
South Ivaborough, NY 97080-7241', 'Female', '414-499-0482', '2025-08-19 04:12:30', '2025-08-19 04:12:30');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (5, 'natasha20@example.com', 'Oral Immanuel Greenfelder', 3, '2025-08-19 04:12:30', '$2y$12$sM28E3Lan1Y6is7sbAAMxe0VwBqmioxmo4aHu7kNsiVot3VbT8XbW', 'uYTZ9t2KIJ', 'Oral', 'Immanuel', 'Greenfelder', '1979-12-29', '12531 Laury Run
West Liam, OH 61192-3755', 'Male', '+1.248.857.6629', '2025-08-19 04:12:30', '2025-08-19 04:12:30');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (6, 'dolores.schmidt@example.com', 'Anahi Trinity Gislason', 1, '2025-08-19 04:12:30', '$2y$12$sM28E3Lan1Y6is7sbAAMxe0VwBqmioxmo4aHu7kNsiVot3VbT8XbW', 'YHwtGoP18R', 'Anahi', 'Trinity', 'Gislason', '1983-07-03', '19078 Elinore Station
North Jackyborough, AR 92386-6429', 'Female', '+1-325-462-9206', '2025-08-19 04:12:30', '2025-08-19 04:12:30');

-- Table: admins
TRUNCATE TABLE `admins`;
INSERT INTO `admins` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (1, 'admin@ckc.edu', 'Admin User', 2, NULL, '$2y$12$pmdBEurJJwPGzQA9aSpwn.5TtyW6JjL.rfXuxnE4wr/2Seql4O44W', NULL, 'Admin', 'System', 'User', '1990-01-01', 'CKC Campus', 'Male', 09123456789, '2025-08-19 04:12:29', '2025-08-19 04:12:29');

-- Table: patients
TRUNCATE TABLE `patients`;
INSERT INTO `patients` (`id`, `school_id`, `patient_type`, `edulvl_id`, `user_id`, `address`, `medical_condition`, `medical_illness`, `operations`, `allergies`, `emergency_contact_name`, `emergency_contact_number`, `emergency_relationship`, `created_at`, `updated_at`) VALUES (3, 125, 1, 2, 6, 'kjhvkhjv', 'jbjgj', 'bljblj', 'iugiuygi', 'khjkj', 'kjbljk', 6464, 'khjvbkl', '2025-08-19 07:22:36', '2025-08-19 07:22:36');
INSERT INTO `patients` (`id`, `school_id`, `patient_type`, `edulvl_id`, `user_id`, `address`, `medical_condition`, `medical_illness`, `operations`, `allergies`, `emergency_contact_name`, `emergency_contact_number`, `emergency_relationship`, `created_at`, `updated_at`) VALUES (5, NULL, 'student', NULL, 3, 'Edit', 'n', 'n', 'n', 'n', 1, 1, 'Sibling', '2025-08-21 03:42:05', '2025-10-26 22:58:08');
INSERT INTO `patients` (`id`, `school_id`, `patient_type`, `edulvl_id`, `user_id`, `address`, `medical_condition`, `medical_illness`, `operations`, `allergies`, `emergency_contact_name`, `emergency_contact_number`, `emergency_relationship`, `created_at`, `updated_at`) VALUES (6, 2, 1, 12, 4, 'aa', 'sda', 'daasd', 'sdasa', 'sdas', 'dsa', 121, 'aaa', '2025-08-21 05:44:55', '2025-08-21 05:44:55');
INSERT INTO `patients` (`id`, `school_id`, `patient_type`, `edulvl_id`, `user_id`, `address`, `medical_condition`, `medical_illness`, `operations`, `allergies`, `emergency_contact_name`, `emergency_contact_number`, `emergency_relationship`, `created_at`, `updated_at`) VALUES (7, NULL, 'student', NULL, 2, '47 purok 2 ne', 'Lozartan', 'N/A', 'Apendicitis', 'Chocolate', 'Emergency', 09658309499, 'Guardian', '2025-10-05 03:35:45', '2025-10-05 03:35:45');

-- Table: doctors
TRUNCATE TABLE `doctors`;
INSERT INTO `doctors` (`id`, `user_id`, `specialization`, `address`, `is_available`, `created_at`, `updated_at`) VALUES (1, 1, 'spec', 'n1b1', 1, '2025-08-19 07:12:11', '2025-08-19 07:12:11');

-- Table: appointments
TRUNCATE TABLE `appointments`;
INSERT INTO `appointments` (`id`, `patient_id`, `date`, `time`, `doc_id`, `status`, `created_at`, `updated_at`, `reason`) VALUES (1, 3, '2025-08-20', '13:00', 1, 'Confirmed', '2025-08-19 07:41:53', '2025-08-20 07:52:00', NULL);
INSERT INTO `appointments` (`id`, `patient_id`, `date`, `time`, `doc_id`, `status`, `created_at`, `updated_at`, `reason`) VALUES (3, 5, '2025-08-23', '10:00', 1, 'Confirmed', '2025-08-21 05:49:30', '2025-08-21 05:51:07', NULL);
INSERT INTO `appointments` (`id`, `patient_id`, `date`, `time`, `doc_id`, `status`, `created_at`, `updated_at`, `reason`) VALUES (4, 5, '2025-10-31', '14:00', 1, 'Pending', '2025-10-26 23:03:18', '2025-10-26 23:03:18', 'Oh uh ah');

-- Table: medicine
TRUNCATE TABLE `medicine`;
INSERT INTO `medicine` (`id`, `name`, `description`, `quantity`, `expiration_date`, `medicine_type`, `status`, `created_at`, `updated_at`) VALUES (1, 'Neozep', 'Gamot sa Sipon', 100, '2027-10-27', 'Anti', 'Active', '2025-10-27 11:09:03', '2025-10-27 11:09:03');

-- Table: prescription_records
TRUNCATE TABLE `prescription_records`;
INSERT INTO `prescription_records` (`id`, `dosage`, `instruction`, `patient_id`, `doctor_id`, `medicine_id`, `created_at`, `updated_at`, `frequency`, `duration`, `date_prescribed`, `date_discontinued`, `status`, `discontinuation_reason`) VALUES (1, '500mg', 'with water', 5, 1, 1, '2025-10-27 20:01:19', '2025-10-27 20:01:19', 3, 7, '2025-10-27', NULL, 'active', NULL);

-- Table: dental_examinations
TRUNCATE TABLE `dental_examinations`;
INSERT INTO `dental_examinations` (`id`, `teeth_status`, `patient_id`, `doctor_id`, `diagnosis`, `created_at`, `updated_at`) VALUES (1, '{\"1\":\"healthy\",\"2\":\"healthy\",\"3\":\"cavity\",\"4\":\"healthy\",\"5\":\"healthy\",\"6\":\"healthy\",\"7\":\"healthy\",\"8\":\"healthy\",\"9\":\"healthy\",\"10\":\"healthy\",\"11\":\"healthy\",\"12\":\"healthy\",\"13\":\"healthy\",\"14\":\"healthy\",\"15\":\"healthy\",\"16\":\"healthy\",\"17\":\"healthy\",\"18\":\"healthy\",\"19\":\"healthy\",\"20\":\"healthy\",\"21\":\"healthy\",\"22\":\"healthy\",\"23\":\"healthy\",\"24\":\"healthy\",\"25\":\"healthy\",\"26\":\"healthy\",\"27\":\"healthy\",\"28\":\"healthy\",\"29\":\"healthy\",\"30\":\"healthy\",\"31\":\"healthy\",\"32\":\"healthy\"}', 5, 1, 'test', '2025-10-26 04:35:45', '2025-10-26 04:35:45');

-- Table: physical_examinations
TRUNCATE TABLE `physical_examinations`;
INSERT INTO `physical_examinations` (`id`, `height`, `weight`, `heart`, `lungs`, `eyes`, `ears`, `nose`, `throat`, `skin`, `bp`, `remarks`, `patient_id`, `doctor_id`, `created_at`, `updated_at`) VALUES (1, 170, 65, 're', 'clear', 'clear', 'clear', 'clear', 'clear', 'clear', 12, 'clear', 6, 1, '2025-10-26 05:28:32', '2025-10-26 05:28:32');
INSERT INTO `physical_examinations` (`id`, `height`, `weight`, `heart`, `lungs`, `eyes`, `ears`, `nose`, `throat`, `skin`, `bp`, `remarks`, `patient_id`, `doctor_id`, `created_at`, `updated_at`) VALUES (2, 170, 65, 'Regular', 'Regular', 'Regular', 'Regular', 'Regular', 'Regular', 'Regular', '120/80', 'Regular', 3, 1, '2025-10-26 22:56:53', '2025-10-26 22:56:53');
INSERT INTO `physical_examinations` (`id`, `height`, `weight`, `heart`, `lungs`, `eyes`, `ears`, `nose`, `throat`, `skin`, `bp`, `remarks`, `patient_id`, `doctor_id`, `created_at`, `updated_at`) VALUES (3, 170, 65, 'john', 'john', 'john', 'john', 'john', 'john', 'john', 120, 'john', 5, 1, '2025-10-27 10:02:59', '2025-10-27 10:02:59');

-- Table: immunization_records
TRUNCATE TABLE `immunization_records`;
INSERT INTO `immunization_records` (`id`, `vaccine_name`, `vaccine_type`, `administered_by`, `dosage`, `site_of_administration`, `expiration_date`, `notes`, `patient_id`, `created_at`, `updated_at`) VALUES (1, 'Covid', 'mrNA', NULL, '0.5ml', 'Right arm', '2025-10-26', 'Vaccine sa buang', 3, '2025-10-26 04:25:53', '2025-10-26 04:25:53');
INSERT INTO `immunization_records` (`id`, `vaccine_name`, `vaccine_type`, `administered_by`, `dosage`, `site_of_administration`, `expiration_date`, `notes`, `patient_id`, `created_at`, `updated_at`) VALUES (2, 'Hepa', 'inactive', NULL, '1ml', 'Right arm', '2025-10-27', 'Regular', 5, '2025-10-26 22:57:22', '2025-10-26 22:57:22');

SET FOREIGN_KEY_CHECKS=1;
