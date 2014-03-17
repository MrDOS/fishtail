<?php namespace ca\acadiau\cs\comp4583\fishtail\data\persistence;

/**
 * Repository for fish.
 *
 * @since 1.0.0
 * @author Samuel Coleman <105709c@acadiau.ca>
 */
class FishRepository
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
     * Store a fish in the database.
     *
     * @param \ca\acadiau\cs\comp4583\fishtail\data\Fish $fish the fish
     * @return int the ID of the inserted session
     */
    public function store($fish)
    {
        $statement = $this->db->prepare(<<<SQL
            INSERT INTO fish (
                session_id,
                species,
                length,
                exact_length,
                catch_health,
                release_health,
                tagged,
                tag_id,
                tag_color,
                took_sample,
                photo)
            VALUES (
                :session_id,
                :species,
                :length,
                :exact_length,
                :catch_health,
                :release_health,
                :tagged,
                :tag_id,
                :tag_color,
                :took_sample,
                :photo);
SQL
        );

        $statement->execute([
            ':session_id' => $fish->sessionId,
            ':species' => $fish->species,
            ':length' => $fish->length,
            /* See https://bugs.php.net/bug.php?id=33876. */
            ':exact_length' => ($fish->exactLength) ? 't' : 'f',
            ':catch_health' => $fish->catchHealth,
            ':release_health' => $fish->releaseHealth,
            ':tagged' => ($fish->tagged) ? 't' : 'f',
            ':tag_id' => $fish->tagId,
            ':tag_color' => $fish->tagColor,
            ':took_sample' => ($fish->tookSample) ? 't' : 'f',
            ':photo' => $fish->photo]);
        return (int) $this->db->lastInsertId('fish_fish_id_seq');
    }
}