<?php

namespace IslamAlsayed\Itoast;

class IToast
{
    public static function success($message = null)
    {
        return (new IToastManager)->add('success', $message);
    }

    public static function error($message = null)
    {
        return (new IToastManager)->add('error', $message);
    }

    public static function warn($message = null)
    {
        return (new IToastManager)->add('warn', $message);
    }

    public static function info($message = null)
    {
        return (new IToastManager)->add('info', $message);
    }

    public static function confirm($message = null)
    {
        return (new IToastManager)->add('confirm', $message);
    }
}