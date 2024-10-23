CREATE DATABASE smart_manufacturing;


-- Users Table
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL
);

-- Jobs Table
CREATE TABLE jobs (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    job_name VARCHAR(100) NOT NULL,
    job_description TEXT NOT NULL
);

-- Machines Table
CREATE TABLE machines (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    machine_name VARCHAR(100) NOT NULL,
    machine_description TEXT NOT NULL,
    status VARCHAR(50) NOT NULL
);


-- Insert sample users
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@example.com', 'adminpassword', 'Admin'),
('manager', 'manager@example.com', 'managerpassword', 'Factory Manager'),
('operator', 'operator@example.com', 'operatorpassword', 'Production Operator'),
('auditor', 'auditor@example.com', 'auditorpassword', 'Auditor');

-- Insert sample jobs
INSERT INTO jobs (job_name, job_description) VALUES
('Job 1', 'Description for Job 1'),
('Job 2', 'Description for Job 2'),
('Job 3', 'Description for Job 3');

-- Insert sample machines
INSERT INTO machines (machine_name, machine_description, status) VALUES
('Machine 1', 'Description for Machine 1', 'Active'),
('Machine 2', 'Description for Machine 2', 'Inactive'),
('Machine 3', 'Description for Machine 3', 'Active');
