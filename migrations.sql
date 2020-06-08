CREATE TABLE tasks
(
    id       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    username VARCHAR(255) NOT NULL,
    email    VARCHAR(255) NOT NULL,
    text     VARCHAR(255) NOT NULL,
    state    TINYINT(1)   NOT NULL,
    edited   TINYINT(1)   NOT NULL
);

INSERT INTO tasks(username, email, text, state, edited)
VALUES ('testuser', 'testuser@test.ru', 'Text testuser`s task 1', 1, 0),
       ('testuser', 'testuser@test.ru', 'Text testuser`s task 2', 0, 0),
       ('testuser', 'testuser@test.ru', 'Text testuser`s task 3', 0, 0),
       ('testuser', 'testuser@test.ru', 'Text testuser`s task 4', 1, 0),
       ('user', 'user@test.ru', 'Text user`s task 1', 0, 0),
       ('user', 'user@test.ru', 'Text user`s task 2', 1, 0),
       ('user', 'user@test.ru', 'Text user`s task 3', 0, 0),
       ('test', 'test@test.ru', 'Text test`s task 1', 0, 0),
       ('test', 'test@test.ru', 'Text test`s task 2', 0, 0),
       ('test', 'test@test.ru', 'Text test`s task 3', 0, 0),
       ('test', 'test@test.ru', 'Text test`s task 4', 0, 0);
