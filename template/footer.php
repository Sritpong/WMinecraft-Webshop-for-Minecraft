<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site'] ?>/js/ZyanJS.js"></script>
<script src="<?php echo $config['site'] ?>/build/toastr.js"></script>
<script type="text/javascript" src="<?php echo $config['site'] ?>/js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="<?php echo $config['site'] ?>/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site'] ?>/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site'] ?>/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="<?php echo $config['site'] ?>/js/dataTables.responsive.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15.0.0/dist/smooth-scroll.polyfills.min.js"></script>
<?php
	if(isset($_GET['page']))
	{
		if($_GET['page'] == 'topup')
		{
			?>
				<script type="text/javascript" src="<?php echo $config['site'] ?>/js/DataTable.js"></script>
			<?php
		}
	}
?>