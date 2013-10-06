<h1>collections of complex sql statement for this application</h1>
<p>
  /!\ warning: in real world application, due to security issue.
  this directory and files must not be accessible by users.
</p>

<ul>
<? foreach (glob('*.sql') as $f): ?>
  <? if ($f == 'sample-data.sql') continue; ?>
  <li><a href="<?=$f?>"><?=$f?></a></li>
<? endforeach; ?>
</ul>
