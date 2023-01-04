<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Skps;
use App\User;
use App\Position;
use App\RankGroup;
use App\Periode;
use App\Unit;
use DB;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class SkpsController extends Controller
{

    public function index()
    {

        $data = Skps::with(['user_rated', 'unit_rated', 'rank_rated', 'position_rated', 'evaluator_position', 'evaluator_rank', 'evaluator_unit', 'evaluator_user'])->get();
        $login = Auth::user();
        $role_id = $login->role_id;
        return view(
            'skps/index',
            [
                'user' => $data,
                'role_id' => $role_id,
            ]
        );
    }

    public function create()
    {
        $users = User::all();
        $position = Position::all();
        $rankgroup = RankGroup::all();
        $periode = Periode::all();
        $unit = Unit::all();

        $skps = Skps::all();
        $login = Auth::user();
        $role_id = $login->role_id;
        return view(
            'skps/form',
            [
                'url' => 'skps.store',
                'users' => $users,
                'position' => $position,
                'rankgroup' => $rankgroup,
                'periode' => $periode,
                'unit' => $unit,
                'role_id' => $role_id,

            ]
        );
    }
    public function store(Request $request, Skps $skps)
    {
        // dd($request->all());
        $request->validate([
            'nip_rated'     => 'required',
            'periode_id'     => 'required',
            'rated_unit_id'     => 'required',
            'rated_position_id'     => 'required',
            'rated_rankgroup_id'     => 'required',
            'commitment'     => 'required',
            'discipline'     => 'required',
            'cooperation'     => 'required',
            'leadership'     => 'required',
            'integrity'     => 'required',
            'service_oriented'     => 'required',
            // 'objection_rated'     => 'required',
            'response_evaluator'     => 'required',
            'superior_decision'     => 'required',
            'recommendation'     => 'required',
            'start_date'     => 'required',
            'date_given_to_superiors'     => 'required',
            'evaluator_rankgroup_id'     => 'required',
            'nip_evaluator'     => 'required',
            'evaluator_unit_id'     => 'required',
            'evaluator_position_id'     => 'required',

        ]);
        $skps->nip_rated = $request->input('nip_rated');
        $skps->periode_id = $request->input('periode_id');
        $skps->rated_unit_id = $request->input('rated_unit_id');
        $skps->rated_position_id = $request->input('rated_position_id');
        $skps->rated_rankgroup_id = $request->input('rated_rankgroup_id');
        $skps->commitment = $request->input('commitment');
        $skps->discipline = $request->input('discipline');
        $skps->cooperation = $request->input('cooperation');
        $skps->leadership = $request->input('leadership');
        $skps->integrity = $request->input('integrity');
        $skps->service_oriented = $request->input('service_oriented');
        $skps->objection_rated = $request->input('objection_rated');
        $skps->response_evaluator = $request->input('response_evaluator');
        $skps->superior_decision = $request->input('superior_decision');
        $skps->recommendation = $request->input('recommendation');
        $skps->start_date = $request->input('start_date');
        $skps->date_given_to_superiors = $request->input('date_given_to_superiors');
        $skps->nip_evaluator = $request->input('nip_evaluator');
        $skps->evaluator_rankgroup_id = $request->input('evaluator_rankgroup_id');
        $skps->evaluator_unit_id = $request->input('evaluator_unit_id');
        $skps->evaluator_position_id = $request->input('evaluator_position_id');
        $skps->save();

        return redirect()
            ->route('skps')
            ->with('message', 'Data berhasil ditambahkan');
    }

    public function edit(Skps $skps)
    {
        $users = User::all();
        $position = Position::all();
        $rankgroup = RankGroup::all();
        $periode = Periode::all();
        $unit = Unit::all();

        $login = Auth::user();
        $role_id = $login->role_id;

        return view(
            'skps/form',
            [
                'skps' => $skps,
                'url' => 'skps.update',
                'users' => $users,
                'position' => $position,
                'rankgroup' => $rankgroup,
                'periode' => $periode,
                'unit' => $unit,
                'role_id' => $role_id,
            ]
        );
    }

    public function update(Request $request, Skps $skps)
    {
        $validator = Validator::make($request->all(), [
            'nip_rated'     => 'required_if:role,Admin',
            'periode_id'     => 'required_if:role,Admin',
            'rated_unit_id'     => 'required_if:role,Admin',
            'rated_position_id'     => 'required_if:role,Admin',
            'rated_rankgroup_id'     => 'required_if:role,Admin',
            'commitment'     => 'required',
            'discipline'     => 'required',
            'cooperation'     => 'required',
            'leadership'     => 'required',
            'integrity'     => 'required',
            'service_oriented'     => 'required',
            'objection_rated'     => 'required',
            'response_evaluator'     => 'required',
            'superior_decision'     => 'required',
            'recommendation'     => 'required',
            'start_date'     => 'required',
            'date_given_to_superiors'     => 'required',
            'evaluator_rankgroup_id'     => 'required_if:role,Admin',
            'nip_evaluator'     => 'required_if:role,Admin',
            'evaluator_unit_id'     => 'required_if:role,Admin',
            'evaluator_position_id'     => 'required_if:role,Admin',
        ]);

        $skps->objection_rated = $request->input('objection_rated');
        $skps->save();

        return redirect()
            ->route('skps')
            ->with('message', 'Data berhasil diedit');
    }

    public function destroy(Skps $skps)
    {
        $skps->forceDelete();
        return redirect()
            ->route('skps')
            ->with('message', 'Data berhasil dihapus');
    }

    public function cetak(Request $request)
    {
        $id = request()->get('id');

        $namaTarget = $request->nip_rated;

       

        // $data['user'] = Skps::user_name()->where('skps.nip_rated', '=', $id)->get();
        // $data['data'] = Skps::user_name()->where('skps.nip_rated', '=', $id)->first();
        
        // $data['target'] = DB::table('skps')
        //                 ->join('targets','skps.nip_rated','targets.nip_rated')
        //                 ->join('realiations','targets.id','realiations.id')
        //                 ->where('skps.nip_rated', $id)
        //                 ->get();

        $skps = Skps::with('target.realisasi')->where('nip_rated', $id)->first();

        // dd($skps);
        foreach ($skps->target as $tk => $tv) {
            if ($tv->type = 'Tugas Jabatan') {
                $target['tugas_jabatan'] = $tv->with('realisasi')->where('type', 'Tugas Jabatan')->where('nip_rated', $id)->get();
            }
            if ($tv->type = 'Kreativitas') {
                $target['kreativitas'] = $tv->with('realisasi')->where('type', 'Kreativitas')->where('nip_rated', $id)->get();
            }
            if ($tv->type = 'Tambahan') {
                $target['tambahan'] = $tv->with('realisasi')->where('type', 'Tambahan')->where('nip_rated', $id)->get();
            }
            // $target[$tk] = $tv;
        }
        // dd($target['kreativitas']);
        
        // $data_json = json_encode($data);
        // foreach ($data->target as $tk => $tv) {
        //     $data_new[$tk]['target'] = $tv;
        //     $data_new[$tk]['realisasi'] = $tv->realisasi;
        // }
      
        // dd($data['target']);
        return view(
            'skps/cetakRevisi', compact(['skps', 'target'])
        );
    }

    public function CetakNilai()
    {
        // $id = request()->get('id');
        // dd($id);
        $data['user'] = Skps::user_name()->where('skps.nip_rated', '=', $id)->get();

        $data['data'] = Skps::user_name()->where('skps.nip_rated', '=', $id)->first();

        $data['nilai'] = DB::table('skps')->get();
        return view(
            'skps/cetak_nilai',

            $data
        );
    }

    public function CetakNilaiAkhir()
    {
        $id = request()->get('id');
        // dd($id);
        $data['user'] = Skps::user_name()->where('skps.nip_rated', '=', $id)->get();

        $data['data'] = Skps::user_name()->where('skps.nip_rated', '=', $id)->first();

        $data['nilai'] = DB::table('skps')->get();
        $data['atasan'] = DB::table('users')->where('nip', '1919030322889')->get();
        $data['skps'] = DB::table('skps')->get();

        return view(
            'skps/cetak_nilai_akhir',

            $data
        );
    }
}
