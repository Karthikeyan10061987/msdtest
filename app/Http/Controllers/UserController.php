<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $cacheKey = 'api.users';

        if (Cache::has($cacheKey)) {
            return ['data' => Cache::get($cacheKey)];
        }

        $response = Http::get('https://dummyjson.com/users');

        if ($response->successful()) {
            $data = $response->json();
           
            $users = [];
            foreach ($data['users'] as $key=>$val) {
                //echo '<pre>'; print_r($val); exit; 
                $users[] = [
                    'id' => $val['id'],
                    'first_name' => $val['firstName'],
                    'last_name' => $val['lastName'],
                ];
            }

            Cache::put($cacheKey, $users, now()->addMinutes(60)); // Cache for 60 minutes

            return ['data' => $users];
        } else {
            return ['status' => 'error'];
        }
    }

    public function getUser(Request $request, $id)
    {
        $cacheKey = "api.user.{$id}";

        if (Cache::has($cacheKey)) {
            return ['data' => Cache::get($cacheKey)];
        }

        $response = Http::get("https://dummyjson.com/users/{$id}");

        if ($response->successful()) {
            $data = $response->json();
            $user = [
                'id' => $data['id'],
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
            ];

            Cache::put($cacheKey, $user, now()->addMinutes(60)); // Cache for 60 minutes

            return ['data' => $user];
        } else {
            return ['status' => 'error'];
        }
    }
}

