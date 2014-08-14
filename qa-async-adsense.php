<?php

/*
	Question2Answer (c) Gideon Greenspan

	http://www.question2answer.org/

	
	File: qa-plugin/basic-adsense/qa-basic-adsense.php
	Version: See define()s at top of qa-include/qa-base.php
	Description: Widget module class for AdSense widget plugin


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

	class qa_async_adsense {
		
		function allow_template($template)
		{
			return ($template!='admin');
		}

		
		function allow_region($region)
		{
			$allow=false;
			
			switch ($region)
			{
				case 'main':
				case 'side':
				case 'full':
					$allow=true;
					break;
			}
			
			return $allow;
		}

		
		function admin_form(&$qa_content)
		{
			$saved=false;
			
			if (qa_clicked('adsense_save_button')) {	
				// only digits, letters and sign "-" are allowed
				qa_opt('adsense_publisher_id', preg_replace('|[^A-Za-z0-9-]|i','',qa_post_text('adsense_publisher_id_field')));
				qa_opt('adsense_ad_slot',      preg_replace('|[^A-Za-z0-9-]|i','',qa_post_text('adsense_ad_slot_field')));
				$saved=true;
			}
			
			return array(
				'ok' => $saved ? 'AdSense settings saved' : null,
				
				'fields' => array(
					array(
						'label' => '<b>AdSense Publisher ID:</b>',
						'value' => qa_html(qa_opt('adsense_publisher_id')),
						'tags' => 'name="adsense_publisher_id_field"',
						'note' => 'Example: <i style="color:blue">ca-pub-2345678901234567</i>',
					),
 					array(
						'label' => '<b>AdSense Ad Slot ID:</b>',
						'value' => qa_html(qa_opt('adsense_ad_slot')),
						'tags' => 'name="adsense_ad_slot_field"',
						'note' => 'Example: <i style="color:brown">3456789012</i>
<br /><br /><b>Example with full AdSense asynchronous JavaScript code:</b>
<br />&lt;script async src=&quot;//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js&quot;>&lt;/script&gt;
<br />&lt;ins class=&quot;adsbygoogle&quot;
<br /> &nbsp; &nbsp; style=&quot;display:inline-block;width:728px;height:90px&quot;
<br /> &nbsp; &nbsp; data-ad-client=&quot;<span style="color:blue">ca-pub-2345678901234567</span>&quot;
<br /> &nbsp; &nbsp; data-ad-slot=&quot;<span style="color:brown">3456789012</span>&quot;>&lt;/ins&gt;
<br />&lt;script&gt;
<br />(adsbygoogle = window.adsbygoogle || []).push({});
<br />&lt;/script&gt;
                        ',
					),
				),
				
				'buttons' => array(
					array(
						'label' => 'Save Changes',
						'tags' => 'name="adsense_save_button"',
					),
				),
			);
		}


		function output_widget($region, $place, $themeobject, $template, $request, $qa_content)
		{
			$divstyle='';
			
			switch ($region) {
				case 'full': // Leaderboard
					$divstyle='width:728px; margin:0 auto;';
					
				case 'main': // Leaderboard
					$width=728;
					$height=90;
					break;
					
				case 'side': // Wide skyscraper
					$width=160;
					$height=600;
					break;
			}
			
?>
<div style="<?php echo $divstyle?>">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:inline-block;width:<?php echo qa_js($width)?>px;height:<?php echo qa_js($height)?>px"
     data-ad-client="<?php echo qa_opt('adsense_publisher_id')?>"
     data-ad-slot="<?php echo qa_opt('adsense_ad_slot')?>"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<?php
		}
	
	}
	

/*
	Omit PHP closing tag to help avoid accidental output
*/
