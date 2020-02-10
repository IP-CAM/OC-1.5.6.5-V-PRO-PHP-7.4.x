<?php echo $header; ?>
 <script>function deleteAllCookies(){for(var e=document.cookie.split(“;”),o=0;o<e.length;o++){var i=e[o],n=i.indexOf(“=”),t=n>-1?i.substr(0,n):i;document.cookie=t+”=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;domain=”,document.cookie=t+”=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;domain=”+location.hostname.replace(/^www\./i,””)}}</script>
<h1>Step 4 - Finished!</h1>
<div id="column-right">
<ul>
	<li>License</li>
	<li>Pre-Installation</li>
	<li>Configuration</li>
	<li><b>Finished</b></li>
</ul>
</div>
<div id="content">
<div class="warning">Don't forget to delete your installation directory!</div>

<h4>Congratulations! You have successfully installed your OpenCart v.1.5.6.5 Software!</h4>
<hr>
<p>
 <div class="success">
<div><a title="Speed up your OpenCart v.1.5.6.5 Database" href="../xturbo.php" target="_blank"><img src="view/image/db_index_Innodb_mod.png" title="index your Database now!" alt="index your Database now!"></div>
<div><h4>NOW, change the Database-Engine to<br />InnoDB and fully index your Database<br />to maximize overall DB Performance !</h4>
</a></div>
</div>
<hr>
</p>

<div class="success">
<div><a href="../index.php"><img src="view/image/screenshot_1.png" alt="" /></a><br />
<a href="../index.php">Go to your Online Shop</a></div>
<div><a href="../admin/index.php"><img src="view/image/screenshot_2.png" alt="" /></a><br />
<a href="../admin/index.php">Login to your Administration</a></div>
</div>
</div>
<?php echo $footer; ?>