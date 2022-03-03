<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;

class StatsController extends Controller
{
    public function lastVisit(ShortUrl $shortUrl)
    {
        return [
            'last_visit' => $shortUrl->last_visit?->toIso8601String(),
        ];
    }

    public function visits(ShortUrl $shortUrl)
    {
        // Does not work in SQLite

        $visits = $shortUrl->visits()
            ->selectRaw("
                DATE_FORMAT(created_at, '%Y-%m-%d') as date,
                COUNT(*) as count
           ")
            ->groupByRaw('DATE_FORMAT(created_at, "%Y-%m-%d")')
            ->get();

        ray($visits->toArray());

        return [
            'total'  => $shortUrl->visits()->count(),
            'visits' => $visits->toArray(),
        ];
    }
}
