<?php

function is_sql($f) {
    return pathinfo($f)['extension'] == 'sql';
}
$ls = array_filter(scandir('.'), 'is_sql');

?>

<h1>collections of complex sql statement for this application</h1>
<p>
  /!\ warning: in real world application, due to security issue.
  this directory and files must not be accessible by users.
</p>

<ul>
<? foreach ($ls as $f): ?>
  <li><a href="<?=$f?>"><?=$f?></a></li>
<? endforeach; ?>
</ul>
