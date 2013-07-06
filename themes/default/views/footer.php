      <footer>
        <p>&copy; Company 2013</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo theme_url()?>assets/js/jquery.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-transition.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-alert.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-modal.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-dropdown.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-tab.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-popover.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-button.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-collapse.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-carousel.js"></script>
    <script src="<?php echo theme_url()?>assets/js/bootstrap-typeahead.js"></script>
	<?php print $this->bep_assets->get_footer_assets();?>
    <?php if($this->preference->item('activate_google_analytics')):?>
    <script type="text/javascript">
    
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '<?php echo $this->preference->item('google_analytics_tracking_code')?>']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <?php endif?>
  </body>
</html>
