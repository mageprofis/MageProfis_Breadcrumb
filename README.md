MageProfis_Breadcrumb
=====================

Facts
------
- Version: check [config.xml](https://github.com/mageprofis/MageProfis_Breadcrumb/blob/master/src/app/code/community/MageProfis/Breadcrumb/etc/config.xml)
- Extension key: MageProfis_Breadcrumb
- [Extension on GitHub](https://github.com/mageprofis/MageProfis_Breadcrumb/)

Description
------------
> tl;dr Puts a category before the product name in the breadcrumb.

If your catalog is configured to use category paths in product urls your probably won't need this module. But if you don't then it might be worth a try. This module fixes the situations, where a product page is viewed and no category has been initialized.

Usually a customer takes a certain "click path" through your store and ends up at a category page. Everything's fine, the breadcrumb shows the latest category(ies) before the product name. But what about deep links from search engines or marketing campaigns? What about links from search results?

This modules loads a collection of all categories, that are associated with a product **and** enabled + visible in the navigation (so you won't have to worry about hidden top seller categories popping up in your breadcrumb).

Requirements
------------
- PHP >= 5.3.0

Compatibility
--------------
- Magento >= 1.7

Installation
------------
You can use this module the old-fashioned way and upload all files from the `./src` folder to your webroot (where your Magento installation sits).

Or you can be smart and use modman. And since you're smart I won't have to explain what [modman](https://github.com/colinmollenhour/modman) is or how you can use it, you already know. :grin:

Support
-------
If you encounter any problems or bugs, please create an issue on [GitHub](https://github.com/mageprofis/MageProfis_Breadcrumb/issues).

Contribution
------------
Any contribution to the development of `MageProfis_Breadcrumb` is highly welcome. The best possibility to provide any code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developers
----------
Mathis Klooß
Volker Thiel

Licence
-------
[GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)

Copyright
---------
(c) 2015 Mathis Klooß

