<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MailboxLayer\Laravel\MailboxLayer;

class VerifyEmail extends Controller
{

public function verifyEmail(Request $request, MailboxLayer $mailboxLayer)
{
    $validatedData = $request->validate([
        'email' => 'required|email',
    ]);

    $email = $validatedData['email'];

    $response = $mailboxLayer->verify($email);

    // Process the response and determine if the email is valid
    if ($response['format_valid'] && $response['smtp_check']) {
        // Email is valid and exists
        // ...
    } else {
        // Email is not valid or does not exist
        // ...
    }
}

}
