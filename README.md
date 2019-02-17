Fixtures Generator Bundle For Doctrine
==================================

This bundle generate the fixtures code for doctrine, you can can override all code without problems 

**Unestable becareful**

Installation

``` 
composer require "mgd/fixtures_generator"
```

Add Into bundles.php
```
    MGDSoft\FixturesGeneratorBundle\MgdsoftFixturesGeneratorBundle::class => ['dev' => true],
```

Configure

```
mgdsoft_fixtures_generator: ~
```

Execute Command to generate Fixtures, by default it create all for your proyect

```
bin/console mgdsoft:fixtures:generate
```

Result will be

src/DataFixtures/ORM/LibsAuto/AbstractLoadUserFixture.php, this file is a abstract class you can override all methods in child class, We recommend not to modify this class.  
```php
<?php

namespace App\DataFixtures\ORM\LibsAuto;

use App\Entity\User;
use MGDSoft\FixturesGeneratorBundle\LoaderFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

abstract class AbstractLoadUserFixture extends AbstractFixture  implements DependentFixtureInterface
{
    protected function loadRows()
    {
        $this->loadRow('1', []);
        $this->om->flush();
    }

    protected function loadRow($key, array $overrideDefaultValues = [])
    {
        $obj = new User();

        $defaultValues = $this->getDefaultValues();

        $properties = array_merge($defaultValues, $overrideDefaultValues);

        foreach ($properties as $property => $value) {
            $this->propertyAccessor->setValue($obj, $property, $value);
        }

        $this->om->persist($obj);
        $this->addReference("user-".$key, $obj);
    }

    protected function getDefaultValues()
    {
        return [

            // ---[ required values ]--- ,
            'username' => 'username',
            'usernameCanonical' => 'usernameCanonical',
            'email' => 'email',
            'emailCanonical' => 'emailCanonical',
            'password' => 'password',
            'roles' => ["ROLE_SUPER_ADMIN"],
            'colour' => 'colour',
            'isOnline' => true,
            'createdAt' => new \DateTime(),
            'updatedAt' => new \DateTime(),
            'salt' => 'salt',
            'enabled' => true,
            'plan' => $this->getReference("plan-1"),

            // ---[ required with default values ]--- ,
            // 'showTips' => true,

            // ---[ non-mandatory fields ]--- ,
            // 'lastLogin' => new \DateTime(),
            // 'confirmationToken' => 'confirmationToken',
            // 'passwordRequestedAt' => new \DateTime(),
            // 'name' => 'name',
            // 'lastName' => 'lastName',
            // 'avatar' => 'avatar',
            // 'initials' => 'initials',
            // 'lang' => 'en',
            // 'planDateEnd' => new \DateTime(),
            // 'stripeSubscriptionId' => 'stripeSubscriptionId',
            // 'userHasEmails' => $this->getReference("user_has_email-1"),
            // 'webPushes' => $this->getReference("user_web_push-1"),
            // 'user_resources' => $this->getReference("user_resources-1"),
            // 'tags' => $this->getReference("tag-1"),
            // 'guest' => $this->getReference("guest-1")
        ];
    }

    public function getDependencies()
    {
        return [
            'App\DataFixtures\ORM\LoadPlanFixture',
            // ---[ non-mandatory fields ]---,
            // 'App\DataFixtures\ORM\LoadUserHasEmailFixture',
            // 'App\DataFixtures\ORM\LoadUserWebPushFixture',
            // 'App\DataFixtures\ORM\LoadUserResourcesFixture',
            // 'App\DataFixtures\ORM\LoadTagFixture',
            // 'App\DataFixtures\ORM\LoadGuestFixture'
        ];
    }
}
```

src/DataFixtures/ORM/LoadUserFixture.php, Here you can customize what you want
```php
<?php

namespace App\DataFixtures\ORM;

use App\DataFixtures\ORM\LibsAuto\AbstractLoadUserFixture;

class LoadUserFixture extends AbstractLoadUserFixture
{

}
```

And for test purpose is created tests/Fixtures/General/LoadTestUserFixture.php

```php
<?php

namespace Tests\Fixtures\General;

use App\DataFixtures\ORM\LibsAuto\AbstractLoadUserFixture;

class LoadTestUserFixture extends AbstractLoadUserFixture
{

}
```

How to insert multiples rows?
-----------------------------

src/DataFixtures/ORM/LoadUserFixture.php, Here you can customize what you want
```php
<?php

namespace App\DataFixtures\ORM;

use App\DataFixtures\ORM\LibsAuto\AbstractLoadUserFixture;

class LoadUserFixture extends AbstractLoadUserFixture
{
    protected function loadRows()
    {
        $this->loadRow('1', ['username' => 'Miguel1', 'email' => 'mgd1@mgdsoftware.com']);
        $this->loadRow('2', ['username' => 'Miguel2', 'email' => 'mgd2@mgdsoftware.com']);
        $this->loadRow('3', ['username' => 'Miguel3', 'email' => 'mgd3@mgdsoftware.com']);
        $this->om->flush();
    }
}
```

Each row insert has a doctrine reference with "class Prefix"-"$key"


To see all options execute

```
bin/console mgdsoft:fixtures:generate -h 
```


All pull request are welcome
