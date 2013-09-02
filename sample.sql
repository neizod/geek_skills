USE geek_skills;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);

INSERT INTO users VALUES
    (1, 'foo'),
    (2, 'bar'),
    (3, 'spam'),
    (4, 'eggs'),
    (5, 'hannah'),
    (6, 'tester'),
    (7, 'uzer'),
    (8, 'xyzzy');

-- -------------------------------------------------------------

DROP TABLE IF EXISTS skills;
CREATE TABLE skills (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);

INSERT INTO skills VALUES
    ( 1, 'basic programming'),
    ( 2, 'oop programming'),
    ( 3, 'functional programming'),
    ( 4, 'logic programming'),
    ( 5, 'concurrent programming'),
    ( 6, 'regular expression'),
    ( 7, 'network security'),
    ( 8, 'file base'),
    ( 9, 'database'),
    (10, 'data mining'),
    (11, 'model view controller'),
    (12, 'mobile application'),
    (13, 'web application');

-- -------------------------------------------------------------

DROP TABLE IF EXISTS languages;
CREATE TABLE languages (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);

INSERT INTO languages VALUES
    ( 1, 'c'),
    ( 2, 'java'),
    ( 3, 'objective-c'),
    ( 4, 'bash'),
    ( 5, 'php'),
    ( 6, 'python'),
    ( 7, 'ruby'),
    ( 8, 'lua'),
    ( 9, 'haskell'),
    (10, 'erlang'),
    (11, 'javascript'),
    (12, 'css'),
    (13, 'html'),
    (14, 'brainfuck');

-- -------------------------------------------------------------

DROP TABLE IF EXISTS frameworks;
CREATE TABLE frameworks (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    lid int(11) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);

INSERT INTO frameworks VALUES
    (1, 'django',       6),
    (2, 'rails',        7),
    (3, 'grals',        2),
    (4, 'drupal',       5),
    (5, 'laravel',      5),
    (6, 'codeigniter',  5),
    (7, 'jquery',      11),
    (8, 'phonegap',    13),
    (9, 'corona',       8);

-- -------------------------------------------------------------

DROP TABLE IF EXISTS achievements;
CREATE TABLE achievements (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    description text,
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);

INSERT INTO achievements VALUES
    ( 1, 'beginner',               'know a language.'),
    ( 2, 'beginner++',             'know 2 languages.'),
    ( 3, 'beginner 101',           'know 5 languages.'),
    ( 4, 'work with a frame',      'know a framework'),
    ( 5, 'looking through window', 'know 4 framework'),
    ( 6, 'programming with class', 'know oop programming.'),
    ( 7, 'finally functional',     'know functional programming.'),
    ( 8, 'pickaxe and shovel',     'know data mining.'),
    ( 9, 'spider geek',            'know web application.'),
    (10, 'geeks everywhere',       'know mobile application.'),
    (11, 'psuedocoder',            'know python or ruby.'),
    (12, 'who is this',            'know javascript.'),
    (13, '!@#$%',                  'know brainfuck.');
