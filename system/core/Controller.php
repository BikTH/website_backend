<?php


defined('BASEPATH') OR exit('No direct script access allowed');


class CI_Controller {

	protected $maintenance = false;
		

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	 
	 
	private static $instance;

	/**
	 * CI_Loader
	 *
	 * @var	CI_Loader
	 */
	 
	 
	public $load;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	 
	public function __construct()
	{
		self::$instance =& $this;
		
		
		foreach (is_loaded() as $var => $class){
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
		
		if( $this->maintenance  ){
			if( !in_array( $this->input->ip_address(), array("129.0.226.227","154.72.150.35", "129.0.205.157") ) ){
				$page = $this->load->view("comingsoon", null, true);
				exit( $page );
			}	
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance(){ return self::$instance; }
}



class MaryFuneral extends CI_Controller{
	
	public $defaultLanguage = 'fr';
	public $language = null;
	
	protected $user = null;
	protected $role = null;
	protected $safe = false;
	

	protected $dir_images = "./public/media/images/";
	
	function __construct(){
		
		parent::__construct();
		
		$this->load->model("Base_model", "Base", true);
		
		if( $this->input->get("lang") != "" && in_array($this->input->get("lang"), array("en", "fr")) ){
            $_SESSION['lang'] = $this->input->get("lang");
        }
        
        $lang = ( array_key_exists("lang", $_SESSION) && $_SESSION['lang'] ) ? $_SESSION['lang'] : $this->defaultLanguage;
        $this->language = $lang;
        
        
        // Définition du timezone
        date_default_timezone_set($this->config->item("default_timezone"));
	}
	
	
	protected function secure($type = "null", $checkHistory = true, $test = true){
		if( $this->session->has_userdata('user') ){
	        $this->user = ( object ) $this->session->userdata('user');
	        $this->role = $this->user->role;
	        
            if( $checkHistory ){
                return $this->checkSecure($this->user->id); // Secure++
            }
	        else{
	            $this->safe = true;
	            return true; }
		}
		else
            return $this->getOut($type, "session_expired", $test);
	}	
	
	
	public function lang($index, $vars = null){
		$this->load->library('parser');
		$translation = $this->lang->line($index);
		if( !is_null($vars) && gettype($vars) == "array" ){
			$string = $this->parser->parse_string($translation, $vars, TRUE);
			return $string;
		}
		else{
			return $translation;
		}
	}
	
	
	public function super(){
        if( $this->safe ){
            if( $this->user->role == "admin" ){
                return true;
            }
        }
        
        if( $this->input->is_ajax_request() ){ exit("_not_granted_");}
        else{
            redirect("/backoffice");
        }
    }
    
    
    protected function loaduser(){
        $user = ( object) $this->session->userdata("user");
        if( $this->session->has_userdata("user") AND isset( $this->session->userdata("user")->id) ){
            $this->user = ( object ) $user;
            $this->role = $this->user->role;
            
            return true;
        }
        else{
            return false;
        }
    }
    
    
	
	private function getOut($type, $reason = null, $testing = false){
	    unset($_SESSION['user']); // Suppression des variables de sessions utilisateurs.
	    if( $this->input->is_ajax_request() ){
	        exit($reason);
	    }
	    else{
	        $this->alert->set($reason, true);
	    	if( !$testing ){
		        if( $type == "admin"){ redirect("/dashboard?login"); }
	    		else if( $type == "agent"){ 
	    			redirect("/?bye"); 
				}
	    		else{ show_404(); }
	    	}
	    	else{ 
	    	    //exit(); 
	    	}
	    }
	}
	
	
		
    protected function isAjax($getout = true){
        if( !$this->input->is_ajax_request() ){
            if( $getout )
                show_404();
            else
                return false;
        }
        else
            return true;
    }
	
    
    
    public function get_uid($prefix = ""){ $code = $prefix."1".date("md").abs( crc32( uniqid() ) ); return $code;}



	private function checkSecure($userID){
	    $sessionID = $this->session->userdata('user')->connectionID;
	    $secure = $this->Base->getthis("connection", array("admin"=> $userID, "status"=> "online", "id"=> $sessionID));
	    if( $secure ){
	    	
	        $this->Base->updateData(array("lastseen"=> now()), array("id"=> $userID), "admin");
            $this->safe = true;
	        return true; // You're secured.
	    }
	    else{
	        return $this->getOut("two_users"); // ***************************************** //
	    }
	}
	
	
	
	protected function managelogin($data){
		if( $data->status !== "suspended" ){ // Si ce compte n'as point été suspendu.
			// Recherche des infos de la dernière connexion.
            $lastlog = $this->Base->get_last_connection($data->id);
            $insertLog = $this->addConnectionLog( $data->id );
            if( $insertLog ){
            	$data->lastconnection = $lastlog;
            	$data->connectionID = $insertLog[0];
				if( $lastlog ){
				    $data->lastlogin = strtotime($lastlog->dateof); // Sauvegarde de la date de la derniere connexion.
				}

				$data->spendedtime = time() - strtotime( $data->dateof ); // Durée passée sur la plateforme Pubshake depuis l'inscription.
				$data->role = $data->role;
				
				$this->session->set_userdata( array("user"=> $data ) );
				
				return true;
            }
		}
		else{
			$this->alert->set("suspended", true);
			if( $type == "admin" ){ redirect("/backoffice"); } else { redirect("/"); }
			return false;
		}
	}
	
	
	
	public function connect(){
		$this->session->unset_userdata('user'); 
		
		$login = $this->input->post("username");
		// $password = sha1($this->input->post("password"));
		$password = sha1($this->input->post("password"));
		
		$connect = $this->Base->getthis("admin", array("username"=> $login, "password"=> $password));
		if( $connect ){
			if( $this->managelogin($connect, "admin") ){
				redirect("/backoffice");
			}
			else{
				redirect("/backoffice");
			}
		}
		else{
			$this->alert->set("invalid", true);  redirect("/backoffice");
		}
	}
	
	
	
	 // ADD USER CONNECTION LOG
    protected function addConnectionLog($user, $type = ""){
    	$this->load->library('user_agent');
    	
        $data = array("admin"=> $user);
        $data["session_alive"] = "false";
        $data["session_token"] = session_id();
        $data["os"] = $this->agent->platform();
        $data["ip_address"] = $this->input->ip_address();
        $data["browser"] = $this->agent->browser();
        $data["device"] = $this->agent->is_mobile() ? "mobile" : "computer";
        $data["dateof"] = now();
        $data["status"] = "online";
		
		// ON DECONNECTE DABORD TOUS LES AUTRES INSTANCES
		$this->Base->updateData(array("status"=> "offline"), array("admin"=> $user), "connection");

        // ON INSERE LE NOUVEAU JOURNAL
        $insertLog = $this->Base->insertData("connection", $data);
        
        return array($insertLog, $data);
    }
	
	
	
	protected function recaptcha($redirect = ""){
        $this->load->helper("recaptcha");
        $reCAPTCHA = new reCAPTCHA($this->config->item("google-recaptcha-site-key"), $this->config->item("google-recaptcha-secret-key"));
        if( !$reCAPTCHA->isValid( $this->input->post('g-recaptcha-response') ) ){
            $this->alert->set("security", true);  redirect($redirect); return false;
        }
        
        return true;
    }
	
	
	
	protected function sendmail($message, $obj, $to, $app_sender_name = null, $app_sender_email = null){
        $app_sender_email = is_null( $app_sender_email ) ? $this->config->item("app_email") : $app_sender_email;
        $app_sender_name = is_null( $app_sender_name ) ? $this->config->item("app") : $app_sender_name;

        
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['priority'] = 1;
        $config['mailtype'] = "html";
        
        $this->load->library("email");
        $this->email->initialize($config);
        
        $this->email->from($app_sender_email, $app_sender_name);
        $this->email->to($to);
        $this->email->subject($obj);
        $this->email->message($message);
        
        if( $this->email->send() ){
            return true;
        }
        return false;
    }
    
    
    
	protected function email_template($file, $data){
		$header = $this->load->view("email/include/email_header.php", array("headline"=> ""), true);
	    $body = $this->load->view("email/{$file}", array("data"=> $data), true);
	    $footer = $this->load->view("email/include/email_footer", null, true);
	    $html = $header.$body.$footer;	
	    
	    return $html;
	}
	
	
	public function cdnresource(){
        
        $type = $this->input->get("type");
        $dir = $this->input->get("dir");
        $useDefault = $this->input->get("default") == "true" ? true : false;
        
        $ppSizes = array(48, 80, 120, 240, 360, 480);
        $defaultPP = "./public/media/default_user_profile.png";
        
        $who = strtolower( $this->input->get("w") ); // WHO : u (unknow) / m (me)
        $size = $this->input->get("s");
        
        if( $type == "pp" ){
            if( !in_array($who, array("ag", "ad")) ){ return; }
            
            $_DIR = "./public/media/admin_pp/";
            
            if( $who == "ad" ){
                if( !$this->loaduser() ){ return; }
                if( !in_array($size, $ppSizes) ) { return; }
                $imageDIR = $_DIR.$this->user->photo;
            }
            else{
                $imageDIR = $defaultPP;
            }
            
            if( !is_file($imageDIR) or $useDefault or ( $who == "m" && $this->user->photo == "" ) ) { $source = $defaultPP; } else { $source = $imageDIR; }
        }
        
        $this->load->helper("upload");
        $handle = new \Verot\Upload\Upload($source);
        header('Content-type: ' . $handle->file_src_mime);
        echo $handle->process();
        die();
    }
    
    protected function _updateUserdata($data){
        if( !$this->safe ) { $this->loaduser(); }
        
        foreach ($data as $index => $value){
            $this->user->$index = $value;
        }
        $this->user = ( object) $this->user;

        $this->session->set_userdata("user", $this->user);
    }
    
    
	
	public function getimage($imageDIR = ""){
		if( $imageDIR == "" ){ return; }
		
		$source = $this->dir_images . $imageDIR;
		$shape = $this->input->get("s"); 
		$width = $this->input->get("w"); 
		$height = $this->input->get("h"); 
		$compress = $this->input->get("c") == "true"; 
		
		if( !is_file($source) ) { return; } 
		
		$this->load->helper("upload");
		$handle = new \Verot\Upload\Upload($source);
		
		if ($handle->uploaded){
		
		$handle->image_resize = true;
		$handle->image_convert = 'jpg';
		$handle->image_default_color = '#FFFFFF';
		$handle->file_overwrite = true;
		
		if( $shape == "box" ){
			$handle->image_x = $width; $handle->image_y = $width; 
			$handle->image_ratio_crop  = true;
			
			if( $compress && $width >= 240 ){ 
				$handle->jpeg_quality = 100;
			}
		}
		else{
			$handle->image_x = $width; 
			// $handle->image_y = $height; 
			$handle->image_ratio_y = true;
			
			$handle->image_ratio_crop  = true;
			$handle->jpeg_quality = 100;
			if( $compress && $width > 400 ){
				$handle->jpeg_quality = 100;
			}
		}
		
		header('Content-type: ' . $handle->file_src_mime);
			echo $handle->process();
			die();
		}
		else{
			show_404();
		}
    }
    
    
    public function _get($table, $clause){
    	return $this->Base->getthis($table, $clause);
    }
}







