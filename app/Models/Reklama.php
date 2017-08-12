<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Settings;
use App\Models\Nomer;
use Cache;

/**
 * @property integer $id
 * @property integer $nomer_id
 * @property integer $polosa
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $rekname
 * @property string $web
 * @property string $dopinf
 */

class Reklama extends Model
{
    //public $reklama;

    protected $table = 'reklama';

    protected $fillable=[
        'rekname', 'nomer', 'polosa', 'web', 'dopinf'
    ];

    public $timestamps = false;

    /**
     * The kwords that belong to the reklama
     */
    public function kwords()
    {
        return $this->belongsToMany('App\Models\Kword');
    }

    public function scopeNomer($query, $nom)
    {
        return $query->whereNomer_id($nom);
    }

// =============================================================================

    /**
     * Puts Reklama-record to archive.
     * Makes 92 from 2, 91 from 1 etc.
     */
    public function reklamaToArch() {
        $this->nomer_id = Nomer::orderBy('nomgaz', 'desc')->first()->id;
        $this->polosa = '9' . $this->polosa;
        $this->save();
    }

    /**
     * Gets Reklama-record from archive to former Polosa.
     * Makes 2 from 92, 1 from 91 etc.
     */
    public function reklamaFromArch() {
        $this->polosa = substr($this->polosa, 1);
        $this->save();
    }

    /**
     * Stores Reklama-record in the DB
     */
    public function store(Request $request) {
        $name = $this->translit($request->name);
        $this->rekname = $this->reklamaName($name, $request->polosa);

        $razmer = ($request->razmer <> 0) ? $request->razmer : $request->mrazmer;

        $tempFile = public_path() . '/img/tmp/work.jpg';
        $smallSize = Settings::find(1)->smallpic;

        $rekImage = public_path() . '/img/' . $this->rekname;

        $this->imgResize($tempFile, $razmer, $smallSize, $rekImage);

        $this->nomer_id = Session::get('editNumberId');
        $this->polosa = $request->polosa;

        $this->dopinf = trim(htmlspecialchars($request->ooo, ENT_NOQUOTES, 'UTF-8'));
        $this->web = trim(htmlspecialchars($request->web, ENT_NOQUOTES, 'UTF-8'));

        $this->save();
    }

    /**
     * Deletes Reklama-record from Reklama-table,
     * cascade deleting from pivot table,
     * unused keyeords and unused images.
     */
    public function destroyRek() {
        $pic = $this->rekname;
        $this->delete(); // and cascade deleting from pivot table

        // delete keywords from kwords table which don't exist in pivot table
        $allKwords = Kword::all()->pluck('id');
        $pivotKwords = DB::table('kword_reklama')->pluck('kword_id');
        $deleteKwords = $allKwords->diff($pivotKwords);
        Kword::destroy($deleteKwords->all());

        $restReklama = self::all()->pluck('rekname')->all();
        if (!in_array($pic, $restReklama)) { // if deleted Rekname does not exist in Reklama table
            $file_name = public_path() . '/img/' . $pic . '.jpg';
            if(file_exists($file_name)){unlink($file_name);}
            $file_name = public_path() . '/img/' . $pic . 's.jpg';
            if(file_exists($file_name)){unlink($file_name);}
        }
    }

    /**
     * @param type $currNom
     * @return integer - id of random Reklama from the current Nomer
     */
    public static function randomRekId($currNom) {
//        $currentNomerId = Nomer::where('nomgaz', $currNom)->first()->id;
//        $results = self::nomer($currentNomerId)->where('polosa', '<', 90)->pluck('id')->all();
//        shuffle($results);

        $randomArr = Cache::remember('randomId', 300, function() use ($currNom) {
            $currentNomerId = Nomer::where('nomgaz', $currNom)->first()->id;
            $results = self::nomer($currentNomerId)->where('polosa', '<', 90)->pluck('id')->all();
            shuffle($results);
            return $results;
        });

        return($randomArr[array_rand($randomArr)]);
    }

    /**
     * Make name for Reklama. This is for Reklama-image name.
     *
     * @param string $name
     * @param integer $polosa
     * @return string
     */
    private function reklamaName($name, $polosa) { //из name делает 1022_1_name999
        $rekNam = Session::get('editNumber') . '_' . $polosa . '_' . $name . rand(0,999);
        return $rekNam;
    }

    private function translit($s) {
        $s = (string) $s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    /**
     * Resize input image file to preview and view
     *
     * @param string $imgFile - image tmp file
     * @param integer $bigSize - size of the big image
     * @param integer $smallSize - size of the preview
     * @param string $newImg - name new image file with path and without .jpg
     */
    private function imgResize ($imgFile, $bigSize, $smallSize, $newImg) {
         //define('SOURCE', $fileimage);
 // TODO add png

        $size = getimagesize($imgFile);
        $source = imagecreatefromjpeg($imgFile);

        if ($size[0]>=$size[1]) {
            $ratio = $size[0]/$size[1];
            $newbigx = $bigSize;
            $newx = $smallSize;
            $newy = round($smallSize/$ratio);
            $newbigy = round($bigSize/$ratio);

        } else {
            $ratio = $size[1]/$size[0];
            $newbigy = $bigSize;
            $newy = $smallSize;
            $newx = round($smallSize/$ratio);
            $newbigx = round($bigSize/$ratio);
        }

        $target = imagecreatetruecolor($newbigx, $newbigy);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $newbigx, $newbigy, $size[0], $size[1]);
//        header('Content-type: image/jpeg');
        imagejpeg($target, $newImg . '.jpg', 95);

        $target = imagecreatetruecolor($newx, $newy);
        imagecopyresampled($target, $source, 0, 0, 0, 0, $newx, $newy, $size[0], $size[1]);
        imagejpeg($target, $newImg . 's.jpg', 95);
    }
}
