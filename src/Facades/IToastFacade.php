<?php

namespace IslamAlsayed\Itoast\Facades;

use App\Helpers\IslamAlsayed\IToast\src\IToastFactory;
use Illuminate\Support\Facades\Facade;

class IToastFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IToastFactory::class;
    }
}