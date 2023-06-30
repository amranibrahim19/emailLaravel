<?php

namespace App\Http\Controllers;

use App\Imports\UserEmailImport;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Models\UserEmail;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

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
                $actionBtn = '<a data-bs-toggle="modal" id="view" data-bs-target="#kt_modal_1" data-attr="' . URL::to('user-email/show/' . $userEmail->id) . '" class="btn btn-primary btn-sm">Edit</a> 
                
                <a href="' . URL::to('user-email/delete/' . $userEmail->id) . '" class="delete btn btn-danger btn-sm">Delete</a>';

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

    public function destroy($id)
    {
        UserEmail::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Record deleted successfully!');
    }

    public function sendBulk(Request $request)
    {

        DB::table('user_emails')->orderBy('id')->chunk(1, function ($users) {
            foreach ($users as $data) {
                $email = $data->email;
                $code = $data->code;

                $details = [
                    'title' => 'Mail from ItSolutionStuff.com',
                    'body' => 'This is for testing email using smtp',
                    'code' => $code
                ];

                Mail::to($email)->send(new WelcomeMail($details, $code));
            }
        });

        return response()->json([
            'success' => 'Success send bulk email!'
        ]);
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

        $data = Excel::import(new UserEmailImport, public_path('uploads/' . $fileName));

        return response()->json([
            'success' => 'Success upload file!'
        ]);
    }
}
