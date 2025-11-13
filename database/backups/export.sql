BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "admins" (
	"id"	integer NOT NULL,
	"email"	varchar NOT NULL,
	"name"	varchar NOT NULL,
	"user_type"	integer NOT NULL,
	"email_verified_at"	datetime,
	"password"	varchar NOT NULL,
	"remember_token"	varchar,
	"f_name"	varchar NOT NULL,
	"m_name"	varchar NOT NULL,
	"l_name"	varchar NOT NULL,
	"dob"	date NOT NULL,
	"address"	varchar NOT NULL,
	"gender"	varchar NOT NULL,
	"contact_no"	varchar NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "appointments" (
	"id"	integer NOT NULL,
	"patient_id"	integer NOT NULL,
	"date"	date NOT NULL,
	"time"	time NOT NULL,
	"doc_id"	integer NOT NULL,
	"status"	varchar NOT NULL DEFAULT 'Pending' CHECK("status" IN ('Pending', 'Confirmed', 'Cancelled')),
	"created_at"	datetime,
	"updated_at"	datetime,
	"reason"	text,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "cache" (
	"key"	varchar NOT NULL,
	"value"	text NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks" (
	"key"	varchar NOT NULL,
	"owner"	varchar NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "courses" (
	"id"	integer NOT NULL,
	"course_name"	varchar NOT NULL,
	"course_description"	varchar,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "dental_examinations" (
	"id"	integer NOT NULL,
	"teeth_status"	text NOT NULL,
	"patient_id"	integer NOT NULL,
	"doctor_id"	integer NOT NULL,
	"diagnosis"	varchar NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("doctor_id") REFERENCES "doctors"("id"),
	FOREIGN KEY("patient_id") REFERENCES "patients"("id")
);
CREATE TABLE IF NOT EXISTS "doctors" (
	"id"	integer NOT NULL,
	"user_id"	integer NOT NULL,
	"specialization"	varchar NOT NULL,
	"address"	varchar NOT NULL,
	"is_available"	tinyint(1) NOT NULL DEFAULT '1',
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("user_id") REFERENCES "users"("id")
);
CREATE TABLE IF NOT EXISTS "educational_level" (
	"id"	integer NOT NULL,
	"level_name"	varchar NOT NULL,
	"year_level"	integer NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "failed_jobs" (
	"id"	integer NOT NULL,
	"uuid"	varchar NOT NULL,
	"connection"	text NOT NULL,
	"queue"	text NOT NULL,
	"payload"	text NOT NULL,
	"exception"	text NOT NULL,
	"failed_at"	datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "health_records" (
	"id"	integer NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	"user_id"	integer,
	"patient_id"	integer,
	"diagnosis"	text,
	"symptoms"	text,
	"treatment"	text,
	"notes"	text,
	"date_recorded"	date,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("patient_id") REFERENCES "patients"("id") on delete cascade,
	FOREIGN KEY("user_id") REFERENCES "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "immunization_records" (
	"id"	integer NOT NULL,
	"vaccine_name"	varchar NOT NULL,
	"vaccine_type"	varchar NOT NULL,
	"administered_by"	varchar,
	"dosage"	varchar NOT NULL,
	"site_of_administration"	varchar NOT NULL,
	"expiration_date"	date NOT NULL,
	"notes"	varchar,
	"patient_id"	integer NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("patient_id") REFERENCES "patients"("id")
);
CREATE TABLE IF NOT EXISTS "immunizations" (
	"id"	integer NOT NULL,
	"name"	varchar NOT NULL,
	"description"	text,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "job_batches" (
	"id"	varchar NOT NULL,
	"name"	varchar NOT NULL,
	"total_jobs"	integer NOT NULL,
	"pending_jobs"	integer NOT NULL,
	"failed_jobs"	integer NOT NULL,
	"failed_job_ids"	text NOT NULL,
	"options"	text,
	"cancelled_at"	integer,
	"created_at"	integer NOT NULL,
	"finished_at"	integer,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "jobs" (
	"id"	integer NOT NULL,
	"queue"	varchar NOT NULL,
	"payload"	text NOT NULL,
	"attempts"	integer NOT NULL,
	"reserved_at"	integer,
	"available_at"	integer NOT NULL,
	"created_at"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "medical_records" (
	"medical_id"	integer NOT NULL,
	"patient_id"	integer NOT NULL,
	"staff_id"	integer NOT NULL,
	"date_of_consultation"	date NOT NULL,
	"reason_for_consultation"	varchar NOT NULL,
	"diagnosis"	varchar NOT NULL,
	"prescription"	varchar NOT NULL,
	"follow_up_appointment"	date,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("medical_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "medicine" (
	"id"	integer NOT NULL,
	"name"	varchar NOT NULL,
	"description"	varchar NOT NULL,
	"quantity"	varchar NOT NULL,
	"expiration_date"	date NOT NULL,
	"medicine_type"	varchar NOT NULL,
	"status"	varchar NOT NULL DEFAULT 'Active' CHECK("status" IN ('Active', 'Expired')),
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "migrations" (
	"id"	integer NOT NULL,
	"migration"	varchar NOT NULL,
	"batch"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "password_reset_tokens" (
	"email"	varchar NOT NULL,
	"token"	varchar NOT NULL,
	"created_at"	datetime,
	PRIMARY KEY("email")
);
CREATE TABLE IF NOT EXISTS "patients" (
	"id"	integer NOT NULL,
	"school_id"	varchar,
	"patient_type"	integer NOT NULL,
	"edulvl_id"	integer,
	"user_id"	integer NOT NULL,
	"address"	varchar NOT NULL,
	"medical_condition"	varchar NOT NULL,
	"medical_illness"	varchar NOT NULL,
	"operations"	varchar NOT NULL,
	"allergies"	varchar NOT NULL,
	"emergency_contact_name"	varchar NOT NULL,
	"emergency_contact_number"	varchar NOT NULL,
	"emergency_relationship"	varchar NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("user_id") REFERENCES "users"("id") on delete no action on update no action
);
CREATE TABLE IF NOT EXISTS "physical_examinations" (
	"id"	integer NOT NULL,
	"height"	varchar NOT NULL,
	"weight"	varchar NOT NULL,
	"heart"	varchar NOT NULL,
	"lungs"	varchar NOT NULL,
	"eyes"	varchar NOT NULL,
	"ears"	varchar NOT NULL,
	"nose"	varchar NOT NULL,
	"throat"	varchar NOT NULL,
	"skin"	varchar NOT NULL,
	"bp"	varchar NOT NULL,
	"remarks"	varchar NOT NULL,
	"patient_id"	integer NOT NULL,
	"doctor_id"	integer NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("doctor_id") REFERENCES "doctors"("id") on delete no action on update no action,
	FOREIGN KEY("patient_id") REFERENCES "patients"("id")
);
CREATE TABLE IF NOT EXISTS "prescription_records" (
	"id"	integer NOT NULL,
	"dosage"	varchar NOT NULL,
	"instruction"	varchar NOT NULL,
	"patient_id"	integer NOT NULL,
	"doctor_id"	integer NOT NULL,
	"medicine_id"	integer NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	"frequency"	varchar,
	"duration"	varchar,
	"date_prescribed"	date,
	"date_discontinued"	date,
	"status"	varchar NOT NULL DEFAULT 'active' CHECK("status" IN ('active', 'discontinued', 'completed')),
	"discontinuation_reason"	text,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("patient_id") REFERENCES "patients"("id")
);
CREATE TABLE IF NOT EXISTS "reports" (
	"id"	integer NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "sessions" (
	"id"	varchar NOT NULL,
	"user_id"	integer,
	"ip_address"	varchar,
	"user_agent"	text,
	"payload"	text NOT NULL,
	"last_activity"	integer NOT NULL,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "staff" (
	"staff_id"	integer NOT NULL,
	"name"	varchar NOT NULL,
	"age"	integer NOT NULL,
	"sex"	integer NOT NULL,
	"date_of_birth"	date NOT NULL,
	"contact_number"	varchar NOT NULL,
	"position"	varchar NOT NULL,
	"work_experience"	integer NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("staff_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "students" (
	"students_id"	integer NOT NULL,
	"first_name"	varchar NOT NULL,
	"middle_name"	varchar NOT NULL,
	"last_name"	varchar NOT NULL,
	"age"	integer NOT NULL,
	"gender"	varchar NOT NULL,
	"course_id"	integer NOT NULL,
	"year_id"	integer NOT NULL,
	"user_id"	integer NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("students_id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "users" (
	"id"	integer NOT NULL,
	"email"	varchar NOT NULL,
	"name"	varchar NOT NULL,
	"user_type"	integer NOT NULL,
	"email_verified_at"	datetime,
	"password"	varchar NOT NULL,
	"remember_token"	varchar,
	"f_name"	varchar NOT NULL,
	"m_name"	varchar NOT NULL,
	"l_name"	varchar NOT NULL,
	"dob"	date NOT NULL,
	"address"	varchar NOT NULL,
	"gender"	varchar NOT NULL,
	"contact_no"	varchar NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "year" (
	"year_id"	integer NOT NULL,
	"year_level"	varchar NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("year_id" AUTOINCREMENT)
);
INSERT INTO "admins" VALUES (1,'admin@ckc.edu','Admin User',2,NULL,'$2y$12$pmdBEurJJwPGzQA9aSpwn.5TtyW6JjL.rfXuxnE4wr/2Seql4O44W',NULL,'Admin','System','User','1990-01-01','CKC Campus','Male','09123456789','2025-08-19 04:12:29','2025-08-19 04:12:29');
INSERT INTO "appointments" VALUES (1,3,'2025-08-20','13:00',1,'Confirmed','2025-08-19 07:41:53','2025-08-20 07:52:00',NULL);
INSERT INTO "appointments" VALUES (3,5,'2025-08-23','10:00',1,'Confirmed','2025-08-21 05:49:30','2025-08-21 05:51:07',NULL);
INSERT INTO "appointments" VALUES (4,5,'2025-10-31','14:00',1,'Pending','2025-10-26 23:03:18','2025-10-26 23:03:18','Oh uh ah');
INSERT INTO "cache" VALUES ('lyjieme@gmail.com|127.0.0.1:timer','i:1755934557;',1755934557);
INSERT INTO "cache" VALUES ('lyjieme@gmail.com|127.0.0.1','i:1;',1755934557);
INSERT INTO "cache" VALUES ('admin@ckc.edu|127.0.0.1:timer','i:1761563003;',1761563003);
INSERT INTO "cache" VALUES ('admin@ckc.edu|127.0.0.1','i:1;',1761563003);
INSERT INTO "dental_examinations" VALUES (1,'{"1":"healthy","2":"healthy","3":"cavity","4":"healthy","5":"healthy","6":"healthy","7":"healthy","8":"healthy","9":"healthy","10":"healthy","11":"healthy","12":"healthy","13":"healthy","14":"healthy","15":"healthy","16":"healthy","17":"healthy","18":"healthy","19":"healthy","20":"healthy","21":"healthy","22":"healthy","23":"healthy","24":"healthy","25":"healthy","26":"healthy","27":"healthy","28":"healthy","29":"healthy","30":"healthy","31":"healthy","32":"healthy"}',5,1,'test','2025-10-26 04:35:45','2025-10-26 04:35:45');
INSERT INTO "doctors" VALUES (1,1,'spec','n1b1',1,'2025-08-19 07:12:11','2025-08-19 07:12:11');
INSERT INTO "educational_level" VALUES (1,'Kindergarten',1,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (2,'Kindergarten',2,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (3,'Kindergarten',3,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (4,'Elementary',1,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (5,'Elementary',2,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (6,'Elementary',3,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (7,'Elementary',4,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (8,'Elementary',5,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (9,'Elementary',6,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (10,'Junior High',7,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (11,'Junior High',8,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (12,'Junior High',9,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (13,'Junior High',10,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (14,'Senior High',11,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (15,'Senior High',12,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (16,'College',1,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (17,'College',2,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (18,'College',3,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "educational_level" VALUES (19,'College',4,'2025-08-19 07:16:49','2025-08-19 07:16:49');
INSERT INTO "immunization_records" VALUES (1,'Covid','mrNA',NULL,'0.5ml','Right arm','2025-10-26','Vaccine sa buang',3,'2025-10-26 04:25:53','2025-10-26 04:25:53');
INSERT INTO "immunization_records" VALUES (2,'Hepa','inactive',NULL,'1ml','Right arm','2025-10-27','Regular',5,'2025-10-26 22:57:22','2025-10-26 22:57:22');
INSERT INTO "medicine" VALUES (1,'Neozep','Gamot sa Sipon','100','2027-10-27','Anti','Active','2025-10-27 11:09:03','2025-10-27 11:09:03');
INSERT INTO "migrations" VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO "migrations" VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO "migrations" VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO "migrations" VALUES (4,'2024_09_28_084702_students',1);
INSERT INTO "migrations" VALUES (5,'2024_09_28_093620_year',1);
INSERT INTO "migrations" VALUES (6,'2024_09_28_100926_staff',1);
INSERT INTO "migrations" VALUES (7,'2024_09_28_101853_medical_records',1);
INSERT INTO "migrations" VALUES (8,'2024_09_28_103209_medicine',1);
INSERT INTO "migrations" VALUES (9,'2024_10_13_143416_create_admins_table',1);
INSERT INTO "migrations" VALUES (10,'2024_10_17_122523_create_appointments_table',1);
INSERT INTO "migrations" VALUES (11,'2024_10_17_154747_create_health_records_table',1);
INSERT INTO "migrations" VALUES (12,'2024_10_18_025647_create_immunizations_table',1);
INSERT INTO "migrations" VALUES (13,'2024_10_18_033556_create_courses_table',1);
INSERT INTO "migrations" VALUES (14,'2024_10_20_145027_create_doctors_table',1);
INSERT INTO "migrations" VALUES (15,'2024_10_20_145920_create_patients_table',1);
INSERT INTO "migrations" VALUES (16,'2024_10_20_150336_create_reports_table',1);
INSERT INTO "migrations" VALUES (17,'2024_10_31_105053_educational_level',1);
INSERT INTO "migrations" VALUES (18,'2024_10_31_123637_create_dental_examinations_table',1);
INSERT INTO "migrations" VALUES (19,'2024_10_31_125602_create_physical_examinations_table',1);
INSERT INTO "migrations" VALUES (20,'2024_10_31_125923_create_immunization_records_table',1);
INSERT INTO "migrations" VALUES (21,'2024_10_31_133553_create_prescription_records_table',1);
INSERT INTO "migrations" VALUES (22,'2025_08_20_082010_add_columns_to_health_records_table',2);
INSERT INTO "migrations" VALUES (23,'2025_08_21_032746_make_school_id_nullable_in_patients_table',3);
INSERT INTO "migrations" VALUES (24,'2025_08_21_034058_make_edulvl_id_nullable_in_patients_table',4);
INSERT INTO "migrations" VALUES (25,'2025_10_14_073250_update_physical_examinations_table_use_patient_id',5);
INSERT INTO "migrations" VALUES (26,'2025_10_26_230011_add_reason_to_appointments_table',5);
INSERT INTO "migrations" VALUES (27,'2024_10_31_200000_add_fields_to_prescription_records_table',6);
INSERT INTO "patients" VALUES (3,'125',1,2,6,'kjhvkhjv','jbjgj','bljblj','iugiuygi','khjkj','kjbljk','6464','khjvbkl','2025-08-19 07:22:36','2025-08-19 07:22:36');
INSERT INTO "patients" VALUES (5,NULL,'student',NULL,3,'Edit','n','n','n','n','1','1','Sibling','2025-08-21 03:42:05','2025-10-26 22:58:08');
INSERT INTO "patients" VALUES (6,'2',1,12,4,'aa','sda','daasd','sdasa','sdas','dsa','121','aaa','2025-08-21 05:44:55','2025-08-21 05:44:55');
INSERT INTO "patients" VALUES (7,NULL,'student',NULL,2,'47 purok 2 ne','Lozartan','N/A','Apendicitis','Chocolate','Emergency','09658309499','Guardian','2025-10-05 03:35:45','2025-10-05 03:35:45');
INSERT INTO "physical_examinations" VALUES (1,'170','65','re','clear','clear','clear','clear','clear','clear','12','clear',6,1,'2025-10-26 05:28:32','2025-10-26 05:28:32');
INSERT INTO "physical_examinations" VALUES (2,'170','65','Regular','Regular','Regular','Regular','Regular','Regular','Regular','120/80','Regular',3,1,'2025-10-26 22:56:53','2025-10-26 22:56:53');
INSERT INTO "physical_examinations" VALUES (3,'170','65','john','john','john','john','john','john','john','120','john',5,1,'2025-10-27 10:02:59','2025-10-27 10:02:59');
INSERT INTO "prescription_records" VALUES (1,'500mg','with water',5,1,1,'2025-10-27 20:01:19','2025-10-27 20:01:19','3','7','2025-10-27',NULL,'active',NULL);
INSERT INTO "sessions" VALUES ('gka1wqFMCwQgKLpJ7By6IiDC7qLfWjDLo1gBcKSi',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUkVCQWdkRVdYOGswNHQ4WlZUcGs0azg4VEdJRFhtSkRGNmd5aTRsNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kb2N0b3IvcGF0aWVudHMvNSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1761595293);
INSERT INTO "sessions" VALUES ('kFRYXnvwfy0BBmgrzicpisHTjkY7hTaZThSYGtNk',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQnpyVVE3MWxXWjRVbmtRaFZCZUFnMnh4aUY0VWprenM2NmprSTBMbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hcHBvaW50bWVudHMvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1761595473);
INSERT INTO "sessions" VALUES ('DVdSkMAUSCsyuUgxhPvCoNG9uK2XprkenOy7FwWu',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZW4wTjhTeXcyaUswSFF6dFcyOHlQdzQ0aVpmcWNYNUZUdWdEZjA4cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1762925802);
INSERT INTO "users" VALUES (1,'doctor@ckc.edu','Dr. John Smith',3,'2025-08-19 04:12:29','$2y$12$Af2m.bNxwMBCV6Wi970EmO62/kP2aYPFqNIQWgEKWHYqZgxYat486','oxQphwAy7RWoozysM8qiaVZI8Cmx3JlOB0BBLigJRnF27NvNQ4Ja4NBJj9ik','John','Medical','Smith','1985-05-15','CKC Medical Center','Male','09123456790','2025-08-19 04:12:29','2025-08-19 04:12:29');
INSERT INTO "users" VALUES (2,'staff@ckc.edu','Jane Staff',2,'2025-08-19 04:12:29','$2y$12$DZvTTVpzHUWnKdRz/gO2XOKMiaxTvlCkTL6TibTSBeHtuGq6cOzQi','nAKNnWiytO','Jane','Office','Staff','1992-08-20','CKC Administration','Female','09123456791','2025-08-19 04:12:29','2025-08-19 04:12:29');
INSERT INTO "users" VALUES (3,'student@ckc.edu','John Student',1,'2025-08-19 04:12:30','$2y$12$OZiKmdxkQXjy/pFTlMV7dujsSufAbwCn1qUKwlL6CPZ8wsOH3l0Rq','Z5LfiHnUA7nphPrXosZ9vwGrRlWwHjKXT3gxoE4GShsHEHPH9hlWE1VIEiEC','John','Academic','Student','2000-12-10','CKC Dormitory','Male','09123456792','2025-08-19 04:12:30','2025-08-19 04:12:30');
INSERT INTO "users" VALUES (4,'ernestine01@example.org','Art Eloy Dooley',2,'2025-08-19 04:12:30','$2y$12$sM28E3Lan1Y6is7sbAAMxe0VwBqmioxmo4aHu7kNsiVot3VbT8XbW','nXiVmMsKn0','Art','Eloy','Dooley','1973-02-02','160 Marquise Well Apt. 876
South Ivaborough, NY 97080-7241','Female','414-499-0482','2025-08-19 04:12:30','2025-08-19 04:12:30');
INSERT INTO "users" VALUES (5,'natasha20@example.com','Oral Immanuel Greenfelder',3,'2025-08-19 04:12:30','$2y$12$sM28E3Lan1Y6is7sbAAMxe0VwBqmioxmo4aHu7kNsiVot3VbT8XbW','uYTZ9t2KIJ','Oral','Immanuel','Greenfelder','1979-12-29','12531 Laury Run
West Liam, OH 61192-3755','Male','+1.248.857.6629','2025-08-19 04:12:30','2025-08-19 04:12:30');
INSERT INTO "users" VALUES (6,'dolores.schmidt@example.com','Anahi Trinity Gislason',1,'2025-08-19 04:12:30','$2y$12$sM28E3Lan1Y6is7sbAAMxe0VwBqmioxmo4aHu7kNsiVot3VbT8XbW','YHwtGoP18R','Anahi','Trinity','Gislason','1983-07-03','19078 Elinore Station
North Jackyborough, AR 92386-6429','Female','+1-325-462-9206','2025-08-19 04:12:30','2025-08-19 04:12:30');
CREATE UNIQUE INDEX IF NOT EXISTS "admins_email_unique" ON "admins" (
	"email"
);
CREATE UNIQUE INDEX IF NOT EXISTS "courses_course_name_unique" ON "courses" (
	"course_name"
);
CREATE UNIQUE INDEX IF NOT EXISTS "failed_jobs_uuid_unique" ON "failed_jobs" (
	"uuid"
);
CREATE UNIQUE INDEX IF NOT EXISTS "immunizations_name_unique" ON "immunizations" (
	"name"
);
CREATE INDEX IF NOT EXISTS "jobs_queue_index" ON "jobs" (
	"queue"
);
CREATE INDEX IF NOT EXISTS "sessions_last_activity_index" ON "sessions" (
	"last_activity"
);
CREATE INDEX IF NOT EXISTS "sessions_user_id_index" ON "sessions" (
	"user_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "users_email_unique" ON "users" (
	"email"
);
COMMIT;
