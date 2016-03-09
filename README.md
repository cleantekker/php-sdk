# Work in progress

### Install  
Run `composer require cleantekker/php-sdk` in your project root.

### Basic usage
```php
$client = new Cleantekker\Cleantekker([
    'token' => 'your jwt access token',
]);

// now you are ready to make api calls, i.e:
$jobs = $client->endpoint->jobs->all();
```

### Inspiration  
This is highly inspired from https://github.com/hassankhan/instagram-sdk   
so big thanks to @hassankhan for everything he did in the above library.
