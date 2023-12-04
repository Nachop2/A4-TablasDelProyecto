<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CommunityLink;
use Illuminate\Http\Request;
use App\Http\Requests\CommunityLinkForm;
use App\Queries\CommunityLinksQuery;
use Illuminate\Support\Facades\Auth;

class CommunityLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = CommunityLinksQuery::getAll();
        if (request()->exists('search')) {
            $term = request()->input('search');
            $links = CommunityLinksQuery::searchQuery($links, $term);
        }
        if (request()->exists('popular')) {
            $links = CommunityLinksQuery::getMostPopular($links);
        } else {
            $links = CommunityLinksQuery::sortByLatest($links);
        }
        return response()->json(['Links' => $links], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommunityLinkForm $request)
    {
        $data = $request->validated();
        $approved = Auth::user()->isTrusted();
        $data['approved'] = $approved;
        $data['user_id'] = Auth::id();

        $repeated = new CommunityLink();
        $test = $repeated->hasAlreadyBeenSubmitted($data['link']);

        //$option = 2 * $approved + $repeated;
        //dd($repeated);
        if ($approved) {
            if ($test === true) {
                // Update approved post
                $old = CommunityLink::firstWhere('link', $data['link']);
                $old->touch();
                $old->save();
                
                return response()->json(['message' => "Your contribution has been updated successfully!"], 201);
            } else {
                // Create approved post
                CommunityLink::create($data);
                return response()->json(['message' => "Your link has been published.Thanks for your contribution."], 201);
            }
        } else {
            if ($test === true) {
                // Update timestamp, but needs to be approved
                $old = CommunityLink::firstWhere('link', $data['link']);
                if ($old['approved']) {
                    $old->touch();
                    $old->save();
                    return response()->json(['message' => "Your contribution has been ignored, an existing aproved post exists, you require to be trusted to update it"], 201);
                } else {
                    $old->touch();
                    $old->save();
                    return response()->json(['message' => "Your contribution has been updated successfully, but it needs to be approved!"], 201);
                }
            } else {
                // Post created, but needs to be approved
                CommunityLink::create($data);
                return response()->json(['message' => "Your link will be reviewed for the administrator before publishing.Thanks for your contribution."], 201);
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
