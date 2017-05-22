# What next?

* Each certificatess are located in `webroot/<certificate-name>`. Certificate Names can be set
with `->setName(<certificate-name>)` function.
* To load CA for signing certificate you will use `->setCa(<certificate-name>, <certificate-key-pass>)`.
__Certificate Key pass__ is located in `code.txt` file in each certificate folder.

## PKCS12 file format

Windows users need certificate in PKCS12 format, `.pfx` file extension. To create this type of file use

```php
...->toFile(true);
```