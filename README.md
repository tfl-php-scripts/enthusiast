# Enthusiast for PHP7

#### I would highly recommend not to use this script for new installations. Although some modifications were made, this script is still pretty old, not very secure, and does not have any tests, that's why please only update it if you have already installed it before.

[Enthusiast](https://github.com/angelasabas/enthusiast) is a listing and listing collective management system ported to PHP 7. Requires at least PHP 7.2.

| PHP version | Supported until | Supported by Enthusiast |
|------------------------------------------|--------------------|-------------------------|
| 7.2 | 30 November 2020 | :white_check_mark: |
| 7.3 | 6 December 2021 | :white_check_mark: |
| 7.4 (recommended, LTS version) | December 2022 | :white_check_mark: |
| 8.0 (not released yet) | Q4 2023 or Q1 2024 | :grey_question: |

Changes are available in [changelog](CHANGELOG.md).

## Upgrading instructions

I'm not providing support for those who have version lower than 3.1.5.

If you are using Enthusiast 3.1.6 (old version by Angela) or 3.2.* (my version):

1. **Back up all your current Enthusiast configurations, files, and databases first.**
2. Take note of your database information in all your `config.php` files.
3. Download [an archive of the public folder of this repository](https://gitlab.com/tfl-php-scripts/enthusiast/-/archive/master/enthusiast-master.zip?path=public). Extract the archive.
4. Replace your current `enthusiast/` files with the `public/enthusiast/` files from this repository.
5. In every fanlisting folder, as well as in the enthusiast and collective folder, paste the `config.sample.php` file. Edit your database information and listing ID variable accordingly, and save it as `config.php` to overwrite your old one. There are samplefl and samplecollective folders put to the archive right for that so please, make your FLs consistent with those examples. 

Please follow the instructions carefully. A lot of issues were related to facts that users had incorrect config files.

That's it! Should you encounter any problems, please [create an issue](https://gitlab.com/tfl-php-scripts/enthusiast/issues/new?issue%5Bassignee_id%5D=&issue%5Bmilestone_id%5D=), and I will try and solve it if I can.
