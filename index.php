<?php define('HIDESOURCE', false);

require 'database.php';
require 'model.php';

if (isset ($_GET['uid'])) {
    $user = new User($_GET['uid']);
} else {
    $user = new User(0);
}

if (isset ($_POST['reset'])) {
    $user->reset_all();
    header("Location: .?uid={$user->uid}", true, 303);
    exit;
}

if (isset ($_POST['sid'])) {
    $sid = $_POST['sid'];
    $user->click_skill($sid);
}

$skill_status = $user->skills_status();

?>


<link rel="stylesheet" href="positioning.css" />
<link rel="stylesheet" href="style.css" />

<div class="column" style="width: 300px;">
  <h1>Skill Tree</h1>

  <? if (!$user->uid): ?>

    <h3>please select user</h3>
    <ul>
    <? foreach (User::show_all() as $auser): ?>
      <li><a href="?uid=<?=$auser['uid']?>"><?=$auser['name']?></a></li>
    <? endforeach; ?>
    </ul>

  <? else: ?>

    <h3>welcome back, <?=$user->name?>!</h3>
    <p><i><?=$user->more?></i></p>

    <form method="post">
      <button name="reset">reset all skill!</button>
    </form>

  <? endif; ?>

  <p id="skill-more">((text area for display extra info))</p>
</div>



<div class="column" style="position: relative; width: 455px;">
  <form method="post">
  <? foreach ($skill_status as $i => $stat): ?>

    <? $skillful = in_array($stat, ['skilled', 'unforgettable']) ? 'skillful' : 'unskillful' ; ?>
    <? $disabled = in_array($stat, ['skilled', 'learnable']) ? '' : 'disabled' ; ?>

    <? if (file_exists("img/a$i.png")): ?>
      <img class="arrow <?=$skillful?>" id="a<?=$i?>" src="<?="img/a$i.png"?>">
    <? endif; ?>

    <button name="sid" value="<?=$i?>" <?=$disabled?>>
      <img class="card fix-size <?=$skillful?>" src="img/s<?=$i?>.jpg" />
    </button>

  <? endforeach; ?>
  </form>
</div>
