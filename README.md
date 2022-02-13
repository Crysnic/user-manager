# User Manager API

Run application

```
cd docker

docker-compose up
```

### Base on
```
https://gitlab.com/martinpham/symfony-5-docker
```


## Commands
Get all user:
```
$ curl http://localhost/api/users
```
Create user:
```
$ curl -X POST -d '{"email":"test@example.com","password":"1234_5678aA","repeatPassword":"1234_5678aA","username":"Ivan Dog"}' http://localhost/api/users
```
Update username:
```
$ curl -X PATCH -d '{"username":"Dog Ivan III"}' http://localhost/api/users/1
```
Update password:
```
$ curl -X PATCH -d '{"password":"12345678aA*","repeatPassword":"12345678aA*"}' http://localhost/api/users/1
```
Search users by part of username:
```
$ curl http://localhost/api/users/parameter/username/value/dog
```
Search users by email:
```
$ curl http://localhost/api/users/parameter/email/value/test@example.com
```