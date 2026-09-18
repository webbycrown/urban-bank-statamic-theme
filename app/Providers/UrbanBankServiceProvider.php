<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Statamic\Events\FormSubmitted;
use Statamic\Events\FormSubmitting;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Support\Str;

/**
 * Urban Bank kit bootstrapping (Rule 06 / 07 / 05 / 03).
 *
 * Shipped separately so starter-kit installs do not overwrite the site's
 * AppServiceProvider. Register in bootstrap/providers.php — see README.
 */
class UrbanBankServiceProvider extends ServiceProvider
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

        // Blog comments → unpublished Comments entries (Rule 03).
        // Form submissions are read-only in the CP, so editors publish via Collections → Comments.
        Event::listen(FormSubmitted::class, function (FormSubmitted $event) {
            if ($event->submission->form()->handle() !== 'comment') {
                return;
            }

            $data = $event->submission->data();
            $name = trim((string) ($data->get('name') ?? 'Comment'));
            $post = trim((string) ($data->get('post') ?? ''));
            $message = (string) ($data->get('message') ?? '');

            if ($post === '' || $message === '') {
                return;
            }

            $title = Str::limit($name.' on '.$post, 100, '');

            Entry::make()
                ->collection('comments')
                ->locale(Site::default()->handle())
                ->published(false)
                ->slug(Str::slug($name.'-'.$post.'-'.uniqid()))
                ->date(now())
                ->data([
                    'title' => $title,
                    'post' => $post,
                    'name' => $name,
                    'email' => $data->get('email'),
                    'phone' => $data->get('phone'),
                    'subject' => $data->get('subject'),
                    'message' => $message,
                ])
                ->save();
        });
    }
}
