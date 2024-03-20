## Set up

This is a sample Law firm crm, that can be used to profile and client cases:

- First step is to clone the repository, on the selected path on your local system.
```
git clone https://github.com/izunnamiles/law_crm.git
```
- Proceed to the the cloned repo root directory and create a .env file used for setting up you environment variables.

```
cp .env.example .env
```

- Once that's done, then you can run composer install, this installs the dependencies needed for the application to function

```
composer install
```
- Run the command below to generate the application key

```
php artisan key:gen
```

- We are now almost there, so we need to update the .env file with our databse configuration

```
DB_DATABASE=database name
DB_USERNAME=database username
DB_PASSWORD=database password (optional: only when your database username has a password)
```

- We can now proceed to add the necessary tables by running migrations (We added a seeder for primary counsels), so we can start working with the app

```
php artisan migrate --seed
```

- We can now serve our application to have access to the UI of the app, we copy the link from the below command and paste on our browser, 

```
php artisan serve
```
- For Testing
  
```
php artisan test --filter AppTest 
```

Thanks :sunglasses:
