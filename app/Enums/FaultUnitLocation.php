<?php

namespace App\Enums;

enum FaultUnitLocation:string
{
    case LeoSendemOffice = 'LeoSendemOffice';
    case LeopackOffice = 'LeopackOffice';
    case MixOffice = 'MixOffice';
    case GTOffice = 'GTOffice';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
