<?php namespace ca\acadiau\cs\comp4583\fishtail\data;

/**
 * A fishing session.
 *
 * @since 1.0.0
 * @author Samuel Coleman <105709c@acadiau.ca>
 */
class FishingSession
{
    /**
     * @var string the TrackMyFish username to be associated with the session
     */
    public $username;
    /**
     * @var double general latitude of session
     */
    public $latitude;
    /**
     * @var double general longitude of session
     */
    public $longitude;
    /**
     * @var string the name of the location per database enum
     */
    public $locationName;
    /**
     * @var \DateTime session start time
     */
    public $startDate;
    /**
     * @var \DateTime session end time
     */
    public $endDate;
    /**
     * @var int the number of other anglers in the area
     */
    public $anglers;
    /**
     * @var bool whether the number of anglers is exact
     */
    public $exactAnglers;
    /**
     * @var int the number of fishing lines involved in the session
     */
    public $lines;
    /**
     * @var int the total number of fish caught throughout the session
     */
    public $catches;
    /**
     * @var bool whether the number of fish caught is exact
     */
    public $exactCatches;

    /**
     * @var \ca\acadiau\cs\comp4583\fishtail\data\Fish[] the fish in the session
     */
    public $fish;

    public function __construct($object)
    {
        if (!isset($object->username))
            throw new FishException('A username must be specified');
        if (!isset($object->startDate))
            throw new FishException('A start date must be specified');
        if (!isset($object->endDate))
            throw new FishException('An end date must be specified');
        if (!isset($object->anglers))
            throw new FishException('The number of anglers must be specified');
        if (!isset($object->exactAnglers))
            throw new FishException('Whether the number of anglers is exact must be specified');
        if (!isset($object->lines))
            throw new FishException('The number of lines must be specified');
        if (!isset($object->catches))
            throw new FishException('The number of catches must be specified');
        if (!isset($object->exactCatches))
            throw new FishException('Whether the number of catches is exact must be specified');
        if (!isset($object->fish) || !is_array($object->fish))
            throw new FishException('An array of fish must be given');

        if ((!isset($object->latitude) || !isset($object->longitude))
            && !isset($object->locationName))
            throw new FishException('A location must be specified');

        $this->username = $object->username;
        $this->latitude = (isset($object->latitude)) ? $object->latitude : null;
        $this->longitude = (isset($object->longitude)) ? $object->longitude : null;
        $this->locationName = (isset($object->locationName)) ? $object->locationName : null;
        $this->startDate = $object->startDate;
        $this->endDate = $object->endDate;
        $this->anglers = $object->anglers;
        $this->exactAnglers = $object->exactAnglers;
        $this->lines = $object->lines;
        $this->catches = $object->catches;
        $this->exactCatches = $object->exactCatches;

        $this->fish = [];
        foreach ($object->fish as $fish)
            $this->fish[] = new Fish($fish);
    }
}