-- MySQL Database Export
-- Generated: 2025-11-12 09:38:34

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- Table: admins
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `user_type` BIGINT NOT NULL,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(255) NULL,
  `f_name` VARCHAR(255) NOT NULL,
  `m_name` VARCHAR(255) NOT NULL,
  `l_name` VARCHAR(255) NOT NULL,
  `dob` DATE NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `gender` VARCHAR(255) NOT NULL,
  `contact_no` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for admins
INSERT INTO `admins` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (1, 'admin@ckc.edu', 'Admin User', 2, NULL, '$2y$12$pmdBEurJJwPGzQA9aSpwn.5TtyW6JjL.rfXuxnE4wr/2Seql4O44W', NULL, 'Admin', 'System', 'User', '1990-01-01', 'CKC Campus', 'Male', 09123456789, '2025-08-19 04:12:29', '2025-08-19 04:12:29');

-- Table: appointments
DROP TABLE IF EXISTS `appointments`;
CREATE TABLE `appointments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` BIGINT NOT NULL,
  `date` DATE NOT NULL,
  `time` VARCHAR(255) NOT NULL,
  `doc_id` BIGINT NOT NULL,
  `status` VARCHAR(255) NULL DEFAULT 'Pending',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `reason` TEXT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for appointments
INSERT INTO `appointments` (`id`, `patient_id`, `date`, `time`, `doc_id`, `status`, `created_at`, `updated_at`, `reason`) VALUES (1, 3, '2025-08-20', '13:00', 1, 'Confirmed', '2025-08-19 07:41:53', '2025-08-20 07:52:00', NULL);
INSERT INTO `appointments` (`id`, `patient_id`, `date`, `time`, `doc_id`, `status`, `created_at`, `updated_at`, `reason`) VALUES (3, 5, '2025-08-23', '10:00', 1, 'Confirmed', '2025-08-21 05:49:30', '2025-08-21 05:51:07', NULL);
INSERT INTO `appointments` (`id`, `patient_id`, `date`, `time`, `doc_id`, `status`, `created_at`, `updated_at`, `reason`) VALUES (4, 5, '2025-10-31', '14:00', 1, 'Pending', '2025-10-26 23:03:18', '2025-10-26 23:03:18', 'Oh uh ah');

-- Table: cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` VARCHAR(255),
  `value` TEXT NOT NULL,
  `expiration` BIGINT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for cache
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('lyjieme@gmail.com|127.0.0.1:timer', 'i:1755934557;', 1755934557);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('lyjieme@gmail.com|127.0.0.1', 'i:1;', 1755934557);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('admin@ckc.edu|127.0.0.1:timer', 'i:1761563003;', 1761563003);
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('admin@ckc.edu|127.0.0.1', 'i:1;', 1761563003);

-- Table: cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` VARCHAR(255),
  `owner` VARCHAR(255) NOT NULL,
  `expiration` BIGINT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: courses
DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_name` VARCHAR(255) NOT NULL,
  `course_description` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_course_name_unique` (`course_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: dental_examinations
DROP TABLE IF EXISTS `dental_examinations`;
CREATE TABLE `dental_examinations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `teeth_status` TEXT NOT NULL,
  `patient_id` BIGINT NOT NULL,
  `doctor_id` BIGINT NOT NULL,
  `diagnosis` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for dental_examinations
INSERT INTO `dental_examinations` (`id`, `teeth_status`, `patient_id`, `doctor_id`, `diagnosis`, `created_at`, `updated_at`) VALUES (1, '{\"1\":\"healthy\",\"2\":\"healthy\",\"3\":\"cavity\",\"4\":\"healthy\",\"5\":\"healthy\",\"6\":\"healthy\",\"7\":\"healthy\",\"8\":\"healthy\",\"9\":\"healthy\",\"10\":\"healthy\",\"11\":\"healthy\",\"12\":\"healthy\",\"13\":\"healthy\",\"14\":\"healthy\",\"15\":\"healthy\",\"16\":\"healthy\",\"17\":\"healthy\",\"18\":\"healthy\",\"19\":\"healthy\",\"20\":\"healthy\",\"21\":\"healthy\",\"22\":\"healthy\",\"23\":\"healthy\",\"24\":\"healthy\",\"25\":\"healthy\",\"26\":\"healthy\",\"27\":\"healthy\",\"28\":\"healthy\",\"29\":\"healthy\",\"30\":\"healthy\",\"31\":\"healthy\",\"32\":\"healthy\"}', 5, 1, 'test', '2025-10-26 04:35:45', '2025-10-26 04:35:45');

-- Table: doctors
DROP TABLE IF EXISTS `doctors`;
CREATE TABLE `doctors` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT NOT NULL,
  `specialization` VARCHAR(255) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `is_available` BIGINT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for doctors
INSERT INTO `doctors` (`id`, `user_id`, `specialization`, `address`, `is_available`, `created_at`, `updated_at`) VALUES (1, 1, 'spec', 'n1b1', 1, '2025-08-19 07:12:11', '2025-08-19 07:12:11');

-- Table: educational_level
DROP TABLE IF EXISTS `educational_level`;
CREATE TABLE `educational_level` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `level_name` VARCHAR(255) NOT NULL,
  `year_level` BIGINT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for educational_level
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (1, 'Kindergarten', 1, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (2, 'Kindergarten', 2, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (3, 'Kindergarten', 3, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (4, 'Elementary', 1, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (5, 'Elementary', 2, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (6, 'Elementary', 3, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (7, 'Elementary', 4, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (8, 'Elementary', 5, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (9, 'Elementary', 6, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (10, 'Junior High', 7, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (11, 'Junior High', 8, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (12, 'Junior High', 9, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (13, 'Junior High', 10, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (14, 'Senior High', 11, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (15, 'Senior High', 12, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (16, 'College', 1, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (17, 'College', 2, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (18, 'College', 3, '2025-08-19 07:16:49', '2025-08-19 07:16:49');
INSERT INTO `educational_level` (`id`, `level_name`, `year_level`, `created_at`, `updated_at`) VALUES (19, 'College', 4, '2025-08-19 07:16:49', '2025-08-19 07:16:49');

-- Table: failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` TEXT NOT NULL,
  `exception` TEXT NOT NULL,
  `failed_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: health_records
DROP TABLE IF EXISTS `health_records`;
CREATE TABLE `health_records` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `user_id` BIGINT NULL,
  `patient_id` BIGINT NULL,
  `diagnosis` TEXT NULL,
  `symptoms` TEXT NULL,
  `treatment` TEXT NULL,
  `notes` TEXT NULL,
  `date_recorded` DATE NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: immunization_records
DROP TABLE IF EXISTS `immunization_records`;
CREATE TABLE `immunization_records` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `vaccine_name` VARCHAR(255) NOT NULL,
  `vaccine_type` VARCHAR(255) NOT NULL,
  `administered_by` VARCHAR(255) NULL,
  `dosage` VARCHAR(255) NOT NULL,
  `site_of_administration` VARCHAR(255) NOT NULL,
  `expiration_date` DATE NOT NULL,
  `notes` VARCHAR(255) NULL,
  `patient_id` BIGINT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for immunization_records
INSERT INTO `immunization_records` (`id`, `vaccine_name`, `vaccine_type`, `administered_by`, `dosage`, `site_of_administration`, `expiration_date`, `notes`, `patient_id`, `created_at`, `updated_at`) VALUES (1, 'Covid', 'mrNA', NULL, '0.5ml', 'Right arm', '2025-10-26', 'Vaccine sa buang', 3, '2025-10-26 04:25:53', '2025-10-26 04:25:53');
INSERT INTO `immunization_records` (`id`, `vaccine_name`, `vaccine_type`, `administered_by`, `dosage`, `site_of_administration`, `expiration_date`, `notes`, `patient_id`, `created_at`, `updated_at`) VALUES (2, 'Hepa', 'inactive', NULL, '1ml', 'Right arm', '2025-10-27', 'Regular', 5, '2025-10-26 22:57:22', '2025-10-26 22:57:22');

-- Table: immunizations
DROP TABLE IF EXISTS `immunizations`;
CREATE TABLE `immunizations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `immunizations_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` VARCHAR(255),
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` BIGINT NOT NULL,
  `pending_jobs` BIGINT NOT NULL,
  `failed_jobs` BIGINT NOT NULL,
  `failed_job_ids` TEXT NOT NULL,
  `options` TEXT NULL,
  `cancelled_at` BIGINT NULL,
  `created_at` BIGINT NOT NULL,
  `finished_at` BIGINT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` TEXT NOT NULL,
  `attempts` BIGINT NOT NULL,
  `reserved_at` BIGINT NULL,
  `available_at` BIGINT NOT NULL,
  `created_at` BIGINT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: medical_records
DROP TABLE IF EXISTS `medical_records`;
CREATE TABLE `medical_records` (
  `medical_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `patient_id` BIGINT NOT NULL,
  `staff_id` BIGINT NOT NULL,
  `date_of_consultation` DATE NOT NULL,
  `reason_for_consultation` VARCHAR(255) NOT NULL,
  `diagnosis` VARCHAR(255) NOT NULL,
  `prescription` VARCHAR(255) NOT NULL,
  `follow_up_appointment` DATE NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`medical_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: medicine
DROP TABLE IF EXISTS `medicine`;
CREATE TABLE `medicine` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `quantity` VARCHAR(255) NOT NULL,
  `expiration_date` DATE NOT NULL,
  `medicine_type` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NULL DEFAULT 'Active',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for medicine
INSERT INTO `medicine` (`id`, `name`, `description`, `quantity`, `expiration_date`, `medicine_type`, `status`, `created_at`, `updated_at`) VALUES (1, 'Neozep', 'Gamot sa Sipon', 100, '2027-10-27', 'Anti', 'Active', '2025-10-27 11:09:03', '2025-10-27 11:09:03');

-- Table: migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` BIGINT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for migrations
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2024_09_28_084702_students', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2024_09_28_093620_year', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2024_09_28_100926_staff', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2024_09_28_101853_medical_records', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8, '2024_09_28_103209_medicine', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9, '2024_10_13_143416_create_admins_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10, '2024_10_17_122523_create_appointments_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11, '2024_10_17_154747_create_health_records_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12, '2024_10_18_025647_create_immunizations_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13, '2024_10_18_033556_create_courses_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14, '2024_10_20_145027_create_doctors_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15, '2024_10_20_145920_create_patients_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16, '2024_10_20_150336_create_reports_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17, '2024_10_31_105053_educational_level', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18, '2024_10_31_123637_create_dental_examinations_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19, '2024_10_31_125602_create_physical_examinations_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20, '2024_10_31_125923_create_immunization_records_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21, '2024_10_31_133553_create_prescription_records_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22, '2025_08_20_082010_add_columns_to_health_records_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23, '2025_08_21_032746_make_school_id_nullable_in_patients_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24, '2025_08_21_034058_make_edulvl_id_nullable_in_patients_table', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25, '2025_10_14_073250_update_physical_examinations_table_use_patient_id', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26, '2025_10_26_230011_add_reason_to_appointments_table', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27, '2024_10_31_200000_add_fields_to_prescription_records_table', 6);

-- Table: password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255),
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: patients
DROP TABLE IF EXISTS `patients`;
CREATE TABLE `patients` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `school_id` VARCHAR(255) NULL,
  `patient_type` BIGINT NOT NULL,
  `edulvl_id` BIGINT NULL,
  `user_id` BIGINT NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `medical_condition` VARCHAR(255) NOT NULL,
  `medical_illness` VARCHAR(255) NOT NULL,
  `operations` VARCHAR(255) NOT NULL,
  `allergies` VARCHAR(255) NOT NULL,
  `emergency_contact_name` VARCHAR(255) NOT NULL,
  `emergency_contact_number` VARCHAR(255) NOT NULL,
  `emergency_relationship` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for patients
INSERT INTO `patients` (`id`, `school_id`, `patient_type`, `edulvl_id`, `user_id`, `address`, `medical_condition`, `medical_illness`, `operations`, `allergies`, `emergency_contact_name`, `emergency_contact_number`, `emergency_relationship`, `created_at`, `updated_at`) VALUES (3, 125, 1, 2, 6, 'kjhvkhjv', 'jbjgj', 'bljblj', 'iugiuygi', 'khjkj', 'kjbljk', 6464, 'khjvbkl', '2025-08-19 07:22:36', '2025-08-19 07:22:36');
INSERT INTO `patients` (`id`, `school_id`, `patient_type`, `edulvl_id`, `user_id`, `address`, `medical_condition`, `medical_illness`, `operations`, `allergies`, `emergency_contact_name`, `emergency_contact_number`, `emergency_relationship`, `created_at`, `updated_at`) VALUES (5, NULL, 'student', NULL, 3, 'Edit', 'n', 'n', 'n', 'n', 1, 1, 'Sibling', '2025-08-21 03:42:05', '2025-10-26 22:58:08');
INSERT INTO `patients` (`id`, `school_id`, `patient_type`, `edulvl_id`, `user_id`, `address`, `medical_condition`, `medical_illness`, `operations`, `allergies`, `emergency_contact_name`, `emergency_contact_number`, `emergency_relationship`, `created_at`, `updated_at`) VALUES (6, 2, 1, 12, 4, 'aa', 'sda', 'daasd', 'sdasa', 'sdas', 'dsa', 121, 'aaa', '2025-08-21 05:44:55', '2025-08-21 05:44:55');
INSERT INTO `patients` (`id`, `school_id`, `patient_type`, `edulvl_id`, `user_id`, `address`, `medical_condition`, `medical_illness`, `operations`, `allergies`, `emergency_contact_name`, `emergency_contact_number`, `emergency_relationship`, `created_at`, `updated_at`) VALUES (7, NULL, 'student', NULL, 2, '47 purok 2 ne', 'Lozartan', 'N/A', 'Apendicitis', 'Chocolate', 'Emergency', 09658309499, 'Guardian', '2025-10-05 03:35:45', '2025-10-05 03:35:45');

-- Table: physical_examinations
DROP TABLE IF EXISTS `physical_examinations`;
CREATE TABLE `physical_examinations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `height` VARCHAR(255) NOT NULL,
  `weight` VARCHAR(255) NOT NULL,
  `heart` VARCHAR(255) NOT NULL,
  `lungs` VARCHAR(255) NOT NULL,
  `eyes` VARCHAR(255) NOT NULL,
  `ears` VARCHAR(255) NOT NULL,
  `nose` VARCHAR(255) NOT NULL,
  `throat` VARCHAR(255) NOT NULL,
  `skin` VARCHAR(255) NOT NULL,
  `bp` VARCHAR(255) NOT NULL,
  `remarks` VARCHAR(255) NOT NULL,
  `patient_id` BIGINT NOT NULL,
  `doctor_id` BIGINT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for physical_examinations
INSERT INTO `physical_examinations` (`id`, `height`, `weight`, `heart`, `lungs`, `eyes`, `ears`, `nose`, `throat`, `skin`, `bp`, `remarks`, `patient_id`, `doctor_id`, `created_at`, `updated_at`) VALUES (1, 170, 65, 're', 'clear', 'clear', 'clear', 'clear', 'clear', 'clear', 12, 'clear', 6, 1, '2025-10-26 05:28:32', '2025-10-26 05:28:32');
INSERT INTO `physical_examinations` (`id`, `height`, `weight`, `heart`, `lungs`, `eyes`, `ears`, `nose`, `throat`, `skin`, `bp`, `remarks`, `patient_id`, `doctor_id`, `created_at`, `updated_at`) VALUES (2, 170, 65, 'Regular', 'Regular', 'Regular', 'Regular', 'Regular', 'Regular', 'Regular', '120/80', 'Regular', 3, 1, '2025-10-26 22:56:53', '2025-10-26 22:56:53');
INSERT INTO `physical_examinations` (`id`, `height`, `weight`, `heart`, `lungs`, `eyes`, `ears`, `nose`, `throat`, `skin`, `bp`, `remarks`, `patient_id`, `doctor_id`, `created_at`, `updated_at`) VALUES (3, 170, 65, 'john', 'john', 'john', 'john', 'john', 'john', 'john', 120, 'john', 5, 1, '2025-10-27 10:02:59', '2025-10-27 10:02:59');

-- Table: prescription_records
DROP TABLE IF EXISTS `prescription_records`;
CREATE TABLE `prescription_records` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dosage` VARCHAR(255) NOT NULL,
  `instruction` VARCHAR(255) NOT NULL,
  `patient_id` BIGINT NOT NULL,
  `doctor_id` BIGINT NOT NULL,
  `medicine_id` BIGINT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  `frequency` VARCHAR(255) NULL,
  `duration` VARCHAR(255) NULL,
  `date_prescribed` DATE NULL,
  `date_discontinued` DATE NULL,
  `status` VARCHAR(255) NULL DEFAULT 'active',
  `discontinuation_reason` TEXT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for prescription_records
INSERT INTO `prescription_records` (`id`, `dosage`, `instruction`, `patient_id`, `doctor_id`, `medicine_id`, `created_at`, `updated_at`, `frequency`, `duration`, `date_prescribed`, `date_discontinued`, `status`, `discontinuation_reason`) VALUES (1, '500mg', 'with water', 5, 1, 1, '2025-10-27 20:01:19', '2025-10-27 20:01:19', 3, 7, '2025-10-27', NULL, 'active', NULL);

-- Table: reports
DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` VARCHAR(255),
  `user_id` BIGINT NULL,
  `ip_address` VARCHAR(255) NULL,
  `user_agent` TEXT NULL,
  `payload` TEXT NOT NULL,
  `last_activity` BIGINT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for sessions
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('gka1wqFMCwQgKLpJ7By6IiDC7qLfWjDLo1gBcKSi', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUkVCQWdkRVdYOGswNHQ4WlZUcGs0azg4VEdJRFhtSkRGNmd5aTRsNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kb2N0b3IvcGF0aWVudHMvNSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1761595293);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('kFRYXnvwfy0BBmgrzicpisHTjkY7hTaZThSYGtNk', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQnpyVVE3MWxXWjRVbmtRaFZCZUFnMnh4aUY0VWprenM2NmprSTBMbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hcHBvaW50bWVudHMvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1761595473);
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('DVdSkMAUSCsyuUgxhPvCoNG9uK2XprkenOy7FwWu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZW4wTjhTeXcyaUswSFF6dFcyOHlQdzQ0aVpmcWNYNUZUdWdEZjA4cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762925802);

-- Table: staff
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `staff_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `age` BIGINT NOT NULL,
  `sex` BIGINT NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `contact_number` VARCHAR(255) NOT NULL,
  `position` VARCHAR(255) NOT NULL,
  `work_experience` BIGINT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: students
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `students_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `middle_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `age` BIGINT NOT NULL,
  `gender` VARCHAR(255) NOT NULL,
  `course_id` BIGINT NOT NULL,
  `year_id` BIGINT NOT NULL,
  `user_id` BIGINT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`students_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: users
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `user_type` BIGINT NOT NULL,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(255) NULL,
  `f_name` VARCHAR(255) NOT NULL,
  `m_name` VARCHAR(255) NOT NULL,
  `l_name` VARCHAR(255) NOT NULL,
  `dob` DATE NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `gender` VARCHAR(255) NOT NULL,
  `contact_no` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data for users
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (1, 'doctor@ckc.edu', 'Dr. John Smith', 3, '2025-08-19 04:12:29', '$2y$12$Af2m.bNxwMBCV6Wi970EmO62/kP2aYPFqNIQWgEKWHYqZgxYat486', 'oxQphwAy7RWoozysM8qiaVZI8Cmx3JlOB0BBLigJRnF27NvNQ4Ja4NBJj9ik', 'John', 'Medical', 'Smith', '1985-05-15', 'CKC Medical Center', 'Male', 09123456790, '2025-08-19 04:12:29', '2025-08-19 04:12:29');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (2, 'staff@ckc.edu', 'Jane Staff', 2, '2025-08-19 04:12:29', '$2y$12$DZvTTVpzHUWnKdRz/gO2XOKMiaxTvlCkTL6TibTSBeHtuGq6cOzQi', 'nAKNnWiytO', 'Jane', 'Office', 'Staff', '1992-08-20', 'CKC Administration', 'Female', 09123456791, '2025-08-19 04:12:29', '2025-08-19 04:12:29');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (3, 'student@ckc.edu', 'John Student', 1, '2025-08-19 04:12:30', '$2y$12$OZiKmdxkQXjy/pFTlMV7dujsSufAbwCn1qUKwlL6CPZ8wsOH3l0Rq', 'Z5LfiHnUA7nphPrXosZ9vwGrRlWwHjKXT3gxoE4GShsHEHPH9hlWE1VIEiEC', 'John', 'Academic', 'Student', '2000-12-10', 'CKC Dormitory', 'Male', 09123456792, '2025-08-19 04:12:30', '2025-08-19 04:12:30');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (4, 'ernestine01@example.org', 'Art Eloy Dooley', 2, '2025-08-19 04:12:30', '$2y$12$sM28E3Lan1Y6is7sbAAMxe0VwBqmioxmo4aHu7kNsiVot3VbT8XbW', 'nXiVmMsKn0', 'Art', 'Eloy', 'Dooley', '1973-02-02', '160 Marquise Well Apt. 876
South Ivaborough, NY 97080-7241', 'Female', '414-499-0482', '2025-08-19 04:12:30', '2025-08-19 04:12:30');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (5, 'natasha20@example.com', 'Oral Immanuel Greenfelder', 3, '2025-08-19 04:12:30', '$2y$12$sM28E3Lan1Y6is7sbAAMxe0VwBqmioxmo4aHu7kNsiVot3VbT8XbW', 'uYTZ9t2KIJ', 'Oral', 'Immanuel', 'Greenfelder', '1979-12-29', '12531 Laury Run
West Liam, OH 61192-3755', 'Male', '+1.248.857.6629', '2025-08-19 04:12:30', '2025-08-19 04:12:30');
INSERT INTO `users` (`id`, `email`, `name`, `user_type`, `email_verified_at`, `password`, `remember_token`, `f_name`, `m_name`, `l_name`, `dob`, `address`, `gender`, `contact_no`, `created_at`, `updated_at`) VALUES (6, 'dolores.schmidt@example.com', 'Anahi Trinity Gislason', 1, '2025-08-19 04:12:30', '$2y$12$sM28E3Lan1Y6is7sbAAMxe0VwBqmioxmo4aHu7kNsiVot3VbT8XbW', 'YHwtGoP18R', 'Anahi', 'Trinity', 'Gislason', '1983-07-03', '19078 Elinore Station
North Jackyborough, AR 92386-6429', 'Female', '+1-325-462-9206', '2025-08-19 04:12:30', '2025-08-19 04:12:30');

-- Table: year
DROP TABLE IF EXISTS `year`;
CREATE TABLE `year` (
  `year_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `year_level` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
