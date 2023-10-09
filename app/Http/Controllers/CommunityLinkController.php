<?php

namespace App\Http\Controllers;

use App\Models\CommunityLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Channel;
use Illuminate\Support\ItemNotFoundException;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $channels = Channel::orderBy('title', 'asc')->get();


        $links = CommunityLink::where('approved', 1)->paginate(25);

        return view('community/index', compact(['links', 'channels']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */



    // public function store(Request $request) {
    //     request()->merge(['user_id' => Auth::id(), 'channel_id' => 1 ]);
    //     CommunityLink::create($request->all());
    //     return back();
    // }


    public function store(Request $request)

    {

        $data = $request->validate([

            'title' => 'required|max:255',



            'channel_id' => 'required|exists:channels,id',

            'link' => 'required|unique:community_links|url|max:255',



        ]);
        $approved = Auth::user()->isTrusted();
        $data['user_id'] = Auth::id();
        $data['approved'] = $approved;

        CommunityLink::create($data);
        if ($approved) {
            return back()->with('success', 'Your contribution has been created successfully!');
        } else {
            return back()->with('info', 'Your contribution has been created successfully!, but it needs to be approved');
        }
    }






    /**
     * Display the specified resource.
     */
    public function show(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityLink $communityLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityLink $communityLink)
    {
        //
    }
}
