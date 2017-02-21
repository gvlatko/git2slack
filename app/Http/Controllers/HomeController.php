<?php

namespace App\Http\Controllers;

use App\Channels;
use App\Http\Requests\CreateChannelRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = Channels::all();

        return view('home', compact('channels'));
    }

    public function addChannel(CreateChannelRequest $request)
    {
        $channel = new Channels;
        $channel->setRepository($request->get('repository'));
        $channel->setDestination($request->get('destination'));
        $channel->save();
        return redirect('home');
    }

    public function deleteChannel($id)
    {
        $channel = Channels::find($id);
        if ($channel) {
            $channel->delete();
        }
        return redirect('home');
    }
}
