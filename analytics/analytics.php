<?php 

	$analytics_folder = 'analytics';
	$user_agent  = $_SERVER['HTTP_USER_AGENT'];
	$visitor_time = date('m/d/Y h:i:s a', time());
	$visitor_date = date('Ymd');

	// Basic functions
	function create_folder($path) {
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		return $path;
	}

	// Get user system info functions
	function getDevice() { 
    	global $user_agent;
    	$device = "Unknown Device";
    	$device_array = array(
    		'/windows nt 10/i'     =>  'Desktop',
    		'/windows nt 6.3/i'     =>  'Desktop',
    		'/windows nt 6.2/i'     =>  'Desktop',
    		'/windows nt 6.1/i'     =>  'Desktop',
    		'/windows nt 6.0/i'     =>  'Desktop',
    		'/windows nt 5.2/i'     =>  'Server',
    		'/windows nt 5.1/i'     =>  'Desktop',
    		'/windows xp/i'         =>  'Desktop',
    		'/windows nt 5.0/i'     =>  'Desktop',
    		'/windows me/i'         =>  'Desktop',
    		'/win98/i'              =>  'Desktop',
    		'/win95/i'              =>  'Desktop',
    		'/win16/i'              =>  'Desktop',
    		'/macintosh|mac os x/i' =>  'Desktop',
    		'/mac_powerpc/i'        =>  'Desktop',
    		'/linux/i'              =>  'Desktop',
    		'/ubuntu/i'             =>  'Desktop',
    		'/iphone/i'             =>  'Phone',
    		'/ipod/i'               =>  'Phone',
    		'/ipad/i'               =>  'Tablet',
    		'/android/i'            =>  'Phone',
    		'/blackberry/i'         =>  'Phone',
    		'/webos/i'              =>  'Other'
    	);

    	foreach ($device_array as $regex => $value) { 
    		if (preg_match($regex, $user_agent)) {
    			$device = $value;
    		}
    	} 

    	return $device;
	}

	function getOS() { 
		global $user_agent;

		$os_platform = "Unknown OS";
		$os_array = array(
			'/windows nt 10/i'     =>  'Windows',
			'/windows nt 6.3/i'     =>  'Windows',
			'/windows nt 6.2/i'     =>  'Windows',
			'/windows nt 6.1/i'     =>  'Windows',
			'/windows nt 6.0/i'     =>  'Windows',
			'/windows nt 5.2/i'     =>  'Windows',
			'/windows nt 5.1/i'     =>  'Windows',
			'/windows xp/i'         =>  'Windows',
			'/windows nt 5.0/i'     =>  'Windows',
			'/windows me/i'         =>  'Windows',
			'/win98/i'              =>  'Windows',
			'/win95/i'              =>  'Windows',
			'/win16/i'              =>  'Windows',
			'/macintosh|mac os x/i' =>  'Mac OS',
			'/mac_powerpc/i'        =>  'Mac OS',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Linux',
			'/iphone/i'             =>  'iOS',
			'/ipod/i'               =>  'iOS',
			'/ipad/i'               =>  'iOS',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'Other',
			'/webos/i'              =>  'Other'
		);

		foreach ($os_array as $regex => $value) { 
			if (preg_match($regex, $user_agent)) {
				$os_platform = $value;
			}
		}   

		return $os_platform;
	}
	
	function getBrowser() {
    	global $user_agent;
    	$browser = "Unknown Browser";

    	$browser_array = array(
    		'/msie/i' =>  'Internet Explorer',
    		'/firefox/i' => 'Firefox',
    		'/safari/i' => 'Safari',
    		'/chrome/i' => 'Chrome',
    		'/opera/i' => 'Other',
    		'/edge/i' => 'Other',
    		'/netscape/i' => 'Other',
    		'/maxthon/i' => 'Other',
    		'/konqueror/i' => 'Other',
    		'/mobile/i' => 'Mobile'
    	);

    	foreach ($browser_array as $regex => $value) { 
    		if (preg_match($regex, $user_agent)) {
            	$browser = $value;
        	}
   	 	}

    	return $browser;
	}


	// Create analytics folders
	// ------------------------
	$realtime_analytics_folder = create_folder($analytics_folder . '/realtime/');

	$realtime_analytics_visitors_folder = create_folder($realtime_analytics_folder . 'visitors/');
	$realtime_analytics_pageviews_folder = create_folder($realtime_analytics_folder . 'pageviews/');
	
	$visitors_analytics_folder = create_folder($analytics_folder . '/visitors/');
	$pageviews_analytics_folder = create_folder($analytics_folder . '/pageviews/');
	$stats_analytics_folder = create_folder($analytics_folder . '/stats/');
	
	$stats_analytics_visitors_folder = create_folder($stats_analytics_folder . 'visitors/');
	$stats_analytics_pageviews_folder = create_folder($stats_analytics_folder . 'pageviews/');
	
	$stats_analytics_pages_folder = create_folder($stats_analytics_folder . 'pages/');
	$stats_analytics_pages_day_folder = create_folder($stats_analytics_pages_folder . $visitor_date . '/');
	$stats_analytics_pages_total_folder = create_folder($stats_analytics_pages_folder . 'total/');
	
	$stats_analytics_referrers_folder = create_folder($stats_analytics_folder . 'referrers/');
	$stats_analytics_referrers_day_folder = create_folder($stats_analytics_referrers_folder . $visitor_date . '/');
	$stats_analytics_referrers_total_folder = create_folder($stats_analytics_referrers_folder . 'total/');
	
	$stats_analytics_countries_folder = create_folder($stats_analytics_folder . 'countries/');
	$stats_analytics_countries_day_folder = create_folder($stats_analytics_countries_folder . $visitor_date . '/');
	$stats_analytics_countries_total_folder = create_folder($stats_analytics_countries_folder . 'total/');
	
	$stats_analytics_devices_folder = create_folder($stats_analytics_folder . 'devices/');
	$stats_analytics_devices_day_folder = create_folder($stats_analytics_devices_folder . $visitor_date . '/');
	$stats_analytics_devices_total_folder = create_folder($stats_analytics_devices_folder . 'total/');
	
	$stats_analytics_oss_folder = create_folder($stats_analytics_folder . 'oss/');
	$stats_analytics_oss_day_folder = create_folder($stats_analytics_oss_folder . $visitor_date . '/');
	$stats_analytics_oss_total_folder = create_folder($stats_analytics_oss_folder . 'total/');
	
	$stats_analytics_browsers_folder = create_folder($stats_analytics_folder . 'browsers/');
	$stats_analytics_browsers_day_folder = create_folder($stats_analytics_browsers_folder . $visitor_date . '/');
	$stats_analytics_browsers_total_folder = create_folder($stats_analytics_browsers_folder . 'total/');
	
	// Calculate analytics data
	// ------------------------
	
	// Get visitor data

	$visitor_ip = $_SERVER['REMOTE_ADDR'];
	$visitor_url = $_GET['url'];
	$visitor_referrer = $_GET['referrer'];
	$visitor_device = getDevice();
	$visitor_os = getOS();
	$visitor_browser = getBrowser();
	
	// Get ip information
	if (function_exists('curl_version')) {
   		$curl = curl_init();  
    	curl_setopt($curl, CURLOPT_URL, 'http://ip-api.com/json/' . $visitor_ip);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    	$visitor_ip_info = json_decode(curl_exec($curl),true);
    	curl_close($curl);
	} else {
		$visitor_ip_info = json_decode(file_get_contents('http://ip-api.com/json/' . $visitor_ip),true);
	}
	
	$visitor_country = $visitor_ip_info['country'];
	$visitor_region = $visitor_ip_info['regionName'];
	$visitor_city = $visitor_ip_info['city'];
	$visitor_timezone = $visitor_ip_info['timezone'];
	
	// Get current page information
	$visitor_current_base = str_replace('www.', '', str_replace('http://', '', str_replace('<!-- ', '', str_replace(' -->', '', $visitor_url))));
	$visitor_current_url = substr($visitor_current_base,0,strpos($visitor_current_base, "/"));
	$visitor_current_page = str_replace($visitor_current_url, '', $visitor_current_base);
	$visitor_current_page = rtrim($visitor_current_page, '/');
	$visitor_current_page = substr($visitor_current_page,strpos($visitor_current_page, "/")+1);

	// Get referrer page information
	$visitor_referrer_base = str_replace('www.', '', str_replace('http://', '', str_replace('<!-- ', '', str_replace(' -->', '', $visitor_referrer))));
	$visitor_referrer_url = substr($visitor_referrer_base,0,strpos($visitor_referrer_base, "/"));
	$visitor_referrer_page = str_replace($visitor_referrer_url, '', $visitor_referrer_base);
	$visitor_referrer_page = rtrim($visitor_referrer_page, '/');
	$visitor_referrer_page = substr($visitor_referrer_page,strpos($visitor_referrer_page, "/")+1);

	// Visitor ID
	$visitor_id = ($value = file($stats_analytics_pageviews_folder . 'total')) ? ($value[0]+1) : 0;
	// Analytics data
	$analytics_content = "
	<div class=\"analyticstry\">
		<div class=\"analytics_stat\">" . $visitor_id . "</div>
		<div class=\"analytics_stat\">" . $visitor_time . "</div>
		<div class=\"analytics_stat\">" . $visitor_country . "</div>
		<div class=\"analytics_stat\">" . $visitor_region . "</div>
		<div class=\"analytics_stat\">" . $visitor_city . "</div>
		<div class=\"analytics_stat\">" . $visitor_timezone . "</div>
		<div class=\"analytics_stat\">" . $visitor_current_page . "</div>
		<div class=\"analytics_stat\">" . $visitor_referrer_base . "</div>
		<div class=\"analytics_stat\">" . $visitor_device . "</div>
		<div class=\"analytics_stat\">" . $visitor_os . "</div>
		<div class=\"analytics_stat\">" . $visitor_browser . "</div>
		<div class=\"analytics_stat\">" . $visitor_ip . "</div>
	</div>";

	// Tempo Real Saida
	$realtime_content = "<tr><td>" . $visitor_ip . "</td><td>" .  $visitor_os . "</td><td>" . $visitor_device . "</td><td>" . $visitor_browser . "</td><td>" . $visitor_country . "</td><td>" . $visitor_city . "</td><td>" . $visitor_current_page . "</td><td>" . $visitor_referrer_url . "</td></tr>"; 
	
	// Write analytics data
	// --------------------
	
	// Realtime analytics
	$realtime_visitor_file = $realtime_analytics_visitors_folder . $visitor_ip;
	$realtime_visitor_writer = fopen($realtime_visitor_file , "w+");
	fputs($realtime_visitor_writer , $realtime_content);
	fclose($realtime_visitor_writer);
	
	$realtime_pageview_file = $realtime_analytics_pageviews_folder . $visitor_id;
	$realtime_pageview_writer = fopen($realtime_pageview_file , "w+");
	fputs($realtime_pageview_writer , "pageview");
	fclose($realtime_pageview_writer);

	// Visitor analytics
	$visitors_analytics_file = $visitors_analytics_folder . $visitor_date;
	$stats_visitors_analytics_file = $stats_analytics_visitors_folder . $visitor_date;
	$stats_visitors_total_analytics_file = $stats_analytics_visitors_folder . 'total';
	
	if (file_exists($visitors_analytics_file)) {
		if (strpos(file_get_contents($visitors_analytics_file),$visitor_ip) == false)  {
			$visitors_analytics_writer = fopen($visitors_analytics_file, "w+");
			fwrite($visitors_analytics_writer , $analytics_content . "\n");
			fclose($visitors_analytics_writer);
			
			$stats_visitors_count = file($stats_visitors_analytics_file);
			$stats_visitors_count[0] ++;
			$stats_visitors_count_writer = fopen($stats_visitors_analytics_file, "w+");
			fputs($stats_visitors_count_writer, $stats_visitors_count[0]);
			fclose($stats_visitors_count_writer);
			
			$stats_visitors_total_count = file($stats_visitors_total_analytics_file);
			$stats_visitors_total_count[0] ++;
			$stats_visitors_total_count_writer = fopen($stats_visitors_total_analytics_file, "w+");
			fputs($stats_visitors_total_count_writer, $stats_visitors_total_count[0]);
			fclose($stats_visitors_total_count_writer);
		}
	} else {
		$visitors_analytics_writer = fopen($visitors_analytics_file, "w+");
		fwrite($visitors_analytics_writer , $analytics_content . "\n");
		fclose($visitors_analytics_writer);
		
		$stats_visitors_count = file($stats_visitors_analytics_file);
		$stats_visitors_count[0] ++;
		$stats_visitors_count_writer = fopen($stats_visitors_analytics_file, "w+");
		fputs($stats_visitors_count_writer, $stats_visitors_count[0]);
		fclose($stats_visitors_count_writer);
			
		$stats_visitors_total_count = file($stats_visitors_total_analytics_file);
		$stats_visitors_total_count[0] ++;
		$stats_visitors_total_count_writer = fopen($stats_visitors_total_analytics_file, "w+");
		fputs($stats_visitors_total_count_writer, $stats_visitors_total_count[0]);
		fclose($stats_visitors_total_count_writer);
	}
	
	// Pageviews analytics
	$pageviews_analytics_file = $pageviews_analytics_folder . $visitor_date;
	$stats_pageviews_analytics_file = $stats_analytics_pageviews_folder . $visitor_date;
	$stats_pageviews_total_analytics_file = $stats_analytics_pageviews_folder . 'total';
	
	$pageviews_analytics_writer = fopen($pageviews_analytics_file, "w+");
	fwrite($pageviews_analytics_writer , $analytics_content . "\n");
	fclose($pageviews_analytics_writer);
	
	$stats_pageviews_count = file($stats_pageviews_analytics_file);
	$stats_pageviews_count[0] ++;
	$stats_pageviews_count_writer = fopen($stats_pageviews_analytics_file, "w+");
	fputs($stats_pageviews_count_writer, $stats_pageviews_count[0]);
	fclose($stats_pageviews_count_writer);
	
	$stats_pageviews_total_count = file($stats_pageviews_total_analytics_file);
	$stats_pageviews_total_count[0] ++;
	$stats_pageviews_total_count_writer = fopen($stats_pageviews_total_analytics_file, "w+");
	fputs($stats_pageviews_total_count_writer, $stats_pageviews_total_count[0]);
	fclose($stats_pageviews_total_count_writer);
	
	// Pages analytics
	
	$stats_pages_analytics_file = $stats_analytics_pages_day_folder . str_replace('/', '_slash_', $visitor_current_page);
	$stats_pages_total_analytics_file = $stats_analytics_pages_total_folder . str_replace('/', '_slash_', $visitor_current_page);
	
	$stats_pages_count = file($stats_pages_analytics_file);
	$stats_pages_count[0] ++;
	$stats_pages_count_writer = fopen($stats_pages_analytics_file, "w+");
	fputs($stats_pages_count_writer, $stats_pages_count[0]);
	fclose($stats_pages_count_writer);
	
	$stats_pages_total_count = file($stats_pages_total_analytics_file);
	$stats_pages_total_count[0] ++;
	$stats_pages_total_count_writer = fopen($stats_pages_total_analytics_file, "w+");
	fputs($stats_pages_total_count_writer, $stats_pages_total_count[0]);
	fclose($stats_pages_total_count_writer);

	// Referrers analytics
	
	$stats_referrers_analytics_file = $stats_analytics_referrers_day_folder . str_replace('/', '', $visitor_referrer_url);
	$stats_referrers_total_analytics_file = $stats_analytics_referrers_total_folder . str_replace('/', '', $visitor_referrer_url);
	
	$stats_referrers_count = file($stats_referrers_analytics_file);
	$stats_referrers_count[0] ++;
	$stats_referrers_count_writer = fopen($stats_referrers_analytics_file, "w+");
	fputs($stats_referrers_count_writer, $stats_referrers_count[0]);
	fclose($stats_referrers_count_writer);
	
	$stats_referrers_total_count = file($stats_referrers_total_analytics_file);
	$stats_referrers_total_count[0] ++;
	$stats_referrers_total_count_writer = fopen($stats_referrers_total_analytics_file, "w+");
	fputs($stats_referrers_total_count_writer, $stats_referrers_total_count[0]);
	fclose($stats_referrers_total_count_writer);
	
	// Countries analytics
	
	$stats_countries_analytics_file = $stats_analytics_countries_day_folder . $visitor_country;
	$stats_countries_total_analytics_file = $stats_analytics_countries_total_folder . $visitor_country;
	
	$stats_countries_count = file($stats_countries_analytics_file);
	$stats_countries_count[0] ++;
	$stats_countries_count_writer = fopen($stats_countries_analytics_file, "w+");
	fputs($stats_countries_count_writer, $stats_countries_count[0]);
	fclose($stats_countries_count_writer);
	
	$stats_countries_total_count = file($stats_countries_total_analytics_file);
	$stats_countries_total_count[0] ++;
	$stats_countries_total_count_writer = fopen($stats_countries_total_analytics_file, "w+");
	fputs($stats_countries_total_count_writer, $stats_countries_total_count[0]);
	fclose($stats_countries_total_count_writer);
	
	// Devices analytics
	
	$stats_devices_analytics_file = $stats_analytics_devices_day_folder . $visitor_device;
	$stats_devices_total_analytics_file = $stats_analytics_devices_total_folder . $visitor_device;
	$stats_devices_total_desktop_analytics_file = $stats_analytics_devices_total_folder . 'desktop';
	$stats_devices_total_mobile_analytics_file = $stats_analytics_devices_total_folder . 'mobile';
	
	$stats_devices_count = file($stats_devices_analytics_file);
	$stats_devices_count[0] ++;
	$stats_devices_count_writer = fopen($stats_devices_analytics_file, "w+");
	fputs($stats_devices_count_writer, $stats_devices_count[0]);
	fclose($stats_devices_count_writer);
	
	$stats_devices_total_count = file($stats_devices_total_analytics_file);
	$stats_devices_total_count[0] ++;
	$stats_devices_total_count_writer = fopen($stats_devices_total_analytics_file, "w+");
	fputs($stats_devices_total_count_writer, $stats_devices_total_count[0]);
	fclose($stats_devices_total_count_writer);
	
	if ($visitor_device == "Desktop")
	{
		$stats_devices_total_desktop_count = file($stats_devices_total_desktop_analytics_file);
		$stats_devices_total_desktop_count[0] ++;
		$stats_devices_total_desktop_count_writer = fopen($stats_devices_total_desktop_analytics_file, "w+");
		fputs($stats_devices_total_desktop_count_writer, $stats_devices_total_desktop_count[0]);
		fclose($stats_devices_total_desktop_count_writer);
	}
	
	if ($visitor_device == "Phone" || $visitor_device == "Tablet")
	{
		$stats_devices_total_mobile_count = file($stats_devices_total_mobile_analytics_file);
		$stats_devices_total_mobile_count[0] ++;
		$stats_devices_total_mobile_count_writer = fopen($stats_devices_total_mobile_analytics_file, "w+");
		fputs($stats_devices_total_mobile_count_writer, $stats_devices_total_mobile_count[0]);
		fclose($stats_devices_total_mobile_count_writer);
	}
	
	// Oss analytics
	
	$stats_oss_analytics_file = $stats_analytics_oss_day_folder . $visitor_os;
	$stats_oss_total_analytics_file = $stats_analytics_oss_total_folder . $visitor_os;
	
	$stats_oss_count = file($stats_oss_analytics_file);
	$stats_oss_count[0] ++;
	$stats_oss_count_writer = fopen($stats_oss_analytics_file, "w+");
	fputs($stats_oss_count_writer, $stats_oss_count[0]);
	fclose($stats_oss_count_writer);
	
	$stats_oss_total_count = file($stats_oss_total_analytics_file);
	$stats_oss_total_count[0] ++;
	$stats_oss_total_count_writer = fopen($stats_oss_total_analytics_file, "w+");
	fputs($stats_oss_total_count_writer, $stats_oss_total_count[0]);
	fclose($stats_oss_total_count_writer);
	
	// Browsers analytics
	
	$stats_browsers_analytics_file = $stats_analytics_browsers_day_folder . $visitor_browser;
	$stats_browsers_total_analytics_file = $stats_analytics_browsers_total_folder . $visitor_browser;
	
	$stats_browsers_count = file($stats_browsers_analytics_file);
	$stats_browsers_count[0] ++;
	$stats_browsers_count_writer = fopen($stats_browsers_analytics_file, "w+");
	fputs($stats_browsers_count_writer, $stats_browsers_count[0]);
	fclose($stats_browsers_count_writer);
	
	$stats_browsers_total_count = file($stats_browsers_total_analytics_file);
	$stats_browsers_total_count[0] ++;
	$stats_browsers_total_count_writer = fopen($stats_browsers_total_analytics_file, "w+");
	fputs($stats_browsers_total_count_writer, $stats_browsers_total_count[0]);
	fclose($stats_browsers_total_count_writer);
?>