<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 6/18/2018
 * Time: 1:11 PM
 */

namespace App\Entities\Core;

use Symfony\Component\Finder\Finder;

class TranslateManager
{
    public $transFunctions = [
        'trans',
        'trans_choice',
        'Lang::get',
        'Lang::choice',
        'Lang::trans',
        'Lang::transChoice',
        '@lang',
        '@choice',
        '__',
        '$trans.get',
    ];
    public $tranlations = [];
    public $jsonFile = '';

    public function __construct()
    {
        $this->jsonFile    = resource_path('/lang/vi.json');
        $this->tranlations = $this->readFileTranslate();
    }

    public function findTranslations($path = null): array
    {
        $path       = $path ?: base_path('/resources/views');
        $groupKeys  = [];
        $stringKeys = [];
        $functions = $this->transFunctions;

        $groupPattern =                              // See http://regexr.com/392hu
            "[^\w|>]" .                          // Must not have an alphanum or _ or > before real method
            '(' . implode('|', $functions) . ')' .  // Must start with one of the functions
            "\(" .                               // Match opening parenthesis
            "[\'\"]" .                           // Match " or '
            '(' .                                // Start a new group to match:
            '[a-zA-Z0-9_-]+' .               // Must start with group
            "([.|\/][^\1)]+)+" .             // Be followed by one or more items/keys
            ')' .                                // Close group
            "[\'\"]" .                           // Closing quote
            "[\),]";                            // Close parentheses or new parameter

        $stringPattern =
            "[^\w|>]" .                                     // Must not have an alphanum or _ or > before real method
            '(' . implode('|', $functions) . ')' .             // Must start with one of the functions
            "\(" .                                          // Match opening parenthesis
            "(?P<quote>['\"])" .                            // Match " or ' and store in {quote}
            "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)" . // Match any string that can be {quote} escaped
            "\k{quote}" .                                   // Match " or ' previously matched
            "[\),]";                                       // Close parentheses or new parameter

        // Find all PHP + Vue files in the app folder, except for storage
        $finder = new Finder();
        $finder->in($path)->exclude('storage')->name('*.php')->name('*.vue')->files();

        /** @var \Symfony\Component\Finder\SplFileInfo $file */
        foreach ($finder as $file) {
            // Search the current file for the pattern
            if (preg_match_all("/$groupPattern/siU", $file->getContents(), $matches)) {
                // Get all matches
                foreach ($matches[2] as $key) {
                    $groupKeys[] = $key;
                }
            }

            if (preg_match_all("/$stringPattern/siU", $file->getContents(), $matches)) {
                foreach ($matches['string'] as $key) {
                    if (preg_match("/(^[a-zA-Z0-9_-]+([.][^\1)\ ]+)+$)/siU", $key, $groupMatches)) {
                        // group{.group}.key format, already in $groupKeys but also matched here
                        // do nothing, it has to be treated as a group
                        continue;
                    }

                    //TODO: This can probably be done in the regex, but I couldn't do it.
                    //skip keys which contain namespacing characters, unless they also contain a
                    //space, which makes it JSON.
                    if ( ! (str_contains($key, '::') && str_contains($key, '.'))
                         || str_contains($key, ' ')) {
                        $stringKeys[] = $key;
                    }
                }
            }
        }

        // Remove duplicates
        $groupKeys  = array_unique($groupKeys);
        $stringKeys = array_unique($stringKeys);

//        $langs      = self::readFileTranslate();
//        $diffs      = array_diff($stringKeys, array_keys($langs));

        return $stringKeys;
//        return [$groupKeys, $stringKeys];
    }

    public function importTranslation($key, $value)
    {
        $this->tranlations[$key] = $value;

        return $this->writeFileTranslate();
    }

    public function readFileTranslate()
    {
        $json = file_get_contents($this->jsonFile);

        return json_decode($json, JSON_FORCE_OBJECT);
    }

    public function writeFileTranslate()
    {
        $jsondata = json_encode($this->tranlations, JSON_UNESCAPED_UNICODE);

        return file_put_contents($this->jsonFile, $jsondata);
    }
}