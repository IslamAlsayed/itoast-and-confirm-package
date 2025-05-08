<?php

namespace Islam\Itoast\Facades;

use App\Helpers\Islam\IToast\src\IToastFactory;
use Illuminate\Support\Facades\Facade;

class IToastFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return IToastFactory::class;
    }
}