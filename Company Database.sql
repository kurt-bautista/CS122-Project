DROP DATABASE IF EXISTS company;
CREATE DATABASE company;
USE company;

CREATE TABLE employees(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	remaining_leaves INT NOT NULL,
	employee_type VARCHAR(255) NOT NULL,
	manager_id INT,
	holiday_type VARCHAR(255) NOT NULL,
	employee_contracts_id INT,
	FOREIGN KEY(manager_id) REFERENCES employees(id));

CREATE TABLE employee_contracts(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	start_date DATE NOT NULL,
	duration DATE NOT NULL,
	hourly_rate DOUBLE NOT NULL,
	expected_time_in TIME NOT NULL,
	employees_id INT NOT NULL,
	FOREIGN KEY(employees_id) REFERENCES employees(id));

ALTER TABLE employees
ADD FOREIGN KEY(employee_contracts_id) REFERENCES employee_contracts(id);

CREATE TABLE leaves(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	status VARCHAR(255) NOT NULL,
	employees_id INT NOT NULL,
	leave_types_id INT NOT NULL,
	FOREIGN KEY(employees_id) REFERENCES employees(id));

CREATE TABLE leave_types(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	paid TINYINT(1) NOT NULL);

ALTER TABLE leaves
ADD FOREIGN KEY(leave_types_id) REFERENCES leave_types(id);

CREATE TABLE workdays(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	time_in DATETIME NOT NULL,
	time_out DATETIME NOT NULL,
	overtime_hours INT,
	employees_id INT NOT NULL,
	leaves_id INT,
	FOREIGN KEY(employees_id) REFERENCES employees(id),
	FOREIGN KEY(leaves_id) REFERENCES leaves(id));

ALTER TABLE workdays
ADD COLUMN employees_hourly_rate DECIMAL NOT NULL;

INSERT INTO employees(username, password, remaining_leaves, employee_type, holiday_type) VALUES ('admin', 'password', 0, 'manager', 'regular');

ALTER TABLE employee_contracts
ADD COLUMN allotted_leaves INT NOT NULL;

INSERT INTO employee_contracts(start_date, duration, hourly_rate, expected_time_in, employees_id, allotted_leaves)
VALUES ('1970-01-01', '2037-12-31', 0.0, '09:00:00', 1, 0);

ALTER TABLE leave_types
DROP COLUMN paid;

INSERT INTO leave_types(name) VALUES ('Sick'), ('Vacation'), ('Special Privilege'), ('Maternity'), ('Paternity');

ALTER TABLE leaves
ADD COLUMN start_date DATE NOT NULL,
ADD COLUMN end_date DATE NOT NULL,
ADD COLUMN duration INT NOT NULL,
ADD COLUMN leave_reason VARCHAR(255);
