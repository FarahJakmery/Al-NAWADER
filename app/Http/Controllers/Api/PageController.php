<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Mail\AlnawaderMail;
use App\Models\Contactus;
use App\Models\PrivacyPolicy;
use App\Models\ShareApp;
use App\Models\ShareApplication;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    use ApiResponseTrait;
    public function privacyPolicyPage()
    {
        $privacy_policy = PrivacyPolicy::translated()->first();
        return $this->apiResponse($privacy_policy, 'This is The Privacy Policy Page Data', 200);
    }

    public function shareApplicationPage()
    {
        $share_app = ShareApp::translated()->first();
        return $this->apiResponse($share_app, 'This is The Share Application Page Data', 200);
    }

    public function contactUsPage()
    {
        $social_media = SocialMedia::first();
        return $this->apiResponse($social_media, 'This is The Contact us Page Data', 200);
    }

    public function sent_message_to_email(Request $request)
    {
        // Saving Message In the DataBase
        $data = [
            'name'  => $request->user_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'body'  => $request->message,
        ];
        Contactus::create($data);

        // Send Message To Email
        $details = [
            'title' => 'test email',
            'name'  => $request->user_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'body'  => $request->message,
        ];
        Mail::to('farah97jojo@gmail.com')->send(new AlnawaderMail($details));
        return $this->apiResponse(null, 'Your message has been sent', 200);
    }
}
