<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Statamic\Events\FormSubmitted;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Support\Str;

/**
 * Urban Bank kit bootstrapping (Rule 06 / 07 / 03).
 *
 * Shipped separately so starter-kit installs do not overwrite the site's
 * AppServiceProvider. Register in bootstrap/providers.php — see README.
 *
 * Career uploads are validated by the form blueprint and resumes asset
 * container (mimes + max). There is no FormSubmitting event in Statamic 5.
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

        // Blog comments → unpublished Comments entries (Rule 03).
        // Form submissions are read-only in the CP, so editors publish via Collections → Comments.
        Event::listen(FormSubmitted::class, function (FormSubmitted $event) {
            if ($event->submission->form()->handle() !== 'comment') {
                return;
            }

            $data = $event->submission->data();
            $name = trim((string) ($data->get('name') ?? 'Comment'));
            $postRef = trim((string) ($data->get('post') ?? ''));
            $message = (string) ($data->get('message') ?? '');

            if ($postRef === '' || $message === '') {
                return;
            }

            // Prefer entry ID (entries field); fall back to slug for older forms.
            // Only accept blogs — a stray ID from another collection must not create Comments.
            $blog = Entry::find($postRef)
                ?? Entry::query()
                    ->where('collection', 'blogs')
                    ->where('slug', $postRef)
                    ->first();

            if (! $blog || $blog->collectionHandle() !== 'blogs') {
                return;
            }

            $title = Str::limit($name.' on '.$blog->get('title', $blog->slug()), 100, '');

            Entry::make()
                ->collection('comments')
                ->locale(Site::default()->handle())
                ->published(false)
                ->slug(Str::slug($name.'-'.$blog->slug().'-'.uniqid()))
                ->date(now())
                ->data([
                    'title' => $title,
                    'post' => $blog->id(),
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
