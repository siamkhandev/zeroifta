<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
        $companies = User::whereRole('company')->orderBy('id','desc')->get();
        return view('admin.companies.index',get_defined_vars());
    }
    public function delete($id)
    {
        User::whereId($id)->delete();
        return redirect()->back()->withError('Company Deleted Successfully');
    }
}
