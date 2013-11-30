<!DOCTYPE html>
<html>
  <head>
    <style>
      div.mock.col3 {
        display: inline-block;
        padding:  1em;
        width:    30%;
      }
      div.mock.col3 h2 {
        border-width: thin;
        border-style: dashed;
        padding:  1em;
        height: 200px;
      }

      div.attension {
        text-align: center;
      }
      div.attension h1 {
        display: inline-block;
        padding:  0.5em;
        border-width: medium;
        border-style: solid;
      }
    </style>
  <head>
  <body>
    <h1>Geek Skill Tree</h1>

    @foreach(array('skill tree', 'language+framework', 'achievements') as $item)
    <div class="mock col3">
      <h2>{{ $item }}</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
      </p>
    </div>
    @endforeach

    <div class="attension">
      <h1>create account now!</h1>
      <br />(or login if you already have an account)
    </div>

  </body>
</html>
