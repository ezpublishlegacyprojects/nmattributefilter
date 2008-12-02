<?php
class search 
{
	
	function search() 
	{
	
	}
	/*
	 *  Return the main settings from the ini-file
	 * 
	 *  @return array
	 * 
	 */
	function fetchSettings( $class_ident )
	{
		$ini 				= eZINI::instance( 'multipleattribute.ini' );
		
		return array( 
					"search_class_name"			=> $class_ident,
					"search_in_parent_node_id"	=> $ini->variable( $class_ident, 'SearchInParentNodeID' ),
					"search_depth"				=> $ini->variable( $class_ident, 'SearchDepth' ),
					"limit"						=> $ini->variable( $class_ident, 'SearchLimit' )
					);
	}
	
	/*
	 * Check if the class ident is configured
	 * @param string $class_ident
	 * @return boolean
	 *  
	 */
	function checkClassIdent( $class_ident )
	{
		$ini	= eZINI::instance( 'multipleattribute.ini' );
		$list	= $ini->variable( 'MainSettings', 'SearchClassNameList' );
		
		if ( in_array( $class_ident, $list ) )
		{
			return true;
		}
		return false;
	}
	/*
	 * Fetch all searchitems
	 * 
	 * @return array
	 */
	function fetchSearchItems( $class_ident )
	{
		// iniate the ini file
		$ini 				= eZINI::instance( 'multipleattribute.ini' );

		// fetch list of items to search in
		$item_list			= $ini->variable( $class_ident, 'SearchItems' );
		
		$searh_item_list 	= array();
		
		// check if there is some search items
		if ( is_array( $item_list ) )
		{
			// looping through the list an fetch attributes
			foreach( $item_list as $item )
			{
				$search_item_list[ $item ] = array(
													"name"						=> $ini->variable( $class_ident.'_' . $item, 'Name' ),
													"ident"						=> $ini->variable( $class_ident.'_' . $item, 'AttributeIdentificator' ),
													"id"						=> $ini->variable( $class_ident.'_' . $item, 'AttributeID' ),
													"type"						=> $ini->variable( $class_ident.'_' . $item, 'AttributeType' ),
													"parent_node_id"			=> $ini->variable( $class_ident.'_' . $item, 'ParentNodeID' ),
													"multiple"					=> $ini->variable( $class_ident.'_' . $item, 'Multiple' ),
													"extended_type"				=> $ini->variable( $class_ident.'_' . $item, 'ExtendedType' ),
													"extended_attribute_min"	=> $ini->variable( $class_ident.'_' . $item, 'ExtendedAttributeMin' ),
													"extended_attribute_max"	=> $ini->variable( $class_ident.'_' . $item, 'ExtendedAttributeMax' )
													);
			}
			return $search_item_list;
		}
		return false;	
	}
	

	/*
	 * Formating search criteries to put in attribute_filter 
	 * 
	 * @param string $identificator
	 * @param array $data
	 * 
	 * @return array/boolean
	 * 
	 */
	function formatSearchItem( $identificator, $data, $class_ident )
	{

		
		// if the searchdata is an array we check that the values is not blank.
		if ( is_array( $data ) )
		{
			if ( $data[0] != '' and $data[0] != 0 )
			{
				$include = true;
			}
		}
		else
		{
			$include = true;
		}
		// check if data is not blank
		if ( $data != '' and $include == true  )
		{

			// fetching basic settings
			$settings	= $this->fetchSettings( $class_ident );
			
			// fetching searchitemlist
			$item_list 	= $this->fetchSearchItems( $class_ident );

			// check if the field we are searching for is defined in the ini file
			if ( array_key_exists( $identificator, $item_list  ) )
			{
				$current_item = $item_list[ $identificator ];
				
				// check that type is specified
				if ( $current_item[ "type" ] != '' )
				{
				
					// returing correct data, given type of attribute
					switch ( $current_item[ "type" ] )
					{
						// relatiion
						case relation:
						
							// if there is more then one relation
							if ( $current_item[ "multiple" ] )
							{
								return false;
							}
							else
							{
								return array( $current_item[ "id" ], '=', $data );
							}
							break;
						
						case text:
							// if the value should be bigger and smaller then two attributes
							if ( $current_item[ "extended_type" ] == 'between_two_attributes' )
							{
								return array( array(  $current_item[ "extended_attribute_min" ], '<', $data ), array( $current_item[ "extended_attribute_max" ], '>', $data ) );
							}
							else
							{
								return array( $current_item[ "id" ], 'like', "*". $data ."*" );
							}
						default: 
							return array( $current_item[ "id" ], '=', $data );
							break;
					}
				}
			}
		}
		return false;
		
				
	}

