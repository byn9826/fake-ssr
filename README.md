Fake SSR
--
Feed web crawler robots on rendered HTML by PHP

Prerequisite
--
Install Google Chrome
```
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i google-chrome-stable_current_amd64.deb
sudo apt-get -f install
```
Installation
--
```
composer require "byn9826/fake-ssr:*"
```
Usage
--
In any controller, in any action you need to fool web crawlers.
```
use byn9826\FakeSSR\FakeSSR;

class TestController extends ControllerBase {

  public function indexAction() {
	
    //The matched url for this action
		$url = 'https://smilings.me'; 
		//The folder used to cache rendered HTML
			//Could be null if $expire is 0
		$cache_folder = dirname(__dir__) . '/.ssr';  
		//Cache expiring time. 
			//Default false: never expire. 0 means never use cache. 
			//1 means cache for 1 min, 10 means cache for 10 min, 100 means cache for 100 min, etc
		$expire = 0;
    FakeSSR::detect($url, $cache_folder,0);

		...
		//Don't need to modify any existing codes
		
  }

}
```
