<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FuelTax;
use Illuminate\Http\Request;

class FuelTaxController extends Controller
{
    public function index()
    {
        $fuelTaxes = FuelTax::orderBy('id','desc')->get();
        return view('admin.fuel_taxes.index',get_defined_vars());
    }
    public function create()
    {
        return view('admin.fuel_taxes.add');
    }
    public function store(Request $request)

    {
        $data = $request->validate([
            'name' => 'required',
            'tax' => 'required|max:100',
           
            
           
        ]);
        $fuelTax = new FuelTax();
        $fuelTax->name = $request->name;
        $fuelTax->tax = $request->tax;
       
        $fuelTax->save();
        return redirect('fuel_taxes')->withSuccess('Fuel Tax Added Successfully');
    }
    public function edit($id)
    {
        $fuelTax = FuelTax::find($id);
        return view('admin.fuel_taxes.edit',get_defined_vars());
    }
    public function update(Request $request,$id)
    {
        $data = $request->validate([
            'name' => 'required',
            'tax' => 'required|max:100',
 
        ]);
        $fuel_taxes = FuelTax::find($id);
        $fuel_taxes->name = $request->name;
        $fuel_taxes->tax = $request->tax;
        $fuel_taxes->update();
        return redirect('fuel_taxes')->withSuccess('Fuel Tax Updated Successfully');
    }
    public function delete($id)
    {
        $fuel_taxes = FuelTax::find($id);
        $fuel_taxes->delete();
        return redirect('fuel_taxes')->withError('Fuel Tax Deleted Successfully');
    }
}
