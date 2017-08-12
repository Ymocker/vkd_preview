<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $currnom
 * @property integer $newnom
 * @property integer $kolvo - quantity of archive numbers
 * @property char $ksdelimiter - symbol for dividing keywords
 * @property integer $smallpic - dimension of thumbnails
 * @property string $actia - text for Actia
 */

class Settings extends Model
{
    protected $table = 'settings';

    protected $fillable=[
        'currnom', 'newnom'
    ];
    public $timestamps = false;
}
