<?php

namespace IslamAlsayed\Itoast;

class IToastManager
{
    public function add(string $type, string $message = null)
    {
        $itoast = new IToastFactory($type, $message);
        $itoasts = session()->get('itoasts', []);
        $itoasts[] = $itoast;
        session()->flash('itoasts', $itoasts);

        return $itoast;
    }
}