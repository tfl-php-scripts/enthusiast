# Changes:

Robotess Fork v1.0

* First and the most important change - I renamed the version so that now it version Robotess Fork v1.0
* Second important change - I added Codeception, so now each PR will be tested against acceptance tests
* Closed #32 - Now approved users can remove themselves + wrote an acceptance test for that
* Fixed #31 - Fatal error when user with the same email tries signing up again + wrote an acceptance test for that

---

v3.2.4

* Fixed #23 - Enth admin panel uses FL's perpage setting for displaying members but global items per page for paginator
* Fixed #24 - Enth admin panel: various problems with searches

Thanks for reporting those two, [Crissy](http://allneonlike.org)!
* Fixed #26 - Now enth dashboard contains information about Enth version, PHP version, PDO type/version

---

v3.2.3

* Fixed #14 - Checked that works fine on PHP 7.4
* Fixed #21 - Finally updated dashboard.php so that it now pulls project's RSS

---

v3.2.2

* Fixed #19 - Editing templates via admin panel keeps adding the slashes

---

v3.2.1

* Fixed #13 - Enthusiast does not always load fanlisting Statistics
* Fixed #18 - Edit info of an owned FL clears category

Thanks for reporting those two, [Jackie](https://www.celes.net)!

---

OLDER CHANGES
* Fixed continue misbehaviour in switches (made PHP 7.3 compatible)
* Fixed issue with members/affiliates who had emails with a plus
* General changes that are allowing to use the script with PHP 7.1 and newer
