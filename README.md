# Test-Work-462

### Local installation

```bash
1) cp .env.example .env
2) go to .env & change DB_DATABASE 
3) set DB_USERNAME
4) set DB_PASSWORD
5) php artisan config:clear
6) php artisan route:cache
7) composer install
8) php artisan migrate 
9) php artisan db:seed
10) chmod -R 777 storage
11) php artisan serve
```

#### Available routes & methods

```bash
http://localhost/api/register  POST create new user
http://localhost/api/login POST login new user login and getting a new token to visit other pages
http://localhost/api/me POST dysplay current user
http://localhost/api/posts  GET  show posts with pagination filters, search and sorting are also available
http://localhost/api/posts  POST create new Post
http://localhost/api/posts/{post} GET show specific post
http://localhost/api/posts/{post} PUT update Post
http://localhost/api/posts/{post} DELETE delete Post
```





