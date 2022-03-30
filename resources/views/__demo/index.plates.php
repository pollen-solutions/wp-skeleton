<?php
/**
 * @var Pollen\ViewExtends\PlatesTemplateInterface $this
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->asset_head(); ?>
</head>
<body>
<h1>Welcome <?php echo $this->get('name'); ?>, from Plates Engine</h1>
<?php echo $this->asset_footer(); ?>
</body>
</html>
