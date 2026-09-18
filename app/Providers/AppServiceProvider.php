<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Private résumé uploads — disk has no public URL (Rule 07).
        config([
            'filesystems.disks.resumes' => [
                'driver' => 'local',
                'root' => storage_path('app/resumes'),
                'visibility' => 'private',
                'throw' => false,
                'report' => false,
            ],
        ]);

        $extra = config('statamic.assets.additional_uploadable_extensions', []);
        config([
            'statamic.assets.additional_uploadable_extensions' => array_values(array_unique(array_merge(
                is_array($extra) ? $extra : [],
                ['doc', 'docx']
            ))),
        ]);
    }
}
