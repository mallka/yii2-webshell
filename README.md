**Notice:the package  forked from samdark/yii2-webshell** 

What we change 
=================
1. allow to run other console command
2. move the jquery.terminal into asset folder due to bower floder is different(since some date) 
3. changed sourcepath of Asset Class, then I don't need to set Alias config anymore.



Yii 2.0 web shell
=================

Web shell allows to run `yii` console commands using a browser.

<img src="screenshot.png" />

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mallka/yii2-webshell "dev-master"
```

or add

```
"mallka/yii2-webshell": "dev-master"
```

to the require section of your `composer.json` file.


Configuration
-------------

To use web shell, include it as a module in the application configuration like the following:
 
```php
return [
    'modules' => [
        'webshell' => [
            'class' => 'mallka\webshell\Module',
            // 'yiiScript' => Yii::getAlias('@root'). '/yii', // adjust path to point to your ./yii script
        ],
    ],

    // ... other application configuration
]
```

With the above configuration, you will be able to access web shell in your browser using
the URL `http://localhost/path/to/index.php?r=webshell`

Access control
--------------

By default access is restricted to local IPs. It could be changed via `allowedIPs` property. Additionally,
`checkAccessCallback` is available to be able to introduce custom access control:

```php
return [
    'modules' => [
        'webshell' => [
            'class' => 'mallka\webshell\Module',
            // 'yiiScript' => Yii::getAlias('@root'). '/yii', // adjust path to point to your ./yii script
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.2'],
            'checkAccessCallback' => function (\yii\base\Action $action) {
                // return true if access is granted or false otherwise
                return true;
            },
            
            //allow to run other commands,default is true,
            'unlimit'=>false,
        ],
    ],

    // ... other application configuration
]
```

Limitations
-----------

Web shell is unable to work interactively because of request-response nature of web. Therefore you should disable interactive mode for commands.