	/*
	 * Function to generate extended attribute filter for searching in object relation list.
	 * 
	 * @param array $searchdata
	 * @return array $extended_filter
	 * 
	 */
	function fetchExtendedFilter( $searchdata, $class_ident )
	{
		// if there is some searchdata
		if ( is_array( $searchdata ) )
		{
			$item_list 	= $this->fetchSearchItems( $class_ident );
			$extended_filter = array( );
			foreach( $searchdata as $identificator => $data )
			{
				$multiple = $item_list[ $identificator ][ "multiple" ];
				if ( $multiple )
				{
					//	$extended_filter[] = 'and';
					$extended_filter[] = $item_list[ $identificator ][ "id" ];
					$extended_filter[] = $data;
				}
			}
			
			if ( count( $extended_filter ) > 1 )
			{
				return $extended_filter;
			}
		}
		return false;
	}
	
	/*
	 * The main function to be called by the view. 
	 * 
	 * @param array $searchdata
	 * @param int $offset
	 * 
	 * @return array $result( "result_all", "result_offset" )
	 * 
	 */
	function doSearch( $searchdata, $class_ident, $offset=false )
	{
		// fetching main settings
		$settings 		= $this->fetchSettings( $class_ident );
		$node_id		= $settings[ "search_in_parent_node_id" ];
		$search_depth	= $settings[ "search_depth" ];
		$limit			= $settings[ "limit" ];
		
		// making the parameters
		$params 		= array();
		$params[ 'ClassFilterType' ] 	= 'include';
		$params[ 'ClassFilterArray'] 	= array( $class_ident );
		$params[ 'Depth' ]				= $search_depth;
		
		// generating attribute filters
		$attributefilter = $this->formatSearchArray( $searchdata, $class_ident );
		
		// if the search has data that need attribute filters
		if ( $attributefilter )
		{
			$params[ 'AttributeFilter' ] = $attributefilter;
		}
		
		// generating extended filters
		$extendedfilter = $this->fetchExtendedFilter( $searchdata, $class_ident );
		
		// if the search has data that need extended filters. (object relation list)
		if ( $extendedfilter )
		{
			$params[ 'ExtendedAttributeFilter' ] = array( 'id' => 'ObjectRelationFilter', 
															'params' => $extendedfilter );
		}	
		// fetching all the results
		$result_all		= eZContentObjectTreeNode::subTreeByNodeID( $params, $node_id );
		
		$result_offset 	= false;
		
		// if a limit is set
		if ( $limit )
		{
			$params[ 'Offset' ] = $offset;
			$params[ 'Limit' ] 	= $limit;
			
			// fethcing x results based on $limit
			$result_offset	 	= eZContentObjectTreeNode::subTreeByNodeID( $params, $node_id );
		}
		
		// returing the result
		$result = array( "result_all" => $result_all, "result_offset" => $result_offset );
		return $result;
		
	}
	/*
	 *  Formating the searchdata
	 *  @param array $searchdata
	 * 
	 *  @return array The Attribute Filter
	 * 
	 * 
	 * 
	 */
	function formatSearchArray( $searchdata, $class_ident )
	{
		
		// if there is some searchdata
		if ( is_array( $searchdata ) )
		{
			$attribute_filter = array();
			foreach( $searchdata as $identificator => $data )
			{
				// formating the searchdata
				$output = $this->formatSearchItem( $identificator, $data, $class_ident );
				
				// if the formating had return value
				if ( $output )
				{
					$attribute_filter[] = $output;
				}
			}
			// if the search had data that needed some attribute filter
			if ( is_array( $attribute_filter ) and count( $attribute_filter ) > 0) 
			{
				$attribute_filter_formated = array( 'and' );
				
				// loop through the attributefilters
				foreach( $attribute_filter as $new_attribute_filter )
				{
				    // if the attribute filter contains array
				    // Must check, because when there is a filter checking between to values we haft to put both in the root of the array.
					if ( is_array( $new_attribute_filter[0] ) )
					{
						foreach( $new_attribute_filter as $new_attribute_filter_splitted )
						{
							$attribute_filter_formated[] = $new_attribute_filter_splitted;
						}
					}
					else
					{
						$attribute_filter_formated[] = $new_attribute_filter;
					}
				}
				return $attribute_filter_formated;
			}
			
		}
		return false;
	}

}
?>