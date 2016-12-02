<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/events', ['as' => 'git.events', 'uses' => GitEventsController::class . '@handlePayload' ]);
//
//Route::post('/events', function(Request $request) {
//  \Log::info($request->header('X-GitHub-Event'));
//  \Log::info($request->header('X-GitHub-Delivery'));
//  \Log::info($request->header('X-Hub-Signature'));
//
//    $providers = collect
//
//    $provider = new GitPayloadProvider($request);
//
//    if (!$provider->verify()) {
//        return response('Unauthorized', 403);
//    }
//
//    $event = $provider->retrieveEvent();
//
//
//});
