# Database support
##Intro##
Mezon built-in classes support varios databases using PDO extension of the PHP language.

##Details##
The following databases are supported:

- CUBRID
- MS SQL Server
- Firebird
- IBM
- Informix
- MySQL
- MS SQL Server
- Oracle
- ODBC and DB2
- PostgreSQL
- SQLite
- 4D

PDO objects are wrapped with ProCrud class wich will help you to create simple CRUD routine.

For example:

```PHP
$DataConnection = array(
    'dns' => 'mysql:host=localhost;dbname=testdb' , 
    'user' => 'user' ,
    'password' => 'password'
);

$CRUD = new PdoCrud();
$CRUD->connect( $DataConnection );
// fetching fields id and title from table test_table where ids are greater than 12
$Records = $CRUD->select( 'id , title' , 'test_table' , 'id > 12' );
```