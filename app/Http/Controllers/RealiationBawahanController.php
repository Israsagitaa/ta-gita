<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Target;
use App\User;
use App\Unit;
use App\Periode;
use App\Output;
use App\Skps;
use Illuminate\Support\Facades\Auth;
use App\Realiation;

class RealiationBawahanController extends Controller
{
    public function index()
    {

        $login = Auth::user();
        $realiation = Realiation::all();
        $users = user::all();
        $skps = Skps::all();
        $target = Target::all();

        if ($login->role_id == 3) {
            $users = user::whereIn('position_id', $login->bawahan())->whereIn('unit_id', $login->unitTugas())->get();
        }
        return view('realisasibawahan.index', compact('users', 'skps', 'realiation', 'target'));
    }

    public function create($nip)
    {
        $realiation =  Realiation::whereHas('target', function ($query) use ($nip) {
            return $query->where('nip_rated', '=', $nip);
        })->get();
        return view('realisasibawahan.view_status', compact(['realiation']));
    }
}
