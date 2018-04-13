<?php

namespace Database\Model;

abstract class AbstractModel
{
	/**
	 * @param array $data
	 * @return void
	 */
	abstract public function exchangeArray(array $data);

	/**
	 * @return array
	 */
	abstract public function toArray();
}