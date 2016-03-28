# Mezon PHP Framework
##Intro##
Mezon is a simple php framework wich will help you to create administrative consoles for your projects.
##Installation##
Go to your web root directory and use:
```bash
mkdir mezon
cd mezon
git init
git remote add mezon <your fork of the mezon project>
```

##First "Hello world" application##
It's very simple to create your own "Hello world" application.

Open %mezon-dir%/index.php file and write this simple code (it can be found in %mezon-path%/doc/examples/hello-world/index.php):
```PHP
require_once( './mezon.php' );

class           HelloWorldApplication extends Application
{
    /**
    *   Main page.
    */
    public function action_index()
    {
        return( 'Hello world!' );
    }
}

$App = new HelloWorldApplication();
$App->run();
```

That's all!

But lets look at this code once again. 

Here we can see Mezon php files.

```PHP
require_once( './mezon.php' );
```

We also can see HelloWorldApplication wich is derived from the Application class.

```PHP
class           HelloWorldApplication extends Application
{
    // ...
}
```
Application class is the most important class of the Mezon framework. In your every application you will override a part of it's methods.

In this example we override only one method - action_index wich draws main page of your application.

```PHP
public function action_index()
{
    return( 'Hello world!' );
}
```

What else can we see? Each page drawing method (or 'view') must return generated content wich will be used for page renderring functions of the Application class and actual template engine.

Then we create the instance of our application and running it.

```PHP
$App = new HelloWorldApplication();
$App->run();
```

##Routing##

Now it is time to go deeper and find out how routes are working?

###One component routes###

Here and a little bit further we shall explore Mezon trying to create a simple web site.

So here is our application (it can be found in %mezon-path%/doc/examples/simple-site/index.php):

```PHP
class           SiteApplication extends Application
{
    /**
    *   Main page.
    */
    public function action_index()
    {
        return( 'This the main page of our simple site!' );
    }

    /**
    *   Contacts page.
    */
    public function action_contacts()
    {
        return( 'This the "Contacts" page' );
    }
}

$App = new SiteApplication();
$App->run();
```

In this example we can see the main page, wich is rendered by public function action_index(). It can be accessed by example.com/ URL or example.com/index/ URL.

And the contacts page, wich is rendered by public function action_contacts(). It can be accessed by example.com/contacts/ URL.

Quite simple, yeah? )

##Configuration##

Mezon has it's own config. It can be accesed with a set of functions, wich are described below.

Getting access to the key in config can be done with get_config_value( $Route , $DefaultValue = false ) function. It returns config value with route $Route and return $DefaultValue if this key was not found. For example:

```PHP
$Value = get_config_value( 'res/images/favicon' , 'http://yoursite.com/res/images/favicon.ico' );

// or the same
$Value = get_config_value( array( 'res' , 'images' , 'favicon' ) , 'http://yoursite.com/res/images/favicon.ico' );
```

Setting values for the config key can be done by calling set_config_value( $Route , $Value ) or add_config_value( $Route , $Value ) function. The main difference between these two functions is that the first one sets scalar key, and the second one adds element to the array in config. Here is small example:

```PHP
set_config_value( 'res/value' , 'Value!' );
var_dump( get_config_value( 'res/value' ) ); // displays 'Value!' string

add_config_value( 'res/value' , 'Value 1!' );
add_config_value( 'res/value' , 'Value 2!' );
var_dump( get_config_value( 'res/value' ) ); // displays array( [0] => 'Value 1!' , [1] => 'Value 2!' ) array
```

That's all you need to know about config read/write.