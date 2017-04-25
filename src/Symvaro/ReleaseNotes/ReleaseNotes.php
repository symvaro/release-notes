<?php
namespace Symvaro\ReleaseNotes;

class ReleaseNotes
{
	public function notesForLocale($locale = 'de')
	{
		//Release Notes - gather and sort and take the last one
        $notes = \File::files(base_path(config('release-notes.path', 'resources/views/releases/') . $locale));
        $notes = array_map(function ($file) {
            return str_replace('.md', '', basename($file));

        }, $notes);

        sort($notes);

        return $notes;
	}


	public function lastNoteForLocale($locale = 'de')
	{
		$notes = $this->notesForLocale($locale);

		if (count($notes) > 0) {
			return config('release-notes.prefix', 'releases') . '.' . $locale . '.' . end($notes);	
		}

		return null;
	}

	public function lastNoteForCurrentLocale()
	{
		return $this->lastNoteForLocale(\Lang::locale());
	}

	public function notesForCurrentLocale($since = null)
	{
		if (is_null($since)) {
			return $this->notesForLocale(\Lang::locale());	
		} else {
			return $this->notesSince($since, \Lang::locale())->toArray();
		}
	}

	public function notesSince($date, $locale = 'de')
	{
		$notes = \File::files(base_path(config('release-notes.path', 'resources/views/releases/') . $locale));
		$filteredNotes = collect([]);

		$notes = array_map(function ($file) use ($filteredNotes) {
        	$date = \DateTime::createFromFormat('Y_m_d_His', substr(basename($file), 0, 17));
        	$obj = new \stdClass();
        	$obj->date = $date;
        	$obj->file = str_replace('.md', '', basename($file));
        	$filteredNotes->push($obj);

        }, $notes);

		$filteredNotes = $filteredNotes->filter(function ($item) use ($date) {
		    return (data_get($item, 'date') > $date);
		});

		return $filteredNotes->pluck('file');
	}
}