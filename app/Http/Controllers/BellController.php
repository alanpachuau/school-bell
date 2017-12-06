<?php

namespace App\Http\Controllers;

use App\Bell;
use App\Sound;
use Illuminate\Http\Request;

class BellController extends Controller
{
    public function index()
    {
        $soundTable = (new Sound)->getTable();
        $bellTable = (new Bell)->getTable();
        $bells = Bell::leftJoin($soundTable .' as sound1_table', 'sound1_table.id', '=', $bellTable.'.sound1_id')
            ->leftJoin($soundTable. ' as sound2_table', 'sound2_table.id', '=', $bellTable.'.sound2_id')
            ->orderBy("created_at", "asc")
            ->select(
                $bellTable.'.*',
                'sound2_table.title as sound2_title',
                'sound2_table.file as sound2_file',
                'sound1_table.title as sound1_title',
                'sound1_table.file as sound1_file'
            )
            ->get();
        return response()->json($bells);
    }

    public function remove(Request $request)
    {
        $bell = Bell::find($request->id);
        $bell->delete();
        return response()->json(['message' => 'deleted'], 200);
    }

    public function store(Request $request)
    {
        $bell = new Bell;
        $bell->name = $request->name;
        $bell->time = $request->time;
        $bell->sound1_volume = $request->sound1Volume;
        $bell->sound2_volume = $request->sound2Volume;
        $bell->sw1 = $request->switch1;
        $bell->sw2 = $request->switch2;
        $bell->sw3 = $request->switch3;
        $bell->sw4 = $request->switch4;
        $bell->switch_on = $request->switchOn;
        $bell->sound1_id = $request->sound1;
        $bell->sound2_id = $request->sound2;

        foreach($request->days as $day) {
            $bell->{$day} = true;
        }

        $bell->save();
    }
}
