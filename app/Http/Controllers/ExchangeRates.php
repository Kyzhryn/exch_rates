<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExchangeRates extends Controller
{

        public static $urlWithRates = "http://www.cbr.ru/scripts/XML_daily.asp";

    //название записи, которая содержит список валют для получения извне
    public static $nameSettingsGettings = "settings_gettings";

    //название записи, которая содержит список валют для вывода в виджет
    public static $nameSettingsView = "settings_view";

    //название записи, которая содержит частоту обновления
    public static $frequency = "frequency";

    public function showPageWithExchangeRates()
    {
        $frequency = Setting::getFrequency() * 1000;
        return view('exchange_rates',["frequency"=>$frequency]);
    }

    public function getExchangeRates()
    {
        $exchangeRatesNeedToTheView = Setting::getAllSettingsView();
        $currencies = [];

        foreach ($exchangeRatesNeedToTheView as $currency)
        {
            $newCurr = [];
            $newCurr[] = $currency;
            $twoDays = ExchangeRate::getExchangeRate($currency);
            $newCurr[] = (float)$twoDays[1]->value;
            $day1 =(float)$twoDays[0]->value;
            $day2 =(float)$twoDays[1]->value;
            $newCurr[] = ($day1
                >
                $day2)?"up":"down";
            $currencies[] = $newCurr;
        }

        return $currencies;
    }

    public static function setExchangeRates()
    {
        //по ссылке получаем xml файл с курсами валют
        $exchange_rates_response = Http::get(ExchangeRates::$urlWithRates);
        $exchange_rates = new \SimpleXMLElement($exchange_rates_response->body());

        //нужно получить те валюты, которые должны быть возвращены в виджет
        $neededRates = Setting::getAllNeededRates();

        //получение текущей даты
        $date = (string)$exchange_rates['Date'];

        //здесь Valute - массив
        foreach($exchange_rates->Valute as $valute)
        {
            //если такая запись нужно для добавления, то добавим
            if(in_array((string)$valute->CharCode,$neededRates))
            {
                ExchangeRate::setExchangeRate(
                    $date,
                    (string) $valute->CharCode,
                    (string) $valute->Value
                );
            }
        }
    }


    public function showPageWithSettings()
    {
        return view('settings');
    }

    public function saveSettingsGetting(Request $request)
    {
        $massik = $request->post();
        $this->clearMassive($massik,'_token');

        $allGettingRates = implode(", ", array_keys($massik));

        $this->updateRecord($this::$nameSettingsGettings,$allGettingRates);
    }

    public function saveSettingsView(Request $request)
    {
        $SettingsView = $request->post();
        $this->clearMassive($SettingsView,'_token');

        $allGettingsRates =explode(", ",Setting::getAllNeededRates());

        foreach($SettingsView as $valute)
        {
            if( !in_array($valute,$allGettingsRates))
            {
                unset($SettingsView[array_search($valute,$SettingsView)]);
            }
        }

        $frequency = $SettingsView['frequency'];
        $this->clearMassive($SettingsView,'frequency');

        $allSettingsRates = implode(", ",array_keys($SettingsView));

        $this->updateRecord($this::$nameSettingsView,$allSettingsRates);

        $this->updateRecord($this::$frequency,$frequency);

    }

    private function clearMassive(&$massive,$keyToDelete)
    {
        unset($massive[$keyToDelete]);
    }

    private function updateRecord($nameRecord,$value)
    {
        Setting::updateRecord($nameRecord,$value);
    }
}
