<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Tour of Web Architecture</title>
<link href="../scripts/demo.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../scripts/ajax.js"></script>
<script type="text/javascript" src="../scripts/demo.js"></script>
</head>

<body onload="showInfo();">

It is <span id="current"></span> 
<br/>
<span id="welcome"></span> <span id="favorite"></span>
<br/>

<p class=heading>
Here are some planets:
</p>

<table>

<tr>
<td><input class=arrow type=button value="&lt;" onclick="rotate(-1);"></td>
<td id="image1"><img src="../images/mars.jpg" height=150 width=150/></td>
<td id="image2"><img src="../images/jupiter.jpg" height=150 width=150/></td>
<td id="image3"><img src="../images/saturn.gif" height=150 width=150/></td>
<td><input class=arrow type=button value="&gt;" onclick="rotate(+1);"></td>
</tr>

<tr>
<td></td>
<td id="label1"><a href="http://en.wikipedia.org/wiki/Mars">Mars</a></td>
<td id="label2"><a href="http://en.wikipedia.org/wiki/Jupiter">Jupiter</a></td>
<td id="label3"><a href="http://en.wikipedia.org/wiki/Saturn">Saturn</a></td>
<td></td>
</tr>

</table>

<form name="infoForm">

<p>
 <label for="firstName">Name:</label> 
 <input type=text size=30 id="firstName" name="firstName" value=""/>
</p>

<p>
<select id="planet" name="planet">
 <option value="">Favorite Planet</option>
 <option value="Mercury">Mercury</option>
 <option value="Venus">Venus</option>
 <option value="Earth">Earth</option>
 <option value="Mars">Mars</option>
 <option value="Jupiter">Jupiter</option>
 <option value="Saturn">Saturn</option>
 <option value="Uranus">Uranus</option>
 <option value="Neptune">Neptune</option>
</select>
</p>

<p>
<input type=submit value="Submit"
       onclick="showInfo(); return false;"/>
</p>

</form>

<p>
<a href="../">Return to index</a>
</p>


</body>
</html>


