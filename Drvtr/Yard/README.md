# Drvtr_Yard Module

This module does not contain any e-commerce features. Instead, it contains developer tools that helps to deeper investigate the Magento's business logic, track bugs, and significantly speed up prototyping, development and testing of new functionality.

##Tools

####Dumper

just use a static method anywhere in the code, for dumping some data
`\Drvtr\Yard\Tools::dump('var/dev/%date%-dummy/%increment%-result.json', $result, true);`

####LoggerPool

just use a static method anywhere in the code, for log some data
`\Drvtr\Yard\Tools::getLogger('var/dev/dummyLog')->info('Dummy info');`

####XDebug Helper
- usage with PHPStorm and Xdebug, one interesting technique of debugging Magento 2 with PHPStorm and Xdebug
https://shkoliar.com/articles/magento-2-debug-helper-module-usage-with-phpstorm-and-xdebug/

With enabled extension and active Xdebug, copy the text what you want to search with debugger and add it to page URL with query param XDS. For example to search for `$22.00` on `/radiant-tee.html` page, use `/radiant-tee.html?XDS=$22.00`. Once the searched query had found, PHPStorm will hit a breakpoint, and you will be able to check the call stack or step further.
