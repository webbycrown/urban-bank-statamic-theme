<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Statamic\Events\FormSubmitted;
use Statamic\Events\FormSubmitting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Private résumé uploads — local disk with no public URL (Rule 07).
        // Files land in storage/app/resumes (outside public/), not public/assets.
        config([
            'filesystems.disks.resumes' => [
                'driver' => 'local',
                'root' => storage_path('app/resumes'),
                'visibility' => 'private',
                'throw' => false,
                'report' => false,
                // Intentionally no "url" key — Statamic treats the container as private.
            ],
        ]);

        $extra = config('statamic.assets.additional_uploadable_extensions', []);
        config([
            'statamic.assets.additional_uploadable_extensions' => array_values(array_unique(array_merge(
                is_array($extra) ? $extra : [],
                ['doc', 'docx']
            ))),
        ]);

        // Belt-and-suspenders: blueprint + container validate, and reject bad career files here.
        Event::listen(FormSubmitting::class, function (FormSubmitting $event) {
            if ($event->submission->form()->handle() !== 'career') {
                return;
            }

            $file = request()->file('resume');

            $validator = Validator::make(
                ['resume' => $file],
                [
                    'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
                ],
                [
                    'resume.mimes' => 'The resume must be a PDF, DOC, or DOCX file.',
                    'resume.max' => 'The resume may not be greater than 5 MB.',
                ]
            );

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }
        });

        // Comments stay hidden until an editor turns on Approved in the CP (Rule 05).
        Event::listen(FormSubmitted::class, function (FormSubmitted $event) {
            if ($event->submission->form()->handle() !== 'comment') {
                return;
            }

            $event->submission->set('approved', false);
        });
    }
}
