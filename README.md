## Online Books Library

Laravel books library application

## About

Online books library is an application for books/users/owes management.
This is my first laravel project, built on Laravel Framework 6.5. It's made for learning purposes only. 
It is still an unfinished project, but maybe someone can still find some use of it.

## Usage

Application has 3 levels of users: admin, moderator, user.
Admin can manage the books and create other users, which by default has an moderator role (library worker).
Moderator can manage the books and create users with the role of user (library member).
User can only see his/her currently rented books.
    
When adding the book to the library, if book ISBN is provided, it will try to find book title, author & description using google books api:
https://developers.google.com/books/docs/v1/getting_started
Same API is used as well to fetch books cover images.

When new user is created a randomly generated password is send to his/her email address.
