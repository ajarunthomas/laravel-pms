### Laravel Setup (Basic)
- `install required packages` composer install
- `Prepare .env file` copy from .env.example to use for .env and include the mysql database details
- `Generate Key` - php artisan key:generate

### Database Migration

php artisan migrate
php artisan db:seed

### Product Management System API endpoints

- `GET` /api/token *[Get User Token]*
- `GET` /api/products *[Product Listing]*
- `GET` /api/products-by-category/{category-id} *[Products by Category]*
- `GET` /api/products/{product-id} *[Get Single Product]*
- `POST` /api/products *[Create Product]*
- `PUT` /api/products/{product-id} *[Update Product Details]*
- `DELETE` /api/products/{product-id} *[Delete a Product]*

### Order Management API endpoints

- `POST` /api/orders *[Place an order]*
- `GET` /api/orders *[Get List of order placed by a user]*
- `GET` /api/orders/{order-id} *[Single Order Details]*

```
Note: Basic Stock Quantity validation and Updation handled on order submission
```

### Input Sanitizing

Implemented in Middleware `XssSanitization`

### Authentication

- Authentication Implemented using Sanctum
- CSRF Token implemented for Web Post Routes
- Included UI for Registration and Login
- Product Management Available for Admin Users
- Basic rate Limiting Included

```
Postman Collection Included in this repository
```

