@extends('layouts.admin')
@section('content')

    <div id="admin_xmlupdate_wrapper" class="admin_wrapper">

    	<div class="ui big fluid input">
    		<input type="text" id="xml_url_input" data-external="1" value="https://dedra.blob.core.windows.net/cms/xmlexport/cs_xml_export.xml?ppk=133538" /> 
    	</div>

    	<form action="/file" class="dropzone" id="xml_dropzone"> 
            <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
             <div class="dz-message">Klikni pre nahranie súboru</div>
        </form>

    	<div class="ui big blue button" id="xml_upload_btn"><i class="upload icon"></i>Nahraj súbor</div>

    	<div class="ui big teal button" id="xml_update_check_btn"><i class="check icon"></i>Spusť kontrolu</div>
    	
    	<div id="xml_results">
    		<div class="new_categories_count caption">Počet nových kategórií: <value></value></div>
    		<div class="new_products_count caption">Počet nových produktov: <value></value></div>
    		<div class="removed_categories_count caption">Počet zneaktivnených kategórií: <value></value></div>
    		<div class="removed_products_count caption">Počet zneaktivnených produktov: <value></value></div>
            <div class="new_categories_list">
                <div class="caption">Pridané kategórie</div>
                <div class="list"></div>
            </div>
            <div class="new_products_list">
                <div class="caption">Pridané produkty</div>
                <div class="list"></div>
            </div>
            <div class="removed_categories_list">
                <div class="caption">Zneaktivnené kategórie</div>
                <div class="list"></div>
            </div>
            <div class="removed_products_list">
                <div class="caption">Zneaktivnené produkty</div>
                <div class="list"></div>
            </div>

            <div class="ui big green button" id="xml_update_confirm_btn"><i class="upload icon"></i>Aktualizuj!</div>

    	</div>

@stop
