<?php echo "<?php\n"; ?>

class <?php echo $this->widgetClass; ?> extends DaWidget {
	public function run() {
	  $this->render('<?php echo $this->viewName; ?>');
	}
}
