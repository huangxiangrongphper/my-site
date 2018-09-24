<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/topics', function (Request $request){
    $topics = \App\Topic::select(['id','name'])
        ->where('name','like','%'.$request->query('q').'%')
        ->get();
    return $topics;
})->middleware('api');

Route::post('/question/follower',function (Request $request){
    $followed = \App\Follow::where('question_id',$request->get('question'))
                ->where('user_id',$request->get('user'))
                ->count();
    if($followed) {
        return request()->json(['followed' => true ]);
    }
    return response()->json(['followed' => false ]);

})->middleware('api');














