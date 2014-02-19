@extends('layout')


@section('hook-head')

  <style>
    .container {
      position: relative;
    }
    button[name='sid'] {
      position: absolute;
      display: inline-block;
      margin:  0px;
      padding: 0px;
      width:  80px;
      height: 80px;
      border: solid thin #09f;
    }
    button[disabled] {
      border-color: #000;
    }
    button img.gray {
      -webkit-filter: grayscale(100%);
         -moz-filter: grayscale(100%);
              filter: grayscale(100%);
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
@stop


@section('content')

  <div class="container">
    <form method="post">
    @foreach ($tree as $index => $node)
    <button name="sid" value="{{$index}}" @if (!$node & 0b01) disabled @endif>
      {{ HTML::image( "public/img/s{$index}.jpg", null,
                      array('class' => $node & 0b10 ? 'color' : 'gray')) }}
    </button>
    @endforeach
    </form>
  </div>

@stop
