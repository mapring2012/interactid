<!doctype html> 
<html lang="en">
   <head>
		<title>Example with click, drag events with geo search - Google maps jQuery plugin</title>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="content-language" content="en" />
		<meta name="author" content="Johan Säll Larsson" />
		<meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="keywords" content="Google maps, jQuery, plugin, geo search" />
		<meta name="description" content="An example with click and drag events, geo localization and geo search using jQuery and Google maps v3" />
		<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
		<meta name="DC.title" content="Example with click, drag events with geo search - Google maps jQuery plugin" />
		<meta name="DC.subject" content="Google maps;jQuery;plugin;geo search" />
		<meta name="DC.description" content="An example with click and drag events, geo localization and geo search using jQuery and Google maps v3" />
		<meta name="DC.creator" content="Johan Säll Larsson" />
		<meta name="DC.language" content="en" />
		<style>
		.map {
			height: 400px;
			width: 100%;
		}
		.ui-dialog
		{
			background:#fff;
			border:1px solid #ddd;
			padding:5px;
		}
		.ui-dialog-content {height:10px!important;}
		</style>
		<script type="text/javascript" src="js/modernizr.min.js"></script>
    </head>
    <body>
		<div id="map_canvas" class="map rounded"></div>
		<div id="dialog"></div>
		<div id="countrys">Contry: <input id="txtcountry" class="txt" name="txtcountry" value=""/></div>
		<div id="states">State: <input id="txtstate" class="txt" name="txtstate" value=""/></div>
		<div id="addresss">Address: <input id="txtaddress" class="txt" name="txtaddress" value=""/></div>
				
				
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
		<script type="text/javascript" src="js/jquery-1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/underscore-1.2.2/underscore.min.js"></script>
		<script type="text/javascript" src="js/backbone-0.5.3/backbone.min.js"></script>
		<script type="text/javascript" src="js/prettify/prettify.min.js"></script>
		<script type="text/javascript" src="js/demo.js"></script>
		<script type="text/javascript" src="js/jquery.ui.map.js"></script>
		<script type="text/javascript" src="js/jquery.ui.map.services.js"></script>
		<script type="text/javascript" src="js/jquery.ui.map.extensions.js"></script>
		<script type="text/javascript">
            $(function() { 
				demo.add(function() {
					$('#map_canvas').gmap({ 'disableDefaultUI':true, 'callback': function(map) {
						var self = this;
						self.set('openDialog', function(marker) {
							$('#dialog'+marker.__gm_id).dialog({'modal':true, 'title': 'Edit and save point', 'buttons': { 
								'No': function() { $(this).dialog('close'); marker.setMap(null); return false; },
								'Save': function() { $(this).dialog('close'); return false; }
							}});
						});
						self.set('findLocation', function(location, marker) {
							self.search({'location': location}, function(results, status) {
								if ( status === 'OK' ) {
									$.each(results[0].address_components, function(i,v) {
										if ( v.types[0] == "administrative_area_level_1" || v.types[0] == "administrative_area_level_2" ) {
											$('#state'+marker.__gm_id).val(v.long_name);
										} else if ( v.types[0] == "country") {
											$('#country'+marker.__gm_id).val(v.long_name);
										}
									});
									marker.setTitle(results[0].formatted_address);
									$('#address'+marker.__gm_id).val(results[0].formatted_address);
									self.get('openDialog')(marker);
								}
							});
						});
						$(map).click( function(event) {
							self.addMarker({'position': event.latLng, 'draggable': true, 'bounds': false}, function(map, marker) {
								$('#countrys').html('Contry: <input id="country'+marker.__gm_id+'" class="txt" name="country" value=""/>');
								$('#states').html('State: <input id="state'+marker.__gm_id+'" class="txt" name="state" value=""/>');
								$('#addresss').html('Address: <input id="address'+marker.__gm_id+'" class="txt" name="address" value=""/>');
								$('#dialog').append('<form id="dialog'+marker.__gm_id+'" method="get" action="/" style="display:none;">Do you want to save?</form>');
								self.get('findLocation')(marker.getPosition(), marker);
							}).dragend( function(event) {
								self.get('findLocation')(event.latLng, this);
							}).click( function() {
								self.get('openDialog')(this);
							})
						});
					}});
				}).load();
			});		
        </script> 
	</body>
</html>