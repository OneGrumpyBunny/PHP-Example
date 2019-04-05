
<script type='text/javascript' src='js/jquery.easing.min.js'></script>
<script type="text/javascript" src="js/jquery.easy-ticker.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function(){

	var dd = jQuery('.vticker').easyTicker({
		direction: 'up',
		easing: 'easeInSine',
		speed: 'slow',
		interval: 2000,
		height: 'auto',
		visible: 2,
		mousePause: 1,
		controls: {
			up: '.up',
			down: '.down',
			toggle: '.toggle',
			stopText: 'Stop !!!'
		}
	}).data('easyTicker');
	
	cc = 1;

});
</script>

<style>
.vticker{
	/*border: 1px solid red;*/
	
}
.vticker ul{
	padding: 0;
	width: 100%;
}
.vticker li{
	list-style: none;
	/*border-bottom: 1px solid green;*/
	border-bottom: 2px solid #9ac4cc;
	padding: 10px;
}
.incident-ticker {
     font-weight: normal;
     color: #777777;
     margin-bottom: 20px;
     margin-top: 40px;
     text-transform: uppercase;
     width:100% !important;
}
.incident-ticker:hover {
	background: #dddddd;
}
}
/*.et-run{
	background: red;
}*/
</style>

<div class="incident-ticker">
	<button class="up">UP</button>
	<button class="down">DOWN</button>

	<div class="vticker">
		<ul>
		<li><strong>12-31-2015</strong> 3420 Metzerott Road<br>Service Call<br>Unit: E-112</li>

		<li><strong>12-31-2015</strong> 6320 Golden Triangle Dr<br>AFA<br>Unit: E-112</li>

		<li><strong>12-31-2015</strong> 6J Hillside Dr<br>EMS Emergency<br>Unit: E-112</li>

		<li><strong>12-31-2015</strong> 495 @Kenilworth<br>9I<br>Unit: E-112</li>

		<li><strong>12-31-2015</strong> 295 @Greenbelt<br>9I<br>Unit: E-112</li>
	</ul>
	</div> 

</div> <!-- incident-ticker -->