<?php

class StarterKitPostInstall
{
    public function handle($console)
    {
        $path = base_path('packages/seo-kit-statamic');

        if (! is_dir($path)) {
            $console->warn('SEO Kit package folder missing; skip composer require.');

            return;
        }

        $console->info('Installing webbycrown/seo-kit-statamic from packages/seo-kit-statamic…');

        $composerJson = base_path('composer.json');
        $data = json_decode(file_get_contents($composerJson), true) ?: [];
        $repos = [];

        foreach ($data['repositories'] ?? [] as $repo) {
            $url = (string) ($repo['url'] ?? '');
            if (str_contains($url, 'packages/seo-kit-statamic')) {
                continue;
            }
            $repos[] = $repo;
        }

        $repos[] = [
            'type' => 'path',
            'url' => 'packages/seo-kit-statamic',
            'options' => ['symlink' => false],
        ];

        $data['repositories'] = $repos;
        file_put_contents(
            $composerJson,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n"
        );

        passthru('composer require webbycrown/seo-kit-statamic:^1.0 --no-interaction 2>&1', $code);

        if ($code !== 0) {
            $console->error('Could not require webbycrown/seo-kit-statamic. Run: composer require webbycrown/seo-kit-statamic:^1.0');
        } else {
            $console->info('SEO Kit installed.');
        }
    }
}
