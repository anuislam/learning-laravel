<?php

namespace Modules\Gymwebsite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Form;
use Validator;
use Auth;
use DB;
use Session;
use Purifier;
use Mail;
use App\BlogPost;
use App\UserPermission;

class contactController extends Controller{

	public function send_mail(Request $request){
		Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|min:10',
            'message'    => 'required|string|max:2500',
        ])->validate();
		$mail_data = $request->all();
		$data = [
			'name' 	  		=> sanitize_text($mail_data['name']),
			'email' 		=> sanitize_email($mail_data['email']),
			'bodyMessage' 	=> Purifier::clean($mail_data['message'], array(
                                            'HTML.Allowed'  => 'b,strong,span,a,em,a[href|title],ul,ol,li,p[style],br,img[width|height|alt|src],h1,h2,h3,h4,h5,h6',
                                            'AutoFormat.AutoParagraph' => true,
                                            'HTML.Nofollow' => true,
                                    )),
		];

        $send = Mail::send('gymwebsite::sendMail', $data, function($message) use ($data){
        	$message->to('anuislams@gmail.com');
        	$message->from($data['email']);
        	$message->subject('Website Visitor < '. $data['name'] .' >');
        });
        if (Mail::failures()) {
        	return redirect()->back()->with('error_send_mail', 'Opss Something is wron please try again..');
        }

        return redirect()->back()->with('send_mail', 'Thanks for you message..');
	}
}