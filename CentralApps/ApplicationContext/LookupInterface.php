<?php
namespace CentralApps\ApplicationContext;

interface LookupInterface
{
	/**
	 * Lookup a single account from the database, using the provided reference
	 * @param string $reference
	 * @return object
	 */
	public function lookupSingleAccountByReference($reference);
}
