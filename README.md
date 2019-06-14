```php
use IMSoP\Containeroonie\Container;
use function IMSoP\Containeroonie\literal;

$container = new Container;

$container->addLiteral('config.mode', 'dev');
$container->addLiteral('aaaprintf', function(...$args) { echo 'aaa'; printf(...$args); });

$container->addClassSingleton(
        LoggerInterface::class,
        DBLogger::class,
        [
            DB::class,
            'config.mode',
            literal(true)
        ]
);

$container->addClassFactory(
        null,
        FormBuilder::class,
        [
            LoggerInterface::class
        ]
);

$container->addCustomSingleton('thingummy', function(Container $c) {
        $thing = new Thingummy;
        $thing->setLogger($c->get(LoggerInterface::class));
        return $thing;
});

$container->addCustomFactory('newThingummy', function(Container $c) {
        $thing = new Thingummy;
        $thing->setLogger($c->get(LoggerInterface::class));
        return $thing;
});

$container->addAlias(OldLoggerInterface::class, LoggerInterface::class);
