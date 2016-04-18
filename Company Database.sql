CREATE DATABASE company;
USE company;

CREATE TABLE employees(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	hourly_rate INT NOT NULL,
	remaining_leaves INT NOT NULL,
	employee_type VARCHAR(255) NOT NULL,
	holiday_type VARCHAR(255) NOT NULL,
	employee_contracts_id INT NOT NULL); 

CREATE TABLE employee_contracts(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	start_date DATE NOT NULL,
	duration DATE NOT NULL,
	employees_id INT NOT NULL,
	FOREIGN KEY(employees_id) REFERENCES employees(id));

ALTER TABLE employees
ADD FOREIGN KEY(employee_contracts_id) REFERENCES employee_contracts(id);

CREATE TABLE leaves(id INT NOT NULL PRIMARY KEY,
	status VARCHAR(255) NOT NULL,
	employees_id INT NOT NULL,
	leave_types_id INT NOT NULL,
	FOREIGN KEY(employees_id) REFERENCES employees(id));

CREATE TABLE leave_types(id INT NOT NULL PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	paid TINYINT(1) NOT NULL);

ALTER TABLE leaves
ADD FOREIGN KEY(leave_types_id) REFERENCES leave_types(id);

CREATE TABLE workdays(id INT NOT NULL PRIMARY KEY,
	time_in DATETIME NOT NULL,
	time_out DATETIME NOT NULL,
	overtime_hours INT,
	employees_id INT NOT NULL,
	leaves_id INT,
	FOREIGN KEY(employees_id) REFERENCES employees(id),
	FOREIGN KEY(leaves_id) REFERENCES leaves(id));
