<?php

?>


<div class="popup-overlay hidden">
	<div class="popup-contact">
		<div class="popup-title__container">
			<div class="popup-title"></div>
			<div class="popup-title"></div>
		</div>
		<div class="popup-informations">	
			<?php

				$refPhoto = "";
				if (get_field('reference')) {
					$refPhoto = get_field('reference');
				}; 
				echo do_shortcode('[contact-form-7 id="81028f8" title="contact"]');
			?>
		</div>	
	</div>
</div>