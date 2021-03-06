<?php

/*
 * This file is part of the dayax package.
 *
 * (c) Anthonius Munthi <me@itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace dayax\collections;


use dayax\core\Component;

/**
 * Stack class
 *
 * Stack implements a stack.
 *
 * The typical stack operations are implemented, which include
 * {@link push()}, {@link pop()} and {@link peek()}. In addition,
 * {@link contains()} can be used to check if an item is contained
 * in the stack. To obtain the number of the items in the stack,
 * check the {@link getCount Count} property.
 *
 * Items in the stack may be traversed using foreach as follows,
 * <code>
 * foreach($stack as $item) ...
 * </code>
 *
 * @author Anthonius Munthi <me@itstoni.com>
 */
class Stack extends Component implements \IteratorAggregate,\Countable
{
	/**
	 * internal data storage
	 * @var array
	 */
	private $_d=array();
	/**
	 * number of items
	 * @var integer
	 */
	private $_c=0;

	/**
	 * Constructor.
	 * Initializes the stack with an array or an iterable object.
	 * @param array|Iterator the initial data. Default is null, meaning no initialization.
	 * @throws InvalidDataTypeException If data is not null and neither an array nor an iterator.
	 */
	public function __construct($data=null)
	{
		if($data!==null)
			$this->copyFrom($data);
	}

	/**
	 * @return array the list of items in stack
	 */
	public function toArray()
	{
		return $this->_d;
	}

	/**
	 * Copies iterable data into the stack.
	 * Note, existing data in the list will be cleared first.
	 * @param mixed the data to be copied from, must be an array or object implementing Traversable
	 * @throws InvalidDataTypeException If data is neither an array nor a Traversable.
	 */
	public function copyFrom($data)
	{
		if(is_array($data) || ($data instanceof Traversable))
		{
			$this->clear();
			foreach($data as $item)
			{
				$this->_d[]=$item;
				++$this->_c;
			}
		}
		else if($data!==null)
			throw new InvalidDataTypeException('stack_data_not_iterable');
	}

	/**
	 * Removes all items in the stack.
	 */
	public function clear()
	{
		$this->_c=0;
		$this->_d=array();
	}

	/**
	 * @param mixed the item
	 * @return boolean whether the stack contains the item
	 */
	public function contains($item)
	{
		return array_search($item,$this->_d,true)!==false;
	}

	/**
	 * Returns the item at the top of the stack.
	 * Unlike {@link pop()}, this method does not remove the item from the stack.
	 * @return mixed item at the top of the stack
	 * @throws InvalidOperationException if the stack is empty
	 */
	public function peek()
	{
		if($this->_c===0)
			throw new InvalidOperationException('stack_empty');
		else
			return $this->_d[$this->_c-1];
	}

	/**
	 * Pops up the item at the top of the stack.
	 * @return mixed the item at the top of the stack
	 * @throws InvalidOperationException if the stack is empty
	 */
	public function pop()
	{
		if($this->_c===0)
			throw new InvalidOperationException('stack_empty');
		else
		{
			--$this->_c;
			return array_pop($this->_d);
		}
	}

	/**
	 * Pushes an item into the stack.
	 * @param mixed the item to be pushed into the stack
	 */
	public function push($item)
	{
		++$this->_c;
		$this->_d[] = $item;
	}

	/**
	 * Returns an iterator for traversing the items in the stack.
	 * This method is required by the interface IteratorAggregate.
	 * @return Iterator an iterator for traversing the items in the stack.
	 */
	public function getIterator()
	{
		return new \ArrayIterator( $this->_d );
	}

	/**
	 * @return integer the number of items in the stack
	 */
	public function getCount()
	{
		return $this->_c;
	}

	/**
	 * Returns the number of items in the stack.
	 * This method is required by Countable interface.
	 * @return integer number of items in the stack.
	 */
	public function count()
	{
		return $this->getCount();
	}
}