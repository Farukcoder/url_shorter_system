<?php

namespace App\Http\Controllers\Api;

use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShortenedUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $urls = ShortenedUrl::where('user_id', Auth::id())->paginate(10);

            $urls->getCollection()->transform(function ($url) {
                $url->short_url = route('s', $url->short_url);
                return $url;
            });
    
            if ($urls->isEmpty()) {
                return response()->json([
                    "status" => "error",
                    "status_code" => 404,
                    "message" => "No URLs found"
                ])->setStatusCode(404);
            }
    
            return response()->json([
                "status" => "success",
                "status_code" => 200,
                "message" => "URLs data found",
                "data" => $urls
            ])->setStatusCode(200);
    
        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "status_code" => 500,
                "message" => "Error: " . $e->getMessage()
            ])->setStatusCode(500);
        }
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
    public function store(Request $request)
    {
        $request->validate([
            'long_url' => 'required|url',
        ]);

        try {
        
            $shortUrl = $this->generateShortUrl($request->long_url);

            ShortenedUrl::create([
                'user_id' => Auth::id(),
                'long_url' => $request->long_url,
                'short_url' => $shortUrl,
            ]);

            return response()->json([
                "status" => "success",
                "message" => "URL shortened successfully",
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while saving the URL",
                "error" => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
    private function generateShortUrl($longUrl)
    {
        // Your logic for generating short URL goes here
        return substr(md5($longUrl . time()), 0, 6);
    }
}
