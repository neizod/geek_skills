DROP DATABASE IF EXISTS geek_skills;
CREATE DATABASE geek_skills;
USE geek_skills;

-- -------------------------------------------------------------

-- HELPER FUNCTION FOR READABILITY SOURCE AND SHORTHAND TRIGGER CODING
-- ===================================================================
-- l, f, s, a --> one letter function name for fast query by name

-- -------------------------------------------------------------

CREATE FUNCTION l (lang varchar(64)) RETURNS int(11)
    RETURN (SELECT lid FROM languages WHERE name=lang);

CREATE FUNCTION f (frame varchar(64)) RETURNS int(11)
    RETURN (SELECT fid FROM frameworks WHERE name=frame);

CREATE FUNCTION s (skill varchar(64)) RETURNS int(11)
    RETURN (SELECT sid FROM skills WHERE name LIKE CONCAT('%', skill, '%'));

CREATE FUNCTION a (ac varchar(64)) RETURNS int(11)
    RETURN (SELECT aid FROM achievements WHERE name LIKE CONCAT('%', ac, '%'));

-- -------------------------------------------------------------

-- DATA TABLES
-- ===========
-- users --> the only insert+delet data table here
-- skills
-- language
-- frameworks
-- achievements

-- -------------------------------------------------------------

CREATE TABLE users (
    uid  int(11)     NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    more text        NOT NULL DEFAULT '',
    PRIMARY KEY (uid),
    UNIQUE KEY (name)
);

INSERT INTO users VALUES
    (NULL, 'foo',     'mathematician.'),
    (NULL, 'bar',     'project manager, business man, i cant code.'),
    (NULL, 'spam',    'i create shiny new language!'),
    (NULL, 'eggs',    'mobile is the future <3'),
    (NULL, 'hal9000', 'daisy, daisy.'),
    (NULL, 'xyzzy',   'boring web dev.'),
    (NULL, 'uzer',    'i interest in finite automata.'),
    (NULL, 'tester',  'hacker');

-- -------------------------------------------------------------

CREATE TABLE skills (
    sid int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    PRIMARY KEY (sid),
    UNIQUE KEY (name)
);

INSERT INTO skills VALUES
    (NULL, 'basic programming'),
    (NULL, 'oop programming'),
    (NULL, 'functional programming'),
    (NULL, 'logic programming'),
    (NULL, 'concurrent programming'),
    (NULL, 'system programming'),
    (NULL, 'regular expression'),
    (NULL, 'network security'),
    (NULL, 'data structure'),
    (NULL, 'database'),
    (NULL, 'data mining'),
    (NULL, 'model view controller'),
    (NULL, 'mobile application'),
    (NULL, 'web application'),
    (NULL, 'computer architecture'),
    (NULL, 'ai'),
    (NULL, 'algorithm'),
    (NULL, 'compiler');

-- -------------------------------------------------------------

CREATE TABLE languages (
    lid int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    PRIMARY KEY (lid),
    UNIQUE KEY (name)
);

INSERT INTO languages VALUES
    (NULL, 'c'),
    (NULL, 'java'),
    (NULL, 'objective-c'),
    (NULL, 'bash'),
    (NULL, 'php'),
    (NULL, 'perl'),
    (NULL, 'python'),
    (NULL, 'ruby'),
    (NULL, 'lisp'),
    (NULL, 'lua'),
    (NULL, 'haskell'),
    (NULL, 'erlang'),
    (NULL, 'javascript'),
    (NULL, 'css'),
    (NULL, 'html'),
    (NULL, 'brainfuck');

-- -------------------------------------------------------------

CREATE TABLE frameworks (
    fid int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    lid int(11) NOT NULL,
    PRIMARY KEY (fid),
    UNIQUE KEY (name),
    FOREIGN KEY (lid) REFERENCES languages (lid)
);

INSERT INTO frameworks VALUES
    (NULL, 'django',      l('python')),
    (NULL, 'rails',       l('ruby')),
    (NULL, 'grals',       l('java')),
    (NULL, 'drupal',      l('php')),
    (NULL, 'laravel',     l('php')),
    (NULL, 'codeigniter', l('php')),
    (NULL, 'jquery',      l('javascript')),
    (NULL, 'phonegap',    l('html')),
    (NULL, 'corona',      l('lua'));

-- -------------------------------------------------------------

