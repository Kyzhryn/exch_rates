@extends('layouts.layout')


@section('title','Настройки')



@section('body')
    <h1> Настройки</h1>
    <h2>Список валют, курсы которых необходимо получать с ЦБ </h2>
    <form id="settings_getting"  onsubmit="sendFormSettingsGettings()">
        @csrf
        <input type = "checkbox" name="AUD"  /> Австралийский доллар
        <input type = "checkbox" name = "AZN"/> Азербайджанский манат
        <input type = "checkbox" name = "GBP"/> Фунт стерлингов Соединенного королевства
        <input type = "checkbox" name = "AMD"/> Армянских драмов
        <br>
        <input type = "checkbox" name = "BYN"/> Белорусский рубль
        <input type = "checkbox" name = "BGN"/> Болгарский лев
        <input type = "checkbox" name = "BRL"/> Бразильский реал
        <input type = "checkbox" name = "HUF"/> Венгерских форинтов
        <br>
        <input type = "checkbox" name = "HKD"/> Гонконгских долларов
        <input type = "checkbox" name = "DKK"/> Датских крон
        <input type = "checkbox" name = "USD"/> Доллар США
        <input type = "checkbox" name = "EUR"/> Евро
        <br>
        <input type = "checkbox" name = "INR"/> Индийских рупий
        <input type = "checkbox" name = "KZT"/> Казахстанских тенге
        <input type = "checkbox" name = "CAD"/> Канадский доллар
        <input type = "checkbox" name = "KGS"/> Киргизских сомов
        <br>
        <input type = "checkbox" name = "CNY"/> Китайских юаней
        <input type = "checkbox" name = "MDL"/> Молдавских леев
        <input type = "checkbox" name = "NOK"/> Норвежских крон
        <input type = "checkbox" name = "PLN"/> Польский злотый
        <br>
        <input type = "checkbox" name = "RON"/> Румынский лей
        <input type = "checkbox" name = "XDR"/> СДР (специальные права заимствования)
        <input type = "checkbox" name = "SGD"/> Сингапурский доллар
        <input type = "checkbox" name = "TJS"/> Таджикских сомони
        <br>
        <input type = "checkbox" name = "TRY"/> Турецких лир
        <input type = "checkbox" name = "TMT"/> Новый туркменский манат
        <input type = "checkbox" name = "UZS"/> Узбекских сумов
        <input type = "checkbox" name = "UAH"/> Украинских гривен
        <br>
        <input type = "checkbox" name = "CZK"/> Чешских крон
        <input type = "checkbox" name = "SEK"/> Шведских крон
        <input type = "checkbox" name = "CHF"/> Швейцарский франк
        <input type = "checkbox" name = "ZAR"/> Южноафриканских рэндов
        <br>
        <input type = "checkbox" name = "KRW"/> Вон Республики Корея
        <input type = "checkbox" name = "JPY"/> Японских иен
        <br> <br>
        <input type ="submit"  id="submit_settings_getting">
    </form>

    <h2> Список валют, которые необходимо выводить в виджете </h2>
    <form id = "settings_view" onsubmit="sendFormSettingsView()">
        @csrf
        <input type = "checkbox" name = "AUD"/> Австралийский доллар
        <input type = "checkbox" name = "AZN"/> Азербайджанский манат
        <input type = "checkbox" name = "GBP"/> Фунт стерлингов Соединенного королевства
        <input type = "checkbox" name = "AMD"/> Армянских драмов
        <br>
        <input type = "checkbox" name = "BYN"/> Белорусский рубль
        <input type = "checkbox" name = "BGN"/> Болгарский лев
        <input type = "checkbox" name = "BRL"/> Бразильский реал
        <input type = "checkbox" name = "HUF"/> Венгерских форинтов
        <br>
        <input type = "checkbox" name = "HKD"/> Гонконгских долларов
        <input type = "checkbox" name = "DKK"/> Датских крон
        <input type = "checkbox" name = "USD"/> Доллар США
        <input type = "checkbox" name = "EUR"/> Евро
        <br>
        <input type = "checkbox" name = "INR"/> Индийских рупий
        <input type = "checkbox" name = "KZT"/> Казахстанских тенге
        <input type = "checkbox" name = "CAD"/> Канадский доллар
        <input type = "checkbox" name = "KGS"/> Киргизских сомов
        <br>
        <input type = "checkbox" name = "CNY"/> Китайских юаней
        <input type = "checkbox" name = "MDL"/> Молдавских леев
        <input type = "checkbox" name = "NOK"/> Норвежских крон
        <input type = "checkbox" name = "PLN"/> Польский злотый
        <br>
        <input type = "checkbox" name = "RON"/> Румынский лей
        <input type = "checkbox" name = "XDR"/> СДР (специальные права заимствования)
        <input type = "checkbox" name = "SGD"/> Сингапурский доллар
        <input type = "checkbox" name = "TJS"/> Таджикских сомони
        <br>
        <input type = "checkbox" name = "TRY"/> Турецких лир
        <input type = "checkbox" name = "TMT"/> Новый туркменский манат
        <input type = "checkbox" name = "UZS"/> Узбекских сумов
        <input type = "checkbox" name = "UAH"/> Украинских гривен
        <br>
        <input type = "checkbox" name = "CZK"/> Чешских крон
        <input type = "checkbox" name = "SEK"/> Шведских крон
        <input type = "checkbox" name = "CHF"/> Швейцарский франк
        <input type = "checkbox" name = "ZAR"/> Южноафриканских рэндов
        <br>
        <input type = "checkbox" name = "KRW"/> Вон Республики Корея
        <input type = "checkbox" name = "JPY"/> Японских иен
        <br>
        <label> Интервал обновления содержимого виджета</label>
        <br>
        <input type="number" name="frequency"> минут
        <br><br>
        <input type ="submit"    id="submit_settings_view">
    </form>

    <script type = "text/javascript">

        function sendFormSettingsGettings()
        {
            var msg = $('#settings_getting').serialize();
            $.ajax({
                type: 'POST',
                url: '/save_settings_gettings',
                data: msg,
                success: function(data)
                {
                    alert('Настройки отправлены успешно');
                },
                error: function (xhr, str)
                {
                    alert('Возникла ошибка');
                }
            })
        }

        function sendFormSettingsView()
        {
            var msg = $('#settings_view').serialize();
            $.ajax({
                type: 'POST',
                url: '/save_settings_view',
                data: msg,
                success: function(data)
                {
                    alert('Настройки отправлены успешно');
                },
                error: function (xhr, str)
                {
                    alert('Возникла ошибка');
                }
            })
        }
    </script>

@endsection
