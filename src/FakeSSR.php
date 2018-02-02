<?php
namespace byn9826\FakeSSR;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class FakeSSR {
	
	public static function detect($address, $expire = false, $cache_path = null) {
		$CrawlerDetect = new CrawlerDetect;
    if($CrawlerDetect->isCrawler()) {
			$html = self::render($address, $expire, $cache_path);
			echo $html;
			exit;
		}
		
	}
	
	private static function render($address, $expire, $cache_path) {
		if ($expire === 0) {
			return self::crawl($address, $expire, null);
		} else if ($expire !== 0) {
			$file_path = $cache_path . '/__' . str_replace('/', '', $address) . '__.html';
			if (!file_exists($file_path) || !self::check($file_path, $expire)) {
				return self::crawl($address, $expire, $file_path);
			} else {
				return file_get_contents($file_path);
			}
		}
	}
	
	public static function check($file_path, $expire) {
		if (!$expire) {
			return true;
		}
		return time() < filemtime($file_path) + $expire * 60;
	}
	
	public static function crawl($address, $expire, $file_path) {
		$cmd = 'google-chrome --headless --disable-gpu --dump-dom --no-sandbox --window-size=1280,1696 ';
		$cmd .= $address . '; echo $?';
		$content = shell_exec($cmd);
		$content = substr($content, 0, -2);
		$dom = new \DOMDocument();
		$dom->loadHTML($content);
		$script = $dom->getElementsByTagName('script');
		$remove = [];
		foreach ($script as $item) {
			$remove[] = $item;
		}
		foreach ($remove as $item) {
			$item->parentNode->removeChild($item); 
		}
		$html = $dom->saveHTML();
		if ($expire !== 0) {
			file_put_contents($file_path, $html);
		}
		return $html;
	}
	
}