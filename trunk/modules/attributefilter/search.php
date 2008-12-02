<?php
include_once( "kernel/common/template.php" );
include_once( "extension/nmattributefilter/classes/search.php" );

$tpl 						= templateInit();
$offset						= $Params['offset'];

$http 						= eZHTTPTool::instance();
$search						= new search();
$ini 						= eZINI::instance( 'multipleattribute.ini' );
$class_ident				= $Params[ 'ClassIdent' ];
$offset						= $Params['Offset'];

if ( $search->checkClassIdent( $class_ident ) ) 
{

	// If a new search is made
	if  ( $http->postVariable( 'search' ) )
	{
		$searchdata = $http->postVariable( 'searchdata' );
		
		// setting the search in a session variable for use in paging and remembering.
		$http->setSessionVariable( 'searchdata_' . $class_ident, $searchdata );
	}
	else
	{
		// if a previous search has been made in this session we use this data.
		if ( $http->hasSessionVariable( 'searchdata' ) )
		{
			$searchdata = $http->sessionVariable( 'searchdata_' . $class_ident );
		}
		else
		{
			$searchdata = false;
		}
	}
	
	// if there is some searchdata
	if ( $searchdata )
	{
	
		// does the search
		$result = $search->doSearch( $searchdata, $class_ident, $offset );
		// setting the variables
		$tpl->setVariable( 'result_all', $result[ "result_all" ] );
		$tpl->setVariable( 'result_offset', $result[ "result_offset" ] );
		$tpl->setVariable( 'page_limit', $ini->variable( $class_ident, 'SearchLimit' ) );
		$tpl->setVariable( 'offset', $offset );
	}
	
	// fetching search items for the form.
	$tpl->setVariable( 'search_item_list', $search->fetchSearchItems( $class_ident ) );
	$tpl->setVariable( 'searchdata', $searchdata );
	$tpl->setVariable( 'class_ident', $class_ident );
}
else
{
	$tpl->setVariable( 'error', ezi18n( 'attributefilter', 'The class ident was not found' ) );
}

$Result[ 'path' ] = array( 
						array( 'text'  => ezi18n( 'attributefilter', 'Search' ),
								'url'  => '/'),
						array(	'text' => ezi18n( 'attributefilter', 'search' ), 
								'url' => false,
								'ident'	=> 'attributefilter' ) );
						
$Result['content'] =& $tpl->fetch( "design:attributefilter/search.tpl" );

?>