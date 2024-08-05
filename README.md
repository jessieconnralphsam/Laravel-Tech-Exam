# Laravel-Tech-Exam
Simulates building a backend API for a simple blog application using Laravel. It will assess your understanding of Laravel fundamentals, user authentication with your choice, and building RESTful APIs.
## Documentation

Exam Link: [Technical Exam](https://docs.google.com/document/d/1IT-XqPKL_KZgJN2xiOAJnKn_43I8h3Rj/edit?usp=drive_link&ouid=106242351847779701342&rtpof=true&sd=true)
<br>
For documentation, visit the following link:
[Documentation](https://drive.google.com/file/d/1NzTjlEDGGGqcVHTtYK-sE4n1dNDeRXhv/view?usp=sharing)
***
Swaggger controller documentation:
http://127.0.0.1:8000/api/documentation

## Setup Database
1. Create database in mysql name: technical_exam
2. Run: php artisan migrate
## User Management

Register Endpoint: POST
http://127.0.0.1:8000/api/register

Body:
{
    "name": "jessie conn sam",
    "email": "jessie.official@gmail.com",
    "password": "Gv7#pR9&zLw!xQ2@fT4$kY1",
    "password_confirmation": "Gv7#pR9&zLw!xQ2@fT4$kY1"
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

***
update email & password Endpoint: PUT
http://127.0.0.1:8000/api/user/update

Header:

Authorization: Bearer {token}

Sample [Bearer token is created when login]:
Authorization: Bearer QwWXP9v60dzpnSlOuth7cOoODUGKUas4mBzkZF5G04590b49

body:

{
    "email": "newemail@example.com",
    "password": "12345689"
}

## Blog Post CRUD

create Blog endpoint:POST
http://127.0.0.1:8000/api/blogs

Header:

Authorization: Bearer {token}
Content-Type: application/json

body: 

{
    "title": "My 4th Blog Post",
    "content": "This is the content of my 4th blog post."
}

***
show blog of authenticated user endppoint:GET
http://127.0.0.1:8000/api/blogs

Header:
body: none

Authorization: Bearer {token}

***

update Blog endpoint:PUT
http://127.0.0.1:8000/api/blogs/{blog id}

Header:

Authorization: Bearer {token}
Content-Type: application/json

body: 

{
    "title": "My updated Blog Post",
    "content": "This is the content of my updated blog post."
}

***

update Blog endpoint:DELETE
http://127.0.0.1:8000/api/blogs/{blog id}

Header:

Authorization: Bearer {token}
Content-Type: application/json

body: 
none

***
## Implement a mechanism to send email notifications whenever a new blog post is created.
- Everytime a new blog is created it will send email to my mail trap that is configure in .env file <br>

Sample:
![Alt text](public/email.png)

***

## Store audit logs in the database, capturing details like the user who made the change, timestamp, and type of operation (create, update, delete).

- Base on the ERD I make trigger in the database (in the migration file [2024_08_02_021815_create_blog_post_trigger.php] ) that everytime action performed in the blog_post it will log on the audit table.

![Alt text](public/trigger.png)