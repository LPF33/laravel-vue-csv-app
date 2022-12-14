# About project:

 - Tabular representation of data from CSV file 
 - Edit and add data 
 - Visualize data with a Pie-Chart
 - Upload & Download CSV file.

## Tech Stack

- TypeScript / [Vue.js 3](https://vuejs.org/)
- PHP / [Laravel 9](https://laravel.com/)
- [Vite](https://laravel.com/docs/9.x/vite)
- 3rd Party Libraries: [Chart.js](https://vue-chartjs.org/), [Fontawesome](https://fontawesome.com/icons)

## Run project local

1. Run it with Docker:
   - git clone git@github.com:LPF33/laravel-vue-csv-app.git
   - Docker build & run

2. Or following components must be installed locally:

   - [nodejs](https://nodejs.org/en/) v16
   - [PHP](https://dotnet.microsoft.com/download) v8
   - [Composer](https://getcomposer.org/) v2.3.10

```console
$ git clone git@github.com:LPF33/laravel-vue-csv-app.git
$ cd laravel-vue-csv-app
$ npm install
$ composer install
$ composer run-script post-root-package-install & composer run-script post-create-project-cmd
$ npm run build
$ php artisan serve
```

## Development

```console
$ php artisan serve
$ npm run dev
```

## Linter

- Backend [Laravel Pint](https://laravel.com/docs/9.x/pint)
- Frontend [Eslint](https://eslint.org/)
  
```console
$ composer run-script lint 
$ npm run lint
```

## Deployment

- Procfile for Apache Server (web: vendor/bin/heroku-php-apache2 public/)
- In .env for Laravel/Vite [Custom Base URLs](https://laravel.com/docs/9.x/vite#custom-base-urls): ASSET_URL=https://example.com
- Application [Key](https://laravel.com/docs/7.x/installation) for Laravel in .env 

## How to install Vue 3 in Laravel 9 with Vite

1. Install Laravel 9
2. Install npm Dependencies
3. Install Vue 3 (in folder **resources/js** lives your Vue App)
   ```console
   npm install vue@next vue-loader@next
    ```
4. Install Vite Plugin and set vite.config.js
    ```console
    @vitejs/plugin-vue
    ```
5. Connect Laravel blade file and use vite directive to add assets
6. Start development servers

https://laravel.com/docs/9.x/vite

https://vitejs.dev/config/

## Laravel Routes
  - Web: In folder **routes/web.php**
    - "/" (GET)
    - "/csv/read" (GET)
    - "/csv/write" (POST)
    - "/csv/add" (POST)
    - "/csv/upload" (POST)
    - "/csv/export" (GET)