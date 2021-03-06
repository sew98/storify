<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyAdmin;
use App\Mail\NewStoryNotification;

class DashboardController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // DB::enableQueryLog();
        $query = Story::where('status', 1);

        //local scope - scopeActive function in Story Model
//        $query = Story::active();

        $type = request()->input('type');
        if( in_array( $type, ['short', 'long'])) {
            $query->where('type', $type);
        }


        $stories = $query->with(['user', 'tags'])
            ->orderBy('id', 'DESC')
            ->paginate(9);
        return view('dashboard.index', [
            'stories' => $stories
        ]);
    }

    public function show(Story $activeStory)
    {
        //
        return view('dashboard.show', [
            'story' => $activeStory
        ]);
    }

    public function email(){
//        Mail::raw('This is the Test email', function ($message){
//            $message->to('admin@localhost.com')
//                ->subject('A New Story was Added');
//        });

//        Mail::send(new NotifyAdmin('Tilte of the story'));
        Mail::send(new NewStoryNotification('Tilte of the story'));
        dd('here');
    }
}
