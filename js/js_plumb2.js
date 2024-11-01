jsPlumb.ready(function() {

    var start= 'second_box';
	
	var end = ['fourth_box','fifth_box'];     

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