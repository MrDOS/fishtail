<?php namespace ca\acadiau\cs\comp4583\fishtail\data\persistence;

/**
 * Repository for fishing sessions.
 *
 * @since 1.0.0
 * @author Samuel Coleman <105709c@acadiau.ca>
 */
class FishingSessionRepository
{
    /**
     * @var \PDO the database
     */
    private $db;
    /**
     * @var \ca\acadiau\cs\comp4583\fishtail\data\persistence\FishRepository a fish repository
     */
    private $fishRepository;

    public function __construct($db, $fishRepository)
    {
        $this->db = $db;
        $this->fishRepository = $fishRepository;
    }

    /**
     * Store a fishing session in the database.
     *
     * @param \ca\acadiau\cs\comp4583\fishtail\data\FishingSession $session the session
     * @return int the ID of the inserted session
     */
    public function store($session)
    {
        $statement = $this->db->prepare(<<<SQL
            INSERT INTO session (
                username,
                start_time,
                end_time,
                location,
                latitude,
                longitude,
                anglers,
                exact_anglers,
                lines,
                catches,
                exact_catches)
            VALUES (
                :username,
                :start_time,
                :end_time,
                :location,
                :latitude,
                :longitude,
                :anglers,
                :exact_anglers,
                :lines,
                :catches,
                :exact_catches);
SQL
        );

        $this->db->beginTransaction();

        $statement->execute([
            ':username' => $session->username,
            ':start_time' => date('c', $session->startDate),
            ':end_time' => date('c', $session->endDate),
            ':location' => $session->locationName,
            ':latitude' => $session->latitude,
            ':longitude' => $session->longitude,
            ':anglers' => $session->anglers,
            /* See https://bugs.php.net/bug.php?id=33876. */
            ':exact_anglers' => ($session->exactAnglers) ? 't' : 'f',
            ':lines' => $session->lines,
            ':catches' => $session->catches,
            ':exact_catches' => ($session->exactCatches) ? 't' : 'f']);
        $sessionId = (int) $this->db->lastInsertId('session_session_id_seq');

        foreach ($session->fish as $fish)
        {
            $fish->sessionId = $sessionId;
            $this->fishRepository->store($fish);
        }

        $this->db->commit();
    }
}