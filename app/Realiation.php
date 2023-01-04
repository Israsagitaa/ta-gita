<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;
class Realiation extends Model
{
    protected $fillable = ['id', 'quantity', 'credit_number', 'mutu', 'cost', 'time'];
    protected $primaryKey = 'id';
    public $incrementing = false;

    public static function realisasi()
    {
        return  DB::table('realiations')
            ->select(
                DB::raw("(SELECT mutu as mututarget FROM targets WHERE id= realiations.id) as mututarget"),
                DB::raw("(SELECT time as timetarget FROM targets WHERE id= realiations.id) as timetarget"),
                DB::raw("(SELECT cost as costtarget FROM targets WHERE id= realiations.id) as costtarget"),
                // DB::raw("(SELECT * from realiations where id in (select id from targets where nip_rated in(select nip from users where users.nip='$nip')))"),
                'realiations.*' 

            )
            ->leftjoin('targets','realiations.id','=','targets.id')
            ->leftjoin('users', 'users.nip','=','targets.nip_rated')
            ->where ('targets.nip_rated', Auth::user()->nip)->get();
    }
    public function target()
    {
        return $this->belongsTo(Target::class, 'id');
    }
    
}
