show databases;

use vlsevt;

show tables;

create table employees (
                           id INT AUTO_INCREMENT PRIMARY KEY,
                           first_name VARCHAR(50) NOT NULL,
                           last_name VARCHAR(50) NOT NULL,
                           position VARCHAR(50),
                           is_available TINYINT(1) DEFAULT 0,
                           image_path VARCHAR(255)
);

drop table tasks;

drop table task_assignment;

DELETE from tasks;

DELETE from employees;

INSERT INTO tasks VALUES () ;


create table tasks (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       description VARCHAR(255) NOT NULL,
                       estimate INT DEFAULT 0,
                       employee_id INT DEFAULT 0,
                       completed BOOL DEFAULT FALSE
);



CREATE TABLE task_assignment (
                                 id INT AUTO_INCREMENT PRIMARY KEY,
                                 task_id INT DEFAULT 0,
                                 employee_id INT DEFAULT 0,
                                 FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE,
                                 FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);



select * from employees;

select * from tasks;