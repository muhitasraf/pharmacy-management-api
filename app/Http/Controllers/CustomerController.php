<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'All Customer List';
        $customer_list = DB::table('customer')->get();
        return view('customer/index',compact('title','customer_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create New Customer';
        return view('customer/create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer_data = [
            'full_name' => $request->customer_name,
            'contact_number' => $request->contact_number,
            'address' => $request->customer_address,
            'customer_type' => $request->customer_type,
            'status' => $request->customer_status,
            'created_by' => 1,
            'created_at' => date('Y-m-d'),
            'updated_by' => 1,
            'updated_at' => date('Y-m-d'),
        ];
        $result = DB::table('customer')->insert($customer_data);
        if($result){
            return redirect('customer');
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
        $title = 'Single Group/Generic';
        $customer_data = DB::table('customer')->where('id',$id)->first();
        return view('customer/show',compact('title','customer_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Customer Edit';
        $customer_data = DB::table('customer')->where('id',$id)->first();
        return view('customer/edit',compact('title','customer_data'));
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
        $customer_data = [
            'full_name' => $request->customer_name,
            'contact_number' => $request->contact_number,
            'address' => $request->customer_address,
            'customer_type' => $request->customer_type,
            'status' => $request->customer_status,
            'created_by' => 1,
            'created_at' => date('Y-m-d'),
            'updated_by' => 1,
            'updated_at' => date('Y-m-d'),
        ];
        $result = DB::table('customer')->where('id',$id)->update($customer_data);
        if($result){
            return redirect('customer');
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
        $result = DB::table('customer')->where('id',$id)->delete();
        if($result){
            return redirect('customer');
        }
    }
}
