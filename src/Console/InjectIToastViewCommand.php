<?php

namespace IslamAlsayed\Itoast\Console;

use Illuminate\Console\Command;

class InjectIToastViewCommand extends Command
{
    protected $signature = 'itoast:inject';
    protected $description = 'Inject itoast snippet, styles, and scripts into layout files.';

    public function handle()
    {
        $masterPath = resource_path('views/layouts/master.blade.php');
        $headPath = resource_path('views/layouts/head.blade.php');
        $footPath = resource_path('views/layouts/foot.blade.php');

        if (!file_exists($masterPath)) {
            $this->warn("master.blade.php not found in layouts folder.");
            return;
        }

        $masterContents = file_get_contents($masterPath);
        $headContents = file_exists($headPath) ? file_get_contents($headPath) : null;
        $footContents = file_exists($footPath) ? file_get_contents($footPath) : null;

        $bladeSnippet = <<<BLADE
            @if (view()->exists('vendor/itoast/itoasts'))
                @include('vendor.itoast.itoasts')
            @endif
        BLADE;

        $cssSnippet = <<<CSS
{{-- FontAwesome Icons --}}
<link rel="stylesheet" href="{{ asset('vendor/itoast/css/all.min.css') }}">
{{-- Itoast Styles --}}
<link rel="stylesheet" href="{{ asset('vendor/itoast/css/itoast.css') }}">
CSS;

        $jsSnippet = <<<JS
{{-- Itoast Scripts --}}
<script type="module" src="{{ asset('vendor/itoast/js/itoast.js') }}"></script>
JS;

        // Inject Blade snippet into master.blade.php (if not already present)
        if (strpos($masterContents, "@include('vendor.itoast.itoasts')") === false) {
            if (strpos($masterContents, '<body>') !== false) {
                $masterContents = str_replace('<body>', "<body>\n" . $bladeSnippet . "\n", $masterContents);
            } else {
                $masterContents .= "\n\n" . $bladeSnippet;
            }
            file_put_contents($masterPath, $masterContents);
            $this->info("Blade snippet injected into master.blade.php");
        } else {
            $this->info("Blade snippet already exists in master.blade.php");
        }

        // === CSS INJECTION ===
        if ($headContents !== null) {
            if (strpos($headContents, '<link rel="stylesheet" href="{{ asset(\'vendor/itoast/css/all.min.css\') }}">') === false) {
                $headContents .= "\n" . $cssSnippet . "\n";
                file_put_contents($headPath, $headContents);
                $this->info("CSS snippet injected into head.blade.php");
            } else {
                $this->info("CSS snippet already exists in head.blade.php");
            }
        } else {
            if (strpos($masterContents, '<link rel="stylesheet" href="{{ asset(\'vendor/itoast/css/all.min.css\') }}">') === false) {
                $masterContents = file_get_contents($masterPath); // reload content
                $masterContents = str_replace('</head>', $cssSnippet . "\n</head>", $masterContents);
                file_put_contents($masterPath, $masterContents);
                $this->info("CSS snippet injected into master.blade.php");
            } else {
                $this->info("CSS snippet already exists in master.blade.php");
            }
        }

        // === JS INJECTION ===
        if ($footContents !== null) {
            if (strpos($footContents, '<script type="module" src="{{ asset(\'vendor/itoast/js/itoast.js\') }}"></script>') === false) {
                $footContents .= "\n" . $jsSnippet . "\n";
                file_put_contents($footPath, $footContents);
                $this->info("JS snippet injected into foot.blade.php");
            } else {
                $this->info("JS snippet already exists in foot.blade.php");
            }
        } else {
            if (strpos($masterContents, '<script type="module" src="{{ asset(\'vendor/itoast/js/itoast.js\') }}"></script>') === false) {
                $masterContents = file_get_contents($masterPath); // reload content
                $masterContents = str_replace('</body>', $jsSnippet . "\n</body>", $masterContents);
                file_put_contents($masterPath, $masterContents);
                $this->info("JS snippet injected into master.blade.php");
            } else {
                $this->info("JS snippet already exists in master.blade.php");
            }
        }
    }
}