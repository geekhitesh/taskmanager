<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mail;
use URL;
use Log;

class UpdateSalesforceDetails extends Controller
{
    //

    public function __construct()
    {
			

    }

    public function updatePhoneEmailForm(Request $request)
    {
		Log::info('visitor appeared');
    	return view('update_phone_email');
    }


    public function sendDetailsByEmail(Request $request)
    {
    	$email_id = $request->input('email_id');
    	$phone_no = $request->input('phone_no');

    	$contact_details = array();
    	$contact_details['email_id'] = $request->input('email_id');
    	$contact_details['phone_no'] = $request->input('phone_no');


    	Mail::send('contact_details_update_email', ['contact_details' => $contact_details], function($message) use ($contact_details) {
         		$message->to('data.correction@buniyad.com')->subject('Details for Phone #'.$contact_details['phone_no'].' Updated');
         		$message->from('helpdesk@buniyad.com');
      		});

    	return view('update_details_success');
    }



}
