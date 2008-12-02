<?php

$Module 						= array( "name" => "Advanced search" );

$ViewList 						= array();

$ViewList["search"] 		= array("functions" 		=> array( 'search' ),
									"script" 			=> "search.php",
									"params"			=> array( 'ClassIdent' ),
									'unordered_params'	=> array( 'offset'		=>	'Offset' )
									);

$FunctionList['search'] = array( );

?>
