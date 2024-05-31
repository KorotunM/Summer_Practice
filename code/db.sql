CREATE TABLE cost (
    item_id INT(10) NOT NULL AUTO_INCREMENT,
    item_name VARCHAR(255) NOT NULL,
    item_type VARCHAR(10) NOT NULL CHECK (item_type REGEXP '^(кг|шт|гр)$'),
    price_per_unit DECIMAL(10,2) NOT NULL,
    PRIMARY KEY(item_id)
);

CREATE TABLE department (
    department_id INT(10) NOT NULL AUTO_INCREMENT,
    department_name VARCHAR(255) NOT NULL,
    manager_name VARCHAR(255) NOT NULL,
    adres VARCHAR(255) NOT NULL,
    PRIMARY KEY(department_id)
);

CREATE TABLE employee (
    employee_id INT(10) NOT NULL AUTO_INCREMENT,
    department_id INT(10) NOT NULL,
    fio VARCHAR(255) NOT NULL,
    tel VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    position VARCHAR(255) NOT NULL,
    PRIMARY KEY(employee_id),
    FOREIGN KEY(department_id) REFERENCES department(department_id)
);

CREATE TABLE office_log (
    id INT(10) AUTO_INCREMENT,
    item_id INT(10) NOT NULL,
    employee_id INT(10) NOT NULL,
    quantity INT(10) NOT NULL,
    purpose VARCHAR(255) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(item_id) REFERENCES cost(item_id),
    FOREIGN KEY(employee_id) REFERENCES employee(employee_id)
);

INSERT INTO cost (item_name, item_type, price_per_unit) VALUES ('Сахар', 'кг', 45.50);
INSERT INTO cost (item_name, item_type, price_per_unit) VALUES ('Ручка', 'шт', 12.75);
INSERT INTO cost (item_name, item_type, price_per_unit) VALUES ('Шоколадка', 'шт', 60.00);

INSERT INTO department (department_name, manager_name, adres) VALUES ('Отдел продаж', 'Иван Иванов', 'ул. Ленина, 1');
INSERT INTO department (department_name, manager_name, adres) VALUES ('Бухгалтерия', 'Петр Петров', 'ул. Пушкина, 2');
INSERT INTO department (department_name, manager_name, adres) VALUES ('IT отдел', 'Анна Сидорова', 'ул. Чехова, 3');

INSERT INTO employee (department_id, fio, tel, email, position) VALUES (1, 'Алексей Смирнов', '89012345678', 'smirnov@example.com', 'Менеджер по продажам');
INSERT INTO employee (department_id, fio, tel, email, position) VALUES (2, 'Мария Иванова', '89023456789', 'ivanova@example.com', 'Бухгалтер');
INSERT INTO employee (department_id, fio, tel, email, position) VALUES (3, 'Дмитрий Козлов', '89034567890', 'kozlov@example.com', 'Системный администратор');

INSERT INTO office_log (item_id, employee_id, quantity, purpose) VALUES (1, 1, 5, 'Закупка сахара для отдела продаж');
INSERT INTO office_log (item_id, employee_id, quantity, purpose) VALUES (2, 2, 50, 'Канцелярия для бухгалтерии');
INSERT INTO office_log (item_id, employee_id, quantity, purpose) VALUES (3, 3, 10, 'Шоколакдки для сотрудников IT отдела');
