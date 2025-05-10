<?php

return [

    // 🔄 Movement and animation settings
    // Set to 'disable' to turn off toast entrance/exit animations
    'move' => 'enable',

    // Duration of the entrance animation (e.g., '0.5s' = 0.5 seconds)
    'enter_time' => '0.5s',

    // Duration of the exit animation
    'exit_time' => '0.5s',

    // Duration the toast remains visible before disappearing
    'visible_time' => '7s',

    // Delay before the toast appears after being triggered
    'start_delay_time' => '1s',

    // 📌 pin icon
    // Whether to pin in the itoast and confirmation modal
    'itoast_pin' => false,
    'confirm_pin' => true,

    // Whether to shake the itoast and confirmation modal
    'itoast_shake' => false,
    'confirm_shake' => true,

    // 🧭 Default toast settings
    // Text direction: 'ltr' (left-to-right) or 'rtl' (right-to-left)
    'default_dir' => 'ltr',

    // Position of the toast: 'top', 'bottom'
    'default_position' => 'top',

    // Default theme
    'default_theme' => 'warn',

    // Default message shown if none is provided
    'default_message' => 'Default message',

    // Default title shown if none is provided
    'default_title' => 'Default title',

    // ✅ Default settings for confirmation modals
    // Default title for confirmation modals
    'default_confirm_title' => 'Confirmation',

    // Default message for confirmation modals
    'default_confirm_message' => 'Are you sure?',

    // Default text for the confirm button
    'default_onconfirm_text' => 'Yes',

    // Default text for the cancel button
    'default_oncancel_text' => 'No',
];