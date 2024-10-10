DROP TABLE IF EXISTS menu_item;

CREATE TABLE menu_item (id INTEGER PRIMARY KEY, parent_id INTEGER, name VARCHAR(255));

INSERT INTO menu_item VALUES (1, null, 'Item 1');
INSERT INTO menu_item VALUES (2, 1, 'Item 1.1');
INSERT INTO menu_item VALUES (3, 1, 'Item 1.2');

INSERT INTO menu_item VALUES (4, null, 'Item 2');
INSERT INTO menu_item VALUES (5, 4, 'Item 2.1');
INSERT INTO menu_item VALUES (6, 5, 'Item 2.1.1');
