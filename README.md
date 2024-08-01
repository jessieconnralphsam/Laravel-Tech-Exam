# Laravel-Tech-Exam
Simulates building a backend API for a simple blog application using Laravel. It will assess your understanding of Laravel fundamentals, user authentication with your choice, and building RESTful APIs.
## Documentation
For documentation, visit the following link:
[Documentation](https://drive.google.com/file/d/1NzTjlEDGGGqcVHTtYK-sE4n1dNDeRXhv/view?usp=sharing)
## Setup Database
1. Create database in mysql name: technical_exam
2. Run: php artisan migrate
## User Management

Register Endpoint: POST
http://127.0.0.1:8000/api/register

Body:
{
    "name": "Jessiesam",
    "email": "Jessie@example.com",
    "password": "12345678"
}

Scripts Pre-request:

pm.sendRequest({
    url:"http://127.0.0.1:8000/sanctum/csrf-cookie",
    method: "GET"
},function (error, response, {cookies}){
    if(!error){
        pm.collectionVariables.set('xsrf-cookie', cookies.get('XSRF-TOKEN'))
    }
})
***
Login Endpoint: POST
http://127.0.0.1:8000/api/login

Body:
{
    "email": "jessie@example.com",
    "password": "12345678"
}

Scripts Pre-request:

pm.sendRequest({
    url:"http://127.0.0.1:8000/sanctum/csrf-cookie",
    method: "GET"
},function (error, response, {cookies}){
    if(!error){
        pm.collectionVariables.set('xsrf-cookie', cookies.get('XSRF-TOKEN'))
    }
})

***
Login Endpoint: POST
http://127.0.0.1:8000/api/logout

Header:

Authorization: Bearer {token}

Sample [Bearer token is created when login]:
Authorization: Bearer QwWXP9v60dzpnSlOuth7cOoODUGKUas4mBzkZF5G04590b49

