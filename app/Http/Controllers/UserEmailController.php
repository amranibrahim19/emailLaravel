<?php

namespace App\Http\Controllers;

use App\Models\UserEmail;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\URL;

class UserEmailController extends Controller
{
    public function index()
    {
        return view('email.index');
    }

    public function getEmailUser()
    {
        $userEmail = UserEmail::orderBy('id', 'desc')->get();

        return Datatables::of($userEmail)
            ->addColumn('action', function ($userEmail) {
                $actionBtn = '<a data-bs-toggle="modal" id="view" data-bs-target="#kt_modal_1" data-attr="' . URL::to('user-email/show/' . $userEmail->id) . '" class="btn btn-primary btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';

                return $actionBtn;
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($id)
    {
        $userEmail = UserEmail::find($id);

        return response()->json([
            'list' => $userEmail
        ]);
    }


    public function update(Request $request, $id)
    {
        UserEmail::where('id', $id)->update([
            'email' => $request->email,
            'code' => $request->code
        ]);

        return response()->json([
            'success' => 'Record updated successfully!'
        ]);
    }
}
