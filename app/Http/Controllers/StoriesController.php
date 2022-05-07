<?php

namespace App\Http\Controllers;

use App\Events\StoryEdited;
use App\Mail\NewStoryNotification;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Http\Requests\StoryRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Events\StoryCreated;
use Intervention\Image\Facades\Image;
use App\Models\Tag;

class StoriesController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Story::class, 'story');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $stories = Story::where('user_id', auth()->user()->id)
//       ->get()
        ->with('tags')
        ->orderBy('id', 'DESC')
        ->paginate(3);

        return view('stories.index', [
            'stories' => $stories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $this->authorize('create');
        $story = new Story;
        $tags = Tag::get();
        return view('stories.create',[
            'story' => $story,
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoryRequest $request)
    {
        //
        // dd($request->all());

        // $data = $request->validate([
        //     'title' => 'required',
        //     'body' => 'required',
        //     'type' => 'required',
        //     'status' => 'required',
        // ]);

        $story =auth()->user()->stories()->create($request->all());


        // auth()->user()->stories()->create([
        //     'title' => $request->title,
        //     'body' => $request->body,
        //     'type' => $request->type,
        //     'status' => $request->status,
        // ]);
//        Mail::send(new NewStoryNotification($story->title));
//        Log::info('A story with title ' . $story->title . ' was added');

        //image upload
        if( $request->hasFile('image') ) {
            $this->_uploadImage($request, $story);
        }

        $story->tags()->sync( $request->tags);

        //event listeners calling
        //commented due to model events
//        event(new StoryCreated($story->title));

        return redirect()->route('stories.index')->with('status', 'Story Created Successfully!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        //
        return view('stories.show', ['story' => $story]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story)
    {
        //
        // Gate::authorize('edit-story', $story);

        $tags = Tag::get();

        return view('stories.edit', [
            'story' => $story,
            'tags' => $tags
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoryRequest $request, Story $story)
    {
        //
        // dd($request->all());
        // $data = $request->validate([
        //     'title' => 'required',
        //     'body' => 'required',
        //     'type' => 'required',
        //     'status' => 'required',
        // ]);

        // $this->authorize('update', $story);

        // auth()->user()->stories()->create($request->all());
        $story->update( $request->all() );


        //image upload (edit or new)
        if( $request->hasFile('image') ) {
            $this->_uploadImage($request, $story);
        }

        $story->tags()->sync( $request->tags);

        //event listeners calling
        //commented due to model events
//        event(new StoryEdited($story->title));

        return redirect()->route('stories.index')->with('status', 'Story Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        //
        $story->delete();
        return redirect()->route('stories.index')->with('status', 'Story Deleted Successfully!');
    }

    //image upload function
    private function _uploadImage( $request, $story)
    {
        if( $request->hasFile('image') ) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(225, 100)->save(public_path('storage/' . $filename));
            //image resizing - using intervention
            $story->image = $filename;
            $story->save();
        }
    }
}
