<div <?php Insight::copyright_attributes() ?>>
    <div class="container">
        <div class="row row-xs-center">
            <div class="col-md-8 copyright_text">
				<?php echo wp_kses( Insight::setting( 'copyright_text' ), 'insight-default' ); ?>
            </div>
            <div class="col-md-4 copyright_payment_img">
                <img src="<?php echo esc_url( Insight::setting( 'copyright_payment_img' ) ); ?>"
                     alt="<?php bloginfo( 'name' ); ?>"/>
            </div>
        </div>
    </div>
	<?php if ( Insight::setting( 'copyright_backtotop_visibility' ) == 1 ) { ?>
        <div class="backtotop" id="backtotop">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                 width="127px" height="37px" viewBox="0 0 127 37"
                 preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,37.000000) scale(0.100000,-0.100000)"
                   fill="#000000" stroke="none">
                    <path d="M543 356 c-93 -30 -181 -104 -259 -216 -36 -53 -115 -103 -194 -124
-50 -13 0 -15 555 -15 555 0 605 2 555 15 -79 21 -158 71 -194 124 -59 86
-137 159 -203 192 -76 37 -188 48 -260 24z"/>
                </g>
            </svg>
        </div>
	<?php } ?>
</div>
