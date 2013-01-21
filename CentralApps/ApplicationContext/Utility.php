<?php
namespace CentralApps\ApplicationContext;

// TODO: having a utility class is a bit shitty, this should be refactored into something else...
class Utility 
{
	
	protected $dependencyInjectionContainer;
	protected $reservedAccountNames = array();
	
	public function __construct( $dependency_injection_container )
	{
		$this->dependencyInjectionContainer = $dependency_injection_container;
	}
	
	public function isApplication($server_name)
	{
		$account_reference = $this->getAccountReferenceFromServerName($server_name);
		return ! $this->isReservedAccountReference($account_reference);
	}
	
	public function getAccountReferenceFromServerName($server_name)
	{
		// TODO: implement
	}
	
	public function isReservedAccountReference( $account_reference )
	{
		return in_array($account_reference, $this->reservedAccountNames);
	}
	
	public function getAccount($server_name)
	{
		$subdomain = $this->getSubdomain($server_name);
	}
		
}