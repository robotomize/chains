# Chain class methods


#### My simple chain method implementation
Not to use, is not completed yet and is not stable.
Calculate the result and use it as the input values for the following method, creating a chain of linked methods.
#### In progress

```php
try {
    $t = new MicroChain();
    $obj = $t->initialize(TestClass::class, 'findById', function(TestClass $model) {
        return $model->getId();
    }, [83])->link(TestClass2::class, 'findById', function (TestClass2 $model) {
        return $model->getId();
    })->link(TestClass3::class, 'findById', function (TestClass3 $model) {
        return $model->getName();
    });
    var_dump($obj->getPointer());
} catch (NullModelException $e) {
    $result = null;
}
```

#### another

```php

try {
    $result = $ch->initialize(User::class, 'getBook', function(User $model) {
        return $model->getId();
    })->link(Book::class, 'getStat', function (Book $model) {
        return $model->getId();
    });
    print $result->getPointer();
} catch (NullModelException $e) {
    $result = null;
}

```
