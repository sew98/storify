<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;

class StoriesController extends Controller
{
    //
    public function index(){
        $stories = Story::where('user_id', auth()->user()->id)
        ->get();
        return view('stories.index', [
            'stories' => $stories
        ]);
    }

    public function show(Story $story){
        // $story = Story::findOrFail($id);
        // dd($story);
        return view('stories.show', ['story' => $story]);
    }

}
