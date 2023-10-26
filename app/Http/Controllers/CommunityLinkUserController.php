<?php

namespace App\Http\Controllers;

use App\Models\CommunityLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CommunityLinkUser;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;





class CommunityLinkUserController extends Controller
{
    public function store(CommunityLink $link)
    {
        $vote = CommunityLinkUser::firstOrNew([
        'user_id' => Auth::id(),
        'community_link_id' => $link->id
        ]);
        $vote->toggleVote($vote);
        return back();

    }

    
}
