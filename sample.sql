USE geek_skills;

-- -------------------------------------------------------------

-- HELPER FUNCTION FOR READABILITY SOURCE ONLY
-- ===========================================

DROP FUNCTION IF EXISTS l;
CREATE FUNCTION l (lang varchar(64)) RETURNS int(11)
    RETURN (SELECT id FROM languages WHERE name=lang);

DROP FUNCTION IF EXISTS f;
CREATE FUNCTION f (frame varchar(64)) RETURNS int(11)
    RETURN (SELECT id FROM frameworks WHERE name=frame);

DROP FUNCTION IF EXISTS s;
CREATE FUNCTION s (skill varchar(64)) RETURNS int(11)
    RETURN (SELECT id FROM skills WHERE name LIKE CONCAT('%', skill, '%'));

DROP FUNCTION IF EXISTS a;
CREATE FUNCTION a (ac varchar(64)) RETURNS int(11)
    RETURN (SELECT id FROM achievements WHERE name LIKE CONCAT('%', ac, '%'));

-- -------------------------------------------------------------

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
    (1, 'django',      l('python')),
    (2, 'rails',       l('ruby')),
    (3, 'grals',       l('java')),
    (4, 'drupal',      l('php')),
    (5, 'laravel',     l('php')),
    (6, 'codeigniter', l('php')),
    (7, 'jquery',      l('javascript')),
    (8, 'phonegap',    l('html')),
    (9, 'corona',      l('lua'));

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
    (s('oop'),        s('basic')),
    (s('functional'), s('basic')),
    (s('logic'),      s('functional')),
    (s('concurrent'), s('functional')),
    (s('security'),   s('basic')),
    (s('file'),       s('basic')),
    (s('file'),       s('concurrent')),
    (s('database'),   s('basic')),
    (s('mining'),     s('database')),
    (s('mining'),     s('regular ex')),
    (s('model'),      s('oop')),
    (s('model'),      s('database')),
    (s('mobile'),     s('model')),
    (s('web'),        s('model'));

-- -------------------------------------------------------------

DROP TABLE IF EXISTS framework_requirement;
CREATE TABLE framework_requirement (
    request_fid int(11) NOT NULL,
    require_sid int(11) NOT NULL,
    PRIMARY KEY (request_fid, require_sid)
);

INSERT INTO framework_requirement VALUES
    (f('django'),      s('web')),
    (f('rails'),       s('web')),
    (f('grals'),       s('web')),
    (f('drupal'),      s('web')),
    (f('drupal'),      s('security')),
    (f('laravel'),     s('web')),
    (f('codeigniter'), s('web')),
    (f('jquery'),      s('functional')),
    (f('phonegap'),    s('mobile')),
    (f('phonegap'),    s('web')),
    (f('corona'),      s('mobile'));

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
            WHEN s('oop') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('class'));
            WHEN s('functional') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('functional'));
            WHEN s('mining') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('pickaxe'));
            WHEN s('mobile') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('everywhere'));
            WHEN s('web') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('spider'));
            ELSE BEGIN END;
        END CASE;
    END!
DELIMITER ;

INSERT INTO user_skill VALUES
    (1, s('basic')),
    (1, s('functional')),
    (2, s('basic')),
    (2, s('database')),
    (3, s('regular ex')),
    (4, s('basic')),
    (4, s('oop')),
    (5, s('basic')),
    (5, s('oop')),
    (5, s('database')),
    (5, s('model')),
    (5, s('mobile')),
    (6, s('basic')),
    (6, s('oop')),
    (6, s('database')),
    (6, s('model')),
    (6, s('web')),
    (8, s('basic')),
    (8, s('logic')),
    (8, s('concurrent')),
    (8, s('database')),
    (8, s('mining'));

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
                INSERT INTO user_achievement VALUES (NEW.uid, a('++'));
            WHEN 5 THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('101'));
            ELSE BEGIN END;
        END CASE;

        CASE NEW.lid
            WHEN l('python') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('psuedocode'));
            WHEN l('ruby') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('psuedocode'));
            WHEN l('javascript') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('this'));
            WHEN l('brainfuck') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('!@#$%'));
            ELSE BEGIN END;
        END CASE;
    END!
DELIMITER ;

INSERT INTO user_language VALUES
    (1, l('haskell')),
    (2, l('java')),
    (3, l('c')),
    (3, l('bash')),
    (4, l('java')),
    (5, l('java')),
    (5, l('objective-c')),
    (5, l('lua')),
    (6, l('bash')),
    (6, l('php')),
    (6, l('javascript')),
    (6, l('css')),
    (6, l('html')),
    (7, l('brainfuck')),
    (8, l('bash')),
    (8, l('php'));

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
                INSERT INTO user_achievement VALUES (NEW.uid, a('frame'));
            WHEN 4 THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('window'));
            ELSE BEGIN END;
        END CASE;
    END!
DELIMITER ;

INSERT INTO user_framework VALUES
    (5, f('corona')),
    (6, f('laravel')),
    (6, f('jquery'));