CREATE TABLE achievements (
    aid int(11) NOT NULL AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    description text,
    PRIMARY KEY (aid),
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
    (NULL, 'psuedocoder',            'know python.'),
    (NULL, 'happy coding',           'know ruby.'),
    (NULL, 'tim toady bicarbonate',  'know perl.'),
    (NULL, 'who is this',            'know javascript.'),
    (NULL, '!@#$%',                  'know brainfuck.');

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

CREATE TABLE skill_requirement (
    rid int(11) NOT NULL,
    sid int(11) NOT NULL,
    PRIMARY KEY (rid, sid),
    FOREIGN KEY (rid) REFERENCES skills (sid),
    FOREIGN KEY (sid) REFERENCES skills (sid)
);

INSERT INTO skill_requirement VALUES
    (s('algorithm'),  s('basic')),
    (s('functional'), s('basic')),
    (s('logic'),      s('functional')),
    (s('ai'),         s('logic')),
    (s('ai'),         s('database')),
    (s('database'),   s('data structure')),
    (s('mining'),     s('database')),
    (s('mining'),     s('regular ex')),
    (s('oop'),        s('basic')),
    (s('model'),      s('oop')),
    (s('model'),      s('database')),
    (s('mobile'),     s('model')),
    (s('web'),        s('model')),
    (s('concurrent'), s('basic')),
    (s('concurrent'), s('architecture')),
    (s('system'),     s('concurrent')),
    (s('security'),   s('system')),
    (s('compiler'),   s('system')),
    (s('compiler'),   s('regular ex'));

-- -------------------------------------------------------------

CREATE TABLE framework_requirement (
    fid int(11) NOT NULL,
    sid int(11) NOT NULL,
    PRIMARY KEY (fid, sid),
    FOREIGN KEY (fid) REFERENCES frameworks (fid),
    FOREIGN KEY (sid) REFERENCES skills (sid)
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

CREATE TABLE user_achievement (
    uid int(11) NOT NULL,
    aid int(11) NOT NULL,
    PRIMARY KEY (uid, aid),
    FOREIGN KEY (uid) REFERENCES users (uid),
    FOREIGN KEY (aid) REFERENCES achievements (aid)
);

-- -------------------------------------------------------------

CREATE TABLE user_skill (
    uid int(11) NOT NULL,
    sid int(11) NOT NULL,
    PRIMARY KEY (uid, sid),
    FOREIGN KEY (uid) REFERENCES users (uid),
    FOREIGN KEY (sid) REFERENCES skills (sid)
);

DELIMITER !
CREATE TRIGGER add_skill_achievement AFTER INSERT ON user_skill
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


CREATE TRIGGER del_skill_achievement AFTER DELETE ON user_skill
    FOR EACH ROW BEGIN
        CASE OLD.sid
            WHEN s('oop') THEN
                DELETE FROM user_achievement WHERE aid = a('class')
                                             AND   uid = OLD.uid;
            WHEN s('functional') THEN
                DELETE FROM user_achievement WHERE aid = a('functional')
                                             AND   uid = OLD.uid;
            WHEN s('mining') THEN
                DELETE FROM user_achievement WHERE aid = a('pickaxe')
                                             AND   uid = OLD.uid;
            WHEN s('mobile') THEN
                DELETE FROM user_achievement WHERE aid = a('everywhere')
                                             AND   uid = OLD.uid;
            WHEN s('web') THEN
                DELETE FROM user_achievement WHERE aid = a('spider')
                                             AND   uid = OLD.uid;
            ELSE BEGIN END;
        END CASE;
    END!
DELIMITER ;

INSERT INTO user_skill VALUES
    (1, s('basic')),
    (1, s('algo')),
    (1, s('functional')),
    (2, s('data structure')),
    (2, s('database')),
    (2, s('regular ex')),
    (2, s('mining')),
    (3, s('basic')),
    (3, s('computer architec')),
    (3, s('concurrent')),
    (3, s('system')),
    (3, s('regular ex')),
    (3, s('compiler')),
    (4, s('basic')),
    (4, s('algo')),
    (4, s('oop')),
    (4, s('data structure')),
    (4, s('database')),
    (4, s('model')),
    (4, s('mobile')),
    (5, s('basic')),
    (5, s('algo')),
    (5, s('functional')),
    (5, s('logic')),
    (5, s('data structure')),
    (5, s('database')),
    (5, s('ai')),
    (6, s('basic')),
    (6, s('oop')),
    (6, s('data structure')),
    (6, s('database')),
    (6, s('model')),
    (6, s('regular ex')),
    (6, s('web')),
    (7, s('computer architec')),
    (7, s('regular ex')),
    (8, s('basic')),
    (8, s('algo')),
    (8, s('functional')),
    (8, s('logic')),
    (8, s('computer architec')),
    (8, s('concurrent')),
    (8, s('data structure')),
    (8, s('database')),
    (8, s('regular ex')),
    (8, s('mining')),
    (8, s('ai')),
    (8, s('system')),
    (8, s('security'));

-- -------------------------------------------------------------

CREATE TABLE user_language (
    uid int(11) NOT NULL,
    lid int(11) NOT NULL,
    PRIMARY KEY (uid, lid),
    FOREIGN KEY (uid) REFERENCES users (uid),
    FOREIGN KEY (lid) REFERENCES languages (lid)
);

DELIMITER !
CREATE TRIGGER add_language_achievement AFTER INSERT ON user_language
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
                INSERT INTO user_achievement VALUES (NEW.uid, a('happy'));
            WHEN l('perl') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('tim toady'));
            WHEN l('javascript') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('this'));
            WHEN l('brainfuck') THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('!@#$%'));
            ELSE BEGIN END;
        END CASE;
    END!


