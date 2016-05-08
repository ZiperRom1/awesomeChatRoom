<?php
/**
 * Room entity
 *
 * @package    Entity
 * @author     Romain Laneuville <romain.laneuville@hotmail.fr>
 */

namespace classes\entities;

use \abstracts\Entity as Entity;
use \classes\entitiesCollection\RoomBanCollection as RoomBanCollection;
use classes\websocket\ClientCollection as ClientCollection;

/**
 * Room entity that extends the Entity abstact class
 *
 * @property   int     $id            The chat room id
 * @property   string  $name          The chat room name
 * @property   int     $creator       The creator id user
 * @property   int     $password      The room password
 * @property   string  $creationDate  The room creation date
 * @property   int     $maxUsers      The room max users number
 *
 * @todo       PHP7 defines object return OR null with method(...): ?Class
 * @see        https://wiki.php.net/rfc/nullable_types
 * @see        https://wiki.php.net/rfc/union_types
 */
class Room extends Entity
{
    use \traits\PrettyOutputTrait;

    /**
     * @var        RoomBanCollection  $roomBanCollection    Collection of banned users
     */
    private $roomBanCollection;
    /**
     * @var        ClientCollection  $clients   The clients connected to the room
     */
    private $clients;
    /**
     * @var        array  $pseudonyms   The clients pseudonym
     */
    private $pseudonyms;

    /*=====================================
    =            Magic methods            =
    =====================================*/

    /**
     * Constructor that calls the parent Entity constructor
     *
     * @param      array  $data   Array($columnName => $value) pairs to set the object DEFAULT null
     */
    public function __construct(array $data = null)
    {
        parent::__construct('Room');

        if ($data !== null) {
            $this->setAttributes($data);
        }

        $this->roomBanCollection = new RoomBanCollection();
        $this->clients           = new ClientCollection();
        $this->pseudonyms        = [];
    }

    /**
     * Room string representation
     *
     * @return     string  The Room string representation
     */
    public function __toString(): string
    {
        return parent::__toString() . PHP_EOL
            . $this->roomBanCollection . PHP_EOL
            . $this->clients . PHP_EOL
            . 'pseudonyms => ' . static::prettyArray($this->pseudonyms) . PHP_EOL;
    }

    /**
     * Room array representation
     *
     * @return     array  The Room array representation
     */
    public function __toArray(): array
    {
        return array_merge(parent::__toArray(), [
            'roomBan'    => $this->roomBanCollection->__toArray(),
            'clients'    => $this->clients->__toArray(),
            'pseudonyms' => $this->pseudonyms
        ]);
    }

    /*-----  End of Magic methods  ------*/

    /*======================================
    =            Public methods            =
    ======================================*/

    /**
     * Get the uers banned collection
     *
     * @return     RoomBanCollection  The users banned collection
     */
    public function getRoomBanCollection(): RoomBanCollection
    {
        return $this->roomBanCollection;
    }

    /**
     * Set the uers banned collection
     *
     * @param      RoomBanCollection  $roomBanCollection  The users banned collection
     */
    public function setRoomBanCollection(RoomBanCollection $roomBanCollection)
    {
        $this->roomBanCollection = $roomBanCollection;
    }

    /**
     * Get the clients
     *
     * @return     ClientCollection  The connected Clients
     */
    public function getClients(): ClientCollection
    {
        return $this->clients;
    }

    /**
     * Set the clients
     *
     * @param      ClientCollection  $clients  The connected Clients
     */
    public function setClients(ClientCollection $clients)
    {
        $this->clients = $clients;
    }

    /**
     * Get the room pseudonyms
     *
     * @return     array  The room pseudonyms
     */
    public function getPseudonyms(): array
    {
        return $this->pseudonyms;
    }

    /**
     * Get the room basic attributes only
     *
     * @return     array  The room basic attributes only
     */
    public function getRoomBasicAttributes()
    {
        return parent::__toArray();
    }

    /*=====  End of Public methods  ======*/
}
