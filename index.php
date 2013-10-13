<?php define('HIDESOURCE', false);

require 'database.php';
require 'model.php';

// create new user.
if (isset ($_POST['username'])) {
    $id = User::create($_POST['username']);
    header("Location: .?uid={$id}", true, 303);
    exit;
}

// try request exists user.
if (isset ($_GET['uid'])) {
    $user = new User($_GET['uid']);
} else {
    $user = new User(0);
}

// reset user skills.
if (isset ($_POST['reset'])) {
    $user->reset_all();
    header("Location: .?uid={$user->uid}", true, 303);
    exit;
}

// update a skill
if (isset ($_POST['sid'])) {
    $sid = $_POST['sid'];
    $user->click_skill($sid);
}

$skill_status = $user->skills_status();
$achievements = $user->achievements();

?>


<link rel="stylesheet" href="positioning.css" />
<link rel="stylesheet" href="style.css" />


<? // 1st column, show user detail. ?>
<div class="column margin" style="width: 300px;">
  <h1>Skill Tree</h1>

  <? if (!$user->uid): ?>

    <h3>please select a user</h3>
    <ul>
    <? foreach (User::show_all() as $auser): ?>
      <li><a href="?uid=<?=$auser['uid']?>"><?=$auser['name']?></a></li>
    <? endforeach; ?>
    </ul>

    <h3>or create new user</h3>
    <form method="post">
      <input name="username">
      <input type="submit">
    </form>

  <? else: ?>

    <h2>welcome back, <?=$user->name?>!</h2>

    <h3>about me:</h3>
    <p><i><?=$user->more?></i></p>

    <h3>achievements</h3>
    <ul class="no-bullet">
    <? foreach ($achievements as $achv): ?>
      <li title="<?=$achv['description']?>">
        <img src="img/etc/star.png" style="width: 20px; height: 20px;" />
        <?=$achv['name']?>
      </li>
    <? endforeach; ?>
    </ul>

    <hr />

    <form method="post">
      <button name="reset">reset all skill!</button>
    </form>

  <? endif; ?>

  <p id="skill-more">((text area for display extra info))</p>
</div>


<? // 2nd column, show skill tree. ?>
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
