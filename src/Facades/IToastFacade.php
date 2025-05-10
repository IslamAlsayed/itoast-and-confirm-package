<?php

namespace IslamAlsayed\Itoast\Facades;

use IslamAlsayed\Itoast\IToastFactory;
use Illuminate\Support\Facades\Facade;

class IToastFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IToastFactory::class;
    }
}