JsonGoDB Documentation
======================

Introduction
------------

JsonGoDB is an open-source, lightweight and easy-to-use JSON file-based database library for PHP. It provides basic CRUD functionality, similar to MongoDB and NeDB. With JsonGoDB you can easily create, read, update and delete data using simple and familiar methods.

Installation
------------

To install JsonGoDB, simply include the **jsonGoDB.php** file in your project and require it in your PHP script.

Creating a new database
-----------------------

To create a new database, simply instantiate the **JsonGoDB** class and pass in a string with the desired name of the JSON file. For example:

`$db = new JsonGoDB("my_db.json");`

Inserting data
--------------

To insert data into the database, use the **insert()** method and pass in an array of data. For example:

`$db->insert(array("name" => "John", "age" => 30));`

Finding data
------------

To find data in the database, use the **find()** method and pass in an array of query parameters. For example:

`$results = $db->find(array("name" => "John"));`

Updating data
-------------

To update data in the database, use the **update()** method and pass in an array of query parameters and data to update. For example:

`$db->update(array("name" => "John"), array("age" => 31));`

Removing data
-------------

To remove data from the database, use the **remove()** method and pass in an array of query parameters. For example:

`$db->remove(array("name" => "John"));`

Deleting a database
-------------------

To delete a database, use the **drop()** method. For example:

`$db->drop();`

Additional features
-------------------

JsonGoDB also provides a **count()** method to return the number of documents in the database, and a **findOne()** method to retrieve a single document that matches a given query. Additionally it has a feature of **ensureIndex()** to create an index on a field for faster queries.

Full code example
-------------------

```<?php
require_once 'jsonGoDB.php';

// Create a new database
$db = new JsonGoDB("my_db.json");

// Insert data into the database
$db->insert(array("name" => "John", "age" => 30));
$db->insert(array("name" => "Jane", "age" => 25));

// Find data in the database
$results = $db->find(array("name" => "John"));
print_r($results);

// Update data in the database
$db->update(array("name" => "John"), array("age" => 31));

// Remove data from the database
$db->remove(array("name" => "Jane"));

// Count the number of documents in the database
$count = $db->count();
echo "Number of documents: $count\n";

// Find a single document that matches a given query
$result = $db->findOne(array("name" => "John"));
print_r($result);

// Create an index on a field for faster queries
$db->ensureIndex("name");

// Delete the database
$db->drop();

```
