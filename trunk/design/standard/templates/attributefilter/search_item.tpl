<div class="block">
	<label>{$item.name}</label>

	{switch match=$item.type}
	 
	    {case match='relation'}
	    
	    	{* If a parent node id is set *}
	    	{if $item.parent_node_id}
	    		
	    		{* fetch the parent node*}
	    		{def $parent_node=fetch( 'content', 'node', hash( 'node_id', $item.parent_node_id ) )}

	    		{* if a parent node excist *}
	    		{if $parent_node}
	    			{def $children_list=fetch( 'content', 'list', hash( 	'parent_node_id', $parent_node.node_id,
	    																'sort_by', $parent_node.sort_array ) )}
	  
	    			<select name="searchdata[{$item.ident}]{if $item.multiple}[]" multiple{else}"{/if}>
	    				{if eq( $item.multiple, false() )}<option value="0">{'Any'|i18n('advancedsearch')}</option>{/if}
	    				{foreach $children_list as $children}
	    					<option value="{$children.contentobject_id}"{if $searchdata|contains( $children.contentobject_id )} selected="selected"{/if}>{$children.name|wash}</option>
	    				{/foreach}
	    			</select>
	    		{/if}
	    	{/if}
	    {/case}
	 
	    {case match='checkbox'}
	        <input type="checkbox" name="searchdata[{$item.ident}]" value="1" {if eq( $searchdata, '1' )} checked{/if} />
	    {/case}
	 
	 	{case match='text'}
	 		<input type="text" name="searchdata[{$item.ident}]" value="{$searchdata}" />
	 	{/case}
	    {case}
	    {/case}
	 
	{/switch}
</div>
