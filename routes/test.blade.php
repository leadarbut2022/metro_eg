<?php

namespace App\Http\Controllers;

use App\Models\clinc;
use App\Models\clinic_img;
use App\Models\clinic_spechl;
use App\Models\clinic_img_lenesc;
use App\Models\clinic_type;
use App\Models\teem_work_clicic;
use App\Models\user_img_lenesc;
use App\Models\clinc_specialty_anml;
use App\Models\img_more;
use App\Models\api_keys;
use Illuminate\Support\Facades\Hash;



use json_decode;








use Illuminate\Http\Request;

class ClincController extends Controller
{
    public function form_regester_clinic(Request $request){


 
     $apicheke = api_keys::where('user_', '=', $request->user_)->first();

        if (!$apicheke) {
        
                    return response()->json(['message' => trans('api_not_sac_user')], 404);
        }else{
        
            if (Hash::check($request->key_, $apicheke->key_)) {





        $regestersuccess='';
        $emailexets='';
        $users = clinc::where('id_user', $request->id_user)->get();

        # check if email is more than 1

        if(sizeof($users) > 0){
             # tell user not to duplicate same email
             $clinicexets=true;
             return response()->json(['message' => compact('clinicexets')], 200);
            
         }





     

        

    
        




                $data = clinc::create([
                        'id_user' => $request->id_user,
                        'name_clinc' => $request->name_clinc,
                        'phone_clinc' => $request->phone_clinc,
                        'owner_name' => $request->owner_name,
                        'clinc_country' => $request->clinc_country,
                        'clinc_gavernetor' => $request->clinc_gavernetor,
                        'clinc_cities' => $request->clinc_cities,
                        'clinc_home_addres' => $request->clinc_home_addres,
                        'clinc_serveses' => $request->clinc_serveses,
                        'location' => $request->location,

                        
                    ]
                );

                if (!$data->save()) {
                    $regestersuccess=false;
                    return response()->json(['message' => trans('regester.failed'),compact('regestersuccess')], 444);
        
                };

                $clinicinfo =clinc::where('id_user', '=', $request->id_user)->first();
                $id_clinic = $clinicinfo->id_clinc;















                     /*                store clinic  img   */

   
            
            
















      


        

                          $id_user_v = $request->id_user ;
                          $id_cliciv_v = $clinicinfo->id_clinc;
                          $image_clinic = $request->img_cinic;

        if ($image_clinic > 0) {
            
                                        $fileNewName=time().$image_clinic->getClientOriginalName();
                                        $image_clinic->move(public_path('img/imgclinic/'),$fileNewName);
                                    
                                            clinic_img::create([
                                                'id_user' => $id_user_v,
                                                'id_clinc' => $id_cliciv_v,
                                                'img_src' => $fileNewName,
                                            ]);
        }

                               
                            
   

                           

                        //     if (!@$data_clinic_img->save()) {
                        //         $regestersuccess=false;
                        //         return response()->json(['message' => trans('regester.failed'),compact('regestersuccess')], 444);
                    
                        //     }

                        // }








                     /*                store clinic  img   */




          





                     /*                store  img  user lensesc */



                    



                

                
                     if ($request->user_len_img > 0) {


                    $image_get_3 = $request->user_len_img;
                    foreach ($image_get_3 as $image) {
                        $fileOriginalName = $image->getClientOriginalExtension();
              
                      $fileNewName=time().$image->getClientOriginalName();
                      $image->move(public_path('img/userleneses/'),$fileNewName);
                 
                      user_img_lenesc ::create([
                            'id_user' => $id_user_v,
                            'id_clinc' => $id_cliciv_v,
                            'img_src' => $fileNewName
                        ]);
                    }


                }


 

    

          




        //              /*                store  img user lensesc */



        //              /*                store  img lensesc */






            
        if ($request->clinic_img_len > 0) {


                                $image_get_2 = $request->clinic_img_len;
                                foreach ($image_get_2 as $image) {
                                    $fileOriginalName = $image->getClientOriginalExtension();
                  
                                $fileNewName=time().$image->getClientOriginalName();
                                $image->move(public_path('img/leneses/'),$fileNewName);
                            
                                clinic_img_lenesc ::create([
                                        'id_user' => $id_user_v,
                                        'id_clinc' => $id_cliciv_v,
                                        'img_src' => $fileNewName
                                    ]);
                                }

                            }
    


                        // if (!$data_clinic_img_lenesc->save()) {
                        //     $regestersuccess=false;
                        //     return response()->json(['message' => trans('regester.failed'),compact('regestersuccess')], 444);

                        // }






        //              /*                store  img lensesc */


// $teem_name_1 = json_encode($request->teem_name, true);
// $teem_name_2 = (array)json_decode($teem_name_1, true);
$teem_name =(array)json_decode($request->teem_name, true);


        if ( is_array($teem_name)) {


            // $clinic_type_ = $request->teem_name;
            $clinic_type_ = $teem_name;

            foreach ($clinic_type_ as $key => $value) {

              teem_work_clicic::create([
                'id_user' => $request->id_user,
                'name' => $key,
                'specialty' => $value,
                // 'phone' => $clinic_type_[2],
                'id_clinc' => $id_clinic
            ]);



            }

        }



        // $teem_name_arr = $request->teem_name;
        // foreach ($teem_name_arr as $nmaeteem) {

    
        //     teem_work_clicic ::create([
        //         'id_user' => $request->id_user,
        //         'name' => $nmaeteem,
        //         'specialty' => $request->teem_specialty,
        //         'phone' => $request->teem_phone,
        //         'id_clinc' => $id_clinic,
        //     ]);
        // }
             
            //     $data_teem_work_clicic = teem_work_clicic::create([
            //         'id_user' => $request->id_user,
            //         'name' => $request->teem_name,
            //         'specialty' => $request->teem_specialty,
            //         'phone' => $request->teem_phone,
            //         'id_clinc' => $id_clinic,



           
            //     ]
            // );


            // if (!$data_teem_work_clicic->save()) {
            //     $regestersuccess=false;
            //     return response()->json(['message' => trans('regester.failed'),compact('regestersuccess')], 444);
    
            // }



        // if ($request->teem_name > 0) {


        //     $clinic_type_ = $request->teem_name;
        //     // foreach ($clinic_type_ as $image) {


        
        //       teem_work_clicic ::create([
        //         'id_user' => $request->id_user,
        //         'name' => $clinic_type_[0],
        //         'specialty' => $clinic_type_[1],
        //         'phone' => $clinic_type_[2],
        //         'id_clinc' => $id_clinic,
        //     ]);
        //     }



            $clinc_type = json_decode($request->clinc_type, true);

            if (is_array($clinc_type)) {


                $clinic_type_ = $clinc_type;
                foreach ($clinic_type_ as $image) {


            
                    clinic_type::create([
                        'id_user' => $id_user_v,
                        'id_clinc' => $id_cliciv_v,
                        'clinc_type' => $image
                    ]);
                }

            }




 $specialty_clinic = json_decode($request->specialty_clinic, true);

                if (is_array($specialty_clinic)) {


                    // $clinic_specialty_clinic_ = $request->specialty_clinic;
                     $clinic_specialty_clinic_ = $specialty_clinic;
                    foreach ($clinic_specialty_clinic_ as $image) {
    
    
                
                        clinic_spechl ::create([
                            'id_user' => $id_user_v,
                            'id_clinc' => $id_cliciv_v,
                            'specialty' => $image
                        ]);
                    }
    
                }
 




                if ($request->img_more > 0) {
                     
                    $image_get_8 = $request->img_more;
                    foreach ($image_get_8 as $image) {
                        $fileOriginalName = $image->getClientOriginalExtension();
          
                      $fileNewName=time().$image->getClientOriginalName();
                      $image->move(public_path('img/img_more/'),$fileNewName);
                 
                        img_more::create([
                            'id_user' => $id_user_v,
                            'id_clinc' => $id_cliciv_v,
                            'img_src' => $fileNewName
                        ]);
                    }

        
                           
                        }




            // $data_clinic_type =clinic_type ::create([
            //     'clinc_type' => $request->clinc_type,
            //     'id_user' => $request->id_user,
            //     'id_clinc' => $id_clinic,

            // ]
            // );




            // if (!$data_clinic_type->save()) {
            //     $regestersuccess=false;
            //     return response()->json(['message' => trans('regester.failed'),compact('regestersuccess')], 444);
    
            // }



 
            //     $data_clinic_spechl =clinic_spechl::create([
            //         'specialty' => $request->specialty_clinic,
            //         'id_user' => $request->id_user,
            //         'id_clinc' => $id_clinic,

            //     ]
            //     );
 

            //     if (!$data_clinic_spechl->save()) {
            //         $regestersuccess=false;
            //         return response()->json(['message' => trans('regester.failed'),compact('regestersuccess')], 444);

            //     }




                 
                $data_clinic_spechl_anmals =clinc_specialty_anml::create([
                    'specialty_anmals' => $request->specialty_anmals,
                    'id_user' => $request->id_user,
                    'id_clinc' => $id_clinic,

                ]
                );
 

                if (!$data_clinic_spechl_anmals->save()) {
                    $regestersuccess=false;
                    return response()->json(['message' => trans('regester.failed'),compact('regestersuccess')], 444);

                }




        // SELECT `id_specialty_anmals`, `id_user`, `id_clinc`, `specialty_anmals`, `created_at`, `updated_at` FROM `clinc_specialty_anml` WHERE 1


        $data->save();

 
        // $data_teem_work_clicic->save();
        // $data_clinic_type->save();
        // $data_clinic_spechl->save();
        // $data_clinic_spechl_anmals->save();
        $regestersuccess=true;
        
        return response()->json(['stat' => compact('regestersuccess','id_clinic')], 200);




            }else{
                return response()->json(['message' => trans('api_not_sac_key')], 404);
            }





        }

    

    }


    
}
