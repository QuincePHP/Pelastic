## What is Pelastic project ?
Pelastic is a powerful yet simple abstraction layer around *Elasticsearch* DSL. It creates an explicit object oriented
layer around the DSL, It has a great [ODM](http://wikipedia.org/ODM) inspired by great ORM of Laravel :
[Eloquent](http://laravel.com/docs/master/eloquent). And some other components which has been described in the doc.

## Why are we developing the Pelastic ?
Actually we have tested a number of clients available for the *Elasticsearch* in PHP, but none of them are developer
friendly, the JSON api provided by *Elasticsearch* is simple but it is not human friendly (I mean JSON), so Pelastic
allows you to develop with the help of your IDE. We have inspired all the good things from other packages, for instance
the connection layer of the official client is really solid, so we added some features to that and made it easy to work,
Or *Elastica*'s query and filter implementations are really clean so we were inspired by them.

But in addition to developer happiness we were hardly working on, we have created a great powerful yet simple *ODM*, the
ODM is really abstract and inspired by *Laravel*'s Eloquent ORM. You can use the ODM in a hybrid environment with your
default ORM/ODM , It also has some adapters for famous frameworks like Laravel, Symfony and Yii.
Also the *SqlMonkey* plugin is a plugin if you are new to *Elasticsearch* it creates a nice SQL-like decorator layer for
Elasticsearch's query DSL. Also if you are using Elasticsearch as your main db it makes the life lot more easier, you can
perform queries like this : ```$sqlMonkey->index('users')->where('name.first', 'Reza')->orWhere('name.last', 'Shadman')->take(5);```