CREATE TABLE cost (
    item_id int(10) NOT NULL AUTO_INCREMENT,
    item_name VARCHAR(255) NOT NULL,
    item_type VARCHAR(10) NOT NULL,
    price_per_unit DECIMAL(10,2) NOT NULL,
    PRIMARY KEY(item_id)
);
CREATE TABLE employee (
    employee_id int(10) NOT NULL AUTO_INCREMENT,
    department_id VARCHAR(255) NOT NULL,
    fio VARCHAR(255) NOT NULL,
    tel VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,
    PRIMARY KEY(employee_id)
);
CREATE TABLE office_log (
    id int(10) AUTO_INCREMENT PRIMARY KEY,
    item_id int(10) NOT NULL,
    emp_change_id VARCHAR(255) NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    quantity int(10) NOT NULL,
    expense_date DATE NOT NULL,
    PRIMARY KEY(id)
);
CREATE TABLE department (
    department_id int(10) NOT NULL AUTO_INCREMENT,
    department_name VARCHAR(255) NOT NULL,
    manager_name VARCHAR(255) NOT NULL,
    PRIMARY KEY(department_id)
);

INSERT INTO employee (department_id, fio, tel, email, position)
VALUES ('1', 'Иванов Иван Иванович', '+79001234567', 'ivanov@example.com', 'Менеджер');
INSERT INTO employee (department_id, fio, tel, email, position)
VALUES ('2', 'Петрова Елена Сергеевна', '+79019876543', 'petrova@example.com', 'Разработчик');

INSERT INTO department (department_name, manager_name)
VALUES ('Отдел продаж', 'Иванов Иван Иванович');
INSERT INTO department (department_name, manager_name)
VALUES ('Отдел разработки', 'Петрова Елена Сергеевна');