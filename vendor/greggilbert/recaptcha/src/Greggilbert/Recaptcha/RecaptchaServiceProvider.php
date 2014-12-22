<?php namespace Greggilbert\Recaptcha;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;

/**
 * Service provider for the Recaptcha class
 * 
 * @author     Greg Gilbert
 * @link       https://github.com/greggilbert

 */
class RecaptchaServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('greggilbert/recaptcha');
		
		$this->addValidator();
		$this->addFormMacro();
	}
	
	/**
	 * Extends Validator to include a recaptcha type
	 */
	public function addValidator()
	{
		$validator = $this->app['Validator'];
		
		$validator::extend('recaptcha', function($attribute, $value, $parameters)
		{
			$challenge = app('Input')->get('recaptcha_challenge_field');
			
			$captcha = new CheckRecaptcha;
			list($passed, $response) = $captcha->check($challenge, $value);
			
			if('true' == trim($passed))
				return true;
			
			return false;
		});
	}
	
	/**
	 * Extends Form to include a recaptcha macro
	 */
	public function addFormMacro()
	{
		app('form')->macro('captcha', function($options = array())
		{
			$configOptions = app('config')->get('recaptcha::options', array());
			
			$mergedOptions = array_merge($configOptions, $options);
			
			$data = array(
				'public_key'	=> app('config')->get('recaptcha::public_key'),
				'options'		=> $mergedOptions,
			);
			
			if(array_key_exists('lang', $mergedOptions) && "" != trim($mergedOptions['lang']))
			{
				$data['lang'] = $mergedOptions['lang'];
			}
			
			$view = 'recaptcha::captcha';
			
			$configTemplate = app('config')->get('recaptcha::template', '');
			
			if(array_key_exists('template', $options))
			{
				$view = $options['template'];
			}
			elseif("" !== trim($configTemplate))
			{
				$view = $configTemplate;
			}
						
			return app('view')->make($view, $data);
		});
	}
	

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		
	}

}