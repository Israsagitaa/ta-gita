<?php

namespace App\Http\Controllers;
use App\Target;
use App\User;
use App\Unit;
use App\Periode;
use App\Output;
use App\Skps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class TargetBawahanController extends Controller
{
   public function index(){
    
    $login = Auth::user();
    $users = user::all();
    $skps = Skps::all();
    
    if($login->role_id == 3){
      $users = user::whereIn('position_id',$login->bawahan())->whereIn('unit_id',$login->unitTugas())->get();
  }
    return view('targetbawahan.index', compact('users','skps'));
   }

   public function create($nip){
    $users = user::where('nip', $nip)->first();
    $target = Target::where('nip_rated', $nip)->get();
    return view('targetbawahan.view_status', compact('users','nip','target'));
   }

   public function update(Request $request, $nip_rated){
    // dd($request->all());
    $target= Target::where("nip_rated",$nip_rated)->update([
        'status'=>$request->input('status'),
       

    ]);
    return redirect()-> route('targetbawahan')->with('Status', 'Status Berhasil Diubah');
}
}

