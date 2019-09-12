<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoadUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $userRawData = file_get_contents('https://gitlab.iterato.lt/snippets/3/raw');
        $userRawData = $userRawData ?? '{}';
        $users = json_decode($userRawData);
        if (!empty($users->data)) {
            foreach ($users->data as $userData) {
                if (!User::where('email', $userData->email)->exists()){
                    $user = new User;
                    $user->fill((array)$userData);
                    $user->save();
                } else {
                    User::where('email', $userData->email)->update((array)$userData);
                }
            }
        }
    }
}
