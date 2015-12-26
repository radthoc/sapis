Shop api
========

Introduction
-------
Api that provides an ecommerce platform for a shop.

Usage
-------
The api takes several requests with the resource/action format tight to specific methods depending on the action to execute on a given resource.

- PUT request to /items - action /save - parameters: name, description, price, id (optional) - returns the id or an error
- GET request to /items - action /list - returns a list of all items
- POST request too /cart - action /add - parameters: customer_id, item_id - returns the id of the row or an error
- ...

Istallation
-----------
Checkout the source: git clone git://github.com/radthoc/sapis.git or dowmload the zip file, and set the db parameters in the parameters.yml file.

Tests
-----
To run the tests just execute the phpunit test suit from the root folder of the cloned repository:
```php
phpunit -c .
```

