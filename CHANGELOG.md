# Changelog

All notable changes to `shipsfocus-mtech-lib` will be documented in this file

## 1.1.0

- Add Resource extends from JsonResource.
- Add Router, to use the additional router functions, bind to router singleton:
    ```php
    # bootstrap/app.php
    $app->singleton('router', \MtLib\Router::class);
    ```
- Add various models shared in many projects (Model, QueryBuilder, Macros)
- Add common base controller used in various projects
- Add common file upload controllers
- Add batch update controllers
- Add Blueprint Macros

## 1.0.0

- Add the 4 filters: ExcludeFilter, NumberFilter, RelationalNumberFilter, UserNameFilter.