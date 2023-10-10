<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityLinkForm;
use App\Models\CommunityLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Channel;

class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $channels = Channel::orderBy('title', 'asc')->get();


        $links = CommunityLink::where('approved', 1)->latest('updated_at')->paginate(25);

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


    public function store(CommunityLinkForm $request)

    {

        $data = $request->validated();
        $approved = Auth::user()->isTrusted();
        $data['user_id'] = Auth::id();
        $data['approved'] = $approved;
        $repeated = CommunityLink::hasAlreadyBeenSubmitted($data['link']);

        //$option = 2 * $approved + $repeated;

        if ($approved) {
            if ($repeated) {
                // Update approved post
                $old = CommunityLink::firstWhere('link', $data['link']);
                $old->touch();
                $old->save();
                return back()->with('success', 'Your contribution has been updated successfully!');
            } else {
                // Create approved post
                CommunityLink::create($data);
                return back()->with('success', 'Your contribution has been created successfully!');
            }
        } else {
            if ($repeated) {
                // Update timestamp, but needs to be approved
                $old = CommunityLink::firstWhere('link', $data['link']);
                if ($old['approved']) {
                    $old->touch();
                    $old->save();
                    return back()->with('error', 'Your contribution has been ignored, an existing aproved post exists, you require to be trusted to update it');
                } else {
                    $old->touch();
                    $old->save();
                    return back()->with('info', 'Your contribution has been updated successfully, but it needs to be approved!');
                }
            } else {
                // Post created, but needs to be approved
                CommunityLink::create($data);
                return back()->with('info', 'Your contribution has been created successfully!, but it needs to be approved');
            }
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
