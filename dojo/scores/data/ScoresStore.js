if (!dojo._hasResource["scores.data.ScoresStore"]) { //_hasResource checks added by build. Do not use _hasResource directly in your code.
	dojo._hasResource["scores.data.ScoresStore"] = true;
	dojo.provide("scores.data.ScoresStore");
	
	dojo.require("dojo.data.util.filter");
	dojo.require("dojo.data.util.simpleFetch");
	
	dojo.declare("scores.data.ScoresStore", null, {	
		//	summary:
		//		The ScoresStore implements the dojo.data.api.Read API and reads
		//		data from files in nexuiz scores log format. References to other
		//		items are not supported as attribute values in this datastore.
		
		
	});
}