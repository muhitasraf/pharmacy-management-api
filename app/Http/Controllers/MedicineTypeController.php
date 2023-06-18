<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Medicine Type List';
        $type_name = DB::table('type')->get();
        return view('type/index',compact('title','type_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create New Medicine Type';
        return view('type/create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type_data = [
            'type_name' => $request->type_name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => 1,
            'created_at' => date('Y-m-d')
        ];
        $result = DB::table('type')->insert($type_data);
        if($result){
            return redirect('medicine_type');
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
        $title = 'Medicine Type';
        $type_name = DB::table('type')->where('id',$id)->first();
        return view('type/show',compact('title','type_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Type Name Edit';
        $type_name = DB::table('type')->where('id',$id)->first();
        return view('type/edit',compact('title','type_name'));
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
        $type_data = [
            'type_name' => $request->type_name,
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => 1,
            'updated_at' => date('Y-m-d')
        ];
        $result = DB::table('type')->where('id',$id)->update($type_data);
        if($result){
            return redirect('medicine_type');
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
        $result = DB::table('type')->where('id',$id)->delete();
        if($result){
            return redirect('medicine_type');
        }
    }
}
