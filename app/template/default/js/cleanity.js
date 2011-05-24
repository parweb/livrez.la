$(function(){
	//WYSIWYG
	//$('textarea').cleditor();
	
	//gestion de lajax
	$('select#Region').live('change', function() {
		$.post( URL+'ajax:'+$('body').attr('module')+'/list/region:'+$(this).val()+'/', function(data) {
			$('#content-in').html(data);
		});
	});
	$('select#Departement').live('change', function() {		
		$.post( URL+'ajax:'+$('body').attr('module')+'/list/departement:'+$(this).val()+'/', function(data) {
			$('#content-in').html(data);
		});
	});
	$('select#Annee').live('change', function() {		
		$.post( URL+'ajax:'+$('body').attr('module')+'/list/annee:'+$(this).val()+'/', function(data) {
			$('#content-in').html(data);
		});
	});
	$('select#Filiere').live('change', function() {		
		$.post( URL+'ajax:'+$('body').attr('module')+'/list/filiere:'+$(this).val()+'/', function(data) {
			$('#content-in').html(data);
		});
	});
	$('select#Ville').live('change', function() {		
		$.post( URL+'ajax:'+$('body').attr('module')+'/list/ville:'+$(this).val()+'/', function(data) {
			$('#content-in').html(data);
		});
	});
	
	$('ul#menu li .top-level').parent().mouseover( function(e) {
		$(this).addClass( 'hover' );
	});
	
	$('ul#menu li .top-level').parent().mouseout( function(e) {
		$(this).removeClass( 'hover' );
	});
	
	$('ul#menu li ul li').mouseover( function(e) {
		$(this).addClass( 'hover' );
	});
	
	$('ul#menu li ul li').mouseout( function(e) {
		$(this).removeClass( 'hover' );
	});
	
	$('#one').css( 'margin', 'auto' );
});