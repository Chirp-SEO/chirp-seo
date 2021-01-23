var project = project || {};

project.invoke = function() {
	var nodes = document.querySelectorAll('[data-js]'),
		node,
		func;

	for (var i = 0, j = nodes.length; i < j; i++) {
		node = nodes[i];
		func = node.getAttribute('data-js');
		if (this[func]) {
			this[func](node);
		}
	}
};

project.pagescore = function(element) {
  var data = {
    url: $(element).data("url"), 
  }

  $.ajax({
      url: $(element).data("path") + '/lib/ajax/pagescore.php',
      type: 'GET',
      data: data,
      success: function(data){ 
        $(element).html(data);
      },
      error: function(xhr, status, error) {
        var err = eval("(" + xhr.responseText + ")");
        console.log(err.Message);
      }
    });
}

project.invoke();

// Helpers

function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");

  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if(pair[0] == variable){return pair[1];}
  }

  return(false);
}