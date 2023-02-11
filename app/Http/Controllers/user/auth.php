<?php

namespace App\Http\Controllers\user;
use Illuminate\Contracts\Session\Session ;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class auth extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'name' =>'required',
            'email' =>'required|unique:users|string|email|max:255',
            'phone'=>'required',
            'password' =>'required',
            // 'n_id' =>'required',
          
             ]);
 
      
       $add= User::create(
            [
                 'name' => $request->name,
                 'email' => $request->email,
                 'phone' => $request->phone,
                 'password' =>Hash::make( $request->password),
                //  'n_id' => $request->n_id,

                 
                
             ]);
        

       if ($add->false) {
        return back()->withErrors(['كلمه السر والبريد غير منطابقين']);
        
       }else{
        return redirect()->route('/')->with('sacsess');   

       }


    }




    public function Login(Request $request){
        $request->validate([
           
            'email' =>'required',
            'password' =>'required',
           
 
             ]);

             $userinfo=User::where('email','=',$request->email)->first();

             if (!$userinfo) {
               return back()->with('fill','thiomthong woring');
             }else{
                if (Hash::check($request->password,$userinfo->password)) {
                  $request->session()->put('logeduser',$userinfo->id);
                  $request->session()->put('nameUser',$userinfo->name);
                  $request->session()->put('phoneuser',$userinfo->phone);
                  $request->session()->put('mohfzauser',$userinfo->mohfza);
                  $request->session()->put('city_user',$userinfo->city_);
                  $request->session()->put('ather_infoirmuser',$userinfo->ather_infoirm);
                  $request->session()->put('mailuser',$userinfo->email);
                 

                  if($request->has('remember_me')){
                    Cookie::queue('email', $request->email, 2629743);
                    Cookie::queue('password', $request->password, 2629743);
                  }


                  
                     return redirect('/');
                }else{
                    return back()->with('fill','password woring');
                }
             }

            }



            public function signOut(){


                if (Session()->has('logeduser')) {
                    Session()->pull('logeduser');
                    // Session()->pull('numroes');
                    // Session::flush();
                    
                    return redirect('login');
                }
              }
}
