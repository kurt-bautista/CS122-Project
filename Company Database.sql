CREATE DATABASE company;
USE company;

CREATE TABLE employees(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	remaining_leaves INT NOT NULL,
	employee_type VARCHAR(255) NOT NULL,
	holiday_type VARCHAR(255) NOT NULL,
	employee_contracts_id INT); 

CREATE TABLE employee_contracts(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	start_date DATE NOT NULL,
	end_date DATE NOT NULL,
	hourly_rate DOUBLE NOT NULL,
	employees_id INT NOT NULL,
	FOREIGN KEY(employees_id) REFERENCES employees(id));

ALTER TABLE employees
ADD FOREIGN KEY(employee_contracts_id) REFERENCES employee_contracts(id);

CREATE TABLE leaves(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	status VARCHAR(255) NOT NULL,
	employees_id INT NOT NULL,
	leave_types_id INT NOT NULL,
	FOREIGN KEY(employees_id) REFERENCES employees(id));

CREATE TABLE leave_types(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	paid TINYINT(1) NOT NULL);

ALTER TABLE leaves
ADD FOREIGN KEY(leave_types_id) REFERENCES leave_types(id);

CREATE TABLE workdays(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	time_in DATETIME NOT NULL,
	time_out DATETIME,
	overtime_hours INT,
	employees_id INT NOT NULL,
	leaves_id INT,
	FOREIGN KEY(employees_id) REFERENCES employees(id),
	FOREIGN KEY(leaves_id) REFERENCES leaves(id));

ALTER TABLE workdays
ADD COLUMN employees_hourly_rate DECIMAL NOT NULL;

INSERT INTO employees(username, password, employee_type, holiday_type) VALUES ('admin', 'password', 'manager', 'regular');

ALTER TABLE employee_contracts
ADD COLUMN alloted_leaves INT NOT NULL;

ALTER TABLE leave_types
DROP COLUMN paid;

INSERT INTO leave_types(name) VALUES ('Sick'), ('Vacation'), ('Special Privilege'), ('Maternity'), ('Paternity');

ALTER TABLE leaves
ADD COLUMN date_used DATE, ADD COLUMN end_date DATE, ADD COLUMN duration INT, ADD COLUMN leave_reason VARCHAR(255);
