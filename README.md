# PHP-API TEST
This is an API test to get data from SpaceX API and XKCD

**Requirements**
1. PHP 7+

**Dependencies**
1. Production
    ```illuminate/validation```
2. Development
    ```phpunit/phpunit```

**Installation**

1. Clone the repo. 

    ```clone https://github.com/sbarbosa115/php-skeleton.git``` 

2. Install phpunit dependencies.

    ```composer install```

3. Check that folder /db is writable. 

**How to use**

App entry point is index.php, you can locale in the root of the application (/). 

Web API
 * Parameters: 
    * sourceId (String) Required, Values supported: [comics, space], 
    * limit (String) Required, [integer > 1], 
    * year (String) Required, [integer, > 2000]
 * Return JSON with results.
 * Call GET Example: 
    * ```/index.php?sourceId=space&limit=1&year=2014```
    * ```/index.php?sourceId=comics&limit=1&year=2014```
 * Call POST Example:
    * ```{ "sourceId": "space","year": 2013,"limit": 1} ```
    * ```{ "sourceId": "comics","year": 2013,"limit": 1} ```
    
PHP-CLI API
 * Parameters: 
     * sourceId (String) Required, Values supported: [comics, space], 
     * limit (String) Required, [integer > 1], 
     * year (String) Required, [integer, > 2000]
 * Return JSON with results.
 * Call Example: 
    * ```php index.php comics 2017 2```
    * ```php index.php space 2017 2```
    
    
Response:
For any way to use the response will be a JSON like this:

```{"meta":{"request":{"sourceId":"space","year":2017,"limit":1},"timestamp":1536592877},"data":[{"number":35,"date":"2017-01-14","name":"Iridium NEXT Mission 1","link":"https:\/\/en.wikipedia.org\/wiki\/Iridium_satellite_constellation#Next-generation_constellation","details":"Return-to-flight mission after the loss of Amos-6 in September 2016. Iridium NEXT will replace the original Iridium constellation, launched in the late 1990s. Each Falcon mission will carry 10 satellites, with a goal to complete deployment of the 66 plus 9 spare satellite constellation by mid 2018. The first two Iridium qualification units were supposed to ride a Dnepr rocket in April 2016 but were delayed, so Iridium decided to qualify the first batch of 10 satellites instead."}]}```


**Test**

```vendor/bin/phpunit```

