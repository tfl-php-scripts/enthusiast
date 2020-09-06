<?php
declare(strict_types = 1);

namespace RobotessNet;

use PDO;
use PDOException;
use function addslashes;

class EnthusiastErrorHandler
{
    use Singleton;

    private $isMonitoring;
    private $dbLink;
    private $dbErrorLog;

    private function __construct(PDO $db_link, string $db_settings, string $db_errorlog)
    {
        $query = "SELECT `value` FROM `$db_settings` WHERE " .
            "`setting` = 'log_errors'";

        try {
            $result = $db_link->query($query);
        } catch (PDOException $e) {
            die('Error executing query: ' . $e->getMessage());
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();

        $this->isMonitoring = $row['value'] === 'yes';
        $this->dbErrorLog = $db_errorlog;
        $this->dbLink = $db_link;
    }

    public static function instance(PDO $db_link, string $db_settings, string $db_errorlog): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self($db_link, $db_settings, $db_errorlog);
        }

        return self::$instance;
    }

    public function logError(string $page, string $text, bool $kill = true): bool
    {
        // check if we're monitoring errors!
        if ($this->isMonitoring) {
            $text = addslashes($text);
            $query = "INSERT INTO `$this->dbErrorLog` VALUES( NOW(), :page, :dtext )";
            try {
                $result = $this->dbLink->prepare($query);
                $result->bindParam(':page', $page);
                $result->bindParam(':dtext', $text);
                $result->execute();

                echo "An error occurred on the page. Please check logs.<br/>";
            } catch (PDOException $e) {
                die('Error executing query: ' . $e->getMessage());
            }
        } else {
            echo "An error occurred on the page: $text.<br/>";
        }

        if ($kill) {
            die();
        }

        return true;
    }

}