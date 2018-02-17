# Voucher Pool
A voucher pool micro-service based in PHP

## Live Demo
A live demo of the application can be found [here](http://ec2-18-217-163-134.us-east-2.compute.amazonaws.com/voucher_pool/vouchers/show).

It's hosted in an EC2 instance using a temporary DNS provided by AWS, so if the server restarts, a new address is asigned. In that case, please contact me so I can update the address.

## Test script
Most of the app's functionality can be tested via the browser. I suggest using Chrome v. 64 or newer (or any other browser with full ES6 support).

To test the API features, please import the [Postman collection](tests/voucher_pool.postman_collection.json) included in the `/tests` folder and follow this steps:

1. Send the `Seed database` request (`GET` request that will clear the database and repopulate it with random data)
2. Send the `Generate vouchers` request (`POST` request to generate a voucher for each recipient)
3. Send the `Validate voucher` request (`PATCH` request to validate a voucher and mark it as used)
4. Send the `Validate voucher` request a second time (now, since the voucher was already used, the response will be an error)
5. Send the `Search vouchers` request (`GET` request that will search for every valid voucher for the given email)

For other tests and checking the results of experiments with the UI, I've included in the Postman collection a folder called `Routes` with requests and tests for all the Entities.

The other subfolders in `tests` are for unity testing with PHPUnit. TO run them, go to the project folder and run these two commands:

```
$ phpab -o autoload.php .
$ phpunit --bootstrap autoload.php tests
```

These should test the database abstraction layer and the models. The controllers and the routes must be tested via the Postman collection.

## Dependencies

### Front-end
* jQuery 3.1.1
* jQuery UI 1.12.1
* Bootstrap 4.0.0
* DataTables 1.10.16
* DataTables Bootstrap 3 integration

### Back-end
* phpab 1.24.1
* PHPUnit 6.5.6
* fzaninotto/faker

## Environment
Amazon Linux AMI 2017.09

Apache 2.4.27

PHP 7.1.13

MySQL Ver 14.14 Distrib 5.7.20
