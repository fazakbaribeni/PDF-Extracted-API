# PDF-Extracted-API
This API - sends the input to AWS's Textract API (https://aws.amazon.com/textract) 


Steps to Follow

1- Add .env file along with details for below: 

AWS_ACCESS_KEY_ID=

AWS_SECRET_ACCESS_KEY=

AWS_DEFAULT_REGION=


DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=api_pdf

DB_USERNAME=root

DB_PASSWORD=

2- Run "php artisan migrate" 

3- Run "php artisan serve"

4- load postman application and add the following 

-Post Request with:

1- form-data

2- body 

2.1 - key = "pdf"=> upload-any-pdf files on your machine
