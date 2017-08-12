<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reklama;

/**
 * @property integer $id
 * @property integer $nomgaz
 * @property integer $nomgod
 * @property string $datavyh
 */
class Nomer extends Model
{
    protected $table = 'nomer';

    protected $fillable=[
        'nomgaz', 'nomgod', 'datavyh'
    ];
    public $timestamps = false;

    /**
     * Get the reklamas for the nomer.
     */
    public function reklamas()
    {
        return $this->hasMany('App\Models\Reklama');
    }

    /**
     * Provides attributes (nomgaz, nomgod, datavyh) for new Nomer
     * @param integer $curr - current Nomer (e.g. 1025)
     */
    public function getNewNumAttr($curr) {
        if ($curr == 0) { //for empty database, there isn't any records in Nomer-table
            $this->nomgaz = 1;
            $this->nomgod = 1;
            $this->datavyh = '';
            $this->current = 0;
        } else {
            $nom = self::orderBy('nomgaz', 'desc')->first();
            $this->current = $nom->nomgaz;
            $this->nomgaz = ++$nom->nomgaz;
            $this->nomgod = ++$nom->nomgod;
            $this->datavyh = $nom->datavyh;
        }
    }

    /**
     * Copies all Reklamas from current Nomer to the new Nomer
     *
     * @param integer $currentNomerId - from nomer-table
     * @param integer $newNomerId
     */
    public static function copyRekToNewNum($currentNomerId, $newNomerId) {
//        $rek = Reklama::where('polosa', '<', 90)
//                      ->where('nomer_id', $currentNomerId)
//                      ->get();
        $rek =  DB::select("SELECT * FROM reklama WHERE polosa < ? AND nomer_id = ?", [90, $currentNomerId]);

        DB::transaction(function () use ($rek, $newNomerId) {
            $pdo = DB::connection()->getPdo();

            $stmt = $pdo->prepare("INSERT INTO reklama (rekname, nomer_id, polosa, web, dopinf) VALUES (:rekname, :nomer_id, :polosa, :web, :dopinf)");
            $stmt->bindParam(':rekname', $rekname);
            $stmt->bindParam(':nomer_id', $nomer_id);
            $stmt->bindParam(':polosa', $polosa);
            $stmt->bindParam(':web', $web);
            $stmt->bindParam(':dopinf', $dopinf);

            $stmtKw = $pdo->prepare("SELECT kword_id FROM kword_reklama WHERE reklama_id = ?");

            foreach ($rek as $value) {
                /*
                * copy all Reklama-records with current nomer_id to
                * same Reklam-records with new nomer_id
                */
                $rekname  = $value->rekname;
                $nomer_id = $newNomerId;
                $polosa   = $value->polosa;
                $web      = $value->web;
                $dopinf   = $value->dopinf;
                $stmt->execute();

                $insertRekId = $pdo->lastInsertId();

                // get IDs of keywords for copied Reklama-record
                $stmtKw->execute([$value->id]);
                $res = $stmtKw->fetchAll();

                // make SQL for prepared statement
                $sql = '';
                $kwArr = array();

                foreach ($res as $kwId) {
                    $sql = $sql . '(?,?),';
                    $kwArr[] = $insertRekId;
                    $kwArr[] = $kwId['kword_id'];
                }
                // insert keyword IDs for new Reclama-record to the pivot-table
                if (count($res) > 0) {
                    $sql = "INSERT INTO kword_reklama (reklama_id, kword_id) VALUES" . rtrim($sql, ',');
                    $stmtPivot = $pdo->prepare($sql);
                    $stmtPivot->execute($kwArr);
                }
            }

        });

        Reklama::where('polosa', '>=', 90)->update(['nomer_id' => $newNomerId]);
    }

    /**
     * Remove oldest Nomer from Nomer-table,
     * corresponding reklama-records from Reklama-table,
     * records from pivot kword-reklama-table,
     * unused keywords from kwords-table,
     * unused images from /img directory.
     */
    public static function delOldestNumber() {
        $delNumId = self::orderBy('nomgaz')->first()->id; // oldest Nomer id
        $delReklamaPic = Reklama::where('nomer_id', $delNumId)->pluck('rekname')->all(); // array of reknames of deleted reklamas
        //$delReklamaPic = DB::select("SELECT rekname FROM reklama WHERE nomer_id = ?", [$delNumId]); // 3 times faster than ORM

        // cascad delete from Reklama-table and kword_reklama-table
        self::destroy($delNumId);

        $restReklama = Reklama::all()->pluck('rekname')->all(); // all reknames after deletion (array)
        $delReklamaPic = array_diff($delReklamaPic, $restReklama); // names of images to delete

        foreach ($delReklamaPic as $pic) { //delete images from '/img' directory
            $file_name = public_path() . '/img/' . $pic . '.jpg';
            if(file_exists($file_name)){unlink($file_name);}
            $file_name = public_path() . '/img/' . $pic . 's.jpg';
            if(file_exists($file_name)){unlink($file_name);}
        }

        // delete keywords from kwords table which don't exist in pivot table
        $allKwords = Kword::all()->pluck('id');
        $pivotKwords = DB::table('kword_reklama')->pluck('kword_id');
        $deleteKwords = $allKwords->diff($pivotKwords);
        Kword::destroy($deleteKwords->all());

        $file_name = public_path() . '/textrek/' . $delNumId . '.txt';
        if(file_exists($file_name)){unlink($file_name);}
    }

    /**
     * Return array of archive numbers for index.view
     * (1028, 1027, 1026, 1025)
     *
     * @return array
     */
    public static function archNumbers () {
        $results = self::orderBy('nomgaz', 'desc')->get();
        $numbers = array(); //array of numbers (1028,1027,1026,1025)
        foreach ($results as $r)
        {
            $numbers[$r->id] = [$r->nomgaz, $r->nomgod];
        }

        // check if new(not published) number exist
        $delLast = Settings::find(1);
        if ($delLast->currnom != $delLast->newnom) {
            unset($numbers[key($numbers)]);
        }

        return $numbers;
    }
}
