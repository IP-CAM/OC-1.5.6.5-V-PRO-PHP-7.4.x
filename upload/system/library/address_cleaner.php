<?php
// v1.3
function cleanaddress($str, $is_name=false) {
/*
Exceptions lists to override the exceptions in the main function.
Main function will convert the exceptions on all fields.  If there is a specific name conversion but it should be applied
to addresses then put it in the name section here and it will override the main function without affecting address fields.
*/
   if ($is_name) {
		// Exceptions for Name Fields
       $all_uppercase = '';
       $all_lowercase = 'Van|Der|Vit|Von';
   } else {
       // /Exceptions for Addresse Fields
       $all_uppercase = 'Po|Pob|P.o.b.|Rm|Rr|Se|Sw|Ne|Nw|Aly|Anx|Apt|Ave|Bch|Blvd|Bldg|Bsmt|Gdns';
       $all_lowercase = 'Der|Die|Das|Von';
   }

/* 
Exceptions in lower case are words you want to be all lowercase.
Exceptions all in upper case are words you want to be all uppercase.
These exceptions apply to name and address fields. Use above lists for exceptions.
*/
	$exceptions = array("a", "and", "as", "by", "in", "of", "or", "to", "on", "de", "la", "le", "las", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X");
	
	$delimiters = array(" ", "-", ".", "'", "O'", "Mc", "Mac", "Fitz");

	$str = mb_convert_case($str, MB_CASE_TITLE, "UTF-8");

	foreach ($delimiters as $dlnr => $delimiter){
		$words = explode($delimiter, $str);
		$newwords = array();
		foreach ($words as $wordnr => $word){
			if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)){
			// check exceptions list for any words that should be in upper case
				$word = mb_strtoupper($word, "UTF-8");
			} elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)){
			// check exceptions list for any words that should be in lower case
				$word = mb_strtolower($word, "UTF-8");
			} elseif (!in_array($word, $exceptions) ){
			// convert to uppercase (non-utf8 only)
				$word = ucfirst($word);
			}
			array_push($newwords, $word);
		}
		$str = join($delimiter, $newwords);
	}

	if ($all_uppercase) {
       // capitalize acronymns and initialisms e.g. PHP
		$str = preg_replace_callback(
			"/\\b($all_uppercase)\\b/",
			function ($zed) {
				return mb_strtoupper($zed[1]);
			},	   
			$str
		);
	}
	if ($all_lowercase) {
		// decapitalize short words e.g. and, on, in etc.
		if ($is_name) {
			// all occurences will be changed to lowercase
			$str = preg_replace_callback(
				"/\\b($all_lowercase)\\b/",
				function ($why) {
					return mb_strtolower($why[1]);
				},	   
			   $str
			);
		} else {
			// first and last word will not be changed to lower case (i.e. titles)
			$str = preg_replace_callback(
				"/(?<=\\W)($all_lowercase)(?=\\W)/",
				function ($zed) {
					return mb_strtolower($zed[1]);
				},	   
				$str
			);
		}
	}

	// decapitalize 'S
	$str = str_replace("'S", "'s", $str); 
	
	// uncomment the line below to change commas for semi-colon
	//$str = str_replace(',', ';', $str); 

   return $str;
}
?>