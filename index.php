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
    $user->add_skill($sid);
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
    border-color: #999;
}

button[name='sid'] {
    position: absolute;
    padding: 0px;
    border:  0px;
    margin:  0px;
}

img.unobtainable {
    -webkit-filter: grayscale(100%);
       -moz-filter: grayscale(100%);
            filter: grayscale(100%);
}

img.unskilled {
    -webkit-filter: sepia(100%);
       -moz-filter: sepia(100%);
            filter: sepia(100%);
}

img.fix-size {
    height: 80px;
    width:  80px;
}
</style>


<div class="column" style="width: 300px;">
  <h1>Skill Tree</h1>
  <p>((user name goes here))</p>
  <form method="post">
    <button name="reset">reset all skill!</button>
  </form>
  <p>((text area for display extra info))</p>
</div>

<div class="column" style="position: relative; width: 383px;">
  <form method="post">
  <? foreach ($skill_status as $i => $stat): ?>
    <? $disabled = $stat == 'unobtainable' ? 'disabled' : '' ; ?>
    <button name="sid" value="<?=$i?>" <?=$disabled?>>
      <img class="card fix-size <?=$stat?>" src="img/s<?=$i?>.jpg" />
    </button>
  <? endforeach; ?>
  </form>
</div>
