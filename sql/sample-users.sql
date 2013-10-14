-- -------------------------------------------------------------

-- ALL ABOUT USERS
-- ===============
-- this file provide sample users data, for mock up or show example.

-- -------------------------------------------------------------

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
    (5, s('artificial intel')),
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
    (8, s('artificial intel')),
    (8, s('system')),
    (8, s('security'));

-- -------------------------------------------------------------

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

INSERT INTO user_framework VALUES
    (4, f('corona')),
    (6, f('laravel')),
    (6, f('jquery'));
