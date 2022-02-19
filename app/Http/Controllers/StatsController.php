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
}
