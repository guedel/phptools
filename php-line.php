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
    <link rel="stylesheet" href="/components/codemirror/lib/codemirror.css">
    <link rel="stylesheet" href="/components/codemirror/theme/monokai.css">
    <script src="/components/codemirror/lib/codemirror.js"></script>
    <script src="/components/codemirror/mode/xml/xml.js"></script>
    <script src="/components/codemirror/mode/javascript/javascript.js"></script>
    <script src="/components/codemirror/mode/css/css.js"></script>
    <script src="/components/codemirror/mode/clike/clike.js"></script>
    <script src="/components/codemirror/mode/php/php.js"></script>

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
  <div style="width:75%">
    <input type='button' onclick='btnExec_click()' value='Exécuter'/>
    <input type="button" onclick="btnClear_click()" value="Effacer" />
    <input type="button" onclick="btnStore_click()" value="Sauver" />
    <!--
    <div id="store_list">
      <ol>
        <li><a onclick="load_code()">Sample 1</a></li>
        <li><a onclick="load_code()">Sample 2</a></li>
      </ol>
    </div>
    -->
    <p><textarea id="instr" name='instr' rows='50' cols='180'><?php echo $instr; ?></textarea></p>
  </div>

  <div>
    <ul id="last_queries">
    </ul>
    <input type="button" value="Vider" onclick="clearList()" />
  </div>

</form>
<fieldset style='border: 1px solid red'>
	<legend>Résultat</legend>
	<div id="result">
	</div>
</fieldset>
<script type="text/javascript">

  var editor = CodeMirror.fromTextArea(document.getElementById('instr'), {
    lineNumbers: true,
    matchBrackets: true,
    //mode: "application/x-httpd-php", // pour du mélange php/html. Non supporté par l'interpréteur
    mode: "text/x-php", // pour le code php pur
    enterMode: "keep",
    tabMode: "shift",
    theme: "monokai",
    smartindent: true
  });

  window.onload = function() {
    // chargement de la dernière requête
    load_code('last-query');

    // chargement de la liste des précédentes requêtes
    var cnt = localStorage.length;
    for (var idx = 0; idx < cnt; ++idx) {
      key = localStorage.key(idx);
      if (key.substr(0, 5) === 'query') {
        addToQueriesList(key, localStorage.getItem(key));
      }
    }
  }

	btnExec_click = function() {
      var http = new ajax('php-line.php');
      var query = editor.doc.getValue();
      http.addParam('instr',  query);
      http.addParam('qry', true);
      storeQuery(query);
      http.sendRequest( 'POST', function(response) {
              var item = document.getElementById('result');
              item.innerHTML = response;
          },
          function(code) {
              alert("Erreur code " + code);
          }
      );
	}

    /**
     *
     * @param {string} query
     * @returns {undefined}
     */
    storeQuery = function(query) {
     localStorage.setItem("last-query", query);
    };

    saveQuery = function(query) {
      var curDate = new Date();
      var key = "query-" + curDate.toLocaleString();
      localStorage.setItem(key, query);
      addToQueriesList(key, query);
    };

    addToQueriesList = function(key, query) {
      var list = document.getElementById('last_queries');
      var elt = document.createElement('li');
      elt.setAttribute('onClick', 'load_code("' + key + '")');
      if (key.substr(0, 5) === 'query') {
        key = key.substr(6);
      }
      var txt = key + ':' + query.substr(0, 80);
      elt.innerText = txt;
      list.appendChild(elt);
    };

    btnStore_click = function() {
      var query = editor.doc.getValue();
      saveQuery(query);
    };

    load_code = function(key) {
      var code = localStorage.getItem(key);
      if (code !== null) {
        editor.doc.setValue(code);
      }
    };

    clearList = function()  {
      var cnt = localStorage.length;
      for (var idx = cnt - 1; idx >= 0; --idx) {
        var key = localStorage.key(idx);
        if (key === null) {

        } else if (key.substr(0, 5) === 'query') {
          localStorage.removeItem(key);
        }
      }
      var list = document.getElementById('last_queries');
      list.innerHTML = "";
    };

    btnClear_click = function() {
      editor.doc.setValue("");
      localStorage.setItem("last-query", "");
    };

</script>
</body>
</html>
