<?php
include_once( "extension/nmattributefilter/classes/search.php" );
class TemplateAttributeFilterFormOperator
{
    /*!
      constructor - does nothing
    */
    function TemplateAttributeFilterFormOperator()
    {
    }

    /*!
     
eturn an array with the template operator name.
    */
    function operatorList()
    {
        return array( 'attributefilterform' );
    }
    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
    	return array( 'attributefilterform' => array( ) );
    }
    /*!
     Eksekverer PHP-funksjonen for operatoren cleanup og modifiserer \a $operatorValue.
    */
    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
    	// iniate objecs
		$search = new search;
		$class_ident = $operatorValue;
		
		// fetch best partners
		$operatorValue = $search->fetchSearchItems( $class_ident );
    }
}

?>
