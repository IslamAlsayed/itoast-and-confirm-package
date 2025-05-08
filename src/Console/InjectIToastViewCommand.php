<?php

namespace IslamAlsayed\Itoast\Console;

use Illuminate\Console\Command;

class InjectIToastViewCommand extends Command
{
    protected $signature = 'itoast:inject';
    protected $description = 'Inject itoast include snippet into master layout if it exists.';

    public function handle()
    {
        $layoutPath = resource_path('views/layouts/master.blade.php');

        if (!file_exists($layoutPath)) {
            $this->warn("master.blade.php not found in layouts folder.");
            return;
        }

        $contents = file_get_contents($layoutPath);

        $snippet = <<<BLADE
            @if (view()->exists('vendor/itoast/itoasts'))
                @include('vendor/itoast/itoasts')
            @endif
        BLADE;

        if (strpos($contents, '@include(\'vendor.itoast\')') !== false) {
            $this->info("Snippet already exists.");
            return;
        }

        // Inject before first </body>
        if (strpos($contents, '</body>') !== false) {
            $contents = str_replace('</body>', $snippet . "\n</body>", $contents);
        } else {
            $contents .= "\n\n" . $snippet;
        }

        file_put_contents($layoutPath, $contents);
        $this->info("Snippet injected into master.blade.php successfully.");
    }
}