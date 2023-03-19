- 環境作成からライブラリを試すためのAPI及びテストコード実装を、ChatGPTを利用して作ってみた    
  - https://stlwolf.notion.site/PHP-JSON-Schema-Libraries-ca1be2822dc84735a2c7e5a2e89b8144

# Laravel REST API with OpenAPI Validation

This project demonstrates how to set up a Laravel REST API with OpenAPI validation using the `lezhnev74/openapi-psr7-validator` library. It includes a Docker-based development environment, a simple REST API, an OpenAPI specification file, and test code to validate the API responses against the OpenAPI specification.

## Requirements

- Docker
- Docker Compose
- Make

## Getting Started

1. Clone the repository and navigate to the project directory.

2. Build the Docker containers:
```shell
make setup
```

3. Start the Docker containers:
```shell
make run
```

4. Install the required PHP libraries:
```shell
make composer
```

5. Run the Laravel migrations to set up the database:
```shell
make migrate
```

6. Start the Laravel development server:
```shell
make serve
```

The API should now be accessible at `http://localhost:8000`.

## Running Tests

To run the test suite, execute the following command:
```shell
make test
```


This will run the test code located in the `tests/Feature/PostApiTest.php` file, which validates the API responses against the OpenAPI specification (`openapi.yml`).

## API Endpoints

The project includes the following API endpoints:

- `POST /api/posts`: Create a new post
- `PUT /api/posts/{id}`: Update an existing post
- `DELETE /api/posts/{id}`: Delete a post

Refer to the `openapi.yml` file for more information about the request and response formats.

## Troubleshooting

If you encounter any issues or errors, make sure to check the Docker logs and Laravel logs for more information:

- Docker logs: `docker-compose logs`
- Laravel logs: `docker-compose exec -w /var/www/html/app app cat storage/logs/laravel.log`

