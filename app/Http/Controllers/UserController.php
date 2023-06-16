<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        return response()->json([
            'success' => 'true',
            'message' => 'All User List',
        ]);
    }

    public function create(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'contact_number' => 'required',
                'password' => 'required|min:6',
                'cpassword' => 'required|min:6|same:password',
                'image' => 'required|image|max:10240',
            ]);
        }catch(ValidationException $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],422);
        }

        try{
            $photo = $request->file('photo');
            $filename = uniqid('image_',true).Str::random(10).'.'.$photo->getClientOriginalExtension();
            if($photo->isValid()){
                $photo->move(public_path().'/uploads/images/',$filename);
            }
            $data = [
                'full_name' => $request->input('fullname'),
                'email' => $request->input('email'),
                'contact_number' => $request->input('mobile_number'),
                'address' => $request->input('address'),
                'password' => bcrypt($request->input('password')),
                'image' => $filename,
            ];
            DB::table('users')->insert($data);
        }catch(ValidationException $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],422);
        }

        return response()->json($request->all());
    }
}
