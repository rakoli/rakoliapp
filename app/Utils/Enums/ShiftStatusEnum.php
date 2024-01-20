<?php

namespace App\Utils\Enums;

enum ShiftStatusEnum: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case INREVIEW = 'inreview';


    /**
     * @return string
     */
    public function label() : string
    {
        return  match ($this){
            static::OPEN  => "Open",
            static::CLOSED  => "Closed",
            static::INREVIEW  => "In Review",
        };

    }
    /**
     * @return string
     */
    public function color() : string
    {
        return  match ($this){
            static::OPEN  => "badge badge-primary",
            static::CLOSED  =>"badge badge-closed",
            static::INREVIEW  => "badge badge-warning",
        };

    }
}
