

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://th.bing.com/th/id/OIP.gV9AeJImpGRTlDs_560erwHaEg?w=287&h=180&c=7&r=0&o=5&pid=1.7" alt="Rest"></a>

## Teste Prático para Estagiário UltraLinks

Este é o teste prático de estágio da Ultralinks, onde foi solicitado a criação de uma API REST utilizando PHP/Laravel, com o banco de dados sendo executado em um contêiner Docker. Neste README, será demonstrado como iniciar o projeto Laravel em sua máquina. Além disso, serão fornecidos comentários sobre os endpoints desenvolvidos.
##
Para implementar o endpoint de cadastro de usuários, criei duas tabelas no banco de dados para armazenar as informações necessárias. Os campos requeridos no cadastro são:

a. Nome Completo;

b. Data de Nascimento;

c. CPF;

d. Email;

e. Senha (Criptografada no Banco);

f. Endereço de Cobrança;
i. CEP;
ii. Complemento;
iii. Número de Endereço.

Os usuários são obrigados a fornecer o CEP e o número de endereço durante o cadastro. Utilizando o CEP fornecido, preencho automaticamente a tabela de endereços. 

```
Metodo POST:
http://localhost:8000/user
{

    "name":"pedro",
    "email":"pedro@gmail.com",
    "cpf":"55874123",
    "date_birth":"2023-08-12",
    "password":"23132",
    "cep":"18570-970",
    "number_adress":157
}

Se todos os campos forem preenchidos corretamente, a resposta será a seguinte:
{
    "name": "pedro",
    "email": "pedro@gmail.com",
    "cpf": "55874123",
    "date_birth": "2023-08-12",
    "updated_at": "2023-12-10T20:54:58.000000Z",
    "created_at": "2023-12-10T20:54:58.000000Z",
    "id": 3
}
Se algum campo estiver inválido ou não preenchido, a resposta será um JSON contendo a
informação adequada do erro, por exemplo:

{
    "messageError": "Bad Request",
    "statusCode": 400,
    "timestamp": "2023-12-10 05:57:49pm"
}
```
Para concluir, a imagem das duas tabelas utilizadas neste primeiro endpoint.
![image](https://github.com/ThalesJ2/Ultralinks-Thales/assets/95149974/00428d2f-2539-40de-9d91-5a5f6130df60)

O segundo endpoint implementado é destinado à autenticação de usuários, exigindo os campos obrigatórios de email e senha para a validação. No processo de autenticação, utilizei a tecnologia JWT para a geração de tokens.

```
Metodo POST:
http://localhost:8000/auth

{
    "email":"pedro@gmail.com",
    "password":"23132"
}

Os dados serão verificados no banco de dados, e se estiverem corretos, retorna um token.

{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXV0aCIsI
mlhdCI6MTcwMjI0MzQzNSwiZXhwIjoxNzAyMjQ3MDM1LCJuYmYiOjE3MDIyNDM0MzUsImp0aSI6IjdISWtUT0JleTBTeEdhaUsiLCJzdWIiOiIzIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.ZuTaKi2eHU1WV_HFWWhep6X5ptMfaCkHi1MwuEy9EiE",
    "token_type": "bearer",
    "expires_in": 3600
}

Se o usuário não estiver cadastrado ou se houver algum campo inválido,retornará a seguinte resposta:

{
    "messageError": "Not Found",
    "statusCode": 404,
    "timestamp": "2023-12-10 09:27:23pm"
}
```

O terceiro endpoint é responsável por realizar depósitos de dinheiro em uma conta e gerar um código para identificar a transação. Para implementar esse endpoint, foram necessárias duas tabelas no banco de dados: account, que armazena o saldo total do usuário, e historic, que registra as operações realizadas pelo usuário, incluindo o valor depositado.

É importante destacar que o usuário só poderá efetuar um depósito se estiver  cadastrado e autenticado.

```
Metodo POST:
http://localhost:8000/user/deposit

Se o CPF fornecido for válido, pertencer ao usuário logado,
e o valor depositado for positivo e válido,
retornará a seguinte resposta.

{
    "Account": {
        "user_cpf": "55874123",
        "balance": 600,
        "updated_at": "2023-12-10T21:48:25.000000Z",
        "created_at": "2023-12-10T21:48:25.000000Z",
        "id": 3
    },
    "Deposit": {
        "value": 600,
        "operation": "DEP1287",
        "id_account": 3,
        "id": 6
    }
}

Caso o usuario informe um valor negativo, retornará a seguinte resposta.
{
    "messageError": "Bad Request",
    "statusCode": 400,
    "message": "invalid field",
    "timestamp": "2023-12-10 09:51:02pm"
}
```
Para concluir, a imagem das duas tabelas utilizadas neste terceiro endpoint.
![image](https://github.com/ThalesJ2/Ultralinks-Thales/assets/95149974/2b331d07-d359-44ec-8d13-fad431d138f2)


