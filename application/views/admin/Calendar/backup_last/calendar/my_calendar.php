<?php
/**
 * @Author: gian
 * @Date:   2016-04-15 08:16:08
 * @Last Modified by:   gian
 * @Last Modified time: 2016-05-31 14:29:18
 */
 	echo lte_widget(5,array('header'   => 'Holidays and Events',
 							'col_grid' => col_grid(12,12,8),
 							'collapsable' => false,
 							'bgColor'  => 'box-info',
 							'body'	   => '<div id="myCalendar"></div>',
 							'foot'	   => false,
 						   )
 				   );
 ?>
