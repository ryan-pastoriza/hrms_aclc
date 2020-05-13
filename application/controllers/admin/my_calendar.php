<?php
/**
 * @Author: gian
 * @Date:   2015-11-03 10:54:34
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2018-10-05 10:26:46
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Calendar extends MY_Controller {

	public function test()
	{
		$events 	= $this->show_event();

		echo "<pre>";
			print_r ($events);
		echo "</pre>";
	}
	public function index()
	{
		$this->create_head_and_navi(array(
											asset_url('plugins/daterangepicker/moment.js'),
										 	asset_url('plugins/fullcalendar/fullcalendar.min.js'),
										 	asset_url('plugins/colorpicker/bootstrap-colorpicker.min.js'),
										 	asset_url('bootstrap/js/bootstrap-datetimepicker.min.js'),
										 	asset_url('plugins/daterangepicker/daterangepicker.js'),
										 	asset_url('plugins/select2/select2.min.js')

										 ),
									array(
											asset_url('plugins/fullcalendar/fullcalendar.min.css'),
											asset_url('plugins/select2/select2.min.css'),
											asset_url('plugins/colorpicker/bootstrap-colorpicker.min.css'),
											asset_url('bootstrap/css/bootstrap-datetimepicker.min.css'),
										 )
								   );

		$eventForm = $this->load->view('admin/Calendar/calendar_form/form',FALSE,TRUE);

		$calendarActivities = $this->load->view('admin/Calendar/calendar/my_calendar',FALSE,TRUE);

		create_content(array('contentHeader' => 'Calendar of Activities',
							 'breadCrumbs' => true,
							 'content' => array($eventForm,$calendarActivities)
							)
					  );
		$this->create_footer(array(
									$this->load->view('admin/Calendar/calendar_form/jscripts',FALSE,TRUE),
									$this->load->view('admin/Calendar/calendar/jscripts',FALSE,TRUE)
								  )
							);
	}
	public function add_event(){

		$this->load->model('events');
		$event = new Events;

		$data = array();
		$ret = array('success' => true);
		// insert
		if($this->input->post("evt_id") == ""){

			$event->title = $this->input->post('title');
			$event->pay = $this->input->post('pay') == 1 ? 1 : 0;
			$event->work = $this->input->post('work') == 1 ? 1 : 0;
			$event->backgroundColor = $event->work == 1 ? "#ff0000" : "#08783b"; // background color
			$event->event_type = $this->input->post('event_type');
			$event->description = $this->input->post('description');

			if($this->input->post('type') == 'one day'){ // check if the type is oneday event

				$event->type = $this->input->post('type');
				$event->start_date = $this->input->post('one_d') . " " .$this->input->post('timeFrom');
				$event->end_date = $this->input->post('one_d'). " " .$this->input->post('timeTo');
				$event->string = $this->input->post('dateNum'). " " .$this->input->post('dateDay') . " of " . $this->input->post('dateMonth');
				$event->repeat = "no";
				$event->save();
			}

			if($this->input->post('type') == 'long event'){ // check if the type is long day event

				// $longee = str_replace("/", "-", $this->input->post("longee"));

				$event->type = $this->input->post('type');
				$event->start_date = $this->input->post("long_from"). " " .$this->input->post('timeFrom');
				$event->end_date = $this->input->post("long_to"). " " .$this->input->post('timeTo');
				$event->string = NULL;
				$event->repeat = "no";
				$event->save();

			}
			if($this->input->post('type') == 'repeat'){ // check if repeated event

				if($this->input->post('repeat') == 'monthly' ){ // check if monthly

					$event->type = $this->input->post("type");
					$event->repeat = $this->input->post('repeat');
					$event->start_date = $this->input->post("monthly_d"). " " .$this->input->post('timeFrom');
					$event->end_date = $this->input->post("monthly_d"). " " .$this->input->post('timeTo');	

					$event->string = $this->input->post('dateNum'). " " .$this->input->post('dateDay') . " of " .$this->input->post('dateMonth');

					$event->save();

				}

				else if($this->input->post('repeat') == 'yearly'){ // check if yearly event

					if($this->input->post("dateType") == "date"){

						$event->start_date 	= $this->input->post("yearly_d"). " " .$this->input->post('timeFrom');
						$event->end_date 	= $this->input->post("yearly_d"). " " .$this->input->post('timeTo');

						$event->repeat 		= "date";
						$event->string = $this->input->post('dateNum'). " " .$this->input->post('dateDay') . " of " .$this->input->post('dateMonth');
					}

					if($this->input->post("dateType") == "string"){

						$event->start_date 	= $this->input->post("yearly_d"). " " .$this->input->post('timeFrom');
						$event->end_date 	= $this->input->post("yearly_d"). " " .$this->input->post('timeTo');

						$event->repeat = "string";
						$event->string = $this->input->post('dateNum'). " " .$this->input->post('dateDay') . " of " .$this->input->post('dateMonth');
						
					}

					$event->type = $this->input->post("type");
					
					$event->save();

				}
			}
		}
		//update
		if($this->input->post("evt_id") != ""){
			$event->load($this->input->post("evt_id"));

			$event->title = $this->input->post('title');
			$event->pay = $this->input->post('pay') == 1 ? 1 : 0;
			$event->work = $this->input->post('work') == 1 ? 1 : 0;
			$event->backgroundColor = $event->work == 1 ? "#ff0000" : "#08783b"; // background color
			$event->event_type = $this->input->post('event_type');
			$event->description = $this->input->post('description');

			if($this->input->post('type') == 'one day'){ // check if the type is oneday event

				$event->type = $this->input->post('type');
				$event->start_date = $this->input->post('one_d'). " " .$this->input->post('timeFrom');
				$event->end_date = $this->input->post('one_d'). " " .$this->input->post('timeTo');
				$event->string = $this->input->post('dateNum'). " " .$this->input->post('dateDay') . " of " . $this->input->post('dateMonth');
				$event->repeat = "no";
				$event->save();
			}

			if($this->input->post('type') == 'long event'){ // check if the type is long day event

				// $longee = str_replace("/", "-", $this->input->post("longee"));

				$event->type = $this->input->post('type');
				$event->start_date = $this->input->post("long_from"). " " .$this->input->post('timeFrom');
				$event->end_date = $this->input->post("long_to"). " " .$this->input->post('timeTo');
				$event->string = NULL;
				$event->repeat = "no";
				$event->save();

			}
			if($this->input->post('type') == 'repeat'){ // check if repeated event

				if($this->input->post('repeat') == 'monthly' ){ // check if monthly

					$event->type = $this->input->post("type");
					$event->repeat = $this->input->post('repeat');
					$event->start_date = $this->input->post("monthly_d"). " " .$this->input->post('timeFrom');
					$event->end_date = $this->input->post("monthly_d"). " " .$this->input->post('timeTo');	

					$event->string = $this->input->post('dateNum'). " " .$this->input->post('dateDay') . " of " .$this->input->post('dateMonth');

					$event->save();

				}

				else if($this->input->post('repeat') == 'yearly'){ // check if yearly event

					if($this->input->post("dateType") == "date"){

						$event->start_date 	= $this->input->post("yearly_d"). " " .$this->input->post('timeFrom');
						$event->end_date 	= $this->input->post("yearly_d"). " " .$this->input->post('timeTo');
						
						$event->repeat 		= "date";
						$event->string = $this->input->post('dateNum'). " " .$this->input->post('dateDay') . " of " .$this->input->post('dateMonth');
					}

					if($this->input->post("dateType") == "string"){

						$event->start_date 	= $this->input->post("yearly_d"). " " .$this->input->post('timeFrom');
						$event->end_date 	= $this->input->post("yearly_d"). " " .$this->input->post('timeTo');

						$event->repeat = "string";
						$event->string = $this->input->post('dateNum'). " " .$this->input->post('dateDay') . " of " .$this->input->post('dateMonth');
						
					}

					$event->type = $this->input->post("type");
					
					$event->save();

				}
			}

		}
		echo json_encode($ret);
	}
	public function show_event(){
		$this->load->model("events");
		$event = new Events;

		$data = array();
		$ret = array();
		$mData = array();
		$getAllEvents = $event->get();

		foreach ($getAllEvents as $key => $value) {
			if($value->type == "one day"){
				$data = [
							'title' => $value->title,
							'start' => $value->start_date,
							'end' => $value->end_date,
							'backgroundColor' => $value->backgroundColor,
							'event_id'	=> $value->event_id,
							"allDay" => true,
						];
				$ret[]  = $data;
			}
			if($value->type == "long event"){
				$endD = new DateTIme($value->end_date);
				$endD->modify("+1 day");

				$data = [
							'title' => $value->title,
							'start' => $value->start_date,
							'end'	=> $endD->format("Y-m-d"),
							'backgroundColor' => $value->backgroundColor,
							'event_id' => $value->event_id,
							"allDay" => true,
						];
				$ret[] = $data;
			}

			if($value->repeat == "monthly"){

				$frm_date = explode("-", $value->start_date);
				$nd_date = explode("-", $value->end_date);
				for($i = 1 ; $i <= 12;$i++){
					if($value->repeat == "monthly"){
							$data = [
										"title" => $value->title,
										"start"	=> date("Y-m-d",strtotime($frm_date[0]."-".$i."-".$frm_date[2])),//."T20:00:00",
										"end"	=> date("Y-m-d",strtotime($nd_date[0]."-".$i."-".$nd_date[2])),//."T02:00:00",
										"backgroundColor" => $value->backgroundColor,
										"event_id" => $value->event_id,
										"allDay" => true,
									];
							$ret[] = $data;
					}
				}

			}


			if($value->repeat == "string"){
				for($i = 2015; $i <= date("Y")+10;$i++){
					if($value->repeat == "string"){
						$rep = new DateTime($value->string . " " .$i);
						$data = [
									'title' => $value->title,
									'start'	=> date("Y-m-d",strtotime($rep->format("Y-m-d"))),
									'end' => date("Y-m-d",strtotime($rep->format("Y-m-d"))),
									'backgroundColor' => $value->backgroundColor,
									'event_id' => $value->event_id,
									"allDay" => true,

								];
						$ret[] = $data;
					}
				}
			}

			if($value->repeat == "date"){
				$frm = explode("-", $value->start_date);
				$nd = explode("-", $value->end_date);
				for($i = 2015; $i <= date("Y")+10;$i++){
					if($value->repeat == "date"){
						$data = [
									"title" => $value->title,
									"start" => date("Y-m-d",strtotime($i."-".$frm[1]."-".$frm[2])),
									"end"   => date("Y-m-d",strtotime($i."-".$nd[1]."-".$nd[2])),
									"backgroundColor" => $value->backgroundColor,
									"event_id" => $value->event_id,
									"allDay" => true,
								];
						$ret[] = $data;		
					}
				}
			}
		}
		echo json_encode($ret);
	}
	public function show_details(){
		$this->load->model('events');
		$id 	= $this->input->post('id');
		$m_y 	= $this->input->post('monthYear');
		$m_y 	= explode(" ", $m_y);

		$event = new Events;
		$data = [];
		$ret = [];

		$eventObject = $event->search(
										[
											"event_id" => $id
										]
									);

		foreach ($eventObject as $key => $value) {
			if($value->repeat == "string"){
				$rep = new DateTime($value->string." ".$m_y[1]);

				$ret = [
							"title" => $value->title,
							"start" =>  date("Y-m-d",strtotime($rep->format("Y-m-d"))),
							"end" =>  date("Y-m-d",strtotime($rep->format("Y-m-d"))),
							"work" => $value->work,
							"pay" => $value->pay,
							"description" => $value->description,
							"event_id" => $value->event_id,
							"event_type" => $value->event_type
					   ];

			}
			if($value->repeat == "date"){
				$frm_date = explode("-",$value->start_date);
				$nd_date = explode("-",$value->end_date);
				$ret = [
							"title" => $value->title,
							"start" => $m_y[1]."-".$m_y[0]."-".$frm_date[2],
							"end"	=> $m_y[1]."-".$m_y[0]."-".$nd_date[2],
							"work" => $value->work,
							"pay" => $value->pay,
							"description" => $value->description,
							"event_id" => $value->event_id,
							"event_type" => $value->event_type
					   ];
			}
			if($value->repeat == "monthly"){
				$frm_date = explode("-",$value->start_date);
				$nd_date = explode("-",$value->end_date);
				$ret = [
							"title" => $value->title,
							"start" => $m_y[1]."-".$m_y[0]."-".$frm_date[2],
							"end"	=> $m_y[1]."-".$m_y[0]."-".$nd_date[2],
							"work" => $value->work,
							"pay" => $value->pay,
							"description" => $value->description,
							"event_id" => $value->event_id,
							"event_type" => $value->event_type
					   ];

			}
			if($value->type == "long event" || $value->type == "one day"){
				$ret = [
							"title" => $value->title,
							"start" => $value->start_date,
							"end" => $value->end_date,
							"work" => $value->work,
							"pay" => $value->pay,
							"description" => $value->description,
							"event_id" => $value->event_id,
							"event_type" => $value->event_type

					   ];
			}

		}

		echo json_encode($ret);	
	}
	public function get_event($id){

		$this->load->model('event');
		$event = new Event;
		$getEvent = $event->search("event.event_id = '{$id}' ");
		return reset($getEvent);
	}
	public function event_load_last_input(){
		$this->load->model('events');
		$event = new Events;

		$event->load_last_input();

		$data = array();
		$ret = array();

		$eventObject = $this->get_event($event->event_id);

		if($eventObject->repeat == "date"){
			$data = array('title' => $eventObject->title,
						  'start' => $eventObject->start_date,
						  'end' => $eventObject->end_date,
						  'backgroundColor' => $eventObject->backgroundColor,
						  'event_id' => $eventObject->event_id
						 );
			$ret[] = $data;

		}

		if($eventObject->repeat == "string"){
			$rep = new DateTime($eventObject->from_date . " ". date("Y"));
			$data = array('title' => $eventObject->title,
						  'start' => date("Y-m-d",strtotime($rep->format("Y-m-d"))),
						  'end' => date("Y-m-d",strtotime($rep->format("Y-m-d"))),
						  'backgroundColor' => $eventObject->backgroundColor,
						  'event_id' => $eventObject->event_id
						 );
			$ret[] = $data;

		}

		if($eventObject->type == "one day"){

			$data = array('title' => $eventObject->title,
   						  'start' => $eventObject->from_date,
   						  'end' => $eventObject->end_date,
   						  'backgroundColor' => $eventObject->backgroundColor,
   						  'event_id'	=> $eventObject->event_id
						 );
			$ret[] = $data;


		}
		if($eventObject->type == "long event"){
			$endD = new DateTIme($eventObject->end_date);
			$endD->modify("+1 day");
			$data = array('title' => $eventObject->title,
   						  'start' => $eventObject->start_date,
   						  'end'	=> $endD->format("Y-m-d"),
   						  'backgroundColor' => $eventObject->backgroundColor,
   						  'event_id'	=> $eventObject->event_id
						 );
			$ret[] = $data;
		}

		//end ko dre!
		if($eventObject->repeat == "monthly" ){

			$start  = new DateTime($eventObject->from_date);
			$interval = new DateInterval("P1M");
			$end = new DateTime('Dec 31');
			$period = new DatePeriod($start,$interval,$end);

			foreach ($period as $key) {
				$data = array('title' => $eventObject->title,
							  'start' => $key->format("Y-m-d"),
							  'backgroundColor' => $eventObject->backgroundColor,
							  'event_id' => $eventObject->event_id
					         );
				$ret[] = $data;
			}

		}
		
		echo json_encode($ret);
	}
	public function view_event(){
		$this->load->model("events");
		$event = new Events;

		$data = array();
		$ret = array();

		$event->load($this->input->post("id"));

		if($event->type == "one day"){
			$timeF = explode(" ", $event->start_date); 
			$timeT = explode(" ", $event->end_date);
			$data = [
						"title" => $event->title,
						"type" => $event->type,
						"from_date" => $event->start_date,
						"pay" => $event->pay,
						"work" => $event->work,
						"event_id" => $event->event_id,
						"event_type" => $event->event_type,
						"description" => $event->description,
						"timeFrom" => $timeF[1],
						"timeTo" => $timeT[1],
					];
		}

		if($event->type == "long event"){
			$data = [
						"title" => $event->title,
						"type" => $event->type,
						"reportrange" => $event->start_date ." - ".$event->end_date,
						"pay" => $event->pay,
						"work" => $event->work,
						"event_id" => $event->event_id,
						"event_type" => $event->event_type,
						"description" => $event->description,
						"long_from" => $event->start_date,
						"long_to" => $event->end_date
					];
		}

		if($event->repeat == "monthly"){
			$data = [
						"title" => $event->title,
						"type" => $event->type,
						"repeat" => $event->repeat,
						"from_date" => $event->start_date,
						"event_type" => $event->event_type,
						"pay" => $event->pay,
						"work" => $event->work,
						"event_id" => $event->event_id,
						"description" => $event->description,
					];
		}

		if($event->repeat == "string"){
			$split = explode(" ", $event->string);
			$data = [
						"title" => $event->title,
						"type" => $event->type,
						"repeat" => "yearly",
						"from_date" => $event->start_date,
						"event_type"  => $event->event_type,
						"pay" => $event->pay,
						"work" => $event->work,
						"event_id" => $event->event_id,
						"description" => $event->description,
						"dateNum" => $split[0],
						"dateDay" => $split[1],
						"dateMonth" => $split[3]

					];
		}
		if($event->repeat == "date"){
			$split = explode(" ", $event->string);
			$data = [
						"title" => $event->title,
						"type" => $event->type,
						"repeat" => "yearly",
						"from_date" => $event->start_date,
						"event_type"  => $event->event_type,
						"pay" => $event->pay,
						"work" => $event->work,
						"event_id" => $event->event_id,
						"description" => $event->description,
						"dateNum" => $split[0],
						"dateDay" => $split[1],
						"dateMonth" => $split[3]

					];
		}

		echo json_encode($data);
	}
	public function delete_event(){
		$this->load->model("events");
		$event = new Events;
		$id = $this->input->post("id");
		$event->load($id);
		$event->delete();
	}
	
}