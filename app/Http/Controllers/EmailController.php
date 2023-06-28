<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        return view('email.index');
    }

    public function send(Request $request)
    {

        $file = $request->file('fileName');

        $filePath = $file->getRealPath();

        $file = fopen($filePath, 'r');

        $header = fgetcsv($file);

        $users = [];

        while ($row = fgetcsv($file)) {
            $users[] = array_combine($header, $row);
        }

        fclose($file);

        return view('email.read', compact('users'));
    }


    public function email(Request $request)
    {

        dd($request->email);
        // foreach ($request->email as $email) {
        //     $user = [
        //         'email' => $email,
        //         'code' => $request->code,
        //     ];

        //     Mail::to($email)->send(new WelcomeMail($user));
        // }

        // return response()->json(
        //     ['message' => 'Email Sent Successfully'],
        //     200
        // );
    }
}
