<?php namespace ca\acadiau\cs\comp4583\fishtail\data\persistence;

/**
 * Access to authentication.
 *
 * @since 1.0.0
 * @author Samuel Coleman <105709c@acadiau.ca>
 */
class AuthRepository
{
    /**
     * @var \PDO the database
     */
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Determine whether a given secret is valid.
     *
     * @param string $secret the app secret
     * @return bool whether the given secret is valid
     */
    public function authenticate($secret)
    {
        $statement = $this->db->prepare(<<<SQL
            SELECT COUNT(secret) AS valid FROM auth WHERE secret = ?;
SQL
        );
        $statement->execute([$secret]);
        return ($statement->fetchColumn(0) > 0);
    }
}