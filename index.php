<?php define('HIDESOURCE', false);

require 'debug.php';
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

// reset user skills, languages, and frameworks.
if (isset ($_GET['reset'])) {
    $user->reset_all();
    header("Location: .?uid={$user->uid}", true, 303);
    exit;
}

// update a skill
if (isset ($_POST['sid'])) {
    $user->click_skill($_POST['sid']);
}

// update a language
if (isset ($_POST['lid'])) {
    $user->click_language($_POST['lid']);
}

// update a framework
if (isset ($_POST['fid'])) {
    $user->click_framework($_POST['fid']);
}


// prepare data for view
$skillful_list = ['skilled', 'unforgettable'];
$clickable_list = ['skilled', 'learnable'];

$skill_status = $user->skills_status();
$achievements = $user->achievements();

$lang_depend = $user->language_dependencies();
$frame_req = $user->framework_requirement();

?>


<link rel="stylesheet" href="positioning.css" />
<link rel="stylesheet" href="style.css" />


<div class="wrapper">

<? // 1st column, show user detail. ?>
<div class="column margin" style="width: 320px;">
  <a href="."><h1>Skill Tree</h1></a>

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

    <hr />

    <h3>achievements</h3>
    <ul class="no-bullet">
    <? foreach ($achievements as $achv): ?>
      <li title="<?=$achv['description']?>">
        <img src="img/etc/star.png" style="width: 20px; height: 20px;" />
        <?=$achv['name']?>
      </li>
    <? endforeach; ?>
    </ul>

  <? endif; ?>

  <div class="owner">
    <hr />
    <a rel="license" href="http://creativecommons.org/licenses/by/3.0/deed.en_US"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by/3.0/80x15.png" /></a>
    <span>skill tree by neizod 2013</span>
  </div>
</div>


<? // 2nd column, show skill tree. ?>
<div class="column" style="width: 455px;">
  <form method="post">
  <? foreach ($skill_status as $i => $skill): ?>

    <? $skillful = in_array($skill['stat'], $skillful_list) ? 'skillful' : 'unskillful' ; ?>
    <? $disabled = in_array($skill['stat'], $clickable_list) ? '' : 'disabled' ; ?>

    <? if (file_exists("img/a$i.png")): ?>
      <img class="arrow <?=$skillful?>" id="a<?=$i?>" src="<?="img/a$i.png"?>">
    <? endif; ?>

    <button name="sid" value="<?=$i?>" title="<?=$skill['name']?>" <?=$disabled?>>
      <img class="card fix-size <?=$skillful?>" src="img/s<?=$i?>.jpg" />
    </button>

  <? endforeach; ?>
  </form>
</div>

<? // 3nd column, show language and framework ?>
<div class="column margin" style="position: relative; width: 320px;">

  <div class="column margin" style="position: relative; border-width: 0;"> 
    <h3>languages</h3>
    <form method="post">
      <h4>codable</h4>

      <ul class="no-bullet">
      <? foreach ($user->codable() as $i => $lang): ?>
        <li>
        <? $title_disabled = array_key_exists($i, $lang_depend) ?
                "title=\"require by: {$lang_depend[$i]}\" disabled" : '' ; ?>
        <li>
          <button name="lid" value="<?=$i?>" <?=$title_disabled?>>x</button>
          <?=$lang?>
        </li>
      <? endforeach; ?>
      </ul>

      <hr />

      <h4>unknown</h4>
      <ul class="no-bullet">
      <? foreach ($user->readable() as $i => $lang): ?>
        <li>
          <button name="lid" value="<?=$i?>">/</button>
          <?=$lang?>
        </li>
      <? endforeach; ?>
      </ul>

    </form>
  </div>

  <div class="column margin" style="position: relative; border-width: 0;"> 
    <h3>frameworks</h3>
    <form method="post">

      <h4>buildable</h4>
      <ul class="no-bullet">
      <? foreach ($user->buildable() as $i => $lang): ?>
        <li>
          <button name="fid" value="<?=$i?>">x</button>
          <?=$lang?>
        </li>
      <? endforeach; ?>
      </ul>

      <hr />

      <h4>unknown</h4>
      <ul class="no-bullet">
      <? foreach ($user->experimentable() as $i => $lang): ?>
        <? $title_disabled = array_key_exists($i, $frame_req) ?
                "title=\"require: {$frame_req[$i]}\" disabled" : '' ; ?>
        <li>
          <button name="fid" value="<?=$i?>" <?=$title_disabled?>>/</button>
          <?=$lang?>
        </li>
      <? endforeach; ?>
      </ul>

    </form>
  </div>

</div>

</div>
