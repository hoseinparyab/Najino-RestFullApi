# Najino RESTful API

<div align="center">
  <img src="https://via.placeholder.com/800x200?text=Najino+RESTful+API" alt="Najino API">
  
  <p align="center">
    <img src="https://img.shields.io/badge/Status-Development-yellow" alt="Status: Development">
    <img src="https://img.shields.io/badge/Access-Private-red" alt="Access: Private">
  </p>
</div>

## Project Overview

**Notice:** This is a private project owned by Najino Company. The source code is exclusively available to the authorized development team.

Najino is a secure and advanced RESTful API service built on the Laravel framework, developed as a dedicated backend for Najino's systems. The project follows modern MVC architecture and implements current software development standards.

## Key Features

- Authentication using Laravel Sanctum
- User and role management
- FAQ system
- Content and blog management
- Portfolio management
- Secure and modern API interfaces
- Comprehensive API documentation
- Automated testing

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher / MariaDB 10.3 or higher
- Node.js 16.x or higher
- NPM or Yarn

## Installation and Setup

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd Najino-RestFullApi
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Configure database**
   Open the `.env` file and set up your database connection:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=najino
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Install frontend dependencies**
   ```bash
   npm install
   npm run build
   ```

8. **Set up storage link**
   ```bash
   php artisan storage:link
   ```

## Creating an Admin User

To create a new admin user, use the following command:

```bash
php artisan make:admin --name="Admin Name" --email="admin@example.com" --password="secure_password"
```

Or run interactively:

```bash
php artisan make:admin
```

## Development Server

To run the project in development mode:

```bash
# Start the development server
php artisan serve

# Run Vite for asset compilation
npm run dev
```

## Running Tests

To execute the test suite:

```bash
php artisan test
```

## Project Structure

- `app/Http/Controllers` - Application controllers
- `app/Models` - Database models
- `app/Http/Requests` - Validation classes
- `app/Http/Resources` - API resources
- `app/Services` - Business logic services
- `database/migrations` - Database migrations
- `database/seeders` - Seed data
- `routes` - Route definitions

## Ownership and Rights

All intellectual property rights for this software are owned by Najino Company. This is proprietary software and is not released under any public license.

## Access Policy

- This project is developed exclusively for Najino Company.
- Any use, copying, or distribution of the source code without written permission from Najino Company is strictly prohibited.
- Access to the code repository is restricted to authorized development team members only.

## Contact Information

- Email: [info@najino.ir](mailto:info@najino.ir)
- Website: [https://najino.ir](https://najino.ir)
- Phone: +98-21-88000000

## Development Team

This project is developed and maintained by Najino Company's software development team.

## Acknowledgments

Special thanks to all members of Najino's IT and development team who have contributed to this project.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
