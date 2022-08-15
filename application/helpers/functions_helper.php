<?php


// CETTE FONCTION ASSET() DONNE ACCES AU FICHIERS PUBLIC

function assets($ressource = null, $refreshcache = false, $version = false){
    $self =& get_instance();
    $refresh = $refreshcache ? "r=".time() : "";
    if( $ressource != "" ){
        if( $version ){
            $v = $self->config->item("app_version");
            return base_url()."public/assets/".$ressource."?v=".$v."&".$refresh;
        }
        else{
            $refresh = $refreshcache ? "?".$refresh : "";
            return base_url()."public/assets/".$ressource.$refresh; }
    }
    else{
        return "";
    }
}




// CETTE FONCTION SUPPRIME UN FICHIER

function unlink_ ( $filename ) {
    // try to force symlinks
    if ( is_link ($filename) ) {
        $sym = @readlink ($filename);
        if ( $sym ) {
            return is_writable ($filename) && @unlink ($filename);
        }
    }

    // try to use real path
    if ( realpath ($filename) && realpath ($filename) !== $filename ) {
        return is_writable ($filename) && @unlink (realpath ($filename));
    }

    // default unlink
    return is_writable ($filename) && @unlink ($filename);
}


function diverse_array($vector) {
    $result = array();
    foreach($vector as $key1 => $value1)
        foreach($value1 as $key2 => $value2)
            $result[$key2][$key1] = $value2;
    return $result;
}



function now($fulldate = true){
    if( $fulldate )
        return date("Y-m-d H:i:s");
    else{
        return date("Y-m-d");
    }
}


function linkto($page = null){
    if( is_null($page) ) { return ""; }
    
    $pages = array("privacy"=> "legal/privacy/",
        "terms"=> "legal/terms"
    );
    
    if( array_key_exists($page, $pages) ){
        return base_url().$pages[$page];
    }
    
    return "";
}




if ( ! function_exists('config'))
{
	function config($item, $for = '', $attributes = array())
	{
		$item = get_instance()->config->item($item);

		if ($for !== '')
		{
			$item = '<label for="'.$for.'"'._stringify_attributes($attributes).'>'.$item.'</label>';
		}

		return $item;
	}
}



if ( ! function_exists('_get'))
{
	function _get($item){
		$item = get_instance()->input->get($item);
		return $item;
	}
	
	function _post($item){
		$item = get_instance()->input->post($item);
		return $item;
	}
}



function _textarea( $str, $maxCharacter = null ){
    return is_null($maxCharacter) ? json_encode( trim( strip_tags( $str ) ) ) : json_encode( character_limiter( trim( strip_tags( $str ) ), $maxCharacter ) );
}


function _name($str, $maxCharacter = 14){
    return character_limiter( trim( str_clean( ( $str ) ) ), $maxCharacter );
}



function str_clean($string, $keepSpaces = true) {
   if( !$keepSpaces ){
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   }
   $str = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
   return trim($str);
}


function emptybox(){
    echo "Aucune donnée disponible pour l'instant.";
}


function showimg($filedir, $w, $h){
    return "https://www.maryfuneral.com/showimg?w=".$w."&h=".$h."&id=".urldecode($filedir);
}



function _echo($data){
    echo json_encode($data);
    return;
}