## ToDo

# Top priority
Required packages:
+	nunomaduro/larastan
	nunomaduro/phpinsights
+	barryvdh/laravel-ide-helper
+	tymondesigns/jwt-auth (depends on "lcobucci/jwt")
+	darkaonline/l5-swagger
+	propaganistas/laravel-phone
+	spatie/laravel-sluggable
+	laravel-lang/common
-	flugg/laravel-responder

+ Modeling (Migrations, Seeds, Indexes)
+ Controllers
+ Resources
+ Requests
+ Trait (limit, sortBy, desc=bool)
Make common response for unifications

# Low priority
+ Middleware only admins
+ Token Middleware
+ JWT implementation
OpenApi
Tests
Docker Container


ssh-keygen -t rsa -b 4096 -m PEM -f storage/app/jwt-keys/jwtRS256.key
ssh-keygen -f storage/app/jwt-keys/jwtRS256.key -e -m PKCS8 > storage/app/jwt-keys/jwtRS256.key.pub