<!DOCTYPE html>
<html>
  <head>
    <style>
      .container {
        position: relative;
      }
      button[name='sid'] {
        position: absolute;
        display: inline-block;
        padding: 0px;
        border:  0px;
        margin:  0px;
        border-style: solid;
        border-width: thin;
        border-color: #09f;
      }
      button[value='1']  { top:   0px; left: 125px; }
      button[value='2']  { top: 125px; left: 250px; }
      button[value='3']  { top: 125px; left:   0px; }
      button[value='4']  { top: 250px; left:   0px; }
      button[value='5']  { top: 125px; left: 375px; }
      button[value='6']  { top: 375px; left: 375px; }
      button[value='7']  { top: 500px; left: 125px; }
      button[value='8']  { top: 500px; left: 375px; }
      button[value='9']  { top: 125px; left: 125px; }
      button[value='10'] { top: 250px; left: 125px; }
      button[value='11'] { top: 500px; left:   0px; }
      button[value='12'] { top: 250px; left: 250px; }
      button[value='13'] { top: 375px; left: 125px; }
      button[value='14'] { top: 375px; left: 250px; }
      button[value='15'] { top:   0px; left: 375px; }
      button[value='16'] { top: 375px; left:   0px; }
      button[value='17'] { top:   0px; left:   0px; }
      button[value='18'] { top: 500px; left: 250px; }
      button img {
        height: 78px;
        width:  78px;
      }
    </style>
  </head>
  <body>
  <h1>Geek Skill Tree</h1>
  <div class="container">
    @for ($i=18; $i; $i--)
    <button name="sid" value="{{$i}}">
      {{ HTML::image("public/img/s$i.jpg") }}
    </button>
    @endfor
  </div>
  </body>
</html>
