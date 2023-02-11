<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class auth extends Controller
{
    
    public function store(Request $request)
    {
        
        // $request->validate([
        //     'name' =>'required',
        //     'email' =>'required|unique:users|string|email|max:255',
        //     'phone'=>'required',
        //     'password' =>'required',
        //     // 'n_id' =>'required',
          
        //      ]);

        $userinfo = User::where('email', '=', $request->email)->first();

        if ( $userinfo->id > 0) {

                    return response()->json(['message' => trans('Email_exet')], 404);
        
        
        }
      
       $add= User::create(
            [
                 'name' => $request->name,
                 'email' => $request->email,
                 'phone' => $request->phone,
                 'password' =>Hash::make( $request->password),
                //  'n_id' => $request->n_id,

                 
                
             ]);
        

       if ($add->false) {
        // return response()->json(['data' =>   userResource::collection(regester::where('id', '=', $id_user,)->get())  ,'stat' => compact('loginsuccess')], 200); 
        // return response()->json(['data' =>   'noooooooooo'  ], 200); 
        return response()->json(['message' =>   'noooooooooo'  ], 200); 


        
       }else{
        return response()->withErrors()->json(['data' =>   'yyyyyyyy'  ], 200); 

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

                    return response()->json(['data' => User::find($userinfo->id)    ], 200); 

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
