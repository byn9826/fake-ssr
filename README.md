Fake SSR
--
Feed web crawlers on rendered HTML for JavaScript rendering pages.  
Users will visit the page normally while web crawlers will directly get already rendered HTML.  

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
composer require "byn9826/fake-ssr:dev-master"
```
Usage
--
In default controller default action (Handle all the traffic here).  
```
use byn9826\FakeSSR\FakeSSR;

class IndexController extends ControllerBase {

  public function indexAction() {
    //$cache_folder is the location of the folder used to cache rendered HTML  
    //make sure www-data could execute in this folder    
    //$cache_folder could be null if $expire is 0  
    $cache_folder = dirname(__dir__) . '/.ssr';  
		  
    //$expire is the cache expiring time. 
    //Default value is false, means never expire.   
    //0 means never use cache.   
    //1 means cache for 1 min, 10 means cache for 10 min, 100 means cache for 100 min, etc
    $expire = 0;
    
    FakeSSR::detect($url, $cache_folder, $expire);

    //Render the index.html for the single page application  
    include(dirname(__dir__) . '/frontend/index.html');
		
  }

}
```

Before fake ssr  
--
![before fake ssr](https://github.com/byn9826/fake-ssr/blob/master/~legend/1.jpg?raw=true)
	
After fake ssr  
--
![after fake ssr](https://github.com/byn9826/fake-ssr/blob/master/~legend/2.jpg?raw=true)
