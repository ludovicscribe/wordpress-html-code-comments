<div class="wrap">
	<h1><?php _e( 'HTML code in comments', $this->textdomain ); ?></h1>
		
	<?php if ( isset( $message ) && !empty( $message ) ) : ?>
	<div class="notice <?php echo $this->get_message_class( $message ); ?> is-dismissible">
		<?php if ( $message == 'add-tag' ) : ?>
		<p><?php _e( 'HTML tag as been added.', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'add-tag-warning' ) : ?>
		<p><?php _e( 'HTML tag has been added but it can cause XSS vulnerabilities.', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'add-attribute' ) : ?>
		<p><?php _e( 'Attribute as been added.', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'remove-tag' ) : ?>
		<p><?php _e( 'HTML tag has been removed.', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'remove-attribute' ) : ?>
		<p><?php _e( 'Attribute has been removed.', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'enable-encode-html' ) : ?>
		<p><?php _e( 'HTML encoding has been enabled.', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'disable-encode-html' ) : ?>
		<p><?php _e( 'HTML encoding has been disabled.', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'enable-force-links-target' ) : ?>
		<p><?php _e( 'Forcing HTML links target has been enabled.', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'disable-force-links-target' ) : ?>
		<p><?php _e( 'Forcing HTML links target has been disabled.', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'bad-format-tag' ) : ?>
		<p><?php _e( 'The tag\'s name is not in the right format. You must enter the name of the tag without the characters "<" and ">".', $this->textdomain ); ?></p>
		<?php elseif ( $message == 'bad-format-attribute' ) : ?>
		<p><?php _e( "The attribute's name is not in the right format.", $this->textdomain ); ?></p>
		<?php endif; ?>
	</div>	
	<?php endif; ?>
	
	<h2><?php _e( 'Allowed HTML tags', $this->textdomain ); ?></h2>
	
	<table class="widefat fixed">
		<thead>
			<tr>
				<th><?php _e( 'Tag name', $this->textdomain ); ?></th>
				<th><?php _e( 'Attribute', $this->textdomain ); ?></th>
			</tr>
		</thead>
		
		<tbody>
		<?php foreach( $allowed_tags as $tag => $attributes ) : ?>
			<tr<?php echo in_array( $tag, $this->warning_tags ) ? ' class="warning"' : ''; ?>>
				<td class="border"<?php echo is_array( $attributes ) && count( $attributes ) != 0 ? ' rowspan="' . count( $attributes ) . '"' : ''; ?>>
				<?php echo $tag; ?>
				</td>
				
			<?php if ( is_array( $attributes ) && count( $attributes) != 0 ) : ?>		
				<?php for( $i = 0; $i < count( $attributes ); $i++ ) : ?>
					<?php echo $i != 0 ? '<tr' . ( in_array( $tag, $this->warning_tags ) ? ' class="warning"' : '' ) . '>' : ''; ?>
						<td<?php echo $i == count( $attributes ) - 1 ? ' class="border"' : ''; ?>>
						<?php echo array_keys( $attributes )[$i]; ?>
						</td>
					</tr>	
				<?php endfor; ?>
			<?php else : ?>
					<td class="border">
					<?php _e( 'No authorized attribute', $this->textdomain ); ?>
					</td>
				</tr>
			<?php endif; ?>
		<?php endforeach; ?>
		<tbody>
	</table>
	
	<h2><?php _e( 'Add tag', $this->textdomain ); ?></h2>
	
	<form method="post" action="<?php echo $this->get_url(); ?>">	
		<label for="add-tag-name"><?php _e( 'Tag name', $this->textdomain ); ?></label>
		<input type="text" name="tag" id="add-tag-name" required />
		
		<br />
		
		<input type="submit" name="add-tag" class="button button-primary" value="<?php _e( 'Add', $this->textdomain ); ?>" />
		
		<input type="hidden" name="action" value="add-tag" />
		<?php wp_nonce_field( 'add-tag' ); ?>
	</form>
	
	<h2><?php _e( 'Delete tag', $this->textdomain ); ?></h2>
	
	<form method="post" action="<?php echo $this->get_url(); ?>">
		<label for="remove-tag-name"><?php _e( 'HTML tag', $this->textdomain ); ?></label>
		
		<select name="tag" id="remove-tag-name">
			<?php foreach( $allowed_tags as $tag => $attributes ): ?>
				<option><?php echo $tag; ?></option>
			<?php endforeach; ?>
		</select>
		
		<br />
			
		<input type="submit" name="remove-tag" class="button button-primary" value="<?php _e( 'Delete', $this->textdomain); ?>" />
		
		<input type="hidden" name="action" value="remove-tag" />
		<?php wp_nonce_field( 'remove-tag' ); ?>
	</form>
	
	<h2><?php _e( 'Add attribute', $this->textdomain ); ?></h2>
	
	<form method="post" action="<?php echo $this->get_url(); ?>">
		<label for="add-attribute-tag"><?php _e( 'HTML tag', $this->textdomain ); ?></label>
		
		<select name="tag" id="add-attribute-tag">
			<?php foreach( $allowed_tags as $tag => $attributes ): ?>
			<option><?php echo $tag; ?></option>
			<?php endforeach; ?>
		</select>
		
		<br />
		
		<label for="add-attribute-name"><?php _e( 'Attribute name', $this->textdomain ); ?></label>
		<input type="text" name="attribute" id="add-attribute-name" required />
			
		<br />
			
		<input type="submit" name="add-attribute" class="button button-primary" value="<?php _e( 'Add', $this->textdomain ); ?>" />
		
		<input type="hidden" name="action" value="add-attribute" />
		<?php wp_nonce_field( 'add-attribute' ); ?>
	</form>
	
	<h2><?php _e( 'Delete attribute', $this->textdomain ); ?></h2>
	
	<form method="post" action="<?php echo $this->get_url(); ?>">
		<label for="remove-attribute-tag"><?php _e( 'HTML tag', $this->textdomain ); ?></label>
		
		<select name="tag" id="remove-attribute-tag">
			<?php foreach( $allowed_tags as $tag => $attributes ) : ?>
			<option><?php echo $tag; ?></option>
			<?php endforeach; ?>
		</select>
		
		<br />
		
		<label for="remove-attribute-name"><?php _e( 'Attribute name', $this->textdomain ); ?></label>
		
		<select name="attribute" id="remove-attribute-name">
		</select>
		
		<br />
			
		<input type="submit" name="remove-attribute" id="remove-attribute-button" class="button button-primary" value="<?php _e( 'Delete', $this->textdomain ); ?>" />
		
		<input type="hidden" name="action" value="remove-attribute" />
		<?php wp_nonce_field( 'remove-attribute' ); ?>
	</form>
	
	<h2><?php _e( 'Advanced configuration', $this->textdomain ); ?></h2>
	
	<p class="bold"><?php _e( 'HTML code encoding', $this->textdomain ); ?></p>
	
	<p><?php _e( "This functionality allows to encode HTML code wrapped in the <code>pre</code> and <code>code</code> tags of your comments in order that WordPress doesn't delete it.", $this->textdomain ); ?></p>
	
	<a href="<?php echo $this->get_enable_encode_html_url(); ?>" class="button button-primary<?php echo ( $encode_html ? ' disabled' : '' ) . '"' . ( $encode_html ?  ' onclick="return false;"' : '' ) . '>' . __( 'Enable', $this->textdomain ); ?></a>
	<a href="<?php echo $this->get_disable_encode_html_url(); ?>" class="button button-primary<?php echo ( !$encode_html ? ' disabled' : '' ) . '"' . ( !$encode_html ? ' onclick="return false;"' : '' ) . '>' . __( 'Disable', $this->textdomain ); ?></a>
	
	<p class="bold"><?php _e( 'Force links target to blank', $this->textdomain ); ?></p>
	
	<p><?php _e( 'This feature sets <code>target</code> attribute of all links in comments to <code>_blank</code> in order to open the URLs in new window.', $this->textdomain ); ?></p>
	
	<a href="<?php echo $this->get_enable_force_links_target_url(); ?>" class="button button-primary<?php echo ( $force_links_target ? ' disabled' : '' ) . '"' . ( $force_links_target ? ' onclick="return false;"' : '' ) . '>' . __( 'Enable', $this->textdomain ); ?></a>
	<a href="<?php echo $this->get_disable_force_links_target_url(); ?>" class="button button-primary<?php echo ( !$force_links_target ? ' disabled' : '' ) . '"' . ( !$force_links_target ? ' onclick="return false;"' : '' ) . '>' . __( 'Disable', $this->textdomain ); ?></a>
</div>