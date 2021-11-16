<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * Login page view
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $redirect   = $request->get('redirect');

        if (Auth::check()) {
            $url    = empty($redirect) ? url("/") : $redirect;
            return redirect($url);
        }
        return view('auth.login', compact('redirect'));
    }

    /**
     * Validate user login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function attemptLogin(Request $request)
    {
        // $data   = $request->all();

        $result = [];

        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember');

        $redirect = $request->redirect;

        $remember = ($remember === 'on') ? true : false;

        $credentials = [
            'email'  => $username,
            'password'  => $password,
        ];

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (empty($redirect)) {
                if(Auth::user()->role === 'admin') {
                    $redirect   = url('/admin');
                } else {
                    $redirect   = url('/');
                }
            }

            $result = [
                'status'    => 'success',
                'message'    => 'Login successfull. Redirecting...',
                'redirect'  => $redirect,
            ];

            return json_encode($result);
        }

        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ]);

        $result = [
            'status'    => 'error',
            'message'    => 'Invalid credentials, please try again.',
        ];

        return json_encode($result);
    }

    /**
     * Register page view
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $redirect   = $request->get('redirect');

        if (Auth::check()) {
            $url    = empty($redirect) ? url("/") : $redirect;
            return redirect($url);
        }

        return view('auth.register', compact('redirect'));
    }

    /**
     * Register page view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function attemptRegister(Request  $request)
    {
        // $data   = $request->all();

        $result = [];
        $errors = [];

        $full_name      = $request->input('full_name');
        $email_id       = strtolower( trim( $request->input('email_id') ) );
        $login_password  = trim( $request->input('login_password') );
        $repeat_password = trim( $request->input('repeat_password') );

        $redirect = $request->redirect;

        if(empty($full_name)) {
            $errors['full_name']    = "Name is required.";
        }

        if(empty($email_id)) {
            $errors['email_id']    = "Email Id is required.";
        } else {
            if(!isValidEmail($email_id)) {
                $errors['email_id']    = "Provide a valid email id.";
            }
            // Check if mobile number already exist
            $Users   = User::where('email', $email_id)->count();
            if($Users > 0) {
                $errors['email_id']    = "Email Id already exist.";
            }
        }

        if(empty($login_password)) {
            $errors['login_password']    = "Please provide a password.";
        }
        if( strlen($login_password) < 8 ) {
            $errors['login_password']    = "Password must be at least 8 characters long.";
        }
        if($login_password !== $repeat_password) {
            $errors['repeat_password']    = "Password does not match.";
        }

        $queryStatus    = false;
        if(empty($errors)) {
            try {
                User::create([
                    'name'      => $full_name,
                    'email'     => $email_id,
                    'password'  => Hash::make($login_password),
                    'role'      => 'user',
                ]);

                $queryStatus    = true;
            } catch (Exception $e) {
                $queryStatus    = $e->getMessage();
            }

            if($queryStatus === true) {
                $loginUrl   = empty($redirect) ? route("login") : route("login", ["redirect" => $redirect]);

                return json_encode([
                    'status'    => 'success',
                    'message'   => "Registration successful, <a href=\"{$loginUrl}\">Sign In now</a>",
                ]);
            } else {
                return json_encode([
                    'status'    => 'error',
                    'message'    =>  "Registration failed, {$queryStatus}",
                ]);
            }
        }

        return json_encode([
            'status'    => 'error',
            'message'   =>  "Registration failed.",
            'errors'    =>  $errors,
        ]);

    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return 'success';
    }

    /**
     * Profile Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_settings()
    {
        $User   = Auth::user();

        if(in_array($User->role, ['superadmin', 'admin'], true)) {
            return view('admin.profile-settings', compact('User'));
        } else {
            return view('user.profile-settings', compact('User'));
        }
    }

    /**
     * Change Password.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password()
    {
        $User   = Auth::user();

        $nonce  = create_nonce(['change-password', $User->id, $User->mobile]);
        return view('auth.user-change-password', compact('User', 'nonce'));
    }

    /**
     * Process ajax requests for Guest user.
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function ajax(Request $request)
    {
        $requestName = $request->requestName;

        // Get change password form
        if($requestName === "get_changePassword") {
            $User   = Auth::user();

            echo "<h5>Change Password</h5>";
            if( empty($User) ) {
                return "<p class=\"msg msg-danger msg-full\">Unauthorized Access.</p>";
            }

            $nonce  = create_nonce(['change-password', $User->id, $User->mobile]);
            return view("auth/user-change-password-form", compact('User', 'nonce'));
        }

        // Change password submit
        if($requestName === "changePassword_submit") {
            $User   = Auth::user();

            $user_id        = $request->user_id;
            $old_password       = $request->old_password;
            $new_password       = $request->new_password;
            $repeat_password    = $request->repeat_password;
            $nonce     = $request->_nonce;

            if( verify_nonce($nonce, ['change-password', $User->id, $User->mobile]) !== true ) {
                return json_encode([
                    'status'    => 'error',
                    'message'   => 'Invalid data submitted.',
                ]);
            }

            if(empty($new_password)) {
                $errors['new_password']    = "New password is empty.";
            } else if( strlen($new_password) < 8 ) {
                $errors['new_password']    = "Password must be at least 8 characters long.";
            }
            if($new_password !== $repeat_password) {
                $errors['repeat_password']    = "Repeat Password does not match.";
            }

            if(empty($old_password)) {
                $errors['old_password']    = "Old password is empty.";
            } else if (!Hash::check($old_password, $User->password)) {
                $errors['old_password']    = "Old password does not match with credentials.";
            }

            if(!empty($errors)) {
                return json_encode([
                    'status'    => 'error',
                    'errors'    =>  $errors,
                ]);
            }

            // Change password
            $exception  = "";
            try {
                User::find($User->id)->update([
                    'password'          => Hash::make($new_password),
                    'plain_text_pass'   => $new_password,
                    'force_pass_reset'  => 0,
                ]);
            } catch (Exception $e) {
                $exception  = $e->getMessage();
            }

            if(empty($exception)) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return json_encode([
                    'status'    => 'success',
                    'message'   => 'Password changesd successfully.',
                ]);
            } else {
                return json_encode([
                    'status'    => 'error',
                    'message'   => $exception,
                ]);
            }
        }
    }

    /**
     * Process ajax requests for LoggedIn user.
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function user_ajax(Request $request)
    {
        $requestName = $request->requestName;

        // Get change password form
        if($requestName === "set_user_session") {
            $allowedKeys    = [
                'admin_transactions_by_age',
                'admin_users_by_availability',
            ];

            $datakey    = $request->datakey;
            $dataval    = $request->dataval;

            if( !in_array($datakey, $allowedKeys) ) {
                return json_encode([
                    'status'    => 'error',
                    'message'   => 'Invalid data key sumpplied.',
                ]);
            }

            $request->session()->put($datakey, $dataval);
            return json_encode([
                'status'    => 'success',
                'message'   => '',
            ]);
        }
    }
}
