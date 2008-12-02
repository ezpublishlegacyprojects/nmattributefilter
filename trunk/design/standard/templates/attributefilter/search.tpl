{$error}

<h2>{ezini( $class_ident, 'SearchHeading', 'multipleattribute.ini')}</h2>
<form action={concat("attributefilter/search/", $class_ident)|ezurl} method="post">
	{include uri="design:attributefilter/searchform.tpl" search_item_list=$search_item_list }
<input type="submit" name="search" value="{'Search'|i18n('advancedsearch')}" />
</form>


{if $result_all}
	Result:<br/><br/>
	{foreach $result_offset as $result}
		{$result.name|wash}<br/>
	{/foreach}
		{def $parameters=hash( 'offset', $offset )}
	     {include name=navigator
	         uri='design:navigator/google.tpl'
	         page_uri=concat("attributefilter/search/", $class_ident)
	          item_count=$result_all|count
	         view_parameters=$parameters
	         item_limit=$page_limit}
{/if}