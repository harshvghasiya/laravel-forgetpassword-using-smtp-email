<?php

namespace App\Http\Controllers;

use App\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function loginForm()
    {
        return view('login');
    }

    public function registerForm()
    {
        return view('register');
    }

    public function login(Request $request)
    {
      if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
        return redirect()->route('dashboard');
    }
    return back();
    }

    public function register(Request $request)
    {

        $res= new Admin;
        $res->email=$request->input('email');
        $res->password=Hash::make($request->input('password'));
        $res->name=$request->input('name');
        $res->save();
        return redirect()->route('loginForm');
    }

    public function dashboard()
    {
       $all=Admin::all();
       return view('dashboard',compact('all')); 
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function forgetpasswordForm()
    {
        return view('forgetpassword');
    }

    public function forgetpassword(Request $request)
    {

        $data=Admin::where('email',$request->input('email'))->first();
        
        if ($data != null) {
            $token=Str::random(15);
            $to_name=$data->name;
            $to_email=$data->email;
            $data->forget_password_token=$token;
            $data->created_at=Carbon::now('Asia/Kolkata');
            $data->save();
             Mail::send('emails.mail_template', ['name'=>$to_name,'body'=>'Hi '.$to_name.', Simple mail','token'=>$token], function($message)use($to_name,$to_email) {
                $message->to($to_email)->subject('Test Email');
                $message->from('harshvghasiya14@gmail.com','Harsh');
            }); 
           return back();
        }
    }

    public function resetForm(Request $request,$token)
    {
        $user=Admin::where('forget_password_token',$token)->first();
        $afterFive=Carbon::now('Asia/kolkata');
        if ($user != null) {
            
        
        $user_created_at=Carbon::createFromTimeString($user->created_at,'Asia/kolkata');
        if ($afterFive->diffInMinutes($user_created_at)>=5) {
                $user->forget_password_token=null;
                $user->save();     
        }

        $user_token=$user->forget_password_token;
         }else{
            $user_token=null;
         }
        return view('resetForm',compact('token','user_token'));
    }

    public function resetPasswordSubmit(Request $request)
    {
        $token=$request->input('forget_password_token');
      
        $user=Admin::where('forget_password_token',$token)->first();
        if ($user != null) {
            $user->password=Hash::make($request->input('password'));
          
            $user->save();
            return redirect()->route('loginForm');
        }

        return back();
    }

}
