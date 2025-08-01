 /*!
 * jQuery HiGoogleFonts Library v0.1.0
 * http://asadiqbal.com/
 *
 * Uses select2 jquery library for creating Picker
 *
 * Copyright Hiwaas and other contributors
 * Released under the Apache license 2.0
 * https://github.com/saadqbal/HiGoogleFonts/blob/master/LICENSE
 *
 * Date: 2016-Feb-20
 */

 
 (function ( $ ) {	
		$.fn.higooglefonts = function(options) {
			
			//console.log(this);
			
				var settings = $.extend({										
					selectedCallback: function(params) { },
					loadedCallback: function(params) { }  
				}, options );
			
				
				var fontMap   =   fontMap || [];
				
				fonts.forEach(function(font,index){
					
					fontMap.push({
						id           :   font,
						text         :   font,
						itemId     :   index
					});
					
				});
			
				var y=0;
				this.select2({
					placeholder:"Google Fonts",
					data: fontMap,
					theme: "classic",
					triggerChange: true,
					allowClear: true,
					minimumResultsForSearch: Infinity,
					templateResult: function (result) {
						//var state = $('<div style="background-position:-10px -'+y+'px !important;" class="li_'+result.itemId+'">'+result.text+'</div>');
						var item = '<style>@import url("https://fonts.googleapis.com/css?family=' + result.text.replace(" ", "+") + '");</style><div style="font-family:' + result.text + '">'+result.text+'</div>';
                        var state = $(item);
						y	+=29;
						return state;
					}
				});
				
				this.on("select2:open", function (e) {
					y=0;
				});
				this.on("select2:close", function (e) {
					y=0;
				});
				this.on("select2:select", function (e) {					
					var font_family		=	e.params.data.text;	
					
					if (typeof settings.selectedCallback == 'function') { // make sure the callback is a function
						
						settings.selectedCallback.call(this, e.params.data.text); // brings the scope to the callback
					}
					
					
					
									
					WebFont.load({
						google: {
							families: [font_family]
						},
						fontactive: function(familyName, fvd) {
							
							if (typeof settings.loadedCallback == 'function') { // make sure the callback is a function
						
								settings.loadedCallback.call(this, familyName); // brings the scope to the callback
							}
							
							
						}
					});
					
				});

				// Set empty initial value
				this.val('');
				this.trigger('change');

		  }; /// End of function
		  
		  var fonts = [
              "Abel", "Abril Fatface", "Acme", "Alegreya", "Alex Brush", "Amaranth", "Amatic SC", "Anton", "Arbutus Slab", "Architects Daughter", "Archivo", "Archivo Black", "Arima Madurai", "Asap", "Bad Script", "Baloo Bhaina", "Bangers", "Berkshire Swash", "Bitter", "Boogaloo", "Bree Serif", "Bungee Shade", "Cantata One", "Catamaran", "Caveat", "Caveat Brush", "Ceviche One", "Chewy", "Contrail One", "Crete Round", "Dancing Script", "Exo 2", "Fascinate", "Francois One", "Freckle Face", "Fredoka One", "Gloria Hallelujah", "Gochi Hand", "Great Vibes", "Handlee", "Inconsolata", "Indie Flower", "Kaushan Script", "Lalezar", "Lato", "Libre Baskerville", "Life Savers", "Lobster", "Lora", "Luckiest Guy", "Marcellus SC", "Merriweather", "Merriweather Sans", "Monoton", "Montserrat", "News Cycle", "Nothing You Could Do", "Noto Serif", "Oleo Script Swash Caps", "Open Sans", "Open Sans Condensed", "Oranienbaum", "Oswald", "PT Sans", "PT Sans Narrow", "PT Serif", "Pacifico", "Patrick Hand", "Peralta", "Permanent Marker", "Philosopher", "Play", "Playfair Display", "Playfair Display SC", "Poiret One", "Press Start 2P", "Prosto One", "Quattrocento", "Questrial", "Quicksand", "Raleway", "Rancho", "Righteous", "Roboto", "Roboto Condensed", "Roboto Slab", "Rubik", "Rye", "Satisfy", "Shadows Into Light", "Shojumaru", "Sigmar One", "Skranji", "Slabo 27px", "Special Elite", "Tinos", "Ultra", "UnifrakturMaguntia", "VT323", "Yanone Kaffeesatz"
		  ];
		  
		}( jQuery ));
