

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
Para concluir, apresento abaixo a imagem das duas tabelas utilizadas neste primeiro endpoint.
![image](https://github.com/ThalesJ2/Ultralinks-Thales/assets/95149974/00428d2f-2539-40de-9d91-5a5f6130df60)

