<?php

namespace App\Enum;

enum GoalStatus: string
{
    case TODO = "A commencer";
    case DONE = "Réussi";
    case CANCELLED = "Annulé";
    case IN_PROGRESS = "En cours";
    case FAILED = "échoué";

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}