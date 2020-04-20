<?php

namespace Symvaro\ReleaseNotes\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateReleasenote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'release:note {name=update : The Name/Tag/Version ID of the release}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Release Note with the given name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('starting release note generator ...');

        $tag = $this->argument('name');
        $filename = $this->getDatePrefix() . '_' . Str::slug($tag, '_') . '.md';

        $this->info('creating relesenotes for release with name ' . $tag . '...');

        // Get all existing languages
        $languages = $this->getLanguages();
        $contents = '### ' . $tag;

        $this->info('creating files for languages: ' . implode(", ", $languages));

        foreach ($languages as $lang) {
            $path = base_path(config('release-notes.path', 'resources/views/releases/') . $lang);

            if (!\File::isDirectory($path)) {
                \File::makeDirectory($path, 0775, true);
            }

            \File::put($path . '/' . $filename, $contents);
        }

        $this->info('done!');
    }

    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    public function getLanguages()
    {
        $langPath = \App::langPath();
        $langFiles = glob("$langPath/*");

        return collect($langFiles)
            ->map(function ($p)  {
                $langFile = basename($p);

                if (Str::endsWith($langFile, '.json')) {
                    $langFile = substr($langFile, 0, strlen($langFile) - strlen('.json'));
                }

                return $langFile;
            })
            ->unique()
            ->filter(function ($p) {
                return $p !== 'vendor';
            })
            ->sort()
            ->all();
    }

}