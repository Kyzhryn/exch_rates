<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExchangeRate extends Model
{
    use HasFactory;

    protected static $tableName = 'ExchangeRates';

    public static function setExchangeRate($date,$name,$value)
    {
        ExchangeRate::getFloat($value);
        //если запись за сегодняшний день уже есть, то ее нужно обновить
        if(ExchangeRate::search($name,$date))
        {

            DB::table(ExchangeRate::$tableName)
                ->where(
                    [
                        ['currency','=',$name],
                        ['date','=',$date]
                    ]
                )
                ->update(['value'=>$value]);
        }
        //иначе ее требуется создать
        else
        {
            DB::table(ExchangeRate::$tableName)
                ->insert(
                    [
                        'currency'=>$name,
                        'date'=>$date,
                        'value'=>$value
                    ]
                );
        }
    }

    //метод для поиска записи о курсе за такую же дату
    //для того, чтобы если в этот день записи еще не было, то она бы добавилась,
    // и не было попытки обновить несуществующую запись
    public static function search($name,$date):bool
    {
        $result = DB::table(ExchangeRate::$tableName)
            ->where([
                ['currency','=',$name],
                ['date','=',$date]
            ])
            ->exists();
        return $result;
    }

    public static function getExchangeRate($name): array
    {
        return
            DB::table(ExchangeRate::$tableName)
            ->select('value')
            ->where([
                    ['currency','=',$name]
                ]
            )
            ->orderBy('id','desc')
            ->limit(2)
            ->get()
            ->values()
            ->all();
    }


    public static function getFloat(&$str)
    {
        if(strstr($str, ",")) {
            $str = str_replace(",", ".", $str); // replace ',' with '.'
        }
        $str = (float)$str;
    }

}
