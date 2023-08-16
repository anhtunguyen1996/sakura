<div class="entry-author container">
    <div class="row">
        <div class="col-md-2">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), $size = '100' ); ?>
        </div>
        <div class="col-md-10">
            <h3 class="name"><?php the_author_meta( 'display_name' ); ?></h3>
            <div class="desc"><?php the_author_meta( 'description' ); ?></div>
        </div>
    </div>
</div>