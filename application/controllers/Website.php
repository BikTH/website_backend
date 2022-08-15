<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends MaryFuneral {
	
	protected $activePage = null;
	
	
	function __construct(){
		parent::__construct();
		$this->lang->load('meta', $this->language);
		$this->lang->load('global', $this->language);
	}
	
	
	public function index(){
		$this->lang->load('website/home', $this->language);
		$this->loadpage("home", array("title"=> lang("title-home") , "description"=> lang("description-home"), "image"=> $this->getSEOImage("home")));
	}
	
	
	
	public function routepage($a = "", $b = null, $c = null){
		$b = !is_null($b) ? "/".$b : "";
		$c = !is_null($c) ? "/".$c : "";
		
		$dir = $a.$b.$c;
		
		if( !is_file( APPPATH . 'views/website/pages/' . $dir . ".php" ) ){ show_404(); }
		
		$currentPage = explode("/", $dir); 
		if( $b == "" ){
			$currentPage = $a;
		}
		else{
			$currentPage = $a."-".$currentPage[ count($currentPage) - 1 ];
		}
		
		// CHARGEMENT DU FICHIER LANGUE
		$this->lang->load('website/'.str_replace("-", "/", $currentPage), $this->language);
		
		// MARQUONS COMME ACTIVE
		$this->activePage = $a;
		
		// CHARGEMENT DE LA VUE.
		$this->loadpage("pages/".$dir, $this->meta($currentPage) );
	}
	
	
	
	private function meta($pageID){
		$metas = array("services","quote" , "about", "about-team", "contact", "services-inhumation" , "services-car" , "services-coffin" , "services-deco" , "services-flowers" , "services-exhumation" , "services-prints" , "services-repatriation", "legal-privacy", "legal-terms" ) ; 

		if( array_search($pageID, $metas) > -1 ){
			$image = $this->getSEOImage($pageID);
			return array("title"=> lang("title-".$pageID), "description"=> lang("description-".$pageID), "image"=> $image);
		} else {
			return array("title"=> "", "description"=> "");
		}
	}
	
	
	
	private function getSEOImage($pageID = "home"){
		return is_file( FCPATH . 'public/assets/img/seo/preview-' . $pageID . '.jpg' ) ? 'preview-' . $pageID . '.jpg' : 'seo-main.jpg';
	}
	
	
	
	private function loadpage($pageDIR, $meta){
		$this->load->view("website/header/head", array("meta"=> $meta, "self"=> $this));
		$this->load->view("website/header/header", array("active"=> $this->activePage, "self"=> $this));
		
		$this->load->view("website/".$pageDIR, array("self"=> $this));
		
		$this->load->view("website/footer/footer", array("active"=> $this->activePage, "self"=> $this));
	}
	
	
	
	public function _include($content = null, $data = null, $langDIR = null){
		if( is_null($content) ) { return; }
		if( !is_file( APPPATH . 'views/website/include/' . $content . ".php" ) ){ return; }
		
		// CHARGEMENT DU FICHIER LANGUE
		$this->lang->load('website/include/'.$content, $this->language);
		
		$this->load->view("website/include/".$content, $data);
	}
	
	
	
	public function call($func = null){
		return $this->$func();
	}
	
	
	private function sendmessage(){
		
		$this->recaptcha("/contact");
		
		$data = array("name"=> _name($this->input->post("name"), 16), 
			"email"=> $this->input->post("contact"), 
			"message"=> _textarea($this->input->post("message"), 500), 
			"topic"=> $this->input->post("topic"));
			
		$html = $this->email_template("contact_email", $data);
		
		$send = $this->sendmail($html, "New message from ".$data["name"], "info@maryfuneral.com");
		if( $send ){
			$this->alert->set("mail_sent", true);
		}
		redirect("/contact");
	}
	
	private function getquote(){
		
		$this->recaptcha("/quote");
		
		$data = array("concern"=>_name($this->input->post("concern"),10),
		"funeral"=> _name($this->input->post("funeral"),10),
		"death_name"=> _name($this->input->post("deathname"), 20),
		"death_first_name"=> _name($this->input->post("deathprename"), 45),
		"death_date"=> _textarea($this->input->post("deathdate"),40),
		"death_birth"=> _textarea($this->input->post("deathbirth"),40),
		"death_gender"=> $this->input->post("deathgender"),
		"name"=> _name($this->input->post("name"), 20),
		"first_name"=> _name($this->input->post("prename"), 45),
		"phone"=> $this->input->post("phone"),
		"email"=> $this->input->post("email"),
		"gender"=> $this->input->post("gender"),
		"dateof"=> now(),
		"quote_status"=> "false",
		"uid"=> $this->get_uid(),
		"message"=> _textarea($this->input->post("message"), 500));
		
		($data["concern"] == "funeral" || $data["concern"] == "insurance") ? : $this->alert->set("quote_error", true) ;
		($data["funeral"] == "vault" || $data["funeral"] == "ground") ? : $this->alert->set("quote_error", true)  ;
		($data["death_gender"] == "male" || $data["death_gender"] == "female") ? : $this->alert->set("quote_error", true)  ;
		($data["gender"] == "male" || $data["gender"] == "female") ?  : $this->alert->set("quote_error", true) ;
		
		$quoteID = $this->Base->insertData("quote",$data);
		($quoteID) ? $this->alert->set("quote_save", true) : $this->alert->set("quote_error", true) ; 
		
		redirect("/quote");
	}
	
	
	public function getcasket(){
		$data = $this->Base->get("casket");
		return $data ? $data : null;
	}
	
	public function getcasketimg($id,$uid){
		$data = $this->Base->getwhere("images", array("casket"=> $id ));
		return $data;
	}
	
	public function showimg(){
		$this->load->helper('upload');
		$dirfile = './public/assets/img/upload/'.urldecode($this->input->get("id"));
		$Images = new \Verot\Upload\Upload($dirfile);
		$Images->image_resize          = true;
		$Images->image_ratio_crop      = true;
		$Images->image_y               = $this->input->get("h");
		$Images->image_x               = $this->input->get("w");
		header('Content-type: ' . $Images->file_src_mime);
		echo $Images->process(); die;
	}
	
	public function gettestimonial(){
		$data = $this->Base->get("testimonial");
		return $data ? $data : null;
	}
}