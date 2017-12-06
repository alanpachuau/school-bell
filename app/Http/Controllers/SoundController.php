<?php

namespace App\Http\Controllers;

use App\Sound;
use Illuminate\Http\Request;

class SoundController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->store('sounds');

            $sound = new Sound;
            $sound->title = $filename;
            $sound->file = $path;
            $sound->save();

            return response()->json([
                'message' => 'Upload success.',
                'soundId' => $sound->id,
                'soundName' => $sound->title,
                'path' => $path,
                'status' => 200
            ], 200);
        }
    }

    public function index() {
        $sounds = Sound::orderBy("title", "asc")->select(
            "id",
            \DB::raw("title as name"),
            \DB::raw("file as url")
        )->get();
        return response()->json($sounds);
    }

    public function remove( Request $request ) {
        $sound = Sound::find($request->id);
        $soundFile = storage_path('app/' . $sound->file);
        if(file_exists($soundFile))
            unlink($soundFile);

        $sound->delete();
        return response()->json(['message' => 'deleted'], 200);
    }
}
