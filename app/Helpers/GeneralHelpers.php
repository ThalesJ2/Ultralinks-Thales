<?php

namespace App\Helpers;


class GeneralHelpers{


    public static function integrationApi($cepAux){
        $url = "https://viacep.com.br/ws/{$cepAux}/json/";
        $options = [
            'http' => [
                'header' => 'Authorization: token ',
                'method' => 'GET',
            ],
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $dados = json_decode($response,true);

        return $dados;
    }

    public static function createAddress($address,$dateAddress,$id_user,$number_address){
        foreach ($address->getFillable() as $campo) {
            if (array_key_exists($campo, $dateAddress)) {
                $address->$campo = $dateAddress[$campo];
            }
            if($campo == 'user_id')
                $address->$campo = $id_user;
            if($campo == 'numero_endereco')
                $address->$campo = $number_address;
        }

    }

    public static function formatObj($account,$deposit){
        $formattedAccount = [
            'id' => $account->id,
            'user_cpf' => $account->user_cpf,
            'balance' => $account->balance,
            'created_at' => $account->created_at,
            'updated_at' => $account->updated_at,
        ];

        $formattedDeposit = [
            'value' => $deposit->value,
            'operation' => $deposit->operation,
            'id_account' => $deposit->id_account,
            'id' => $deposit->id,
        ];
        $formattedAccount['deposit'] = $formattedDeposit;
        return $formattedAccount;
    }
}
