<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ShortLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shortLinks = ShortLink::latest()->get();

        return view('shortenLink', compact('shortLinks'));
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
            'link' => 'required|url',
            'limit' => 'sometimes|integer|nullable'
        ]);

//        dd($request->all());

        $input['link'] = $request->link;
        $input['limit'] = $request->limit;
        $input['code'] = Str::random(6);

        ShortLink::create($input);

        return redirect('generate-shorten-link')
            ->with('message', [
                'type' => 'success',
                'text' => 'Shorten Link Generated Successfully!'
            ]);
    }

    public function shortenLink($code)
    {
        $shortLink = ShortLink::where('code', $code)->first();
        if ($shortLink->limit === 0) {
            return redirect('generate-shorten-link')
                ->with('message', [
                    'type' => 'danger',
                    'text' => 'Sorry! Link limit extended.'
                ]);
        }
        $shortLink->increment('click_count',1);
        if ($shortLink->limit) {
            $shortLink->decrement('limit');
            return redirect($shortLink->link);
        }
        return redirect($shortLink->link);
    }
}
