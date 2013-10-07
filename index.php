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
<style>
div.column {
    float: left;
    display: inline-block;
    height: 100%;
    border-style: solid;
    border-width: thin;
    border-color: #999;
}

.card {
    display: inline-block;
    padding: 0px;
    margin: 0px;
    border-style: solid;
    border-width: thin;
    border-color: #09f;
}

button[name='sid'] {
    position: absolute;
    padding: 0px;
    border:  0px;
    margin:  0px;
}

button:not([disabled]) {
    cursor: pointer;
}

.arrow {
    position: absolute;
    padding: 0px;
    border:  0px;
    margin:  0px;
}

img.unskillful {
    -webkit-filter: grayscale(100%);
       -moz-filter: grayscale(100%);
            filter: grayscale(100%);
}

img.fix-size {
    height: 78px;
    width:  78px;
}
</style>


<div class="column" style="width: 300px;">
  <h1>Skill Tree</h1>

  <? if (!$user->uid): ?>

    <h3>please select user</h3>
    <ul>
    <? foreach (User::all() as $auser): ?>
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
    <? $disabled = in_array($stat, ['skilled', 'unskilled']) ? '' : 'disabled' ; ?>

    <? if (file_exists("img/a$i.png")): ?>
      <img class="arrow <?=$skillful?>" id="a<?=$i?>" src="<?="img/a$i.png"?>">
    <? endif; ?>

    <button name="sid" value="<?=$i?>" <?=$disabled?>>
      <img class="card fix-size <?=$skillful?>" src="img/s<?=$i?>.jpg" />
    </button>

  <? endforeach; ?>
  </form>
</div>
