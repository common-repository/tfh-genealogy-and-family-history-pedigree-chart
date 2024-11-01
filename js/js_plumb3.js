jsPlumb.ready(function() {

    var start= 'third_box';
	
	var end = ['sixth_box','seventh_box'];     

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

});