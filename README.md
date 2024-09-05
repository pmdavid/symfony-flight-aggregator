## Overview

This repository consists of an API, created in Symfony 6. This API connects to an external API to obtain flight information, process it and return it via an endpoint and a console command.

## Get started

1. Run composer install

```bash
composer install
```
2. Run symfony server

```bash
 symfony server:start
```

## Features

1. Return JSON flights information: 

Endpoint GET: http://localhost:port/api/avail?origin=MAD&destination=BIO&date=2022-06-10

2. Return flights information through console: 

```bash
php bin/console lleego:avail MAD BIO 2023-06-01
```

3. Execute tests:

```bash
 ./vendor/bin/phpunit    
```

## Some considerations


- I took the decision to create an application service called SegmentDataMapper that processes the necessary fields of the XML segments and create the Segment objects, but we could also consider creating a Factory (in Domain layer) design pattern to create the Segment instances.
- The processXMLData method on TestAPIClient.php could be extracted to a specific configuration/data extraction service for XMLs of this type/format.
- For any questions about repository, config or functionality, write to: davidpalacios.ma@gmail.com
