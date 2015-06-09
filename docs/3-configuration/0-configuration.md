## Configuration and usage

### Config class
After installing Pelastic you need to create a config class which contains some data about your clusters and such a things.
```php

$config = new \Quince]\Pelastic\Config\PelasticConfig();
$config->setHosts(['http://localhost:9200'], ['http://some-example:9200']);
$config->setSelector(new \Quince\Pelastic\Connection\Selector\PerScriptRoundRobinSelector());
$config->setPool('Quince\Pelastic\Connection\Pool\NoPingConnectionPool');

```
Also none of the the config options are mandatory so you can simply skip this step, but being a little bit explicit here
is really good as you will figure out how Pelastic works.

### Pelastic Manager
Pelastic Manager is a simple class which acts like a Facade around the features, think of it as **EntityManager** in *Doctrine*. This
class is Singleton so there is only once instance of it during your script execution. If you are using a Dependency Manager and container
your life would be really easier.

You can get the instance simply like this :
```php

$pelasticManager = \Quince\Pelastic\PelasticManager::getInstance();

```

And also you can easily pass your config to the singleton **PelasticManager** instance :

```php

$config = new \Quince]\Pelastic\Config\PelasticConfig();
$config->setHosts(['http://localhost:9200'], ['http://some-example:9200']);
$config->setSelector(new \Quince\Pelastic\Connection\Selector\PerScriptRoundRobinSelector());
$config->setPool('Quince\Pelastic\Connection\Pool\NoPingConnectionPool');

$pelasticManager = \Quince\Pelastic\PelasticManager::getInstance();
$pelasticManager->setConfig($config);

```


