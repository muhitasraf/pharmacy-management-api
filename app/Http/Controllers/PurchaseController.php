<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Purchase List';
        $sql = "SELECT tm.*, c.company_name FROM tran_master tm
                LEFT JOIN company c ON c.id = tm.company_id";
        $purchase_list = DB::select($sql);
        return view('purchase/index',compact('title','purchase_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create New purchase';
        $prev_inv = DB::select("SELECT invoice_no FROM tran_master ORDER BY id DESC LIMIT 1");
        if(!empty($prev_inv['invoice_no'])){
            $prev_inv_str = substr($prev_inv['invoice_no'],0,9);
            $prev_inv_num = substr($prev_inv['invoice_no'],9,strlen($prev_inv['invoice_no']));
            $new_invoice_no = $prev_inv_str.sprintf('%08d', $prev_inv_num + 1);
        }else{
            $new_invoice_no = "INV-".date("Y")."-00000000";
        }
        $company_name = DB::table('company')->select('id','company_name')->get();
        $sql = "SELECT b.id, b.brand_name, t.type_name, b.strength, b.packsize, g.generic_name, c.company_name, b.status FROM `brands` b
                LEFT JOIN generic g ON b.generic_id = g.id
                LEFT JOIN company c ON b.company_id = c.id
                LEFT JOIN type t ON b.type_id = t.id";
        $brand_list = DB::select($sql);
        return view('purchase/create',compact('title','company_name','new_invoice_no','brand_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        if(isset($request->brand_name[0]) && !empty($request->brand_name[0])){

            $tran_data = [
                'company_id' => $request->company_name,
                'invoice_no' => $request->invoice_no,
                'tran_date' => $request->purchase_date,
                'total_qty' => $request->total_qty,
                'total_price' => $request->grand_total,
            ];
            $result = DB::table('tran_master')->insert($tran_data);
            if($result){
                $id = DB::table('tran_master')->select('id')->orderBy('id','DESC')->first()->id;
                for($i = 0; $i<count($request->brand_name); $i++){
                    $purchase_data[] = [
                        'brand_id' => $request->brand_name[$i],
                        'generic_id' => $request->generic_id[$i],
                        'tran_id' => $id,
                        'price' => $request->price[$i],
                        'qty' => $request->qty[$i],
                        'total_price' => $request->total[$i],
                        'tran_date' => $request->purchase_date
                    ];
                }
                $result = DB::table('stock_in')->insert($purchase_data);
            }


            if($result){
                return redirect('purchase');
            }else{
                return redirect('purchase.create');
            }
        }else{
            return redirect('purchase.create');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Purchase';
        $sql = "SELECT b.brand_name, g.generic_name, g.id generic_id, tm.invoice_no, si.qty, si.price, si.total_price, tm.total_qty, si.tran_date
                FROM stock_in si
                LEFT JOIN brands b ON b.id = si.brand_id
                LEFT JOIN generic g ON g.id = si.generic_id
                LEFT JOIN tran_master tm ON tm.id = si.tran_id
                WHERE si.tran_id = $id";
        $purchase_data = DB::select($sql)[0];
        $company_name = DB::table('company')->select('id','company_name')->get();
        return view('purchase/edit',compact('title', 'company_name', 'purchase_data'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function medicine_list(){
        $company_id = $_POST['company_id'];
        $sql = "SELECT b.id, b.brand_name, t.type_name, b.strength, b.packsize, g.generic_name, c.company_name, b.status FROM brands b
                LEFT JOIN generic g ON b.generic_id = g.id
                LEFT JOIN company c ON b.company_id = c.id
                LEFT JOIN type t ON b.type_id = t.id WHERE b.company_id = $company_id";
        $purchase_list = DB::select($sql);
        echo json_encode($purchase_list);
    }

    public function single_brand(){
        $brand_id = $_POST['brand_id'];
        $sql = "SELECT b.id, b.brand_name, b.generic_id, t.type_name, b.price, b.strength, b.packsize, g.generic_name, c.company_name, b.status FROM brands b
                LEFT JOIN generic g ON b.generic_id = g.id
                LEFT JOIN company c ON b.company_id = c.id
                LEFT JOIN type t ON b.type_id = t.id WHERE b.id = $brand_id";
        $single_brand = DB::select($sql);
        echo json_encode($single_brand);
    }

}
