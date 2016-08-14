<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use RestClient;
use Socialite;

class OauthController extends Controller
{
    public function redirectToGithubProvider()
    {
        return Socialite::driver('github')
            ->scopes([
                'user',
                'read:org',
            ])->redirect();
    }

    public function handleGithubProviderCallback()
    {
        try {
            $response = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return redirect('/')->with('error', [
                'message' => 'Error authenticating with Github',
            ]);
        }

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

        // check if user is already in the db
        $user = User::find($response->id);

        // create user if not in db
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

        // login the user
        auth()->login($user);

        return redirect()->action('DashboardController@getIndex');
    }

    public function redirectToGoogleProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleProviderCallback()
    {
        try {
            $response = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect('/')->with('error', [
                'message' => 'Error authenticating with Google',
            ]);
        }

        // check if user is in my-sands organization
        if (false === strstr($response->email, env('GOOGLE_ONLY_EMAIL', '@my-sands.com'))) {
            return redirect('/')->with('error', [
                'message' => 'Please login using your ' . env('GOOGLE_ONLY_EMAIL', '@my-sands.com') . ' email.',
            ]);
        }

        $user = User::find($response->id);

        // create nickname if not exists
        if (!$response->nickname) {
            $names = explode(' ', $response->name);
            $response->nickname = array_shift($names);
        }

        // create user if not found
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

        // log the user in
        auth()->login($user);

        return redirect()->action('DashboardController@getIndex');
    }

    public function logout()
    {
        session()->flush();
        auth()->logout();
        return redirect('/');
    }
    //
}
