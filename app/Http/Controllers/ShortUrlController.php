<?php

namespace App\Http\Controllers;

use App\Facades\Actions\UrlCode;
use App\Models\ShortUrl;
use Symfony\Component\HttpFoundation\Response;

class ShortUrlController extends Controller
{
    public function store()
    {
        request()->validate([
            'url' => 'required|url',
        ]);

        $code = UrlCode::generate();

        $shortUrl = ShortUrl::query()
            ->firstOrCreate([
                'url' => request('url'),
            ], [
                'short_url' => config('app.url') . '/' . $code,
                'code'      => $code,
            ]);

        return response()->json([
            'short_url' => $shortUrl->short_url,
        ], Response::HTTP_CREATED);
    }

    public function destroy(ShortUrl $shortUrl)
    {
        $shortUrl->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
