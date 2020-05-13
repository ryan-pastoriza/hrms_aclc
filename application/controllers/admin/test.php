<?php

	defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Test extends MY_Controller
	{
		
		public function index(){

			$this->create_head_and_navi(array(asset_url('bootstrap-editable/js/bootstrap-editable.min.js')));

			$content = lte_load_view('button_groups',[
													'buttons' => [
																	'\/' => [
																					'link' => ['Accept' => ['link' => '#',
																											'attr' => ""], 
																								'Delete' => ['link' => '#',
																											'attr' => ""
																												]
																								],
																					'attr' => "class = 'btn'"
																				],
																	'Other' => [
																					'link' => "#",
																					'attr' => 'class="btn"'
																				]

																	]
												]);
			create_content(['content' => $content,
							'contentHeader' => 'test']);


		}
	}

