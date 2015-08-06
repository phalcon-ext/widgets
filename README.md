Phalcon\Ext\Widgets
=======

## Installing ##

Install composer in a common location or in your project:

    curl -s http://getcomposer.org/installer | php

Create the composer.json file as follows:

```
{
	"require": {
		"phalcon-ext/widgets": "dev-master"
	}
}
```

Run the composer installer:

```bash
php composer.phar install
```

Add in your the code

    require_once('vendor/autoload.php');
    
    
## Using ##

```php
class SomeWidget extends Phalcon\Ext\Widgets\WidgetBase
{
  public function init()
  {
    // optional some method
  }
  
  public function render($params = null) 
  {
    return $params['a'] + $params['b'] * ($params['c'] ?: 1);
  }
}

// Register widgets manager in DI
$di->setShared('widgets', function() use ($di) {

  $widgets = new Phalcon\Ext\Widgets\Manager();
  
  // Register some widget (the syntax is similar in DI)
  $widgets->set('some', function($options) {
    $widget = SomeWidget($options);
    $widget->init();
    
    return $widget;
  });
  
  return $widgets;
});


// Somewhere in view
echo $this->getDI()->get('widgets')->render('some', ['a' => 5, 'b' => 5, 'c' => 2]); // 15
```
