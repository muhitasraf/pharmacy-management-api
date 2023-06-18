<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('company/index',compact('title','company_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create New company';
        return view('company/create',compact('title'));
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
            'status' => $request->company_status,
            'created_by' => 1,
            'created_at' => date('Y-m-d'),
            'updated_by' => 1,
            'updated_at' => date('Y-m-d'),
        ];
        $result = DB::table('company')->insert($company_data);
        if($result){
            // notification(['type'=>'success', 'message'=>'Create Successfully']);
            return redirect('company');
        }else{
            // notification(['type'=>'error', 'message'=>'Failed To Cteate']);
            return redirect('company');
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
        return view('company/show',compact('title','company_data'));
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
        return view('company/edit',compact('title','company_data'));
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
            'status' => $request->company_status,
            'updated_by' => 1,
            'updated_at' => date('Y-m-d'),
        ];
        $result = DB::table('company')->where('id',$id)->update($company_data);
        if($result){
            return redirect('company');
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
        $result = DB::table('company')->where('id',$id)->delete();
        if($result){
            return redirect('company');
        }else{
            return redirect('company');
        }
    }
}
