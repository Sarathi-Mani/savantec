<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = User::where('type', 'company')->where('is_active',1)->where('delete_status',1)->get();
        return view('company.index', compact('companies'));
    }

    public function create()
    {
        return view('company.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users',
            'mobile' => 'nullable|string|max:20',
            
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
      
        $user->type = 'company';
        $user->lang = 'en';
        $user->created_by = \Auth::user()->creatorId();
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect()->route('company.index')->with('success', 'Company created successfully.');
    }

    public function edit($id)
    {
        $company = User::find($id);
        return view('company.edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();

        return redirect()->route('company.index')->with('success', 'Company updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete_status = 0;
            $user->is_active = 0;
            $user->save();
            return redirect()->route('company.index')->with('success', 'Company deleted successfully.');
        }
        return redirect()->route('company.index')->with('error', 'Company not found.');
    }
}