# Creating itermediate CA

This type of CA you will use for signing users and servers certificates.

```php
$cf->domainName()
    ->setOrganizationName('Hogwarts School of Witchcraft and Wizardry')
    ->setCountryName('SK')
    ->setOrganizationalUnitName('Hogwarts houses')
    ->setCommonName('Slytherin HSoWaW House');

$cf->setType('intermediate')
    ->setName('Hogwarts/Slytherin')
    ->setCa('Hogwarts', '200634')
    ->sign()->toFile();
```