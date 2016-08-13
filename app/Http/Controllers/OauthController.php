<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use RestClient;
use Socialite;

class OauthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')
            ->scopes([
                'user',
                'read:org',
            ])->redirect();
    }

    public function handleProviderCallback()
    {
        // try {
        $response = Socialite::driver('github')->user();
        // } catch (Exception $e) {
        //     return redirect('/')->with('error', [
        //         'message' => 'Error authenticating with Github',
        //     ]);
        // }

        // check user is a part of the sands organization

        $api = new RestClient([
            'base_url' => "https://api.github.com/",
            'headers' => ['Authorization' => 'token ' . $response->token],
        ]);

        $result = $api->get("user/orgs");

        try {
            $orgs = array_pluck($result->decode_response(), 'login');
        } catch (Exception $e) {
            return redirect('/')->with('error', [
                'message' => 'Error getting your Github Organization Membership.',
            ]);
        }

        if ($result->info->http_code != 200 || !in_array(env('GITHUB_ONLY_ORG'), $orgs)) {
            return redirect('/')->with('error', [
                'message' => 'You have to be a member of the Sands Consulting Organization to access this application.',
            ]);
        }

        $user = User::find($response->id);

        // create user

        if (!$user) {
            $user = User::create([
                'id' => $response->id,
                'email' => $response->email,
                'nickname' => $response->nickname,
                'name' => $response->name,
                'avatar' => $response->avatar,
                'token' => $response->token,
            ]);
        }

        // update user

        $updateData = [];

        foreach ([
            'email',
            'nickname',
            'name',
            'avatar',
            'token',
        ] as $prop) {
            if ($user->{$prop} != $response->{$prop}) {
                $updateData[$prop] = $response->{$prop};
            }
        }

        if ($updateData) {
            $user->update($updateData);
        }

        auth()->login($user);

        return redirect()->action('ApplicationsController@getIndex');
    }
    //
}
