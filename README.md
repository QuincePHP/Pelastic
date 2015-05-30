# Pelastic

**Pelastic** _(/ˈplastik/)_ is an explicit abstraction layer on elasticsearch query DSL.

### Introduction
The philosophy of the *Pelastic* project is to provide a human friendly, object oriented layer around *elasticsearch*'s DSL.  

*Elasticsearch* contains two main DSLs, the query DSL and the filter DSL, *Pelastic* makes it easy to work with them by treating them as objects in your PHP application.

### Features
 - Explicit Query and Filter classes based on elasticsearch docs.
 - Plastic ODM, an ODM inspired by Laravel's *Eloquent*.
 - SQL monkey, SQL like abstraction layer over the *query* and *filter* features. (```$monkey->index('blog_posts')->where('cats.id', 255)->take(5);```).
 - Plastic adapters, easily integrate *Plastic* and its ODM with your faramework's ORM and use them in a hybrid environment.
 - Eventing system, there is an event for any action.
 - Guzzle made request performer, which offers pretty exceptions, so you can develop more debug friendly.

### Explicit Queries and Filters
Elasticsearch's DSL is great itself, but there are problems with JSON (or equivalent arras in PHP). Standalone query and filter classes allow you to develop with the help of your IDE(yes there is auto-complete for any of the queries/filters included in elasticsearch docs).  

### Pelastic ODM
*Pelastic* contains an ODM package, The ODM is implemented in an active record mode inpired by laravel's eloquent. The reason we have chosen the active record mode, is that elasticsearch is famous for its ability to be schema less, so we didn't to make a limit on that. we simply treat them in a way that elasticsearch does. 

### SQL Monkey
The *Pelastic* project contains an *SqlMonkey* plugin which provides an *SQL* like layer around the DSL(inspired by laravel's ```QueryBuilder``` calss), so it really makes it easy if you want a quick take off. In addition it allows you to perform foundational queries in a really easier way(queries like exact matches, like or wildcard queries, or creating a document inside an index).
We have considered that it is very casual to use elasticsearch as a READ db, so we created the *SqlMonkey* to allow you to query like a boss.  

### Pelastic Adapters
*Pelastic* adapters allow you to integrate your current framework and ORM(or ODM) with *Pelastic*, we have created some adapters for *Laravel*, *Symfony*, *Doctrine*, *Propel* and *Yii*. So this is really great to integrate your *Eloquent* models or *Doctrine* entities with elasticsearch (ofcourse in a configurable, extendable way).

### Eventing system
The *Pelastic* project contains a great eventing system, which allows you do magic things, there is an event for everything! no more debugging nightmare. we have also created an integraion plugin for the [PHPDebugbar](http://phpdebugbar.com/) project.

### Guzzle made request performer
Pelastic contains an abstraction layer over the Elasticsearch's HTTP api which allows you handle exceptions much more easier, and also develop in a debug friendly mode. The HTTP layer is handled by great *Guzzle* project.

