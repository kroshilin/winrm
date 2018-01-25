# Installation and usage  
Use this util to execute powershell commands on windows hosts.  
In order to use it you need to install python and https://github.com/diyan/pywinrm  

`composer require kroshilin/winrm-client`

## Example  
```php
    $winRm = new WinRm('127.0.0.1', 'admin', 'password');
    try {
        $result = $winRm->executeCommand('echo "Hello world"');
    } catch (\Exception $e) {
        // handle exceptions
    }

    return $result;
 ```