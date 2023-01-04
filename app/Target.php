<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Auth;
use Illuminate\Support\Facades\DB;

class Target extends Model
{

    protected $fillable = [
        'id',
        'activities', 'ak', 'credit_number', 'quantity', 'output_id', 'mutu', 'time', 'cost', 'nip_rated', 'periode_id', 'type',
        'Parent_id', 'status',
    ];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    // public $incrementing = false;
    public function parent()
    {
        return $this->hasone(Unit::class, 'id', 'parent_id');
    }

    public static function target()
    {
        return DB::table('targets')
            ->select(
                DB::raw("(SELECT name as dinilai FROM users WHERE nip= targets.nip_rated) as dinilai"),
                DB::raw("(SELECT start_date as tgl_mulai FROM periodes WHERE id=targets.periode_id) as tgl_mulai"),
                DB::raw("(SELECT finish_date as tgl_selesai FROM periodes WHERE id=targets.periode_id) as tgl_selesai"),
                'targets.*'
             
            )
            ->leftjoin('skps','skps.nip_rated','=','targets.nip_rated')
            ->leftjoin('users', 'users.nip','=','skps.nip_rated')
            ->where ('targets.nip_rated', Auth::user()->nip)->get();
    }

    public static function showtarget()
    {
        return DB::table('targets')
        ->select(
            DB::raw("(SELECT name as dinilai FROM users WHERE nip= targets.nip_rated) as dinilai"),
        )
        ->leftjoin('skps','skps.nip_rated','=','targets.nip_rated')
        ->leftjoin('users', 'users.nip','=','skps.nip_rated')
        ->where ('targets.nip_rated', Auth::user()->nip)->get();
    }
    public function skps()
    {
        return $this->belongsTo(Skps::class, 'nip_rated', 'periode_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'nip');
    }
    public function realisasi()
    {
        return $this->hasMany(Realiation::class, 'id');
    }
}