<?php
/**
 * Abstract Collection entity pattern
 *
 * @package    Abstract
 * @author     Romain Laneuville <romain.laneuville@hotmail.fr>
 */

namespace abstracts;

use classes\ExceptionManager as Exception;
use traits\PrettyOutputTrait as PrettyOutputTrait;

/**
 * Abstract Collection pattern to use with Entity pattern
 *
 * @abstract
 *
 * @todo       PHP7 defines object return OR null with method(...): ?Class
 * @see        https://wiki.php.net/rfc/nullable_types
 * @see        https://wiki.php.net/rfc/union_types
 */
abstract class EntityCollection implements \Iterator, \ArrayAccess, \Countable, \SeekableIterator
{
    use PrettyOutputTrait;

    /**
     * @var        Entity[]  $collection    An array of entity object
     */
    protected $collection = [];
    /**
     * @var        int[]|string[]  $indexId     An array of entity id key
     */
    protected $indexId = [];
    /**
     * @var        int  $current    Current position of the pointer in the $collection
     */
    protected $current = 0;

    /*=====================================
    =            Magic methods            =
    =====================================*/

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Return the collection in an array format
     *
     * @return     array  Array with all the entities attributes
     */
    public function __toArray(): array
    {
        $arrayCollection = $this->collection;

        foreach ($this->collection as $key => $entity) {
            $arrayCollection[$key] = $entity->__toArray();
        }

        return $arrayCollection;
    }

    /**
     * Pretty print the Collection
     *
     * @return     string  String output
     */
    public function __toString(): string
    {
        $string = PHP_EOL . 'Collection of (' . $this->count() . ') '
            . str_replace('Collection', '', get_class($this))
            . ' entity' . PHP_EOL . implode(array_fill(0, 116, '-')) . PHP_EOL;

        foreach ($this->collection as $entity) {
            $string .= $entity . implode(array_fill(0, 116, '-')) . PHP_EOL;
        }

        return $string;
    }

    /*-----  End of Magic methods  ------*/

    /*======================================
    =            Public methods            =
    ======================================*/

    /**
     * Add an entity at the end of the collection
     *
     * @param      Entity     $entity  The entity object
     * @param      string     $key     A key to save the entity DEFAULT null (auto generated)
     *
     * @throws     Exception  If the entity id is already in the collection
     */
    public function add($entity, $key = null)
    {
        $id = $key ?? $this->parseId($entity->getIdValue());

        if (array_key_exists($id, $this->indexId)) {
            throw new Exception(
                'This entity is already in the collection ' . $this,
                Exception::$WARNING
            );
        } else {
            $this->collection[] = $entity;
            $this->indexId[$id] = $this->count() - 1;
        }
    }

    /**
     * Remove an entity from the collection
     *
     * @param      Entity  $entity  The entity
     *
     * @throws     Exception  If the entity is not already in the collection
     */
    public function remove($entity)
    {
        $id = $this->parseId($entity->getIdValue());

        if (!array_key_exists($id, $this->indexId)) {
            throw new Exception(
                'This entity is not already in the collection ' . $this,
                Exception::$WARNING
            );
        }

        $index = $this->indexId[$id];
        unset($this->indexId[$id]);
        unset($this->collection[$index]);
    }

    /**
     * Set an entity which is already in the collection
     *
     * @param      Entity     $entity  The entity object
     * @param      string     $key     A key to save the entity DEFAULT null (auto generated)
     *
     * @throws     Exception  If the entity id is not already in the collection
     */
    public function set($entity, $key = null)
    {
        $id = $key ?? $this->parseId($entity->getIdValue());

        if (!array_key_exists($id, $this->indexId)) {
            throw new Exception(
                'This entity id(' . static::formatVariable($id) .') is not already in the collection ' . $this,
                Exception::$WARNING
            );
        } else {
            $this->collection[$this->indexId[$id]] = $entity;
        }
    }

    /**
     * Get an entity by its ID or null if there is no entity at the given id
     *
     * @param      mixed        $entityId  The entity id(s) in a array
     *
     * @return     Entity|null  The entity
     */
    public function getEntityById($entityId)
    {
        $entity = null;
        $id     = $this->parseId($entityId);

        if (array_key_exists($id, $this->indexId)) {
            $entity = $this->collection[$this->indexId[$id]];
        }

        return $entity;
    }

    /**
     * Get an entity by its index or null if there is no entity at the given index
     *
     * @param      int|string  $index  The entity index in the Collection
     *
     * @return     Entity|null      The entity
     */
    public function getEntityByIndex($index)
    {
        $entity = null;

        if (isset($this->collection[$index])) {
            $entity = $this->collection[$index];
        }

        return $entity;
    }

    /*==========  Iterator interface  ==========*/

    /**
     * Returns the current element
     *
     * @return     Entity  The current entity
     */
    public function current()
    {
        return $this->collection[$this->current];
    }

    /**
     * Returns the key of the current entity
     *
     * @return     int|null  Returns the key on success, or NULL on failure
     */
    public function key()
    {
        return $this->current;
    }

    /**
     * Moves the current position to the next element
     */
    public function next()
    {
        $this->current++;
    }

    /**
     * Rewinds back to the first element of the Iterator
     */
    public function rewind()
    {
        $this->current = 0;
    }

    /**
     * Checks if current position is valid
     *
     * @return     bool  Returns true on success or false on failure
     */
    public function valid()
    {
        return isset($this->collection[$this->current]);
    }

    /*==========  ArrayAccess interface  ==========*/

    /**
     * Whether an offset exists
     *
     * @param      int|string  $offset  An offset to check for
     *
     * @return     bool        True if the offset exists, else false
     */
    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
    }

    /**
     * Returns the entity at specified offset
     *
     * @param      int|string  $offset  The offset to retrieve
     *
     * @return     Entity      Return the matching entity
     */
    public function offsetGet($offset)
    {
        return $this->collection[$offset];
    }

    /**
     * Assigns an entity to the specified offset
     *
     * @param      int|string  $offset  The offset to assign the entity to
     * @param      Entity      $entity  The entity to set
     */
    public function offsetSet($offset, $entity)
    {
        $this->collection[$offset] = $entity;
    }

    /**
     * Unset an offset
     *
     * @param      int|string  $offset  The offset to unset
     */
    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    /*==========  Countable interface  ==========*/

    /**
     * Count elements of an object
     *
     * @return     int   The custom count as an integer
     */
    public function count()
    {
        return count($this->collection);
    }

    /*==========  SeekableIterator interface  ==========*/

    /**
     * Seeks to a position
     *
     * @param      int        $position  The position to seek to
     *
     * @throws     Exception  If the position is not seekable
     *
     * @todo PHP7 type int $position not possible
     */
    public function seek($position)
    {
        if (!isset($this->collection[$position])) {
            throw new Exception('There is no data in this iterator at index ' . $position, Exception::$ERROR);
        } else {
            $this->current = $position;
        }
    }

    /*-----  End of Public methods  ------*/

    /*======================================
    =            Private method            =
    ======================================*/

    /**
     * Parse the id(s) sent to transform it in a string if the id is on multiple columns
     *
     * @param      mixed   $id     The id(s) in an array
     *
     * @return     string  The id(s) key
     */
    private function parseId($id): string
    {
        if (is_array($id)) {
            $id = static::md5Array($id);
        }

        return $id;
    }

    /*-----  End of Private method  ------*/
}