CREATE TRIGGER del_language_achievement AFTER DELETE ON user_language
    FOR EACH ROW BEGIN
        CASE (SELECT count(*) FROM user_language ul WHERE ul.uid=OLD.uid)
            WHEN 0 THEN
                DELETE FROM user_achievement WHERE aid = 1
                                             AND   uid = OLD.uid;
            WHEN 1 THEN
                DELETE FROM user_achievement WHERE aid = a('++')
                                             AND   uid = OLD.uid;
            WHEN 4 THEN
                DELETE FROM user_achievement WHERE aid = a('101')
                                             AND   uid = OLD.uid;
            ELSE BEGIN END;
        END CASE;

        CASE OLD.lid
            WHEN l('python') THEN
                DELETE FROM user_achievement WHERE aid = a('psuedocode')
                                             AND   uid = OLD.uid;
            WHEN l('ruby') THEN
                DELETE FROM user_achievement WHERE aid = a('happy')
                                             AND   uid = OLD.uid;
            WHEN l('perl') THEN
                DELETE FROM user_achievement WHERE aid = a('tim toady')
                                             AND   uid = OLD.uid;
            WHEN l('javascript') THEN
                DELETE FROM user_achievement WHERE aid = a('this')
                                             AND   uid = OLD.uid;
            WHEN l('brainfuck') THEN
                DELETE FROM user_achievement WHERE aid = a('!@#$%')
                                             AND   uid = OLD.uid;
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
    (4, l('objective-c')),
    (4, l('lua')),
    (5, l('java')),
    (6, l('bash')),
    (6, l('php')),
    (6, l('javascript')),
    (6, l('css')),
    (6, l('html')),
    (7, l('brainfuck')),
    (8, l('bash')),
    (8, l('php'));

-- -------------------------------------------------------------

CREATE TABLE user_framework (
    uid int(11) NOT NULL,
    fid int(11) NOT NULL,
    PRIMARY KEY (uid, fid),
    FOREIGN KEY (uid) REFERENCES users (uid),
    FOREIGN KEY (fid) REFERENCES frameworks (fid)
);

DELIMITER !
CREATE TRIGGER add_framework_achievement AFTER INSERT ON user_framework
    FOR EACH ROW BEGIN
        CASE (SELECT count(*) FROM user_framework uf WHERE uf.uid=NEW.uid)
            WHEN 1 THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('frame'));
            WHEN 4 THEN
                INSERT INTO user_achievement VALUES (NEW.uid, a('window'));
            ELSE BEGIN END;
        END CASE;
    END!


CREATE TRIGGER del_framework_achievement AFTER DELETE ON user_framework
    FOR EACH ROW BEGIN
        CASE (SELECT count(*) FROM user_framework uf WHERE uf.uid=OLD.uid)
            WHEN 0 THEN
                DELETE FROM user_achievement WHERE aid = a('frame')
                                             AND   uid = OLD.uid;
            WHEN 3 THEN
                DELETE FROM user_achievement WHERE aid = a('window')
                                             AND   uid = OLD.uid;
            ELSE BEGIN END;
        END CASE;
    END!
DELIMITER ;

INSERT INTO user_framework VALUES
    (4, f('corona')),
    (6, f('laravel')),
    (6, f('jquery'));
