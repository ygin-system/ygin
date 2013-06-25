<?php $this->beginContent($this->getModule()->applicationLayout); ?>
<noscript>
<div>
<p>JavaScript is disabled in your browser</p>
<p>RBAM requires JavaScript to be enabled. Please enable JavaScript before continuing.</p>
</div>
</noscript>
<div id="rbam">
	<?php
	if (strtolower($this->id)!=='rbaminitialise'):
		if ($this->getModule()->showMenu)
			$this->renderPartial('/rbam/_menu');
		echo "<h2>".($this->id==='rbam'?'':CHtml::image($this->getModule()->baseScriptUrl.'/images/rbam.png','Role Base Access Manager',array('width'=>'32px','height'=>'32px'))).$this->pageTitle.'</h2>';
		$this->renderPartial('/help/_help');
	else:
		echo "<h2>{$this->pageTitle}</h2>";
	endif;

	echo $content;
	?>
</div>
<?php $this->endContent(); ?>