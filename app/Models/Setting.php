<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    use HasFactory;

    protected static $tableName = "settings";

    //название записи, которая содержит список валют для получения извне
    public static $nameSettingsGettings = "settings_gettings";

    //название записи, которая содержит список валют для вывода в виджет
    public static $nameSettingsView = "settings_view";

    //название записи с частотой обновления
    public static $nameFrequency = "frequency";

    protected $fillable = [
        'name',
        'value'
    ];

    public static function updateRecord($nameRecord,$value)
    {
        DB::table(Setting::$tableName)->where('name',$nameRecord)->update(
            ['value'=>$value]
        );
    }

    public static function getFrequency()
    {
        return
            DB::table(Setting::$tableName)
                ->where(
                    'name',
                    '=',
                    Setting::$nameFrequency)
                ->value('value');
    }

    public static function getAllNeededRates()
    {
        return
            explode(', ',
                DB::table(Setting::$tableName)
                ->where(
                    'name',
                    '=',
                    Setting::$nameSettingsGettings)
                ->value('value')
            );
    }

    public static function getAllSettingsView()
    {
        return
            explode(', ',
                DB::table(Setting::$tableName)
                    ->where(
                        'name',
                        '=',
                        Setting::$nameSettingsView)
                    ->value('value')
            );
    }



}
