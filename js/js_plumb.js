jsPlumb.ready(function() {


  

    var start = 'first_box';
	
	var end = ['second_box','third_box'];    

	for(var i=0;i<end.length;i++){
		
		jsPlumb.connect({
		source:start,
		target:end[i],
		connector: ["Straight"],
		anchor: ["Left", "Right"],
		endpoint:"Dot",
	    endpointStyle:{radius:1},
		paintStyle:{ strokeStyle:"lightgray", lineWidth:2, }
	    
						})

	}
	
	$(window).resize(function(){
      jsPlumb.repaintEverything();
  });


 


});