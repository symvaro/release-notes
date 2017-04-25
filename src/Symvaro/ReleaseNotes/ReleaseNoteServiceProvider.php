<?php
namespace Symvaro\ReleaseNotes;

use Illuminate\Support\ServiceProvider;

class ReleaseNoteServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        // Configuration
        $this->publishes([
            __DIR__ . '/../../config/release-notes.php' => config_path('release-notes.php'),
        ], 'config');
    }
    
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands(\Symvaro\ReleaseNotes\Commands\CreateReleasenote::class);

        $this->app->bind(
            'release-notes',
            'Symvaro\ReleaseNotes\ReleaseNotes'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
