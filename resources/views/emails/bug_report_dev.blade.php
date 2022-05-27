<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Controles - BugReport</title>
</head>

<body>
	Olá {{ $name }},
	<br>
	Um novo Bug foi encontrado no sistema de Controles, e registrado no sistema pelo(a) {{$usuario}}.
	<p>
		<b>Módulo:</b>
		<br>
		{{$modulo}}
	</p>
	<p>
		<b>Problema:</b>
		<br>
		{{$problema}}
	</p>
	<br>
	Boa Sorte...
</body>
</html>