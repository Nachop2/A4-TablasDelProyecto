<?php

namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;

class CommunityLinksQuery
{
    public static function getByChannel(Channel $channel,$link)
    {
        return $link->where('channel_id', $channel['id']);
    }

    public static function getAll()
    {
        return $links = CommunityLink::where('approved', 1);
    }

    // Filtering start

    public static function searchQuery($links,$term)
    {
        return $links->where('title','like', "%".$term."%");
    }

    // Filtering ending, requires pagination

    public static function getMostPopular($links)
    {
        return $links->withCount('users')->orderBy('users_count', 'desc')->paginate(25)->withQueryString();
    }
    public static function sortByLatest($links)
    {
        return $links->latest('updated_at')->paginate(25)->withQueryString();
    }
    
}
