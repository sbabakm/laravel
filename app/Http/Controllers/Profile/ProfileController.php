<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Notifications\ActiveCodeNotification;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {
        return view('profile.index');
    }

    public function manageTwoFactor() {
        return view('profile.two-factor-auth');
    }

    public function postManageTwoFactor(Request $request) {

        $validate_data = $request->validate([
            'type'  =>  'required|in:sms,off',
            'phone' =>  'required_unless:type,off'
        ]);

        if($validate_data['type'] == 'sms') {
            if($request->user()->phone_number !== $validate_data['phone']){
                //create code
                $code = ActiveCode::GenerateCode(auth()->user());
                $request->session()->flash('phone', $validate_data['phone']);
                //return $code;
                //send code to user
                //$request->user()->notify(new ActiveCodeNotification($code , $validate_data['phone']));
                return redirect(route('profile.2fa.phone'));
            }
        }
        if($validate_data['type'] == 'off') {
            $request->user()->update([
                'two_factor_type' => 'off'
            ]);
        }
        return back();
    }

    public function getPhoneVerify(Request $request) {
        if(! $request->session()->has('phone')) {
            return redirect(route('profile.2fa.manage'));
        }
        $request->session()->reflash();
        return view('profile.phone-verify');
    }

    public function postPhoneVerify(Request $request) {

        $validate_date = $request->validate([
            'token' => 'required'
        ]);

        if(! $request->session()->has('phone')) {
            return redirect(route('profile.2fa.manage'));
        }

        $status = ActiveCode::VerifyCode($request->token , $request->user());
         if($status) {
            $request->user()->activeCode()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_type' => 'sms'
            ]);
             alert()->success('احراز هویت دو مرحله ای تایید شد','Success Message');
         }
         else {
             alert()->error('احراز هویت دو مرحله ای تایید نشد','error Message');
         }

        return redirect(route('profile.2fa.manage'));
    }
}
