CREATE TABLE cost (
    item_id int(10) NOT NULL AUTO_INCREMENT,
    item_name VARCHAR(255) NOT NULL,
    item_type VARCHAR(10) NOT NULL CHECK (item_type REGEXP '^(кг|шт|гр)$'),
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
    id int(10) AUTO_INCREMENT,
    item_id int(10) NOT NULL,
    employee_id int(10) NOT NULL,
    quantity int(10) NOT NULL,
    purpose VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
CREATE TABLE department (
    department_id int(10) NOT NULL AUTO_INCREMENT,
    department_name VARCHAR(255) NOT NULL,
    manager_name VARCHAR(255) NOT NULL,
    adres VARCHAR(255) NOT NULL,
    PRIMARY KEY(department_id)
);

INSERT INTO employee (department_id, fio, tel, email, position)
VALUES ('1', 'Иванов Иван Иванович', '+79001234567', 'ivanov@example.com', 'Менеджер');
INSERT INTO employee (department_id, fio, tel, email, position)
VALUES ('2', 'Петрова Елена Сергеевна', '+79019876543', 'petrova@example.com', 'Разработчик');

INSERT INTO department (department_name, manager_name, adres)
VALUES ('IT', 'John Smith', '123 Main St');
INSERT INTO department (department_name, manager_name, adres)
VALUES ('HR', 'Jane Doe', '456 Elm St');

INSERT INTO cost (item_name, item_type, price_per_unit)
VALUES ('Paper', 'Stationery', 1.50);
INSERT INTO cost (item_name, item_type, price_per_unit)
VALUES ('Pens', 'Stationery', 0.75);

INSERT INTO office_log (item_id, employee_id, quantity, purpose)
VALUES (2, 18, 10, 'Распечатка документов');
INSERT INTO office_log (item_id, employee_id, quantity, purpose)
VALUES (3, 25, 5, 'Записи в блокноте');