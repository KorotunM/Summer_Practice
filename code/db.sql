CREATE TABLE cost (
    id INT PRIMARY KEY,
    item_id INT NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    item_type VARCHAR(10) NOT NULL,
    price_per_unit DECIMAL(10,2) NOT NULL
);
CREATE TABLE employee (
    id INT PRIMARY KEY,
    employee_id INT NOT NULL,
    department_id INT NOT NULL,
    fio VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    tel VARCHAR(20) NOT NULL
);
CREATE TABLE office_log (
    id INT PRIMARY KEY,
    item_id INT NOT NULL,
    emp_change_id INT NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    expense_date DATE NOT NULL
);
CREATE TABLE department (
    id INT PRIMARY KEY,
    department_id INT NOT NULL,
    department_name VARCHAR(255) NOT NULL,
    manager_name VARCHAR(255) NOT NULL
);