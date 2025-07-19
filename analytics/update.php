<?php
	error_reporting(0);
	ini_set("display_errors", 0);

	$timezone = 'Australia/Melbourne';

	// Optional
	// Name of Folder where analytics are stored
	$analytics_folder = 'analytics';

	// Functions
	function filecount($path)  {
    	$size = 0;
    	$ignore = array('.','..','cgi-bin','.DS_Store');
    	$files = scandir($path);
    	foreach($files as $t) 
    	{
        	if(in_array($t, $ignore)) continue;
        	if (is_dir(rtrim($path, '/') . '/' . $t)) 
        	{
           	 	$size += filecount(rtrim($path, '/') . '/' . $t);
        	} 
        	else 
        	{
            	$size++;
        	}   
    	}
    	return $size;
	}
	
	date_default_timezone_set($timezone);
	$current_time = time();
	
	$date = array(
		date('Ymd'),
		date('Ymd', strtotime("-1 days")),
		date('Ymd', strtotime("-2 days")),
		date('Ymd', strtotime("-3 days")),
		date('Ymd', strtotime("-4 days")),
		date('Ymd', strtotime("-5 days")),
		date('Ymd', strtotime("-6 days")),
		date('Ymd', strtotime("-7 days")),
		date('Ymd', strtotime("-8 days")),
		date('Ymd', strtotime("-9 days")),
		date('Ymd', strtotime("-10 days")),
		date('Ymd', strtotime("-11 days")),
		date('Ymd', strtotime("-12 days")),
		date('Ymd', strtotime("-13 days")),
		date('Ymd', strtotime("-14 days")),
		date('Ymd', strtotime("-15 days")),
		date('Ymd', strtotime("-16 days")),
		date('Ymd', strtotime("-17 days")),
		date('Ymd', strtotime("-18 days")),
		date('Ymd', strtotime("-19 days")),
		date('Ymd', strtotime("-20 days")),
		date('Ymd', strtotime("-21 days")),
		date('Ymd', strtotime("-22 days")),
		date('Ymd', strtotime("-23 days")),
		date('Ymd', strtotime("-24 days")),
		date('Ymd', strtotime("-25 days")),
		date('Ymd', strtotime("-26 days")),
		date('Ymd', strtotime("-27 days")),
		date('Ymd', strtotime("-28 days")),
		date('Ymd', strtotime("-29 days"))
	);

	// Analytics database directories
	$realtime_analytics_folder = $analytics_folder . '/realtime/';
	$realtime_analytics_visitors_folder = $realtime_analytics_folder . 'visitors/';
	$realtime_analytics_pageviews_folder = $realtime_analytics_folder . 'pageviews/';
	$visitors_analytics_folder = $analytics_folder . '/visitors/';
	$pageviews_analytics_folder = $analytics_folder . '/pageviews/';
	$stats_analytics_folder = $analytics_folder . '/stats/';
	$stats_analytics_visitors_folder = $stats_analytics_folder . 'visitors/';
	$stats_analytics_pageviews_folder = $stats_analytics_folder . 'pageviews/';
	$stats_analytics_pages_folder = $stats_analytics_folder . 'pages/';
	$stats_analytics_pages_total_folder = $stats_analytics_pages_folder . 'total/';
	$stats_analytics_referrers_folder = $stats_analytics_folder . 'referrers/';
	$stats_analytics_referrers_total_folder = $stats_analytics_referrers_folder . 'total/';
	$stats_analytics_countries_folder = $stats_analytics_folder . 'countries/';
	$stats_analytics_countries_total_folder = $stats_analytics_countries_folder . 'total/';
	$stats_analytics_devices_folder = $stats_analytics_folder . 'devices/';
	$stats_analytics_devices_total_folder = $stats_analytics_devices_folder . 'total/';
	$stats_analytics_oss_folder = $stats_analytics_folder . 'oss/';
	$stats_analytics_oss_total_folder = $stats_analytics_oss_folder . 'total/';
	$stats_analytics_browsers_folder = $stats_analytics_folder . 'browsers/';
	$stats_analytics_browsers_total_folder = $stats_analytics_browsers_folder . 'total/';

	$analytics_content = "";

	// Compute analytics
	// Realtime analytics
	$realtime_visitors = glob($realtime_analytics_visitors_folder . '*');
	$current_online_visitor_count = 0;
	$current_realtime_visitor_count = 0;
	$one_minute_realtime_visitor_count = 0;
	$two_minutes_realtime_visitor_count = 0;
	$three_minutes_realtime_visitor_count = 0;
	$four_minutes_realtime_visitor_count = 0;
	$five_minutes_realtime_visitor_count = 0;
	$six_minutes_realtime_visitor_count = 0;
	$seven_minutes_realtime_visitor_count = 0;
	$eight_minutes_realtime_visitor_count = 0;
	$nine_minutes_realtime_visitor_count = 0;

	foreach ($realtime_visitors as $visitor) {
		if (is_file($visitor)) {
			if (($current_time - filemtime($visitor)) < 180) {
				$current_online_visitor_count += 1;
			}

			if (($current_time - filemtime($visitor)) < 60) {
				$current_realtime_visitor_count += 1;
			}

			if ((($current_time - filemtime($visitor)) >= 60) && (($current_time - filemtime($visitor)) < 120)) {
				$one_minute_realtime_visitor_count += 1;
			}
        	
        	if ((($current_time - filemtime($visitor)) >= 120) && (($current_time - filemtime($visitor)) < 180)) {
        		$two_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 180) && (($current_time - filemtime($visitor)) < 240)) {
        		$three_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 240) && (($current_time - filemtime($visitor)) < 300)) {
        		$four_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 300) && (($current_time - filemtime($visitor)) < 360)) {
        		$five_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 360) && (($current_time - filemtime($visitor)) < 420)) {
        		$six_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 420) && (($current_time - filemtime($visitor)) < 480)) {
        		$seven_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 480) && (($current_time - filemtime($visitor)) < 540)) {
        		$eight_minutes_realtime_visitor_count += 1;
        	}
        	
        	if ((($current_time - filemtime($visitor)) >= 540) && (($current_time - filemtime($visitor)) < 600)) {
        		$nine_minutes_realtime_visitor_count += 1;
        	}
        	
        	if (($current_time - filemtime($visitor)) >= 600) {
        		unlink($visitor);
        	}
        }
    }

    $realtime_pageviews = glob($realtime_analytics_pageviews_folder . '*');
	$current_realtime_pageviews_count = 0;
	$one_minute_realtime_pageviews_count = 0;
	$two_minutes_realtime_pageviews_count = 0;
	$three_minutes_realtime_pageviews_count = 0;
	$four_minutes_realtime_pageviews_count = 0;
	$five_minutes_realtime_pageviews_count = 0;
	$six_minutes_realtime_pageviews_count = 0;
	$seven_minutes_realtime_pageviews_count = 0;
	$eight_minutes_realtime_pageviews_count = 0;
	$nine_minutes_realtime_pageviews_count = 0;

  	foreach ($realtime_pageviews as $pageviews) {
    	if (is_file($pageviews)) {
      		if (($current_time - filemtime($pageviews)) < 60){
        		$current_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 60) && (($current_time - filemtime($pageviews)) < 120))
      		{
        		$one_minute_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 120) && (($current_time - filemtime($pageviews)) < 180))
      		{
        		$two_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 180) && (($current_time - filemtime($pageviews)) < 240))
      		{
        		$three_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 240) && (($current_time - filemtime($pageviews)) < 300))
      		{
        		$four_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 300) && (($current_time - filemtime($pageviews)) < 360))
      		{
        		$five_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 360) && (($current_time - filemtime($pageviews)) < 420))
      		{
        		$six_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 420) && (($current_time - filemtime($pageviews)) < 480))
      		{
        		$seven_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 480) && (($current_time - filemtime($pageviews)) < 540))
      		{
        		$eight_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if ((($current_time - filemtime($pageviews)) >= 540) && (($current_time - filemtime($pageviews)) < 600))
      		{
        		$nine_minutes_realtime_pageviews_count += 1;
        	}
        	
        	if (($current_time - filemtime($pageviews)) >= 600)
      		{
        		unlink($pageviews);
        	}
        }
    }
	
	// Visitor analytics
	$visitors = array();
	
	for ($i = 0; $i <= 29; $i++) {
		if (file_exists($stats_analytics_visitors_folder . $date[$i])){
    		array_push($visitors,(($value = file($stats_analytics_visitors_folder . $date[$i])) ? $value[0] : 0));
    	} else {
    		array_push($visitors,0);
    	}
	}
	
	// Pageview analytics
	$pageviews = array();
	
	for ($i = 0; $i <= 29; $i++)  {
		if (file_exists($stats_analytics_pageviews_folder . $date[$i])) {
    		array_push($pageviews,(($value = file($stats_analytics_pageviews_folder . $date[$i])) ? $value[0] : 0));
    	} else {
    		array_push($pageviews,0);
    	}
	}
	
	// Pages analytics
	$pages_list = glob($stats_analytics_pages_folder . 'total/' . '*');
	foreach($pages_list as $pagename) {
		$pagename = str_replace('_slash_', '/', $pagename);
		$total_pages[str_replace($stats_analytics_pages_folder . 'total/', '', $pagename)] = (($value = file($pagename)) ? $value[0] : 0);	
	}
	
	arsort($total_pages);

	foreach($pages_list as $pagename) {
		$pagename = str_replace('_slash_', '/', $pagename);
		$pagename = str_replace($stats_analytics_pages_folder . 'total/', '', $pagename);
		$today_pages[$pagename] = (($value = file($stats_analytics_pages_folder . $date[0] . '/' .$pagename)) ? $value[0] : 0);
	}
	
	arsort($today_pages);
	
	$total_pages_keys = array_keys($total_pages);
	$today_pages_keys = array_keys($today_pages);
	$total_pages_page = array();
	$total_pages_count = array();
	$today_pages_page = array();
	$today_pages_count = array();
	
	for ($i = 0; $i <= 9; $i++) {
		array_push($total_pages_page,array_key_exists($i,$total_pages_keys) ? $total_pages_keys[$i] : '');
		array_push($today_pages_page,array_key_exists($i,$today_pages_keys) ? $today_pages_keys[$i] : '');
		array_push($total_pages_count,array_key_exists($total_pages_keys[$i],$total_pages) ? $total_pages[$total_pages_keys[$i]] : 0);
		array_push($today_pages_count,array_key_exists($today_pages_keys[$i],$today_pages) ? $today_pages[$today_pages_keys[$i]] : 0);
	}
	
	// Referrer analytics
	$referrers_list = glob($stats_analytics_referrers_folder . 'total/' . '*');
	
	foreach($referrers_list as $referrername) {
		$total_referrers[str_replace($stats_analytics_referrers_folder . 'total/', '', $referrername)] = (($value = file($referrername)) ? $value[0] : 0);	
	}
	
	arsort($total_referrers);
	
	foreach($referrers_list as $referrername)
	{
		$referrername = str_replace($stats_analytics_referrers_folder . 'total/', '', $referrername);
		$today_referrers[$referrername] = (($value = file($stats_analytics_referrers_folder . $date[0] . '/' .$referrername)) ? $value[0] : 0);
	}
	
	arsort($today_referrers);
	
	
	$total_referrers_keys = array_keys($total_referrers);
	$today_referrers_keys = array_keys($today_referrers);
		
	$total_referrers_referrer = array();
	$total_referrers_count = array();
	$today_referrers_referrer = array();
	$today_referrers_count = array();
	
	for ($i = 0; $i <= 9; $i++)
	{
		array_push($total_referrers_referrer,array_key_exists($i,$total_referrers_keys) ? $total_referrers_keys[$i] : '');
		array_push($today_referrers_referrer,array_key_exists($i,$today_referrers_keys) ? $today_referrers_keys[$i] : '');
		
		array_push($total_referrers_count,array_key_exists($total_referrers_keys[$i],$total_referrers) ? $total_referrers[$total_referrers_keys[$i]] : 0);
		array_push($today_referrers_count,array_key_exists($today_referrers_keys[$i],$today_referrers) ? $today_referrers[$today_referrers_keys[$i]] : 0);
	}
	
	
	
	
	
	
	
	
	
	
	
	// Country analytics
	
	$countries_list = glob($stats_analytics_countries_folder . 'total/' . '*');
	
	
	foreach($countries_list as $countryname)
	{
		$total_countries[str_replace($stats_analytics_countries_folder . 'total/', '', $countryname)] = (($value = file($countryname)) ? $value[0] : 0);	
	}
	
	arsort($total_countries);
	
	
	foreach($countries_list as $countryname)
	{
		$countryname = str_replace($stats_analytics_countries_folder . 'total/', '', $countryname);
		$today_countries[$countryname] = (($value = file($stats_analytics_countries_folder . $date[0] . '/' .$countryname)) ? $value[0] : 0);
	}
	
	arsort($today_countries);
	
	
	$total_countries_keys = array_keys($total_countries);
	$today_countries_keys = array_keys($today_countries);
		
	$total_countries_country = array();
	$total_countries_count = array();
	$today_countries_country = array();
	$today_countries_count = array();
	
	for ($i = 0; $i <= 9; $i++)
	{
		array_push($total_countries_country,array_key_exists($i,$total_countries_keys) ? $total_countries_keys[$i] : '');
		array_push($today_countries_country,array_key_exists($i,$today_countries_keys) ? $today_countries_keys[$i] : '');
		
		array_push($total_countries_count,array_key_exists($total_countries_keys[$i],$total_countries) ? $total_countries[$total_countries_keys[$i]] : 0);
		array_push($today_countries_count,array_key_exists($today_countries_keys[$i],$today_countries) ? $today_countries[$today_countries_keys[$i]] : 0);
	}
	
	
	
	
	
	
	
	
	
	// Devices analytics
	
	
	$total_devices = array((($value = file($stats_analytics_devices_folder . 'total/Desktop')) ? $value[0] : 0), (($value = file($stats_analytics_devices_folder . 'total/Phone')) ? $value[0] : 0), (($value = file($stats_analytics_devices_folder . 'total/Tablet')) ? $value[0] : 0), (($value = file($stats_analytics_devices_folder . 'total/Server')) ? $value[0] : 0), (($value = file($stats_analytics_devices_folder . 'total/Other')) ? $value[0] : 0));
	
	
	
	// Oss analytics
	
	
	$total_oss = array((($value = file($stats_analytics_oss_folder . 'total/Windows')) ? $value[0] : 0), (($value = file($stats_analytics_oss_folder . 'total/Mac OS')) ? $value[0] : 0), (($value = file($stats_analytics_oss_folder . 'total/Linux')) ? $value[0] : 0), (($value = file($stats_analytics_oss_folder . 'total/iOS')) ? $value[0] : 0), (($value = file($stats_analytics_oss_folder . $date[0] . '/Android')) ? $value[0] : 0));
	
	
	
	// Browsers analytics
	
	
	$total_browsers = array((($value = file($stats_analytics_browsers_folder . 'total/Chrome')) ? $value[0] : 0), (($value = file($stats_analytics_browsers_folder . 'total/Firefox')) ? $value[0] : 0), (($value = file($stats_analytics_browsers_folder . 'total/Safari')) ? $value[0] : 0), (($value = file($stats_analytics_browsers_folder . 'total/Internet Explorer')) ? $value[0] : 0), (($value = file($stats_analytics_browsers_folder . $date[0] . '/Mobile')) ? $value[0] : 0));
	
	
	
	
	if (($total_browsers[0] > $total_browsers[1]) && ($total_browsers[0] > $total_browsers[2]) && ($total_browsers[0] > $total_browsers[3]) && ($total_browsers[0] > $total_browsers[4]))
	{
		$most_popular_browser = "Chrome";
	}
	if (($total_browsers[1] > $total_browsers[0]) && ($total_browsers[1] > $total_browsers[2]) && ($total_browsers[1] > $total_browsers[3]) && ($total_browsers[1] > $total_browsers[4]))
	{
		$most_popular_browser = "Firefox";
	}
	if (($total_browsers[2] > $total_browsers[0]) && ($total_browsers[2] > $total_browsers[1]) && ($total_browsers[2] > $total_browsers[3]) && ($total_browsers[2] > $total_browsers[4]))
	{
		$most_popular_browser = "Safari";
	}
	if (($total_browsers[3] > $total_browsers[0]) && ($total_browsers[3] > $total_browsers[1]) && ($total_browsers[3] > $total_browsers[2]) && ($total_browsers[3] > $total_browsers[4]))
	{
		$most_popular_browser = "Internet Explorer";
	}
	if (($total_browsers[4] > $total_browsers[0]) && ($total_browsers[4] > $total_browsers[1]) && ($total_browsers[4] > $total_browsers[2]) && ($total_browsers[4] > $total_browsers[3]))
	{
		$most_popular_browser = "Mobile";
	}
	
	
	
	// Main analytics
	
	$seven_days_visitors = $visitors[0] + $visitors[1] + $visitors[2] + $visitors[3] + $visitors[4] + $visitors[5] + $visitors[6];
	$seven_days_pageviews = $pageviews[0] + $pageviews[1] + $pageviews[2] + $pageviews[3] + $pageviews[4] + $pageviews[5] + $pageviews[6];
	
	$thirty_days_visitors = $visitors[0] + $visitors[1] + $visitors[2] + $visitors[3] + $visitors[4] + $visitors[5] + $visitors[6] + $visitors[7] + $visitors[8] + $visitors[9] + $visitors[10] + $visitors[11] + $visitors[12] + $visitors[13] + $visitors[14] + $visitors[15] + $visitors[16] + $visitors[17] + $visitors[18] + $visitors[19] + $visitors[20] + $visitors[21] + $visitors[22] + $visitors[23] + $visitors[24] + $visitors[25] + $visitors[26] + $visitors[27] + $visitors[28] + $visitors[29];
	$thirty_days_pageviews = $pageviews[0] + $pageviews[1] + $pageviews[2] + $pageviews[3] + $pageviews[4] + $pageviews[5] + $pageviews[6] + $pageviews[7] + $pageviews[8] + $pageviews[9] + $pageviews[10] + $pageviews[11] + $pageviews[12] + $pageviews[13] + $pageviews[14] + $pageviews[15] + $pageviews[16] + $pageviews[17] + $pageviews[18] + $pageviews[19] + $pageviews[20] + $pageviews[21] + $pageviews[22] + $pageviews[23] + $pageviews[24] + $pageviews[25] + $pageviews[26] + $pageviews[27] + $pageviews[28] + $pageviews[29];
	
	$total_visitors = ($value = file($stats_analytics_visitors_folder . 'total')) ? $value[0] : 0;
	$total_pageviews = ($value = file($stats_analytics_pageviews_folder . 'total')) ? $value[0] : 0;
	
	$desktop_visitor_count = ($value = file($stats_analytics_devices_total_folder . 'desktop')) ? $value[0] : 0;
	$mobile_visitor_count = ($value = file($stats_analytics_devices_total_folder . 'mobile')) ? $value[0] : 0;
	
	$desktop_visitor_percentage = round((($desktop_visitor_count/($desktop_visitor_count + $mobile_visitor_count))*100));
	$mobile_visitor_percentage = 100-$desktop_visitor_percentage;
	
	
	$windows_percentage = round(($total_oss[0]/$total_pageviews)*100);
	$macos_percentage = round(($total_oss[1]/$total_pageviews)*100);
	$linux_percentage = round(($total_oss[2]/$total_pageviews)*100);
	$ios_percentage = round(($total_oss[3]/$total_pageviews)*100);
	$android_percentage = round(($total_oss[4]/$total_pageviews)*100);
	
	
	
	$internetexplorer_percentage = round(($total_browsers[0]/$total_pageviews)*100);
	$firefox_percentage = round(($total_browsers[1]/$total_pageviews)*100);
	$safari_percentage = round(($total_browsers[2]/$total_pageviews)*100);
	$chrome_percentage = round(($total_browsers[3]/$total_pageviews)*100);
	$mobile_percentage = round(($total_browsers[4]/$total_pageviews)*100);
	
	
	
	
	
	
	
	
	
	// Add Analytics to content
	
	// Main analytics
	
	$analytics_content .= "
							<div class=\"content_wrapper white\">
    							<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Visitors<br>Total</div>
									<div class=\"main_analytics_item_value\">" . $total_visitors . "</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Pageviews<br>Total</div>
									<div class=\"main_analytics_item_value\">" . $total_pageviews . "</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Desktop<br>Devices</div>
									<div class=\"main_analytics_item_value\">" . $desktop_visitor_percentage . "%</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Mobile<br>Devices</div>
									<div class=\"main_analytics_item_value\">" . $mobile_visitor_percentage . "%</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Most popular<br>Country</div>
									<div class=\"main_analytics_item_value\">" . $total_countries_country[0] . "</div>
								</div>
								<div class=\"main_analytics_item\">
									<div class=\"main_analytics_item_headline\">Most popular<br>Browser</div>
									<div class=\"main_analytics_item_value\">" . $most_popular_browser . "</div>
								</div>
							</div>
	";
	
	
	
	// Realtime analytics
	
	$analytics_content .= "<iframe id=\"realtime_content\" src=\"realtime/admin.php\" style=\"position:relative; left:0; top:0; width:100%; height:600px; overflow:hidden; border:none; outline:none; box-sizing:border-box;\" width=\"100%\" height=\"600px\" scrolling=\"no\"></iframe>";
	
	
	
	// Visitor analytics
	
	$analytics_content .= "
    						<div class=\"content_wrapper white\" style=\"padding:0; height:400px;\">
    							<div class=\"content_headline\" style=\"margin-bottom:50px; color:#2b4059;\">Visitors and Pageviews</div>
    							<div class=\"sub_analytics_holder\">
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Visitors<br>Today</div>
    									<div class=\"sub_analytics_item_value\">" . $visitors[0] . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Visitors<br>30 days</div>
    									<div class=\"sub_analytics_item_value\">" . $thirty_days_visitors . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Visitors<br>Total</div>
    									<div class=\"sub_analytics_item_value\">" . $total_visitors . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Pageviews<br>today</div>
    									<div class=\"sub_analytics_item_value\">" . $pageviews[0] . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Pageviews<br>30 days</div>
    									<div class=\"sub_analytics_item_value\">" . $thirty_days_pageviews . "</div>
    								</div>
    								<div class=\"sub_analytics_item\">
    									<div class=\"sub_analytics_item_headline\">Pageviews<br>Total</div>
    									<div class=\"sub_analytics_item_value\">" . $total_pageviews . "</div>
    								</div>
    							</div>
    							<div class=\"chart_holder\" id=\"visitors_chart_holder\">
    								<canvas id=\"visitors_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    							</div>
    							<div class=\"chart_mesh\">
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    									<div class=\"chart_mesh_bar\"></div>
    								</div>
    								<div class=\"chart_mesh_inner\">
    								</div>
    							</div>
    						</div>
    						
    						<script>
    						
    							var visitors_data = 
    							{
    								labels: [\"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\", \"\"],
    								datasets: 
    								[
    									{
          									fillColor: \"#6a6ca9\",
           									strokeColor: \"rgba(0,0,0,0.0)\",
           									pointColor: \"rgba(0,0,0,0.0)\",
            								pointStrokeColor: \"rgba(0,0,0,0.0)\",
            								data: [0,0," . $pageviews[29] . "," . $pageviews[28] . "," . $pageviews[27] . "," . $pageviews[26] . "," . $pageviews[25] . "," . $pageviews[24] . "," . $pageviews[23] . "," . $pageviews[22] . "," . $pageviews[21] . "," . $pageviews[20] . "," . $pageviews[19] . "," . $pageviews[18] . "," . $pageviews[17] . "," . $pageviews[16] . "," . $pageviews[15] . "," . $pageviews[14] . "," . $pageviews[13] . "," . $pageviews[12] . "," . $pageviews[11] . "," . $pageviews[10] . "," . $pageviews[9] . "," . $pageviews[8] . "," . $pageviews[7] . "," . $pageviews[6] . "," . $pageviews[5] . "," . $pageviews[4] . "," . $pageviews[4] . "," . $pageviews[2] . "," . $pageviews[1] . "," . $pageviews[0] . ",0,0]
        								},
        								{
          									fillColor: \"#51acb8\",
           									strokeColor: \"rgba(0,0,0,0.0)\",
           									pointColor: \"rgba(0,0,0,0.0)\",
            								pointStrokeColor: \"rgba(0,0,0,0.0)\",
            								data: [0,0," . $visitors[29] . "," . $visitors[28] . "," . $visitors[27] . "," . $visitors[26] . "," . $visitors[25] . "," . $visitors[24] . "," . $visitors[23] . "," . $visitors[22] . "," . $visitors[21] . "," . $visitors[20] . "," . $visitors[19] . "," . $visitors[18] . "," . $visitors[17] . "," . $visitors[16] . "," . $visitors[15] . "," . $visitors[14] . "," . $visitors[13] . "," . $visitors[12] . "," . $visitors[11] . "," . $visitors[10] . "," . $visitors[9] . "," . $visitors[8] . "," . $visitors[7] . "," . $visitors[6] . "," . $visitors[5] . "," . $visitors[4] . "," . $visitors[3] . "," . $visitors[2] . "," . $visitors[1] . "," . $visitors[0] . ",0,0]
        								}
  									]
								}
								
								document.getElementById('visitors_chart').width = document.getElementById('visitors_chart_holder').offsetWidth + 143;
								document.getElementById('visitors_chart').height = document.getElementById('visitors_chart_holder').offsetHeight;
								
    							var visitors_chart = document.getElementById('visitors_chart').getContext('2d');
    							new Chart(visitors_chart).Line(visitors_data,{scaleLineColor: \"rgba(0,0,0,0)\", scaleShowGridLines : false, scaleShowLabels: true});
    						</script>
    
    ";

	
    
     
    
    
	
	
	// Pages analytics
	
	$analytics_content .= "
							<div class=\"content_container dark\" style=\"border-bottom:1px solid rgba(255,255,255,0.1);\">
							<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\" style=\"margin:50px 0 30px 0;\">Pages</div>
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"bar_chart_holder\">
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[0]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[1]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[2]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[3]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_pages_count[4]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    								</div>
    							</div>
    									<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_pages_page[0] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[0]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_pages_page[1] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[1]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_pages_page[2] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[2]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_pages_page[3] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[3]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_pages_page[4] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_pages_count[4]/$total_pageviews)*100) . "%</div>
    										</div>
    									</div>
    						</div>
    ";
    
    
    
    
    
    
    
    
    
    
    // Pages analytics
	
	$analytics_content .= "
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\" style=\"margin:50px 0 30px 0;\">Referrers</div>
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"bar_chart_holder\">
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_referrers_count[0]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_referrers_count[1]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_referrers_count[2]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_referrers_count[3]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_referrers_count[4]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    								</div>
    							</div>
    									<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_referrers_referrer[0] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_referrers_count[0]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_referrers_referrer[1] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_referrers_count[1]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_referrers_referrer[2] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_referrers_count[2]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_referrers_referrer[3] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_referrers_count[3]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_referrers_referrer[4] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_referrers_count[4]/$total_pageviews)*100) . "%</div>
    										</div>
    									</div>
    						</div>
    ";
    
    
    
    
    
    
    
     // Pages analytics
	
	$analytics_content .= "
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\" style=\"margin:50px 0 30px 0;\">Countries</div>
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"bar_chart_holder\">
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[0]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[1]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[2]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[3]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    									<div class=\"bar_chart\">
    										<div class=\"bar_chart_bar\">
    											<div class=\"bar_chart_bar_value\" style=\"height:" . round(($total_countries_count[4]/$total_pageviews)*100) . "%;\"></div>
    										</div>
    									</div>
    								</div>
    							</div>
    							<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[0] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[0]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[1] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[1]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[2] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[2]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[3] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[3]/$total_pageviews)*100) . "%</div>
    										</div>
    										<div class=\"tripple_chart_item\">
    											<div class=\"tripple_chart_item_huge\">" . $total_countries_country[4] . "</div>
    											<div class=\"tripple_chart_item_small\">" . round(($total_countries_count[4]/$total_pageviews)*100) . "%</div>
    										</div>
    									</div>
    						</div>
    						</div>
    ";
    
	
	
	
	
	
	// Devices analytics
	
	$analytics_content .= "
							<div class=\"content_container dark\">
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\">Devices</div>
    							
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"tripple_chart_holder\" id=\"devices_total_chart_holder\" style=\"top:20%; height:80%; margin-top:0;\">
    									<canvas id=\"devices_total_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    								</div>
    							</div>
    							<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    								<div class=\"tripple_chart_item\" style=\"margin-top:35px;\">
    									<div class=\"tripple_chart_item_large\">" . "Desktop" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[0]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Phone" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[1]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Tablet" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[2]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Server" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[3]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Other" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_devices[4]/$total_pageviews)*100) . "%</div>
    								</div>
    							</div>
    						</div>
    						
    						<script>
    						
    							
  								var devices_total_data = 
    							[
    								{
        								value:" . $total_devices[0] . ",
        								color:\"rgba(255,255,255,1)\"
    								},
    								{
        								value:" . $total_devices[1] . ",
        								color:\"rgba(255,255,255,0.8)\"
    								},
    								{
        								value:" . $total_devices[2] . ",
        								color:\"rgba(255,255,255,0.6)\"
    								},
    								{
        								value:" . $total_devices[3] . ",
        								color:\"rgba(255,255,255,0.4)\"
    								},
    								{
        								value:" . $total_devices[4] . ",
        								color:\"rgba(255,255,255,0.2)\"
    								}
  								]
								
							
    							document.getElementById('devices_total_chart').width = document.getElementById('devices_total_chart_holder').offsetWidth;
								document.getElementById('devices_total_chart').height = document.getElementById('devices_total_chart_holder').offsetHeight;
								
    							var devices_total_chart = document.getElementById('devices_total_chart').getContext('2d');
    							new Chart(devices_total_chart).Doughnut(devices_total_data,{segmentStrokeColor: \"rgba(255,255,255,0)\"});
    						</script>
    
    ";
	
	
	
	
	// OS analytics
	
	$analytics_content .= "
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\">Systems</div>
    							
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"tripple_chart_holder\" id=\"oss_total_chart_holder\" style=\"top:20%; height:80%; margin-top:0;\">
    									<canvas id=\"oss_total_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    								</div>
    							</div>
    							<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    								<div class=\"tripple_chart_item\" style=\"margin-top:35px;\">
    									<div class=\"tripple_chart_item_large\">" . "Windows" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[0]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Mac OS" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[1]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Linux" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[2]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "iOS" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[3]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Android" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_oss[4]/$total_pageviews)*100) . "%</div>
    								</div>
    							</div>
    						</div>
    						
    						<script>
    						
    							
  								var oss_total_data = 
    							[
    								{
        								value:" . $total_oss[0] . ",
        								color:\"rgba(255,255,255,1)\"
    								},
    								{
        								value:" . $total_oss[1] . ",
        								color:\"rgba(255,255,255,0.8)\"
    								},
    								{
        								value:" . $total_oss[2] . ",
        								color:\"rgba(255,255,255,0.6)\"
    								},
    								{
        								value:" . $total_oss[3] . ",
        								color:\"rgba(255,255,255,0.4)\"
    								},
    								{
        								value:" . $total_oss[4] . ",
        								color:\"rgba(255,255,255,0.2)\"
    								}
  								]
								
								document.getElementById('oss_total_chart').width = document.getElementById('oss_total_chart_holder').offsetWidth;
								document.getElementById('oss_total_chart').height = document.getElementById('oss_total_chart_holder').offsetHeight;
								
    							var oss_total_chart = document.getElementById('oss_total_chart').getContext('2d');
    							new Chart(oss_total_chart).Doughnut(oss_total_data,{segmentStrokeColor: \"rgba(255,255,255,0)\"});
    						</script>
    
    ";
    
    
    
    
    
    
	
	
	
	// Browsers analytics
	
	$analytics_content .= "
    						<div class=\"content_tripple_wrapper\">
    							<div class=\"darken\"></div>
    							<div class=\"content_headline\">Browsers</div>
    							
    							
    							<div class=\"content_inner_tripple_wrapper_inner\">
    								<div class=\"tripple_chart_holder\" id=\"browsers_total_chart_holder\" style=\"top:20%; height:80%; margin-top:0;\">
    									<canvas id=\"browsers_total_chart\" style=\"position:relative; float:left; width:100%; height:100%;\"></canvas>
    								</div>
    							</div>
    							<div class=\"content_inner_tripple_wrapper_inner\" style=\"min-height:0;\">
    								<div class=\"tripple_chart_item\" style=\"margin-top:35px;\">
    									<div class=\"tripple_chart_item_large\">" . "Chrome" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[0]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Firefox" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[1]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Safari" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[2]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Internet Explorer" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[3]/$total_pageviews)*100) . "%</div>
    								</div>
    								<div class=\"tripple_chart_item\">
    									<div class=\"tripple_chart_item_large\">" . "Mobile" . "</div>
    									<div class=\"tripple_chart_item_medium\">" . round(($total_browsers[4]/$total_pageviews)*100) . "%</div>
    								</div>
    							</div>
    						</div>
    						
    						<script>
    						
    							
  								var browsers_total_data = 
    							[
    								{
        								value:" . $total_browsers[0] . ",
        								color:\"rgba(255,255,255,1)\"
    								},
    								{
        								value:" . $total_browsers[1] . ",
        								color:\"rgba(255,255,255,0.8)\"
    								},
    								{
        								value:" . $total_browsers[2] . ",
        								color:\"rgba(255,255,255,0.6)\"
    								},
    								{
        								value:" . $total_browsers[3] . ",
        								color:\"rgba(255,255,255,0.4)\"
    								},
    								{
        								value:" . $total_browsers[4] . ",
        								color:\"rgba(255,255,255,0.2)\"
    								}
  								]
								
								document.getElementById('browsers_total_chart').width = document.getElementById('browsers_total_chart_holder').offsetWidth;
								document.getElementById('browsers_total_chart').height = document.getElementById('browsers_total_chart_holder').offsetHeight;
								
    							var browsers_total_chart = document.getElementById('browsers_total_chart').getContext('2d');
    							new Chart(browsers_total_chart).Doughnut(browsers_total_data,{segmentStrokeColor: \"rgba(255,255,255,0)\"});
    						</script>
    					</div>
    ";
	
	
	
	

	echo $analytics_content;
?>