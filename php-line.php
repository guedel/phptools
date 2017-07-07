<?php 
	$instr = '';
	if (isset($_REQUEST['instr'])) {
		$instr = urldecode($_REQUEST['instr']);
	}
	
	if (isset($_REQUEST['qry'])) {
		// Reponse aux requetes ajax.
		try {
				eval($instr);
		}
		catch (Exception $e) {
			echo "Erreur: ". $e->getMessage();
		}
		exit;
	}
?>
<html>
<head>
<title>Console PHP</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">
	// Basé sur l'extrait de code trouvé à 
	// http://www.javascriptsource.com/ajax/simple-ajax-by-jeff-manning-120613062001.html
	function ajax(url) {
		this.xmlhttp;
		this.variables = "";
		this.page = "";
		
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			this.xmlhttp=new XMLHttpRequest();
		}
		else // code for IE6, IE5
			this.xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		this.page = url;
		 
		this.addParam = function(name,value) {
			if (value instanceof String || typeof value === 'string') {
				var plus = encodeURIComponent('+');
				value = value.replace(/\+/g, plus);
			}
			if (this.variables.length == 0) {
				this.variables = encodeURIComponent(name) + "=" + encodeURIComponent(value)
			}
			else {
				this.variables += "&" + encodeURIComponent(name) + "=" + encodeURIComponent(value)
			}
		}
		 
		this.sendRequest = function(method, onready, onerror) {
			//the instructions param takes the form of an eval statement
			xmlhttp = this.xmlhttp;
			if(method == 'GET') {
				page = this.page + "?" + this.variables;
				xmlhttp.open("GET", page, true);
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						if (onready != null) {
							onready(xmlhttp.responseText);
						}
					}
				}
				xmlhttp.send();
		 
			}
			else {
				xmlhttp.open("POST", this.page, true);
				//Send the proper header information along with the request
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				// Les 2 lignes suivantes ne sont pas safe. Supprimées.
				//xmlhttp.setRequestHeader("Content-length", this.variables.length);
				//xmlhttp.setRequestHeader("Connection", "close");
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						if (onready != null) {
							onready(xmlhttp.responseText);
						}
					} 
				}
				xmlhttp.send(this.variables);
			}
		}
	}
	
</script>
</head>
<body>
<form id="frmInput" method='get'>
	<input type='button' onclick='btnclick()' value='Exécuter'/>
	<p><textarea id="instr" name='instr' rows='10' cols='80'><?php echo $instr; ?></textarea></p>
</form>
<fieldset style='border: 1px solid red'>
	<legend>Résultat</legend>
	<div id="result">
	</div>
</fieldset>
<script type="text/javascript">
	function btnclick() {
		var http = new ajax('php-line.php');
		var instr = document.getElementById("instr").value;
		http.addParam('instr', instr );
		http.addParam('qry', true);
		http.sendRequest( 'POST', function(response) {
			var item = document.getElementById('result');
			item.innerHTML = response;
		});
	}
</script>
</body>
</html>
