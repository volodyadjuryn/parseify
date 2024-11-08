# Parseify
Parseify is a web scraping tool designed to extract product listings from e-commerce websites. Currently, it supports product categories on solmar.com.ua.

## Setup
To get started, clone the repository and run docker:
```shell
git clone https://github.com/volodyadjuryn/parseify.git
docker-compose up -d
```

## Features
* Product List Endpoint: Provides an API endpoint to retrieve a list of parsed products.
* Import Command: Imports products from a specified URL via command line.


## Endpoints
Product List Endpoint:
* Retrieve a list of parsed products by accessing the /products endpoint.

## Usage
Import Products Command
To import products from a specified category URL, use the following command:
```
docker-compose exec php bin/console app:import <url>
```

Example:
```shell
docker-compose exec php bin/console app:import https://solmar.com.ua/catalog/noski/
```

#### Notes:
* Currently, Parseify does not support pagination traversal.
* The parser only supports category pages (e.g., https://solmar.com.ua/catalog/noski/).

### Supported Sites
Parseify currently supports the website solmar.com.ua. Only product categories are supported for scraping.
