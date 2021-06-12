<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncoesAuxiliares extends Model
{
    use HasFactory;

    public static function converterNumMes(){

        $mes = "";
        
        switch(date("m"))
        {
            case '01':
                $mes = "Janeiro";
                break;
            case '02':
                $mes = "Fevereiro";
                break;
            case '03':
                $mes = "Março";
                break;
            case '04':
                $mes = "Abril";
                break; 
            case '05':
                $mes = "Maio";
                break;
            case '06':
                $mes = "Junho";
                break;
            case '07':
                $mes = "Julho";
                break;
            case '08':
                $mes = "Agosto";
                break;
            case '09':
                $mes = "Setembro";
                break;
            case '10':
                $mes = "Outubro";
                break; 
            case '11':
                $mes = "Novembro";
                break; 
            case '12':
                $mes = "Dezembro";
                break;                             
        }

        return $mes;
    }
}
