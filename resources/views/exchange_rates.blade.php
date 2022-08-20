@extends('layouts.layout')

@section('title', 'Курс валют')

@section('body')
    <script type = "text/javascript">
        setTimeout(getNewRecord,{{$frequency}});

        function getNewRecord()
        {
            $.get('/getNewRecords',function(data,status)
            {
              var textWithExchangeRates = '';
              for(let i = 0; i<data.length; i++)
              {
                  textWithExchangeRates += data[i][0] + '=' + data[i][1] + ' ' + ( data[i][2] == 'up' ? '&#8593;' : '&#8595;') + '<br>';
              }
              $("#exchange_rates").html(textWithExchangeRates);
            });
        }
        getNewRecord();
    </script>
    <h1>Курс валют на текущий момент</h1>
    <div id="exchange_rates">

    </div>
@endsection
