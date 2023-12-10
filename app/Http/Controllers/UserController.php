<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\CustomValidation;
use App\Helpers\GeneralHelpers;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\Adress;
use App\Models\Historic;
use Illuminate\Support\Facades\Auth;
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
            return response()->json([ $user,], 200);
        } catch (Throwable $th) {
            return response()->json([
                'messageError' => "Bad Request",
                'statusCode' => 400,
                'timestamp' => date("Y-m-d h:i:sa")
            ], 400);
        }
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = Auth::attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }
    public function guard()
    {
        return Auth::guard('web');
    }

    public function deposit(Request $request)
    {
        try{
            $data = $request->all();
            $number = random_int(1000,9999);
            $code_deposit = "DEP".$number;
            $user = User::where('cpf', $data['cpf'])->get();
            //$acc = Account::with('historics')->where('user_cpf', $data['cpf'])->first();
            $acc = Account::where('user_cpf',$data['cpf'])->first();

            if(!CustomValidation::validateBalance($data['value']))
            {
                return response()->json([
                    'messageError' => "Bad Request",
                    'statusCode' => 400,
                    'message'=> "invalid field",
                    'timestamp' => date("Y-m-d h:i:sa")
                ], 400);
            }

            if($acc){
                $result = Account::where('user_cpf', $data['cpf'])
                ->increment('balance', $data['value']);

                $acc->balance+=$data['value'];
                $historics = Historic::create([
                    'value' => $data['value'],
                    'operation' => $code_deposit,
                    'id_account' =>$acc->id,
                ]);

                if ($result == 0) {
                    return response()->json([
                        'messageError' => "Bad Request",
                        'statusCode' => 400,
                        'timestamp' => date("Y-m-d h:i:sa")
                    ], 400);
                }
                return response()->json(["Account"=>$acc,"Deposit"=>$historics],200);
            }

            if ($user->isNotEmpty()) {
                $account = Account::create([
                    'user_cpf' => $data['cpf'],
                    'balance' => $data['value'],
                ]);

                $historics = Historic::create([
                    'value' => $data['value'],
                    'operation' => $code_deposit,
                    'id_account' => $account->id,
                ]);

                return response()->json(["Account"=>$account,"Deposit"=>$historics],200);
            }

            return response()->json([
                'messageError' => "Not Found",
                'statusCode' => 404,
                'timestamp' => date("Y-m-d h:i:sa")
            ], 404);

        }catch (Throwable $th){
            return response()->json(['error' => "Internal error"], 500);
        }

    }

}
