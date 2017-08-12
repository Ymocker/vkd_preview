<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings;
use Illuminate\Http\Request;

/**
 * @property integer $id
 * @property string $kword
 */

class Kword extends Model
{
    protected $table = 'kwords';

    protected $fillable=['kword'];

    public $timestamps = false;

    /**
     * The reklamas that belong to the kword
     */
    public function reklamas()
    {
        return $this->belongsToMany('App\Models\Reklama');
    }

    /**
     * Adds keywords in the table if they are not exist there.
     * Returns array of ID of new added keywords.
     *
     * @param array $ks
     * @return array $ks - array of IDs of inserted keywords
     */
    public function addNewKw($kwString) {
        $results = Settings::find(1);
        $ksArr = explode($results->ksdelimiter, $kwString); // ks string to array

        $kw = array();

        foreach($ksArr as $value) {
// TODO remove spaces from $value
            $value = trim($value);
            if ($value <> '') {
                $kw[] = parent::firstOrCreate(['kword' => $value])->id;
            }
        }
        return $kw;
    }

    /**
     * Takes selected keywords and new keywords,
     * adds new ones in the DB
     *
     * @param Request $request
     * @return array of IDs of keywords for the new Reklama-record
     */
    public function store(Request $request) {
        $kwSelect = ($request->kw === null) ? array() : $request->kw; // selected keywords ID array
        foreach($kwSelect as $key => $value) {
            $kwSelect[$key] = (int) $value;
        }

        $dopKw = trim(htmlspecialchars($request->newks,ENT_NOQUOTES,'UTF-8'));
//TODO удаление двойных... пробелов из строки

        $addedKw = $this->addNewKw($dopKw); // added keywords ID array

        $allKw = array_merge($kwSelect, $addedKw);
        $allKw = array_unique($allKw); // keyword's IDs

        return $allKw;
    }

}
