Book Management Apis
===========

Apis for managing books.

Built With
-------------------

Php

Lumen

Mysql

Phpunit

Coding Standards
----------------

Psr-2 for coding guidelines.

psr-4 for auto loading.

Getting Started
---------------
These instructions will get you a copy of the project up and running on your local machine.


Prerequisites
-------------

Php 7.x

Mysql 5.x

Composer

Installing
----------

Follow these steps to setup the project localy

1) Clone or download this repo in your local machines.
2) Go to project root directory and run composer install from command line.
3) Create .env file on root directory and setup database credentials and configure other environmental settings in this file, an example file is present in the repository.
4) Run all migrations by running 'php artisan migrate' from command line, this step will set up the database schema automatically.
5) Do appropriate web server configuration for landing the request to public/index.php.

After these steps project will be up and running.

Usage
-----

Following apis are enclosed in this project

1. http(s)://yourdomain.com/api/external-books

    Description : Retrieves a list of books from an external api

    Method      : GET
    
    Parameters  
    
         name(String|Optional) : Name of the book to retrieve or it can be skipped for retrieving all the books.
         
    Response 
    
            [
                "status_code": 200,
                "status": "success",
                "data": [
                    {
                        "name": "A Game of Thrones",
                        "isbn": "978-0553103540",
                        "authors": [
                            "George R. R. Martin"
                        ],
                        "number_of_pages": 694,
                        "publisher": "Bantam Books",
                        "country": "United States",
                        "release_date": "1996-08-01",
                    },
                    {
                        "name": "A Clash of Kings",
                        "isbn": "978-0553108033",
                        "authors": [
                            "George R. R. Martin"
                        ],
                        "number_of_pages": 768,
                        "publisher": "Bantam Books",
                        "country": "United States",
                        "release_date": "1999-02-02",
                    }
                ]
            ]

        
2. http(s)://yourdomain.com//api/v1/books

    Description : Creates a new book in the system

    Method      : POST
    
    Parameters  
    
         name(String|Required)              : Name of the book
         
         isbn(String|Required)              : Isbn for the book
         
         authors(Array|Required)            : Authors for the book
         
         country(string|Required)           : Coutry for the book
         
         number_of_pages(Integer|Required)  : No of pages in the book
         
         publisher(String|Required)         : Publisher for the book
         
         release_date(String|Required)      : Publisher for the book
         
    Response
    
        [
            "status_code": 201,
            "status": "success",
            "data": [
                "book": {
                    "name": "My First Book",
                    "isbn": "123-3213243567",
                    "authors": [
                        "John Doe"
                    ],
                    "number_of_pages": 350,
                    "publisher": "Acme Books",
                    "country": "United States",
                    "release_date": "2019-08-01",
                },
            ]
        ]
        
3. http(s)://yourdomain.com//api/v1/books

    Description : Retrieve a list of book from local system.

    Method      : GET
    
    Parameters  
    
         name(String|Optional)              : Name of the book
         
         country(string|Optional)           : Coutry for the book
         
         publisher(String|Optional)         : Publisher for the book
         
         release_date(String|Optional)      : Publisher for the book
         
    Response
    
        [
            "status_code": 200,
            "status": "success",
            "data": [
                {
                    "id": 1,
                    "name": "A Game of Thrones",
                    "isbn": "978-0553103540",
                    "authors": [
                        "George R. R. Martin"
                    ],
                    "number_of_pages": 694,
                    "publisher": "Bantam Books",
                    "country": "United States",
                    "release_date": "1996-08-01",
                },
                {
                    "id": 2,
                    "name": "A Clash of Kings",
                    "isbn": "978-0553108033",
                    "author": [
                        "George R. R. Martin"
                    ],
                    "number_of_pages": 768,
                    "publisher": "Bantam Books",
                    "country": "United States",
                    "release_date": "1999-02-02",
                }
            ]
        ]

        
4. http(s)://yourdomain.com//api/v1/books/:id

    Description : Update a book identified by id in the url.

    Method      : PATCH
    
    Parameters  
    
          name(String|Required)              : Name of the book
                  
          isbn(String|Required)              : Isbn for the book
                  
          authors(Array|Required)            : Authors for the book
                  
          country(string|Required)           : Coutry for the book
                  
          number_of_pages(Integer|Required)  : No of pages in the book
                  
          publisher(String|Required)         : Publisher for the book
                  
          release_date(String|Required)      : Publisher for the book
         
    Response
    
        [
            "status_code": 200,
            "status": "success",
            "message": "The book My First Book was updated successfully",
            "data": {
                "id": 1,
                "name": "My First Updated Book",
                "isbn": "123-3213243567",
                "authors": [
                    "John Doe"
                ],
                "number_of_pages": 350,
                "publisher": "Acme Books Publishing",
                "country": "United States",
                "release_date": "2019-01-01",
            }
        ]



        
4. http(s)://yourdomain.com//api/v1/books/:id

    Description : Delete a book identified by id in the url.

    Method      : Delete
    
    Parameters  
         
    Response
    
        [
            "status_code": 200,
            "status": "success",
            "message": "The book My First Book was updated successfully",
            "data": {
                "id": 1,
                "name": "My First Updated Book",
                "isbn": "123-3213243567",
                "authors": [
                    "John Doe"
                ],
                "number_of_pages": 350,
                "publisher": "Acme Books Publishing",
                "country": "United States",
                "release_date": "2019-01-01",
            }
        ]


        
4. http(s)://yourdomain.com//api/v1/books/:id

    Description : Retrieves a specific book from local system.

    Method      : GET
    
    Parameters  
         
    Response
    
        [
            "status_code": 200,
            "status": "success",
            "data": {
                "id": 1,
                "name": "My First Book",
                "isbn": "123-3213243567",
                "authors": [
                    "John Doe"
                ],
                "number_of_pages": 350,
                "publisher": "Acme Books Publishing",
                "country": "United States",
                "release_date": "2019-01-01",
            }
        ]




Running the tests
-----------------

All the test cases reside in the tests directory on the root. For running all the test 
go to the project directory and run './vendor/bin/phpunit tests/' from command line.

                                    
                                    
                                    
