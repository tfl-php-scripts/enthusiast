# Enthusiast

#### I would highly recommend not to use this script for new installations. Although some modifications were made, this script is still pretty old, not very secure, and does not have any tests, that's why please only update it if you have already installed it before.

[Enthusiast](https://github.com/angelasabas/enthusiast), but using PDO instead of the deprecated MySQL extension. Requires at least PHP 5.4, and compatible with PHP 7 (up to PHP 7.3).

| PHP version | Supported until | Supported by Enthusiast |
|------------------------------------------|--------------------|-------------------------|
| 7.1 | 1 December 2019 | :white_check_mark: |
| 7.2 | 30 November 2020 | :white_check_mark: |
| 7.3 | 6 December 2021 | :white_check_mark: |
| 7.4 (to be released on 21 November 2019) | December 2022 | :question: |
| 8.0 (not released yet) | Q4 2023 or Q1 2024 | :grey_question: |

## Changes

- Converted all mysql_* functions to PDO
- Replaced all instances of `TYPE=MyISAM` with `ENGINE=MyISAM`
- Replaced `ereg()` with `preg_match()`
- Updated [PEAR](https://pear.php.net/package/PEAR/) to v1.10.5
- Updated [PEAR/Mail](https://pear.php.net/package/Mail/) to v1.4.1
- Removed all closing tags
- Added docker-compose
- Fixed continue misbehaviour in switches (PHP 7.3 compatible)
- Members/affiliates emails with a plus are not an issue anymore

## Upgrading

If you are using [this version](https://github.com/angelasabas/enthusiast) of Enthusiast:

1. **Back up all your current Enthusiast configurations, files, and databases first.**
2. Take note of your database information in all your `config.php` files.
3. Download an [archive of this repository](https://gitlab.com/elephanto/enthusiast/-/archive/master/enthusiast-master.zip). Extract the archive.
4. Replace your current `enthusiast/` files with the `public/enthusiast/` files from this repository.
5. In every fanlisting folder, paste the `config.sample.php` file. Edit your database information and listing ID variable accordingly, and save it as `config.php` to overwrite your old one.
