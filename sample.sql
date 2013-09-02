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

-- -------------------------------------------------------------

-- RELATION TABLES
-- ===============
-- skill_requirement
-- framework_requirement
-- user_achievement  --> trigger-base
-- user_skill
-- user_language
-- user_framework

-- -------------------------------------------------------------

DROP TABLE IF EXISTS skill_requirement;
CREATE TABLE skill_requirement (
    request_sid int(11) NOT NULL,
    require_sid int(11) NOT NULL,
    PRIMARY KEY (request_sid, require_sid)
);

INSERT INTO skill_requirement VALUES
    ( 2,  1),
    ( 3,  1),
    ( 4,  3),
    ( 5,  3),
    ( 7,  1),
    ( 8,  1),
    ( 8,  5),
    ( 9,  1),
    (10,  9),
    (10,  6),
    (11,  2),
    (11,  9),
    (12, 11),
    (13, 11);

-- -------------------------------------------------------------

DROP TABLE IF EXISTS framework_requirement;
CREATE TABLE framework_requirement (
    request_fid int(11) NOT NULL,
    require_sid int(11) NOT NULL,
    PRIMARY KEY (request_fid, require_sid)
);

INSERT INTO framework_requirement VALUES
    (1, 13),
    (2, 13),
    (3, 13),
    (4, 13),
    (4,  7),
    (5, 13),
    (6, 13),
    (7,  3),
    (8, 12),
    (8, 13),
    (9, 12);

-- -------------------------------------------------------------

DROP TABLE IF EXISTS user_achievement;
CREATE TABLE user_achievement (
    uid int(11) NOT NULL,
    aid int(11) NOT NULL,
    PRIMARY KEY (uid, aid)
);

-- -------------------------------------------------------------

DROP TABLE IF EXISTS user_skill;
CREATE TABLE user_skill (
    uid int(11) NOT NULL,
    sid int(11) NOT NULL,
    PRIMARY KEY (uid, sid)
);

DELIMITER !
CREATE TRIGGER skill_achievement AFTER INSERT ON user_skill
    FOR EACH ROW BEGIN
        CASE NEW.sid
            WHEN 2 THEN -- oop
                INSERT INTO user_achievement VALUES (NEW.uid, 6);
            WHEN 3 THEN -- fun
                INSERT INTO user_achievement VALUES (NEW.uid, 7);
            WHEN 10 THEN -- mining
                INSERT INTO user_achievement VALUES (NEW.uid, 8);
            WHEN 12 THEN -- mobile
                INSERT INTO user_achievement VALUES (NEW.uid, 10);
            WHEN 13 THEN -- web
                INSERT INTO user_achievement VALUES (NEW.uid, 9);
            ELSE BEGIN END;
        END CASE;
    END!
DELIMITER ;

INSERT INTO user_skill VALUES
    (1,  1),
    (1,  3),
    (2,  1),
    (2,  9),
    (3,  6),
    (4,  1),
    (4,  2),
    (5,  1),
    (5,  2),
    (5,  9),
    (5, 11),
    (5, 12),
    (6,  1),
    (6,  2),
    (6,  9),
    (6, 11),
    (6, 13),
    (8,  1),
    (8,  4),
    (8,  5),
    (8,  9),
    (8, 10);

-- -------------------------------------------------------------

DROP TABLE IF EXISTS user_language;
CREATE TABLE user_language (
    uid int(11) NOT NULL,
    lid int(11) NOT NULL,
    PRIMARY KEY (uid, lid)
);

DELIMITER !
CREATE TRIGGER language_achievement AFTER INSERT ON user_language
    FOR EACH ROW BEGIN
        CASE (SELECT count(*) FROM user_language ul WHERE ul.uid=NEW.uid)
            WHEN 1 THEN
                INSERT INTO user_achievement VALUES (NEW.uid, 1);
            WHEN 2 THEN
                INSERT INTO user_achievement VALUES (NEW.uid, 2);
            WHEN 5 THEN
                INSERT INTO user_achievement VALUES (NEW.uid, 3);
            ELSE BEGIN END;
        END CASE;

        CASE NEW.lid
            WHEN 6 THEN -- python
                INSERT INTO user_achievement VALUES (NEW.uid, 11);
            WHEN 7 THEN -- ruby
                INSERT INTO user_achievement VALUES (NEW.uid, 11);
            WHEN 11 THEN -- javascript
                INSERT INTO user_achievement VALUES (NEW.uid, 12);
            WHEN 14 THEN -- brainfuck
                INSERT INTO user_achievement VALUES (NEW.uid, 13);
            ELSE BEGIN END;
        END CASE;
    END!
DELIMITER ;

INSERT INTO user_language VALUES
    (1,  9),
    (2,  2),
    (3,  1),
    (3,  4),
    (4,  2),
    (5,  2),
    (5,  3),
    (5,  8),
    (6,  4),
    (6,  5),
    (6, 11),
    (6, 12),
    (6, 13),
    (7, 14),
    (8,  4),
    (8,  5);

-- -------------------------------------------------------------

DROP TABLE IF EXISTS user_framework;
CREATE TABLE user_framework (
    uid int(11) NOT NULL,
    fid int(11) NOT NULL,
    PRIMARY KEY (uid, fid)
);

DELIMITER !
CREATE TRIGGER framework_achievement AFTER INSERT ON user_framework
    FOR EACH ROW BEGIN
        CASE (SELECT count(*) FROM user_framework uf WHERE uf.uid=NEW.uid)
            WHEN 1 THEN
                INSERT INTO user_achievement VALUES (NEW.uid, 4);
            WHEN 4 THEN
                INSERT INTO user_achievement VALUES (NEW.uid, 5);
            ELSE BEGIN END;
        END CASE;
    END!
DELIMITER ;

INSERT INTO user_framework VALUES
    (5, 9),
    (6, 5),
    (6, 7);
