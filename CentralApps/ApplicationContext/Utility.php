<?php
namespace CentralApps\ApplicationContext;

// TODO: having a utility class is a bit shitty, this should be refactored into something else...
class Utility 
{
	
	protected $dependencyInjectionContainer;
	protected $reservedAccountNames = array();
	protected $serverName = '';
	protected $domainName = '';
	
	public function __construct()
	{

	}
	
	public function setServerName($server_name)
	{
		$this->serverName = $server_name;
	}
	
	public function setDomainName($domain_name)
	{
		$this->domainName = $domain_name;
	}
	
	public function isApplication()
	{
		$account_reference = $this->getAccountReference();
		return ! $this->isReservedAccountReference($account_reference);
	}
	
	public function getAccountReference()
	{
		return str_replace('.' . $this->domainName, '', $this->serverName);
	}
	
	public function setReservedAccountNames($reserved_account_names)
	{
		$this->reservedAccountNames = $reserved_account_names;
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