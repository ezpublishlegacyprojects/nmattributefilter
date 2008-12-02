<?
/*
[MainSettings]
# List of different classes to search for based on params
SearchClassNameList[]
SearchClassNameList[]=plant
SearchClassNameList[]=article

[plant]
# Top level for where to start the search
SearchInParentNodeID=162

# How deep the search goes in the hiarchy
SearchDepth=4

# Page limit on displaying search result
SearchLimit=1

# Heading of the searchpage
SearchHeading=S&oslash;k i planteleksikonet

# Predefine attributes wich the user can search in. 
# If the attribute is not in this list it will not appear in the search form
SearchItems[]
SearchItems[]=flower_color
SearchItems[]=flourishes
SearchItems[]=hardness_zones
SearchItems[]=snail_prof
SearchItems[]=deer_prof
SearchItems[]=height

# Attribute blocks
# Defines the search attribute with necesarry values
#
# Ex.
# 
# The name given in SearchItems[]
# [my_attribute]
# 
# Name to display in the searchform.
# Name=My attribute
#-
# Name for the form-elements.
# AttributeIdentificator=my_attribute
#-
# Type of attribute. Supported: relation, checkbox and text
# relation 	=> the attribute must be a relation or relation list (if relation list, also see 'Multiple' )
# checkbox 	=> the attribute must be a checkbox. 
# text		=> the attribute could string, int and so on.
# AttributeType=relation
#-
# ID for the attribute on the class to search for
# AttributeID=1
#-
# The parent node id. Only in use on 'relation'. This tells the  advancedsearch where to look for relation objects
# ParentNodeID=2
#-
# If there are multiple relations this must be set to true. Takes only effect if AttributeType is set to 'relation'.
# This tells the advancedsearch to switch from standard select-box to multiple-select-box.
# Multiple=true
#-
# Special type. Supported: between_two_attribues 
# If this is set the value in the search must be bigger than the min-value, and smaller than the max-value¬
# Requires: ExtendedAttributeMin, ExtendedAttributeMax
#-
# ID to the attribute the value should be bigger then
# ExtendedAttributeMin
#-
# ID to the attribute the value should be lower then
# ExtendedAttributeMax


[plant_flower_color]
Name=Farge
AttributeIdentificator=flower_color
AttributeType=relation
AttributeID=430
ParentNodeID=234
Multiple=true

[plant_flourishes]
Name=Blomstringstid
AttributeIdentificator=flourishes
AttributeType=relation
AttributeID=422
ParentNodeID=184
Multiple=true

[plant_hardness_zones]
Name=Herdighet
AttributeIdentificator=hardness_zones
AttributeType=relation
AttributeID=465
ParentNodeID=175
Multiple=true

[plant_snail_prof]
Name=Sneglefri
AttributeIdentificator=snail_prof
AttributeType=checkbox
AttributeID=425

[plant_deer_prof]
Name=R&aring;dyrfri
AttributeIdentificator=deer_prof
AttributeType=checkbox
AttributeID=426

[plant_height]
Name=H&oslash;yde (i cm)
AttributeIdentificator=height
AttributeType=text
ExtendedType=between_two_attributes
ExtendedAttributeMin=415
ExtendedAttributeMax=416

[article]
# Top level for where to start the search
SearchInParentNodeID=163

# How deep the search goes in the hiarchy
SearchDepth=3

# Page limit on displaying search result
SearchLimit=1


# Heading of the searchpage
SearchHeading=Filtrer artikler p&aring; sesonger

# Predefine attributes wich the user can search in. 
# If the attribute is not in this list it will not appear in the search form
SearchItems[]
SearchItems[]=seasons

[article_seasons]
Name=Sesonger
AttributeIdentificator=seasons
AttributeType=relation
AttributeID=464
ParentNodeID=262
Multiple=true
*/
?>
