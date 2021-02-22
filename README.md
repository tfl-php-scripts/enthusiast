# Enthusiast for PHP 7 [Robotess Fork]

The main repository with the issue tracking can be found on [gitlab](https://gitlab.com/tfl-php-scripts/enthusiast).

An original author is [Angela Sabas](https://github.com/angelasabas/enthusiast), the other contributor is [Lysianthus](https://github.com/Lysianthus/enthusiast) / Original readme by Angela is [here](https://gitlab.com/tfl-php-scripts/enthusiast/readme.txt).

#### I would highly recommend not to use this script for new installations. Although some modifications were made, this script is still pretty old, not very secure, and does not have any tests, that's why please only update it if you have already installed it before.

This version requires at least PHP 7.2 and PDO_MySQL extensions (with MySQL = 5.7; or 5.6 - though it's pretty outdated).

| PHP version | Supported by Enthusiast | Link to download |
|------------------------------------------|-------------------------|---------------------|
| 7.2 | + |[an archive of the public folder of this repository for PHP 7.2](https://scripts.robotess.net/files/enthusiast/php72-php73-master.zip)|
| 7.3 | + |[an archive of the public folder of this repository for PHP 7.3](https://scripts.robotess.net/files/enthusiast/php72-php73-master.zip)| 
| 7.4 | + |[an archive of the public folder of this repository for PHP 7.4](https://gitlab.com/tfl-php-scripts/enthusiast/-/archive/master/enthusiast-master.zip?path=public) ([mirror](https://scripts.robotess.net/files/enthusiast/php74-master.zip))|
| 8.0 | ? |-|

**If you have MySQL 8.0 or higher, proper script operation is not guaranteed. For now, I'm not planning to fully support MySQL 8.0.** 

Changes are available in [a changelog](https://gitlab.com/tfl-php-scripts/enthusiast/CHANGELOG.md).

## Upgrading instructions

I'm not providing support for those who have version lower than 3.1.5.

If you are using Enthusiast 3.1.6 (old version by Angela) or Enthusiast [Robotess Fork] 1.* (previously - 3.2.* (my version)):

1. **Back up all your current Enthusiast configurations, files, and databases first.**
2. Take note of your database information in all your `config.php` files.
3. Download an archive - please choose appropriate link from the table above. Extract the archive.
4. Replace your current `enthusiast/` files with the `public/enthusiast/` files from this repository. Make sure that you have all files from the folder uploaded.
5. In every fanlisting folder, as well as in the enthusiast and collective folder, paste the `config.sample.php` file. Edit your database information and listing ID variable accordingly, and save it as `config.php` to overwrite your old one. There are samplefl and samplecollective folders put to the archive right for that so please, make your FLs consistent with those examples. 

Please follow the instructions carefully. A lot of issues were caused by users having incorrect config files.

That's it! Should you encounter any problems, please create an issue [here](https://gitlab.com/tfl-php-scripts/enthusiast/-/issues), and I will try and solve it if I can. You can also report an issue via [contact form](http://contact.robotess.net?box=scripts&subject=Issue+with+Enthusiast). Please note that I don't support fresh installations, only those that were upgraded from old version.

## Appreciations
Thanks to everyone who report their issues in any way, and thanks to those who are beta-testers of the new versions:
* [Nicki](https://fanlistings.nickifaulk.com/)
 
If you're willing to be a beta-tester, just let me know via [form](http://contact.robotess.net?box=scripts&subject=Beta-Testing+of+Enthusiast).