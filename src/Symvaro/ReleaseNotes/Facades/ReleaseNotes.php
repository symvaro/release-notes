<?php
namespace Symvaro\ReleaseNotes\Facades;

use Illuminate\Support\Facades\Facade;

class ReleaseNotes extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'release-notes';
    }
}
