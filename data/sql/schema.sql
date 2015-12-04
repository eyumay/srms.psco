CREATE TABLE acadamic_position (id BIGINT AUTO_INCREMENT, position_name VARCHAR(250) NOT NULL UNIQUE, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE academic_calendar (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, academic_year VARCHAR(255) NOT NULL, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE academic_calendar_events (id BIGINT AUTO_INCREMENT, event_id BIGINT NOT NULL, academic_calendar_id BIGINT NOT NULL, start_date DATE NOT NULL, end_date DATE, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX event_id_idx (event_id), INDEX academic_calendar_id_idx (academic_calendar_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE action_on_student (id BIGINT AUTO_INCREMENT, action_name VARCHAR(35) NOT NULL UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE audit_log (id BIGINT AUTO_INCREMENT, user_id BIGINT NOT NULL, action TEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE autoincrement (id BIGINT AUTO_INCREMENT, entity_name VARCHAR(255) NOT NULL, last_value BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE calendar_events (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE center (id BIGINT AUTO_INCREMENT, name VARCHAR(250) NOT NULL UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE checklist_breakdown (id BIGINT AUTO_INCREMENT, program_checklist_id BIGINT NOT NULL, program_section_id BIGINT NOT NULL, semester_type_id BIGINT NOT NULL, year BIGINT NOT NULL, semester BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX program_checklist_id_idx (program_checklist_id), INDEX semester_type_id_idx (semester_type_id), INDEX program_section_id_idx (program_section_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE course (id BIGINT AUTO_INCREMENT, grade_type_id BIGINT NOT NULL, department_id BIGINT NOT NULL, course_number VARCHAR(250) NOT NULL, name VARCHAR(250) NOT NULL, credit_houre BIGINT NOT NULL, ac_minutes VARCHAR(250), aproval_date DATE, description TEXT, status TINYINT(1) DEFAULT '1', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX course_index_idx (department_id, course_number), INDEX grade_type_id_idx (grade_type_id), INDEX department_id_idx (department_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE course_checklist (id BIGINT AUTO_INCREMENT, course_id BIGINT NOT NULL, program_id BIGINT NOT NULL, year BIGINT NOT NULL, semester BIGINT NOT NULL, course_type VARCHAR(50), status TINYINT(1) DEFAULT '1', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX course_checklist_index_idx (program_id, course_id, year, semester), INDEX course_id_idx (course_id), INDEX program_id_idx (program_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE course_pool (id BIGINT AUTO_INCREMENT, enrollment_info_id BIGINT NOT NULL, course_id BIGINT NOT NULL, UNIQUE INDEX course_pool_index_idx (enrollment_info_id, course_id), INDEX enrollment_info_id_idx (enrollment_info_id), INDEX course_id_idx (course_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE course_relation_types (id BIGINT AUTO_INCREMENT, relation_name VARCHAR(255) NOT NULL, remark VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE department (id BIGINT AUTO_INCREMENT, name VARCHAR(250) NOT NULL UNIQUE, faculty_id BIGINT NOT NULL, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX faculty_id_idx (faculty_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE enrollment_info (id BIGINT AUTO_INCREMENT, student_id BIGINT NOT NULL, student_uid VARCHAR(255), program_id BIGINT NOT NULL, section_id BIGINT, academic_year VARCHAR(10) NOT NULL, year BIGINT, semester BIGINT, leftout TINYINT(1) DEFAULT '0', academic_status BIGINT DEFAULT 0, semester_action BIGINT DEFAULT 0, payment_status BIGINT DEFAULT 0, enrollment_action BIGINT DEFAULT 0, mention VARCHAR(5), previous_chrs BIGINT DEFAULT 0, semester_chrs BIGINT DEFAULT 0, total_chrs BIGINT DEFAULT 0, previous_grade_points FLOAT(18, 2) DEFAULT 0, semester_grade_points FLOAT(18, 2) DEFAULT 0, total_grade_points FLOAT(18, 2) DEFAULT 0, previous_repeated_chrs FLOAT(18, 2) DEFAULT 0, semester_repeated_chrs FLOAT(18, 2) DEFAULT 0, total_repeated_chrs FLOAT(18, 2) DEFAULT 0, previous_repeated_grade_points FLOAT(18, 2) DEFAULT 0, semester_repeated_grade_points FLOAT(18, 2) DEFAULT 0, total_repeated_grade_points FLOAT(18, 2) DEFAULT 0, program_checklist_id BIGINT DEFAULT 0, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX student_id_idx (student_id), INDEX program_id_idx (program_id), INDEX section_id_idx (section_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE enrollment_type (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, overload BIGINT NOT NULL, underload BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE faculty (id BIGINT AUTO_INCREMENT, name VARCHAR(250) NOT NULL UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE grade (id BIGINT AUTO_INCREMENT, grade_type_id BIGINT NOT NULL, gradechar VARCHAR(15) NOT NULL UNIQUE, is_removable TINYINT(1) NOT NULL, is_repeated TINYINT(1) NOT NULL, is_calculated TINYINT(1) NOT NULL, min_value FLOAT(18, 2) NOT NULL, max_value FLOAT(18, 2) NOT NULL, value FLOAT(18, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX grade_type_id_idx (grade_type_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE grade_type (id BIGINT AUTO_INCREMENT, name VARCHAR(250) NOT NULL UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE instructor (id BIGINT AUTO_INCREMENT, department_id BIGINT NOT NULL, academic_position_id BIGINT NOT NULL, instructor_id_number VARCHAR(250) NOT NULL UNIQUE, date_of_birth DATE NOT NULL, gender VARCHAR(30) NOT NULL, picture VARCHAR(250), title VARCHAR(250) NOT NULL, qualification VARCHAR(255) NOT NULL, acadamic_position VARCHAR(255) NOT NULL, town VARCHAR(255) NOT NULL, woreda VARCHAR(250) NOT NULL, kebele VARCHAR(250) NOT NULL, house_number VARCHAR(250) NOT NULL, nationality VARCHAR(255) NOT NULL, ethnicity VARCHAR(255) NOT NULL, telephone VARCHAR(250), remark TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX department_id_idx (department_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE program (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, department_id BIGINT NOT NULL, program_type_id BIGINT NOT NULL, enrollment_type_id BIGINT NOT NULL, minor VARCHAR(255), number_of_semesters BIGINT NOT NULL, total_max_chr BIGINT NOT NULL, total_min_chr BIGINT NOT NULL, number_of_years BIGINT NOT NULL, max_number_of_years BIGINT NOT NULL, approval_date DATE, status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX program_index_idx (department_id, name), INDEX department_id_idx (department_id), INDEX program_type_id_idx (program_type_id), INDEX enrollment_type_id_idx (enrollment_type_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE program_checklist (id BIGINT AUTO_INCREMENT, program_id BIGINT UNIQUE NOT NULL, number_of_semesters BIGINT NOT NULL, total_maximum_chr BIGINT NOT NULL, total_minimum_chr BIGINT NOT NULL, number_of_years BIGINT NOT NULL, max_number_of_years BIGINT NOT NULL, status TINYINT(1) DEFAULT '1' NOT NULL, remark TEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX program_id_idx (program_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE program_checklist_breakdown (id BIGINT AUTO_INCREMENT, program_id BIGINT NOT NULL, semester_type_id BIGINT NOT NULL, year BIGINT NOT NULL, semester BIGINT NOT NULL, semester_min_chr BIGINT NOT NULL, semester_max_chr BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX program_id_idx (program_id), INDEX semester_type_id_idx (semester_type_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE program_section (id BIGINT AUTO_INCREMENT, program_id BIGINT NOT NULL, center_id BIGINT NOT NULL, academic_advisor_id BIGINT, academic_calendar_id BIGINT NOT NULL, number_of_student BIGINT NOT NULL, academic_year VARCHAR(255) NOT NULL, year BIGINT NOT NULL, semester BIGINT, section_number BIGINT NOT NULL, is_activated TINYINT(1) DEFAULT '0' NOT NULL, is_promoted TINYINT(1) DEFAULT '0' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX batch_section_index_idx (program_id, academic_year, year, semester, section_number, center_id), INDEX program_id_idx (program_id), INDEX academic_calendar_id_idx (academic_calendar_id), INDEX academic_advisor_id_idx (academic_advisor_id), INDEX center_id_idx (center_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE program_type (id BIGINT AUTO_INCREMENT, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE promotion_setting (id BIGINT AUTO_INCREMENT, program_id BIGINT NOT NULL, current_year BIGINT NOT NULL, current_semester BIGINT NOT NULL, to_year BIGINT NOT NULL, to_semester BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX promotion_index_idx (program_id, current_year, current_semester, to_year, to_semester), INDEX program_id_idx (program_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE registration (id BIGINT AUTO_INCREMENT, enrollment_info_id BIGINT NOT NULL, date DATE NOT NULL, is_grade_complain TINYINT(1) DEFAULT '0', is_reexam TINYINT(1) DEFAULT '0', is_makeup TINYINT(1) DEFAULT '0', is_add TINYINT(1) DEFAULT '0', is_drop TINYINT(1) DEFAULT '0', is_underloaded TINYINT(1) DEFAULT '0', is_overloaded TINYINT(1) DEFAULT '0', ac VARCHAR(255), remark VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX enrollment_info_id_idx (enrollment_info_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE registration_type (id BIGINT AUTO_INCREMENT, registration_type_name VARCHAR(255) NOT NULL, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE related_courses (id BIGINT AUTO_INCREMENT, course_id BIGINT NOT NULL, prerequisite_course_number VARCHAR(100) NOT NULL, course_relation_type VARCHAR(100) NOT NULL, date_from DATE, date_to DATE, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX course_relation_index_idx (course_relation_type, course_id, prerequisite_course_number), INDEX course_id_idx (course_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE section_course_offering (id BIGINT AUTO_INCREMENT, course_id BIGINT NOT NULL, grade_status BIGINT NOT NULL, instructor_id BIGINT, section_id BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX section_course_offering_index_idx (course_id, section_id), INDEX course_id_idx (course_id), INDEX instructor_id_idx (instructor_id), INDEX section_id_idx (section_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE semester_type (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE status_setting (id BIGINT AUTO_INCREMENT, year BIGINT NOT NULL, semester BIGINT NOT NULL, min_grade_point FLOAT(18, 2) NOT NULL, max_grade_point FLOAT(18, 2) NOT NULL, status VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student (id BIGINT AUTO_INCREMENT, student_uid VARCHAR(255) NOT NULL UNIQUE, name VARCHAR(255) NOT NULL, fathers_name VARCHAR(255) NOT NULL, grandfathers_name VARCHAR(255) NOT NULL, mother_name VARCHAR(255), date_of_birth DATE NOT NULL, admission_year VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, photo VARCHAR(255), birth_location VARCHAR(255), residence_city VARCHAR(255), residence_woreda VARCHAR(255), residence_kebele VARCHAR(255), residence_house_number VARCHAR(255), ethinicity VARCHAR(255), telephone VARCHAR(255), email VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX student_index_idx (name, fathers_name, grandfathers_name, date_of_birth), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_academic_status (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, value BIGINT NOT NULL, category VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_center (id BIGINT AUTO_INCREMENT, center_id BIGINT NOT NULL, student_id BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX center_id_idx (center_id), INDEX student_id_idx (student_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_course (id BIGINT AUTO_INCREMENT, student_id BIGINT NOT NULL, instructor_id BIGINT NOT NULL, registration_id BIGINT NOT NULL, course_id BIGINT NOT NULL, grade_id BIGINT NOT NULL, is_repeated TINYINT(1) DEFAULT '0' NOT NULL, is_academic_repeated TINYINT(1) DEFAULT '0' NOT NULL, is_dropped TINYINT(1) DEFAULT '0' NOT NULL, is_added TINYINT(1) DEFAULT '0' NOT NULL, is_leftout TINYINT(1) DEFAULT '0' NOT NULL, remark VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX grade_id_idx (grade_id), INDEX student_id_idx (student_id), INDEX registration_id_idx (registration_id), INDEX instructor_id_idx (instructor_id), INDEX course_id_idx (course_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_course_grade (id BIGINT AUTO_INCREMENT, student_id BIGINT NOT NULL, instructor_id BIGINT, registration_id BIGINT NOT NULL, course_id BIGINT NOT NULL, grade_id BIGINT, is_repeated TINYINT(1) DEFAULT '0' NOT NULL, is_academic_repeated TINYINT(1) DEFAULT '0' NOT NULL, is_dropped TINYINT(1) DEFAULT '0' NOT NULL, is_added TINYINT(1) DEFAULT '0' NOT NULL, is_calculated TINYINT(1) DEFAULT '1' NOT NULL, is_exempted BIGINT DEFAULT 0 NOT NULL, regrade_status BIGINT DEFAULT 0, grade_status TINYINT(1) DEFAULT '0' NOT NULL, remark VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX grade_id_idx (grade_id), INDEX student_id_idx (student_id), INDEX registration_id_idx (registration_id), INDEX instructor_id_idx (instructor_id), INDEX course_id_idx (course_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_exemption (id BIGINT AUTO_INCREMENT, student_id BIGINT NOT NULL, course_id BIGINT NOT NULL, reason VARCHAR(255), grade TEXT, remark VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX exemption_index_idx (student_id, course_id), INDEX student_id_idx (student_id), INDEX course_id_idx (course_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_g_c_r (id BIGINT AUTO_INCREMENT, student_id BIGINT NOT NULL, program_checklist_id BIGINT NOT NULL, semester BIGINT NOT NULL, total_credits BIGINT NOT NULL, total_gradepoints BIGINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX student_id_idx (student_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_graduate (id BIGINT AUTO_INCREMENT, student_id BIGINT NOT NULL, graduation_date DATE NOT NULL, ac VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX student_id_idx (student_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_graraduate (id BIGINT AUTO_INCREMENT, student_id BIGINT NOT NULL, graduation_date DATE NOT NULL, ac VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX student_id_idx (student_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_info (id BIGINT AUTO_INCREMENT, student_id BIGINT NOT NULL, program_id BIGINT NOT NULL, section_id VARCHAR(5), academic_year BIGINT NOT NULL, year BIGINT, semester BIGINT, leftout TINYINT(1) DEFAULT '0', advisor BIGINT, status BIGINT, mention VARCHAR(5), action BIGINT, previous_chrs BIGINT, semester_chrs BIGINT, total_chrs BIGINT, previous_grade_points FLOAT(18, 2), semester_grade_points FLOAT(18, 2), total_grade_points FLOAT(18, 2), previous_repeated_chrs FLOAT(18, 2), semester_repeated_chrs FLOAT(18, 2), total_repeated_chrs FLOAT(18, 2), previous_repeated_grade_points FLOAT(18, 2), semester_repeated_grade_points FLOAT(18, 2), total_repeated_grade_points FLOAT(18, 2), program_checklist_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX student_id_idx (student_id), INDEX program_id_idx (program_id), INDEX status_idx (status), INDEX advisor_idx (advisor), INDEX action_idx (action), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_load (id BIGINT AUTO_INCREMENT, enrollment_info_id VARCHAR(255) NOT NULL, overload BIGINT, underload BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_program_section_transfer (id BIGINT AUTO_INCREMENT, student_id BIGINT NOT NULL, section_id BIGINT NOT NULL, to_section VARCHAR(200) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX student_program_section_transfer_index_idx (student_id, section_id), INDEX student_id_idx (student_id), INDEX section_id_idx (section_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_readmission (id BIGINT AUTO_INCREMENT, enrollment_info_id BIGINT NOT NULL, readmission_date DATE NOT NULL, ac VARCHAR(255), remark VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX student_readmission_index_idx (enrollment_info_id, readmission_date), INDEX enrollment_info_id_idx (enrollment_info_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_semester_action (id BIGINT AUTO_INCREMENT, name VARCHAR(35) NOT NULL UNIQUE, value BIGINT NOT NULL, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_status (id BIGINT AUTO_INCREMENT, status VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE student_withdrawal (id BIGINT AUTO_INCREMENT, enrollment_info_id BIGINT NOT NULL, withdrawal_date DATE NOT NULL, ac VARCHAR(255), remark VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX enrollment_info_id_idx (enrollment_info_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE user (id BIGINT AUTO_INCREMENT, login VARCHAR(100) NOT NULL, password VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, fathers_name VARCHAR(100) NOT NULL, grand_fathers_name VARCHAR(100) NOT NULL, privilege VARCHAR(200) NOT NULL, gender VARCHAR(10) NOT NULL, email VARCHAR(100) NOT NULL, department_id BIGINT NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX login_index_idx (login), UNIQUE INDEX email_index_idx (email), INDEX department_id_idx (department_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_forgot_password (id BIGINT AUTO_INCREMENT, user_id BIGINT NOT NULL, unique_key VARCHAR(255), expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id BIGINT AUTO_INCREMENT, user_id BIGINT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id BIGINT AUTO_INCREMENT, user_id_number VARCHAR(255) NOT NULL, id_number VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, grand_fathers_name VARCHAR(255) NOT NULL, phone VARCHAR(255), email_address VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(128) NOT NULL UNIQUE, is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id BIGINT, group_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE academic_calendar_events ADD CONSTRAINT academic_calendar_events_event_id_calendar_events_id FOREIGN KEY (event_id) REFERENCES calendar_events(id);
ALTER TABLE academic_calendar_events ADD CONSTRAINT aaai FOREIGN KEY (academic_calendar_id) REFERENCES academic_calendar(id);
ALTER TABLE audit_log ADD CONSTRAINT audit_log_user_id_user_id FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE;
ALTER TABLE checklist_breakdown ADD CONSTRAINT checklist_breakdown_semester_type_id_semester_type_id FOREIGN KEY (semester_type_id) REFERENCES semester_type(id) ON DELETE CASCADE;
ALTER TABLE checklist_breakdown ADD CONSTRAINT checklist_breakdown_program_section_id_program_section_id FOREIGN KEY (program_section_id) REFERENCES program_section(id) ON DELETE CASCADE;
ALTER TABLE checklist_breakdown ADD CONSTRAINT checklist_breakdown_program_checklist_id_program_checklist_id FOREIGN KEY (program_checklist_id) REFERENCES program_checklist(id) ON DELETE CASCADE;
ALTER TABLE course ADD CONSTRAINT course_grade_type_id_grade_type_id FOREIGN KEY (grade_type_id) REFERENCES grade_type(id);
ALTER TABLE course ADD CONSTRAINT course_department_id_department_id FOREIGN KEY (department_id) REFERENCES department(id);
ALTER TABLE course_checklist ADD CONSTRAINT course_checklist_program_id_program_id FOREIGN KEY (program_id) REFERENCES program(id);
ALTER TABLE course_checklist ADD CONSTRAINT course_checklist_course_id_course_id FOREIGN KEY (course_id) REFERENCES course(id);
ALTER TABLE course_pool ADD CONSTRAINT course_pool_enrollment_info_id_enrollment_info_id FOREIGN KEY (enrollment_info_id) REFERENCES enrollment_info(id) ON DELETE CASCADE;
ALTER TABLE course_pool ADD CONSTRAINT course_pool_course_id_course_id FOREIGN KEY (course_id) REFERENCES course(id) ON DELETE CASCADE;
ALTER TABLE department ADD CONSTRAINT department_faculty_id_faculty_id FOREIGN KEY (faculty_id) REFERENCES faculty(id);
ALTER TABLE enrollment_info ADD CONSTRAINT enrollment_info_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id);
ALTER TABLE enrollment_info ADD CONSTRAINT enrollment_info_section_id_program_section_id FOREIGN KEY (section_id) REFERENCES program_section(id);
ALTER TABLE enrollment_info ADD CONSTRAINT enrollment_info_program_id_program_id FOREIGN KEY (program_id) REFERENCES program(id);
ALTER TABLE grade ADD CONSTRAINT grade_grade_type_id_grade_type_id FOREIGN KEY (grade_type_id) REFERENCES grade_type(id);
ALTER TABLE instructor ADD CONSTRAINT instructor_department_id_department_id FOREIGN KEY (department_id) REFERENCES department(id) ON DELETE CASCADE;
ALTER TABLE program ADD CONSTRAINT program_program_type_id_program_type_id FOREIGN KEY (program_type_id) REFERENCES program_type(id) ON DELETE CASCADE;
ALTER TABLE program ADD CONSTRAINT program_enrollment_type_id_enrollment_type_id FOREIGN KEY (enrollment_type_id) REFERENCES enrollment_type(id) ON DELETE CASCADE;
ALTER TABLE program ADD CONSTRAINT program_department_id_department_id FOREIGN KEY (department_id) REFERENCES department(id) ON DELETE CASCADE;
ALTER TABLE program_checklist ADD CONSTRAINT program_checklist_program_id_program_id FOREIGN KEY (program_id) REFERENCES program(id) ON DELETE CASCADE;
ALTER TABLE program_checklist_breakdown ADD CONSTRAINT program_checklist_breakdown_semester_type_id_semester_type_id FOREIGN KEY (semester_type_id) REFERENCES semester_type(id) ON DELETE CASCADE;
ALTER TABLE program_checklist_breakdown ADD CONSTRAINT program_checklist_breakdown_program_id_program_id FOREIGN KEY (program_id) REFERENCES program(id) ON DELETE CASCADE;
ALTER TABLE program_section ADD CONSTRAINT program_section_program_id_program_id FOREIGN KEY (program_id) REFERENCES program(id) ON DELETE CASCADE;
ALTER TABLE program_section ADD CONSTRAINT program_section_center_id_center_id FOREIGN KEY (center_id) REFERENCES center(id);
ALTER TABLE program_section ADD CONSTRAINT program_section_academic_calendar_id_academic_calendar_id FOREIGN KEY (academic_calendar_id) REFERENCES academic_calendar(id) ON DELETE CASCADE;
ALTER TABLE program_section ADD CONSTRAINT program_section_academic_advisor_id_instructor_id FOREIGN KEY (academic_advisor_id) REFERENCES instructor(id);
ALTER TABLE promotion_setting ADD CONSTRAINT promotion_setting_program_id_program_id FOREIGN KEY (program_id) REFERENCES program(id) ON DELETE CASCADE;
ALTER TABLE registration ADD CONSTRAINT registration_enrollment_info_id_enrollment_info_id FOREIGN KEY (enrollment_info_id) REFERENCES enrollment_info(id) ON DELETE CASCADE;
ALTER TABLE related_courses ADD CONSTRAINT related_courses_course_id_course_id FOREIGN KEY (course_id) REFERENCES course(id);
ALTER TABLE section_course_offering ADD CONSTRAINT section_course_offering_section_id_program_section_id FOREIGN KEY (section_id) REFERENCES program_section(id) ON DELETE CASCADE;
ALTER TABLE section_course_offering ADD CONSTRAINT section_course_offering_instructor_id_instructor_id FOREIGN KEY (instructor_id) REFERENCES instructor(id);
ALTER TABLE section_course_offering ADD CONSTRAINT section_course_offering_course_id_course_id FOREIGN KEY (course_id) REFERENCES course(id);
ALTER TABLE student_center ADD CONSTRAINT student_center_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id);
ALTER TABLE student_center ADD CONSTRAINT student_center_center_id_center_id FOREIGN KEY (center_id) REFERENCES center(id);
ALTER TABLE student_course ADD CONSTRAINT student_course_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id);
ALTER TABLE student_course ADD CONSTRAINT student_course_registration_id_registration_id FOREIGN KEY (registration_id) REFERENCES registration(id);
ALTER TABLE student_course ADD CONSTRAINT student_course_instructor_id_instructor_id FOREIGN KEY (instructor_id) REFERENCES instructor(id);
ALTER TABLE student_course ADD CONSTRAINT student_course_grade_id_grade_id FOREIGN KEY (grade_id) REFERENCES grade(id);
ALTER TABLE student_course ADD CONSTRAINT student_course_course_id_course_id FOREIGN KEY (course_id) REFERENCES course(id);
ALTER TABLE student_course_grade ADD CONSTRAINT student_course_grade_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id);
ALTER TABLE student_course_grade ADD CONSTRAINT student_course_grade_registration_id_registration_id FOREIGN KEY (registration_id) REFERENCES registration(id) ON DELETE CASCADE;
ALTER TABLE student_course_grade ADD CONSTRAINT student_course_grade_instructor_id_instructor_id FOREIGN KEY (instructor_id) REFERENCES instructor(id);
ALTER TABLE student_course_grade ADD CONSTRAINT student_course_grade_grade_id_grade_id FOREIGN KEY (grade_id) REFERENCES grade(id);
ALTER TABLE student_course_grade ADD CONSTRAINT student_course_grade_course_id_course_id FOREIGN KEY (course_id) REFERENCES course(id);
ALTER TABLE student_exemption ADD CONSTRAINT student_exemption_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id);
ALTER TABLE student_exemption ADD CONSTRAINT student_exemption_course_id_course_id FOREIGN KEY (course_id) REFERENCES course(id);
ALTER TABLE student_g_c_r ADD CONSTRAINT student_g_c_r_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id);
ALTER TABLE student_graduate ADD CONSTRAINT student_graduate_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id);
ALTER TABLE student_graraduate ADD CONSTRAINT student_graraduate_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id);
ALTER TABLE student_info ADD CONSTRAINT student_info_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id);
ALTER TABLE student_info ADD CONSTRAINT student_info_status_student_status_id FOREIGN KEY (status) REFERENCES student_status(id);
ALTER TABLE student_info ADD CONSTRAINT student_info_program_id_program_id FOREIGN KEY (program_id) REFERENCES program(id);
ALTER TABLE student_info ADD CONSTRAINT student_info_advisor_instructor_id FOREIGN KEY (advisor) REFERENCES instructor(id);
ALTER TABLE student_info ADD CONSTRAINT student_info_action_action_on_student_id FOREIGN KEY (action) REFERENCES action_on_student(id);
ALTER TABLE student_program_section_transfer ADD CONSTRAINT student_program_section_transfer_student_id_student_id FOREIGN KEY (student_id) REFERENCES student(id) ON DELETE CASCADE;
ALTER TABLE student_program_section_transfer ADD CONSTRAINT student_program_section_transfer_section_id_program_section_id FOREIGN KEY (section_id) REFERENCES program_section(id) ON DELETE CASCADE;
ALTER TABLE student_readmission ADD CONSTRAINT student_readmission_enrollment_info_id_enrollment_info_id FOREIGN KEY (enrollment_info_id) REFERENCES enrollment_info(id);
ALTER TABLE student_withdrawal ADD CONSTRAINT student_withdrawal_enrollment_info_id_enrollment_info_id FOREIGN KEY (enrollment_info_id) REFERENCES enrollment_info(id);
ALTER TABLE user ADD CONSTRAINT user_department_id_department_id FOREIGN KEY (department_id) REFERENCES department(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_forgot_password ADD CONSTRAINT sf_guard_forgot_password_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;