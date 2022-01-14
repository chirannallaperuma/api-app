##Setup Instructions


Install dependencies
```
composer instal
``` 

Copy .env file  for configurations

```
cp .env.example .env
```

Generate app key
```
php artisan key:generate
```

Database migration
```
php artisan migrate
```

Generate API documentation

```
php artisan l5-swagger: generate
```
Run the local test server

```
php artisan serve
```

API access

- `localhost:8000/api/register` - Student Register.
- `localhost:8000/api/login` - Student Login.
- `localhost:8000/api/students` - Student List.
- `localhost:8000/api/courses` - Course List.
- `localhost:8000/api/courses/enroll` - Course Enroll.
- `localhost:8000/api/student-courses` - Student enrolled course list.


Access API documentation

```
http://localhost:8000/api/documentation
```
