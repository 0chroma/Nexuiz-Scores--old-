if(!dojo._hasResource["scores.formatting"]){ //_hasResource checks added by build. Do not use _hasResource directly in your code.
dojo._hasResource["scores.formatting"] = true;
dojo.provide("scores.formatting");

scores.formatting.color2html = function(text) {
	var colors=[
		'<span style="color:#000;">',
		'<span style="color:#000;">',
		'<span style="color:#f00;">',
		'<span style="color:#0f0;">',
		'<span style="color:#ff0;">',
		'<span style="color:#00f;">',
		'<span style="color:#3ff;">',
		'<span style="color:#f0f;">',
		'<span style="color:#fff;">',
		'<span style="color:#bbb;">',
		'<span style="color:#777;">'
	]
	text = text.split("^");
	var out = "";
	for(var i=0; i<=text.length-1; i++)
	{
		var s = text[i]
		if(i > 0) out += "</span>";
		out += colors[parseInt(s[0])];
		out += s.substring(1);
	}
}

}