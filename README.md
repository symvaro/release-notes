## Release Notes

Laravel Package to create and manage markdown release notes.

### Installation

Composer

```
composer require symvaro/release-notes
```

And optionally add the Facade

```
'ReleaseNotes' => Symvaro\ReleaseNotes\Facades\ReleaseNotes::class,
```

and **publish the config file** for view path customization.

### Usage

Creating a new Note (from terminal)

```
artisan release:note name_for_the_update
```

```
artisan release:note "Super tolle neue Features"
```

This automatically creates `.md` files for every language used in your application. The default directory is `resources/views/release/`.

Retrieving all relaese notes, sorted by date created, for current set language

```
\ReleaseNotes::notesForCurrentLocale();
```

Retrieving most recent 10 notes

```
\ReleaseNotes::notesForCurrentLocale(null, 10);
```

Retrieving notes after a specific date

```
\ReleaseNotes::notesForCurrentLocale(new \DateTime());
```

Retrieving only the most recent note

```
\ReleaseNotes::lastNoteForCurrentLocale()
```

Using a custom language

```
\ReleaseNotes::notesForLocale('de');
```
