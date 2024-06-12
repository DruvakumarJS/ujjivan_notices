<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Audit;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Models\LoginKey;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo(){

        $audit = Audit::create([
            'action' => 'Logged in to Ujjivan Dashboard',
            'track_id' => Auth::user()->id,
            'user_id' => Auth::user()->id,
            'module' => 'Login',
            'operation' => 'C',
            'pan_india' => '-'
          ]);

        return '/home';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(){
        $privateKey = openssl_pkey_new(array(
            'private_key_bits' => 2048, // Key size in bits
            'private_key_type' => OPENSSL_KEYTYPE_RSA, // Type of key to be generated
        ));
        if ($privateKey === false) {
            // Handle key generation error
            abort(500, 'Error generating private key.');
        }
        $result = openssl_pkey_export($privateKey, $privateKeyString);
        if ($result === false) {
            // Handle key export error
            abort(500, 'Error exporting private key.');
        }
        
        // Extract the public key from the private key
        $publicKeyDetails = openssl_pkey_get_details($privateKey);
        $publicKey = $publicKeyDetails['key'];
        $sessionPublicKey = Session::get('publicKey');

        // print_r($sessionPublicKey);exit;
    
        if($sessionPublicKey == ''){

            $loginKey = new LoginKey();
            $loginKey->publickey = $publicKey;
            $loginKey->privatekey = $privateKeyString;
            $loginKey->save();
            Session::put('sId', trim($loginKey->id));
            Session::put('publicKey', trim($publicKey));
        }
        $publicKey =  Session::get('publicKey');

        
        return view('auth.login');
    }

    protected function attemptLogin(Request $request){

        $sId =  Session::get('sId');
        // print_r(Session::get('sId'));exit;
        $loginKey = LoginKey::find($sId);
       // echo '<pre>';
        // print_r($sId);exit;
        if($loginKey){
           $privateKey = $loginKey->privatekey;
        }else{
            return response()->json( ['status'=>'0','message'=>'failed']);
        }


        $user = User::where('email',$request->email)->first();
       
        $encryptedPassword = $request->input('password');
        $encryptedData = base64_decode($encryptedPassword);
        $decryptedData = null;
        // openssl_private_decrypt($encryptedData, $decryptedData, $privateKey);

       if (!openssl_private_decrypt($encryptedData, $decryptedData, $privateKey)) {
            $error = openssl_error_string();
            echo "Decryption error: $error";
        } else {
        //    return response()->json(['decryptedData' => $decryptedData ]);
        }
        $credentials = ['email'=>$request->input('email') , 'password'=>$decryptedData];
        if (Auth::attempt($credentials)) {
           // print_r("1"); die();
            $user = Auth::user();
            $user->session_id = Session::getId();
            $user->save();
            LoginKey::where('id',$sId)->delete();
            Session::forget('publicKey');
            Session::forget('sId');

            $audit = Audit::create([
            'action' => 'Logged in to Ujjivan Dashboard',
            'track_id' => Auth::user()->id,
            'user_id' => Auth::user()->id,
            'module' => 'Login',
            'operation' => 'C',
            'pan_india' => '-'
          ]);
            // return redirect(URL::route('home'));
            // return redirect()->intended(URL::route('home'));
            return response()->json( ['status'=>'1','message'=>'success']);
        }else{
           // print_r("2"); die();
            LoginKey::where('id',$sId)->delete();
            Session::forget('publicKey');
            Session::forget('sId');
            return response()->json( ['status'=>'0','message'=>'failed11']);
            // return redirect()->back()->withErrors(['employee_id' => 'User ID / Password seems to be incorrect']);
        }
    }

    protected function logout(){
        Session::flush();
       
        Auth::logout();

        return redirect('login');
    }
}
