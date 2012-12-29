<?php

namespace dayax\collections;

/**
 * QueueIterator class
 *
 * QueueIterator implements Iterator interface.
 *
 * QueueIterator is used by Queue. It allows Queue to return a new iterator
 * for traversing the items in the queue.
 *
 * @author Anthonius Munthi <me@itstoni.com>
 * @author Qiang Xue <qiang.xue@gmail.com>
 */
class QueueIterator implements \Iterator
{
    /**
     * @var array the data to be iterated through
     */
    private $_d;
    /**
     * @var integer index of the current item
     */
    private $_i;
    /**
     * @var integer count of the data items
     */
    private $_c;

    /**
     * Constructor.
     * @param array the data to be iterated through
     */
    public function __construct(&$data)
    {
        $this->_d=&$data;
        $this->_i=0;
        $this->_c=count($this->_d);
    }

    /**
     * Rewinds internal array pointer.
     * This method is required by the interface Iterator.
     */
    public function rewind()
    {
        $this->_i=0;
    }

    /**
     * Returns the key of the current array item.
     * This method is required by the interface Iterator.
     * @return integer the key of the current array item
     */
    public function key()
    {
        return $this->_i;
    }

    /**
     * Returns the current array item.
     * This method is required by the interface Iterator.
     * @return mixed the current array item
     */
    public function current()
    {
        return $this->_d[$this->_i];
    }

    /**
     * Moves the internal pointer to the next array item.
     * This method is required by the interface Iterator.
     */
    public function next()
    {
        $this->_i++;
    }

    /**
     * Returns whether there is an item at current position.
     * This method is required by the interface Iterator.
     * @return boolean
     */
    public function valid()
    {
        return $this->_i<$this->_c;
    }
}