<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Statamic\Events\FormSubmitted;

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

        // Comments stay hidden until an editor turns on Approved in the CP (Rule 05).
        Event::listen(FormSubmitted::class, function (FormSubmitted $event) {
            if ($event->submission->form()->handle() !== 'comment') {
                return;
            }

            $event->submission->set('approved', false);
        });
    }
}
