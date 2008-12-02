{foreach $search_item_list as $search_item}
	{def $ident=$search_item.ident}
	{include uri="design:attributefilter/search_item.tpl" item=$search_item searchdata=$searchdata[$ident] }
{/foreach}