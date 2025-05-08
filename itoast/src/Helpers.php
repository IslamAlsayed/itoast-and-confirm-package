<?php

if (!function_exists('addIToast')) {
    function addIToast($type, $message)
    {
        return app('itoast')->add($type, $message);
    }
}

if (!function_exists('addItoastSuccess')) {
    function addItoastSuccess($message)
    {
        return app('itoast')->add('success', $message);
    }
}

if (!function_exists('addItoastError')) {
    function addItoastError($message)
    {
        return app('itoast')->add('error', $message);
    }
}

if (!function_exists('addItoastWarn')) {
    function addItoastWarn($message)
    {
        return app('itoast')->add('warn', $message);
    }
}

if (!function_exists('addItoastInfo')) {
    function addItoastInfo($message)
    {
        return app('itoast')->add('info', $message);
    }
}

if (!function_exists('addConfirm')) {
    function addConfirm($message)
    {
        return app('itoast')->add('confirm', $message);
    }
}

if (!function_exists('addConfirmSuccess')) {
    function addConfirmSuccess($message)
    {
        return app('itoast')->add('confirm', $message)->theme('success');
    }
}

if (!function_exists('addConfirmError')) {
    function addConfirmError($message)
    {
        return app('itoast')->add('confirm', $message)->theme('error');
    }
}

if (!function_exists('addConfirmWarn')) {
    function addConfirmWarn($message)
    {
        return app('itoast')->add('confirm', $message)->theme('warn');
    }
}

if (!function_exists('addConfirmInfo')) {
    function addConfirmInfo($message)
    {
        return app('itoast')->add('confirm', $message)->theme('info');
    }
}

if (!function_exists('getIcon')) {
    function getIcon($type)
    {
        $icons = [
            'success' => 'circle-check',
            'error' => 'circle-xmark',
            'warn' => 'triangle-exclamation',
            'info' => 'circle-exclamation'
        ];

        return isset($icons[$type]) ? $icons[$type] : 'circle-exclamation';
    }
}

if (!function_exists('isEmoji')) {
    function isEmoji($char)
    {
        return preg_match('/[\x{1F600}-\x{1F64F}' . '\x{1F300}-\x{1F5FF}' . '\x{1F680}-\x{1F6FF}' . '\x{2600}-\x{26FF}' . '\x{2700}-\x{27BF}' . '\x{1F900}-\x{1F9FF}' . '\x{1FA70}-\x{1FAFF}]/u', $char);
    }
}

if (!function_exists('isIToastArray')) {
    function isIToastArray($type, $key)
    {
        if (is_array(session()->get($type)) && isset(session()->get($type)[$key])) {
            return session()->get($type)[$key];
        }

        if ($key == 'message') {
            return session()->get($type);
        }

        return null;
    }
}

if (!function_exists('getIToastActions')) {
    function getIToastActions($type)
    {
        $data = [];

        if (is_array(session()->get($type)) && isset(session()->get($type)['actions'])) {
            $data = session()->get($type)['actions'];
        }

        if (!$data) {
            return null;
        }

        if (array_key_exists('label', $data) && array_key_exists('url', $data)) {
            return [$data];
        }

        return $data;
    }
}