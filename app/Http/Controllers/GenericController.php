<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenericController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'All Generic List';
        $generic_name = DB::table('generic')->get();
        return view('generic/index',compact('title','generic_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create New Generic/Group';
        return view('generic/create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $generic_data = [
            'generic_name' => $request['generic_name'],
            'dose' => $request['dose'],
            'mode_of_action' => $request['mode_of_action'],
            'status' => $request['status'],
            'created_by' => 1,
            'created_at' => date('Y-m-d')
        ];
        $result = DB::table('generic')->insert($generic_data);
        if($result){
            return redirect('generic');
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
        $generic_name = DB::table('generic')->where('id',$id)->first();
        return view('generic/show',compact('title','generic_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Generic Name Edit';
        $generic_name = DB::table('generic')->where('id',$id)->first();
        return view('generic/edit',compact('title','generic_name'));
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
        $generic_data = [
            'generic_name' => $request->generic_name,
            'dose' => $request->dose,
            'mode_of_action' => $request->mode_of_action,
            'status' => $request->status,
            'updated_by' => 1,
            'updated_at' => date('Y-m-d')
        ];
        $result = DB::table('generic')->where('id',$id)->update($generic_data);
        if($result){
            return redirect('generic');
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
        $result = DB::table('generic')->where('id',$id)->delete();
        if($result){
            return redirect('generic');
        }
    }
}
