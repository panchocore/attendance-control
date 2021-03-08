/***********************************************************************************************************************************/
/* JQuery AnalogicReloj plugin
   	* Version 0.2.2
    * 2009-07-04 10:56
    * URL: ??????????
    * Description: jQuery Plugin to show a analogic clock using JQuery Rotate plugin Made by Wilq32 URL: http://wilq32.blogspot.com/
    * Author: Ernesto Javier Arana
	* Author Url:http://aullidovertical.blogspot.com
    * Copyright: Copyright (c) 2009 NetoJav under dual MIT/GPL license.
	*
	* Enjoy!!!!!!!!!!! :)
	*
	*Depends:
	*		JQuery 1.2.+.js 
	*		JQueryRemote.js
	*
	*
	*
	* Notes:
		by @Wilq32:
		To use it in IE you need those two lines to be added after <body> tag:
		
		 
		
		<!-- Include the VML behavior -->
		<style>v\: * { behavior:url(#default#VML); display:inline-block }</style>
		<!-- Declare the VML namespace -->
		<xml:namespace ns="urn:schemas-microsoft-com:vml" prefix="v" />
	*bugs: In IE 8  	
/***********************************************************************************************************************************/


(function($){  
		  $.fn.analogicReloj = function(options) {
			 

			  var opc = $.extend({}, $.fn.analogicReloj.defaults, options);
		
			  return this.each(function(){
					var h = $(this).height();
					var left = (h/2)  - 3;
					var $this = $(this);
    				// build element specific options
    				var o = $.meta ? $.extend({}, opc, $this.data()) : opc;
					
					$(o.sec).css('left',left);
					$(o.mint).css('left',left);
					$(o.hour).css('left',left);
						
					setInterval( function() {
							var now = new Date();
							var time = $.fn.analogicReloj.fecha(o.IsUtc);
							
							if(opc.IsUtc==true){			
								UtcHourZone = time + (3600000 * o.utcoffset);			
								now = new Date(UtcHourZone);
							}
										 
							else{
								now = new Date(time);
							}
							//setiando variables
							var seconds = now.getSeconds();
							var hours = now.getHours() 
							var mins = now.getMinutes();
							
							//angulo actual relativo al tiempo 
							var sdegree = seconds * 6;
							var hdegree = hours * 30 + (mins / 2);
							var mdegree = mins * 6;
							
							//usando el plugin jqueryRotate, se rota el elemento  
							$(o.mint).rotate({angle:mdegree});
							$(o.hour).rotate({angle:hdegree});						  
							$(o.sec).rotate({angle:sdegree});	
								  
					}, 1000 );
							
					$this.fadeIn(1000);	
				
						
			});
		};

  
		 //opciones por defecto	  
			  $.fn.analogicReloj.defaults = {
								sec: '#sec',
								mint: '#min',
								hour:'#hour',
								IsUtc:false,
								utcoffset: 0 
			  };
		 
		
  		//método para setiar hora a UTC(tiempo universal coordinado, en español)
		$.fn.analogicReloj.fecha = function(flag){
				var now = new Date();  
				var Time;
				var local= now.getTime();
				
				if(flag==true){
					var utcoffset=now.getTimezoneOffset() * 60000;
					Time = local + utcoffset;
											
				}
										
				else{
					Time = local;
				}
				
				return Time;		
										 		
		};

})(jQuery);

