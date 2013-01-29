# Application Context Processor

This component is designed for use in application which make use of subdomains to segregate data / accounts.  

For example, if you have the domain mydomain.com and one of your customers logs in and uses the application via customername.mydomain.com, this component makes it easy to lookup those customers details, and to determine what "context" the application is running in (account context or not).  This lets you route and manage the application correctly.

## Installation

Add the project to your composer.json file

	{
		"require": {
        	"mattkirwan/temp-token": "1.0.*"
    	}
    }
    
Install the project

	php composer.phar update

## Usage

1. Create an account factory, which implements LookupInterface, this is used to take an account reference and create an account object. Application specific code.
2. Create an account context object, pass the server name, the domain name and the account factory
3. The context will then setup, and store a reference for the account

	$account_context = new \CentralApps\ApplicationContext\Context($_SERVER['SERVER_NAME'], 'mydomain.com', $account_factory);

4. You can check to see if the application is being ran as an 'account context'

	$account_context->isAccountContext(); // returns true or false
	
5. You can also check to see if the account context is valid (that the subdomain matches a real account)

	$account_context->isValidReference();
	
6. Finally, you can get the account object, which is retrieved via your pre-defined account factory

	$account = $account_context->getAccount(); // null if not valid
