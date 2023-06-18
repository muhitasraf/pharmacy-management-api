<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDOException;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Company List';
        $company_list = DB::table('company')->get();
        return response()->json([
            'success' => true,
            'message' => $title,
            'data' => $company_list
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company_data = [
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_number' => $request->company_number,
            'company_address' => $request->company_address,
            'status' => $request->status,
            'created_by' => 1,
            'created_at' => date('Y-m-d'),
            'updated_by' => 1,
            'updated_at' => date('Y-m-d'),
        ];

        try{
            $result = DB::table('company')->insert($company_data);
            if($result){
                return response()->json([
                    'success' => true,
                    'message' => "CREATED",
                ],422);
            }
        }catch(PDOException $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Company Info';
        $company_data = DB::table('company')->where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => $title,
            'data' => $company_data
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Comopany';
        $company_data = DB::table('company')->where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => $title,
            'data' => $company_data
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company_data = [
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_number' => $request->company_number,
            'company_address' => $request->company_address,
            'status' => $request->status,
            'updated_by' => 1,
            'updated_at' => date('Y-m-d'),
        ];

        try{
            $result = DB::table('company')->where('id',$id)->update($company_data);
            if($result){
                return response()->json([
                    'success' => true,
                    'message' => "UPDATED",
                ],422);
            }
        }catch(PDOException $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $result = DB::table('company')->where('id',$id)->delete();
            if($result){
                return response()->json([
                    'success' => true,
                    'message' => "DELETED",
                ],200);
            }
        }catch(PDOException $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],422);
        }
    }
}
