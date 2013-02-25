<?php
namespace CentralApps\ApplicationContext;

class Context 
{	
	protected $accountReference = null;
	protected $utility;
	protected $accountFactory = null;
	protected $account = null;
	
	/**
	 * Constructor
	 * @param string $server_name the name of the server, typically $_SERVER['SERVER_NAME']
	 * @param string $application_domain the domain name used by the application
	 * @param LookupInterface $account_factory the application specific account factory
	 * @param array $reserved_names an array of reserved subdomains / account names [optional]
	 * @param Utility $utility optional utility class if we want to inject one [optional]
	 */
	public function __construct($server_name, $application_domain, LookupInterface $account_factory=null, $reserved_names=array('www'), Utility $utility=null)
	{
		$this->accountFactory = $account_factory;
		$this->utility = (!is_null($utility)) ? $utility : new Utility();
		$this->utility->setReservedAccountNames($reserved_names);
		$this->utility->setServerName($server_name);
		$this->utility->setDomainName($application_domain);
		$this->accountReference = $this->utility->getAccountReference();
	}
	
	/**
	 * Get the application context reference string
	 * @return String
	 */
	public function getApplicationContextReference()
	{
		return $this->utility->getAccountReference();
	}
	
	/**
	 * Based off the server name, check if we are running in account context or not
	 * @return bool
	 */
	public function isAccountContext()
	{
		return ! $this->utility->isReservedAccountReference($this->accountReference);
	}
	
	private function lookupAccount()
	{
		try{
			$this->account = $this->accountFactory->lookupSingleAccountByReference($this->reference);
		} catch(\Exception $e) {
			throw $e;
		}
	}
	
	/**
	 * Check if the account reference is valid
	 * @return bool
	 */
	public function isValidReference()
	{
		if($this->isAccountContext() && is_null($this->account)) {
			try {
				$this->lookupAccount();
			} catch(\Exception $e) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Get the account object related to the account reference
	 * The account object is looked up using the account factory passed to the class
	 * @return mixed object if valid account, otherwise null
	 */
	public function getAccount()
	{
		// TODO: remove duplication between this and the isValidReference method
		// TODO: throw exceptions depending on account state? (thought required)
		if($this->isAccountContext() && is_null($this->account)) {
			try {
				$this->lookupAccount();
			} catch(\Exception $e) {
				// don't do anything - returning the null account is fine
			}
		}
		return $this->account;
	}
	
	
	
}
