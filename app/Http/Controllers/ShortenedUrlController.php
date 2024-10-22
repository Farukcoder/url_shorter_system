<?php

namespace App\Http\Controllers;

use App\Models\ShortenedUrl;
use App\Http\Requests\StoreShortenedUrlRequest;
use App\Http\Requests\UpdateShortenedUrlRequest;

class ShortenedUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = ShortenedUrl::where('user_id', auth()->id())->paginate(10);
        return view('shortend_url.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shortend_url.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShortenedUrlRequest $request)
    {
        $request->validate([
            'long_url' => 'required|url',
        ]);

        // Logic for generating the short URL
        $shortUrl = $this->generateShortUrl($request->long_url);

        ShortenedUrl::create([
            'user_id' => auth()->user()->id,
            'long_url' => $request->long_url,
            'short_url' => $shortUrl,
        ]);

        return redirect()->route('url-shorten.index')->with('success', 'URL shortened successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($shortenedUrl)
    {
        // Find the URL by the short URL slug
        $shortenedUrl = ShortenedUrl::where('short_url', $shortenedUrl)->firstOrFail();

        // Increment the click count each time the short URL is accessed
        $shortenedUrl->increment('click_count');

        // Redirect to the original long URL
        return redirect($shortenedUrl->long_url);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShortenedUrl $shortenedUrl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShortenedUrlRequest $request, ShortenedUrl $shortenedUrl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortenedUrl $shortenedUrl)
    {
        //
    }

    private function generateShortUrl($longUrl)
    {
        // Your logic for generating short URL goes here
        return substr(md5($longUrl . time()), 0, 6);
    }
    public function shortenerViewUrl($shortenedUrl)
    {
        // Find the URL by the short URL slug
        $shortenedUrl = ShortenedUrl::where('short_url', $shortenedUrl)->firstOrFail();

        // Increment the click count each time the short URL is accessed
        $shortenedUrl->increment('click_count');

        // Redirect to the original long URL
        return redirect($shortenedUrl->long_url);
    }

}
