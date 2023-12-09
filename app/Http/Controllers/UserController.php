<?php

namespace App\Http\Controllers;

use App\Helpers\CustomValidation;
use App\Helpers\GeneralHelpers;
use App\Http\Resources\UserResource;
use App\Models\Adress;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;

class UserController extends Controller
{

    public function index(){
        $users = User::all();
        return UserResource::collection($users);
    }

    public function create(Request $request){
        try {
            date_default_timezone_set('America/Sao_Paulo');
            $data = $request->all();
            $cep = $data['cep'];
            $number_address = $data['number_adress'];
            $data['password'] = bcrypt($request->password);

            $cepAux = str_replace("-","",$cep);
            if(!CustomValidation::validateCep($cepAux) || !CustomValidation::validateNumber($number_address) || !CustomValidation::validateEmail($data))
            {
                return response()->json([
                    'messageError' => "Bad Request",
                    'statusCode' => 400,
                    'message'=> "invalid field",
                    'timestamp' => date("Y-m-d h:i:sa")
                ], 400);
            }
            $user = User::create($data);
            $id_user = $user['id'];

            $address = new Adress();
            $dateAddress = GeneralHelpers::integrationApi($cepAux);
            GeneralHelpers::createAddress($address,$dateAddress,$id_user,$number_address);

            $address->save();
            return response()->json([
                $user,
            ], 200);

        } catch (Throwable $th) {
            echo $th;
            return response()->json([

                'messageError' => "Bad Request",
                'statusCode' => 400,
                'timestamp' => date("Y-m-d h:i:sa")
            ], 400);
        }
    }
}
