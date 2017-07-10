<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<div class="ufcsm-container">
<?php 
	// Set up the default query to display courses
	
	if ( have_posts() ): ?>
	  <table class="table table-hover table-striped syllabus-table">
		<thead>
		  <tr>
			<th class="syllabus-course"><?php _e('Course', 'syllabus-manager'); ?></th>
			<th class="syllabus-section"><?php _e('Section', 'syllabus-manager'); ?></th>
			<th class="syllabus-title"><?php _e('Title / Syllabus', 'syllabus-manager'); ?></th>
			<th class="syllabus-instruct"><?php _e('Instructor(s)', 'syllabus-manager'); ?></th>
			<th class="syllabus-dept"><?php _e('Department', 'syllabus-manager'); ?></th>
			<th class="syllabus-level"><?php _e('Course Level', 'syllabus-manager'); ?></th>
			<th class="syllabus-semester"><?php _e('Semester', 'syllabus-manager'); ?></th>
		  </tr>
		</thead>
		<tbody>
		<?php
			while ( have_posts() ) : the_post(); 
				$prefix = get_field('syllabus_manager_prefix');
				$number = get_field('syllabus_manager_number');
				$section = get_field('syllabus_manager_section');
				$title = get_field('syllabus_manager_title');
				$syllabus_id = get_the_ID();
				$syllabus_url = get_field('syllabus_manager_syllabus');
				$syllabus_title = ( $syllabus_url )? sprintf('<a href="%s" target="_blank">%s</a>', $syllabus_url, $title) : $title;
				
				$syllabus_lists =  array(
					'instruct' => 'syllabus_instructor',
					'dept' => 'syllabus_department',
					'level' => 'syllabus_level',
					'semester' => 'syllabus_semester',
				);
		?>
		<tr>
			<td class="syllabus-course"><?php echo $prefix . $number; ?></td>
			<td class="syllabus-section"><?php echo $section; ?></td>
			<td class="syllabus-title"><?php echo $syllabus_title; ?></td>
			
			<?php
				// Display the taxonomy lists
				foreach ( $syllabus_lists as $key => $term ):
					$term_class = 'syllabus-' . $key;
					$term_list = get_the_term_list( $syllabus_id, $term, '<ul class="list-inline"><li>', ',</li><li>', '</li>' );
					$term_list = ( !is_wp_error( $term_list ) )? $term_list : '';	
					printf( '<td class="%s">%s</td>', $term_class, $term_list );
				endforeach;
			?>
		</tr>
			<?php endwhile; // End of the loop. ?>
		</tbody>
		</table>
	<?php else: ?>
		<div><?php _e('No courses found.', 'Syllabus_Manager'); ?></div>
	<?php endif; ?>
</div><!-- .ufcsm-container --> 