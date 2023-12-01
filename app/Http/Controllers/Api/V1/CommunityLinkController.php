<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CommunityLink;
use Illuminate\Http\Request;
use App\Http\Requests\CommunityLinkForm;
use App\Queries\CommunityLinksQuery;
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
        if(request()->exists('search')){
            $term = request()->input('search');
            $links = CommunityLinksQuery::searchQuery($links,$term);
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
        //
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
