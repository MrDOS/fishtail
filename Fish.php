<?php namespace ca\acadiau\cs\comp4583\fishtail\data;

/**
 * A caught fish.
 *
 * @since 1.0.0
 * @author Samuel Coleman <105709c@acadiau.ca>
 */
class Fish
{
    /**
     * @var int the database ID of the session to which the fish belongs
     */
    public $session;

    /**
     * @var string the species of fish
     */
    public $species;
    /**
     * @var double the length of the fish in millimetres
     */
    public $length;
    /**
     * @var bool whether the length of the fish is exact
     */
    public $exactLength;
    /**
     * @var string the health of the fish when caught
     */
    public $catchHealth;
    /**
     * @var string the health of the fish when released
     */
    public $releaseHealth;
    /**
     * @var whether or not the fish is tagged
     */
    public $tagged;
    /**
     * @var string the fish tag ID
     */
    public $tagId;
    /**
     * @var string the colour of the fish tag
     */
    public $tagColor;
    /**
     * @var bool whether or not a scale sample was taken
     */
    public $tookSample;
    /**
     * @var string a photo of the fish
     */
    public $photo;

    public function __construct($object)
    {
        if (!isset($object->species))
            throw new FishException('A species must be specified');
        if (!isset($object->length))
            throw new FishException('A length must be specified');
        if (!isset($object->exactLength))
            throw new FishException('Whether the length is exact must be specified');
        if (!isset($object->catchHealth))
            throw new FishException('The catch health must be specified');
        if ($object->catchHealth !== 'dead' && !isset($object->releaseHealth))
            throw new FishException('The release health must be specified');

        $this->session = null;

        $this->species = $object->species;
        $this->length = $object->length;
        $this->exactLength = $object->exactLength;
        $this->catchHealth = $object->catchHealth;
        $this->releaseHealth = ($this->catchHealth !== 'dead') ? $object->releaseHealth : 'dead';

        if ((isset($object->tagged) && $object->tagged)
            || (isset($object->tagId) && $object->tagId != null
                && isset($object->tagColor) && $object->tagColor != null))
        {
            $this->tagged = true;
            $this->tagId = (isset($object->tagId)) ? $object->tagId : null;
            $this->tagColor = (isset($object->tagColor)) ? $object->tagColor : null;
            $this->tookSample = false;
        }
        else
        {
            $this->tagged = false;
            $this->tagId = null;
            $this->tagColor = null;
            $this->tookSample = (isset($object->tookSample) && $object->tookSample);
        }
    }
}