<?php

namespace Islam\Itoast;

class IToastFactory
{
    public $type;
    public $message;
    public $title = null;
    public $emoji = null;
    public $icon = null;
    public $duration = null;
    public $position = null;
    public $pin = null;
    public $theme = null;
    public $dir = null;
    public $onconfirm = null;
    public $link = null;
    public $target = null;
    public $oncancel = null;
    public $actions = [];

    public function __construct($type, $message = null)
    {
        $this->type = $type;

        $this->message = $message ?: config('itoast.default_message', 'default message');

        $this->title = $type ?: config('itoast.default_title', 'default title');
        $this->position = config('itoast.default_position', 'top');
        $this->onconfirm = config('itoast.default_onconfirm_text', 'Yes');
        $this->oncancel = config('itoast.default_oncancel_text', 'No');
    }

    public function title($title = null)
    {
        $this->title = $title ?: match ($this->type) {
            'confirm' => config('itoast.default_confirm_title', 'you are sure?'),
            default => config('itoast.default_title', 'default title'),
        };

        return $this;
    }

    public function emoji($emoji)
    {
        $this->emoji = $emoji;
        return $this;
    }

    public function icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function getIcon()
    {
        return $this->icon ?: match ($this->type) {
            'success' => 'circle-check',
            'error' => 'circle-xmark',
            'warn' => 'triangle-exclamation',
            'info' => 'circle-exclamation',
            default => 'bell',
        };
    }

    public function duration($milliseconds)
    {
        $this->duration = $milliseconds;
        return $this;
    }

    public function position($position = null)
    {
        $this->position = $position ?: config('itoast.default_position', 'top');
        return $this;
    }

    public function pin($pin = 'pin')
    {
        $this->pin = $pin;
        return $this;
    }

    public function withAction($label, $url)
    {
        $this->actions[] = ['label' => $label, 'url' => $url];
        return $this;
    }

    public function theme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    public function getTheme()
    {
        return $this->theme ?: match ($this->type) {
            'success' => 'success',
            'error' => 'error',
            'warn' => 'warn',
            'info' => 'info',
            default => config('itoast.default_theme'),
        };
    }

    public function dir($dir = 'ltr')
    {
        $this->dir = $dir ?: config('itoast.default_dir', 'ltr');
        return $this;
    }

    public function onConfirm($onconfirm = null)
    {
        $this->onconfirm = $onconfirm ?: config('itoast.default_onconfirm_text', 'Yes');
        return $this;
    }

    public function link($link = '/')
    {
        $this->link = $link;
        return $this;
    }

    public function target($target = null)
    {
        $this->target = $target;
        return $this;
    }

    public function onCancel($oncancel = null)
    {
        $this->oncancel = $oncancel ?: config('itoast.default_oncancel_text', 'No');
        return $this;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'emoji' => $this->emoji,
            'icon' => $this->icon,
            'duration' => $this->duration,
            'position' => $this->position,
            'pin' => $this->pin,
            'theme' => $this->theme,
            'dir' => $this->dir,
            'onconfirm' => $this->onconfirm,
            'link' => $this->link,
            'target' => $this->target,
            'oncancel' => $this->oncancel,
            'actions' => $this->actions,
        ];
    }
}