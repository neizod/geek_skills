<?php if (!defined('HIDESOURCE')) exit ('No direct script access allowed.');

$db = mysqli_connect(
    'localhost',
    'root',
    '',
    'geek_skills'
)
or exit ('No chance to connect database.');
