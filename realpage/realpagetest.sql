DROP DATABASE IF EXISTS realpagetest;

CREATE DATABASE realpagetest;
USE realpagetest;

CREATE TABLE employees(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	remaining_leaves INT NOT NULL,
	employee_type VARCHAR(255) NOT NULL,
	holiday_type VARCHAR(255) NOT NULL,
	employee_contracts_id INT);

CREATE TABLE employee_contracts(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	start_date DATE NOT NULL,
	duration DATE NOT NULL,
	hourly_rate DOUBLE NOT NULL,
	employees_id INT NOT NULL,
	FOREIGN KEY(employees_id) REFERENCES employees(id));

ALTER TABLE employees
ADD FOREIGN KEY(employee_contracts_id) REFERENCES employee_contracts(id);

CREATE TABLE leaves(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	status VARCHAR(255) NOT NULL,
	employees_id INT NOT NULL,
	leave_types_id INT NOT NULL,
	workdays_id INT,
	FOREIGN KEY(employees_id) REFERENCES employees(id));

CREATE TABLE leave_types(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	paid TINYINT(1) NOT NULL);

ALTER TABLE leaves
ADD FOREIGN KEY(leave_types_id) REFERENCES leave_types(id);

/**
CREATE TABLE leave_requests(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  request_date DATE NOT NULL,
  num_of_days INT NOT NULL,
  leave_reason VARCHAR(255),
  employees_id INT,
  FOREIGN KEY(employees_id) REFERENCES employees(id)
);
*/

CREATE TABLE workdays(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	time_in DATETIME NOT NULL,
	time_out DATETIME NOT NULL,
	overtime_hours INT,
	employees_id INT NOT NULL,
	leaves_id INT,
	FOREIGN KEY(employees_id) REFERENCES employees(id),
	FOREIGN KEY(leaves_id) REFERENCES leaves(id));

ALTER TABLE leaves
ADD FOREIGN KEY(workdays_id) REFERENCES workdays(id);

ALTER TABLE workdays
ADD COLUMN employees_hourly_rate DECIMAL NOT NULL;

INSERT INTO employees (username,password,first_name,last_name,remaining_leaves,employee_type,holiday_type,employee_contracts_id) VALUES (
    'antonsuba', '420blazeit', 'Anton', 'Suba', 69,'Manager','Local',NULL
);

INSERT INTO employees(username, password, employee_type, holiday_type) VALUES ('admin', 'password', 'manager', 'regular');

ALTER TABLE employee_contracts
ADD COLUMN alloted_leaves INT NOT NULL;

ALTER TABLE leave_types
DROP COLUMN paid;

INSERT INTO leave_types(name) VALUES ('Sick'), ('Vacation'), ('Special Privilege'), ('Maternity'), ('Paternity');

ALTER TABLE leaves
ADD COLUMN start_date DATE, ADD COLUMN end_date DATE, ADD COLUMN num_of_days INT, ADD COLUMN leave_reason VARCHAR(255);

INSERT INTO leaves(status, employees_id, leave_types_id, workdays_id, start_date, end_date, num_of_days) VALUES
('APPROVED', 1, 1, NULL, '2016-04-15','2016-04-20', 5), ('APPROVED', 1, 4, NULL, '2016-05-03','2016-05-06', 3);