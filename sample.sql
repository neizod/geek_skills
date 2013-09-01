USE geek_skills;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);

INSERT INTO users VALUES
    (NULL, 'foo'),
    (NULL, 'bar'),
    (NULL, 'spam'),
    (NULL, 'eggs'),
    (NULL, 'hannah'),
    (NULL, 'tester'),
    (NULL, 'uzer'),
    (NULL, 'xyzzy');

-- -------------------------------------------------------------

DROP TABLE IF EXISTS skills;
CREATE TABLE skills (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);

INSERT INTO skills VALUES
    (NULL, 'basic programming'),
    (NULL, 'oop programming'),
    (NULL, 'functional programming'),
    (NULL, 'logic programming'),
    (NULL, 'concurrent programming'),
    (NULL, 'regular expression'),
    (NULL, 'network security'),
    (NULL, 'file base'),
    (NULL, 'database'),
    (NULL, 'data mining'),
    (NULL, 'model view controller'),
    (NULL, 'mobile application'),
    (NULL, 'web application');

-- -------------------------------------------------------------

DROP TABLE IF EXISTS languages;
CREATE TABLE languages (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);

INSERT INTO languages VALUES
    (NULL, 'c'),
    (NULL, 'java'),
    (NULL, 'objective-c'),
    (NULL, 'bash'),
    (NULL, 'php'),
    (NULL, 'python'),
    (NULL, 'ruby'),
    (NULL, 'lua'),
    (NULL, 'haskell'),
    (NULL, 'erlang'),
    (NULL, 'javascript'),
    (NULL, 'css'),
    (NULL, 'html'),
    (NULL, 'brainfuck');

-- -------------------------------------------------------------

DROP TABLE IF EXISTS frameworks;
CREATE TABLE frameworks (
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
--  lang_id int(11) NOT NULL,         -- use this in real work,
    lang_name varchar(64) NOT NULL,   -- this line is for readable mockup.
    PRIMARY KEY (id),
    UNIQUE KEY (name)
);

INSERT INTO frameworks VALUES
    (NULL, 'django',      'python'),
    (NULL, 'rails',       'ruby'),
    (NULL, 'grals',       'java'),
    (NULL, 'drupal',      'php'),
    (NULL, 'laravel',     'php'),
    (NULL, 'codeigniter', 'php'),
    (NULL, 'jquery',      'javascript'),
    (NULL, 'phonegap',    'html'),
    (NULL, 'corona',      'lua');

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
    (NULL, 'beginner',               'know a language.'),
    (NULL, 'beginner++',             'know 2 languages.'),
    (NULL, 'beginner 101',           'know 5 languages.'),
    (NULL, 'work with a frame',      'know a framework'),
    (NULL, 'looking through window', 'know 4 framework'),
    (NULL, 'programming with class', 'know oop programming.'),
    (NULL, 'finally functional',     'know functional programming.'),
    (NULL, 'pickaxe and shovel',     'know data mining.'),
    (NULL, 'spider geek',            'know web application.'),
    (NULL, 'geeks everywhere',       'know mobile application.'),
    (NULL, 'psuedocoder',            'know python or ruby.'),
    (NULL, 'who is this',            'know javascript.'),
    (NULL, '!@#$%^&*()_+',           'know brainfuck.');
