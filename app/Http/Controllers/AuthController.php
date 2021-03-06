<?php

namespace App\Http\Controllers;

use App\Http\Resources\Jobad as JobadResource;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function registerAsCustomer(Request $request)
    {
        $user = $this->generalRegister($request);

        $user->assignRole('customer');
        return response(new UserResource($user), 201);
    }
    public function registerAsDesigner(Request $request)
    {
        $user = $this->generalRegister($request);
        $user->assignRole('designer');
        return response(new UserResource($user), 201);
    }

    public function generalRegister(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
//        Log::debug($request->username);

        $user = \App\Models\User::create([
            'email' => $request->email,
            'username'=>$request->username,
            'password' => bcrypt($request->password)
        ]);
        return $user;
    }

    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;

        $this->validate($request,[
            'email'=>'required',
            'password'=>'required'
        ]);

        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        }
        catch (\GuzzleHttp\Exception\BadResponseException $e) {
            //return response($e);

            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }
}
