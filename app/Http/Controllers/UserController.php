<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PDOException;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    function  __construct()
    {

    }

    public function index(){
        $data = app('db')->table('users')->get();
        return response()->json([
            'success' => 'true',
            'message' => 'All User List',
            'data' => $data,
        ],200);
    }

    public function create(Request $request){

        try{
            $this->validate($request, [
                'full_name' => 'required',
                'user_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'contact_number' => 'required',
                'password' => 'required|min:6',
                'cpassword' => 'required|min:6|same:password',
                // 'image' => 'required|image|max:10240',
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],422);
        }

        try{
            // $photo = $request->file('photo');
            // $filename = uniqid('image_',true).Str::random(10).'.'.$photo->getClientOriginalExtension();
            // if($photo->isValid()){
            //     $photo->move(public_path().'/uploads/images/',$filename);
            // }
            $data = [
                'full_name' => $request->input('full_name'),
                'user_name' => $request->input('user_name'),
                'email' => $request->input('email'),
                'contact_number' => $request->input('contact_number'),
                'address' => $request->input('address'),
                'password' => app('hash')->make($request->input('password')),
                // 'image' => $filename,
            ];

            $rs = app('db')->table('users')->insertGetId($data);
            return response()->json([
                'success' => true,
                'message' => 'Successfully Created',
            ],201);
        }catch(PDOException $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],422);
        }

    }
}
