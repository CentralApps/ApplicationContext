<?php
namespace CentralApps\ApplicationContext;

class Context 
{	
	protected $accountReference = null;
	protected $utility;
	protected $accountFactory = null;
	protected $account = null;
	
	public function __construct($server_name, $application_domain, LookupInterface $account_factory=null, $reserved_names=array('www'), Utility $utility=null)
	{
		$this->accountFactory = $account_factory;
		$this->utility = (!is_null($utility)) ? $utility : new Utility();
		$this->utility->setReservedAccountNames($reserved_names);
		$this->utility->setServerName($server_name);
		$this->utility->setApplicationDomain($application_domain);
		$this->accountReference = $this->utility->getAccountReference();
	}
	
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
