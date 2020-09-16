# Changes:

v.1.0.5

* Fixed #38 - suppressing a warning when cache file does not exist and cannot be created. Thanks for reporting, @misssolitude! 
* Fixed #40 - creating affiliates table only if it does not exist, dropping it only if it exists. Thanks for reporting, [Nicki](https://fanlistings.nickifaulk.com/)!

There were also some enhancements and fixes regarding usage of the deprecated functions. Also now if you forget to set $listing variable in config file, you will get a warning on the page. 

v.1.0.4

* Closed #37 - now it's possible to update a setting 'show/hide email' for a user via dashboard.

v.1.0.3

* Fixed #36 - a bug with pagination in admin panel (affected pages: members of fanlisting, owned, joined, errorlog and categories) - thanks for reporting, [Jill](http://totallygirl.net)!
* For backward compatibility, if you're using your own addform.inc.php, allowed names for inputs are not only "enth_$extraFieldName" but also "$extraFieldName". Though I'd recommend renaming inputs to "enth_$extraFieldName".

There were also some code style fixes and fixes for EA inspections implemented.

---

v.1.0.2

* Fixed #34 - a bug that didn't allow users to update their emails via form.

Also there were various fixes implemented regarding forms.

---

v.1.0.1

* Small change: added $$stat_opened$$ variable to statistics template.

---

Robotess Fork v1.0

* First and the most important change - I renamed the version so that now it is version Robotess Fork v1.0.
* Second important change - I added Codeception, so now each PR will be tested against acceptance tests.
* Closed #32 - Now approved users can remove themselves + wrote an acceptance test for that.
* Fixed #31 - Fatal error when user with the same email tries signing up again + wrote an acceptance test for that.

---

v3.2.4

* Fixed #23 - Enth admin panel uses FL's perpage setting for displaying members but global items per page for paginator.
* Fixed #24 - Enth admin panel: various problems with searches.

Thanks for reporting those two, [Crissy](http://allneonlike.org)!
* Fixed #26 - Now enth dashboard contains information about Enth version, PHP version, PDO type/version.

---

v3.2.3

* Fixed #14 - Checked that works fine on PHP 7.4.
* Fixed #21 - Finally updated dashboard.php so that it now pulls project's RSS.

---

v3.2.2

* Fixed #19 - Editing templates via admin panel keeps adding the slashes.

---

v3.2.1

* Fixed #13 - Enthusiast does not always load fanlisting Statistics.
* Fixed #18 - Edit info of an owned FL clears category.

Thanks for reporting those two, [Jackie](https://www.celes.net)!

---

OLDER CHANGES
* Fixed continue misbehaviour in switches (made PHP 7.3 compatible).
* Fixed issue with members/affiliates who had emails with a plus.
* General changes that are allowing to use the script with PHP 7.1 and newer.
