<?php
if ( !defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}

$jobs_id = get_the_ID();
if(!empty($job_id)){
    $jobs_id = $job_id;
}
$excerpt  = get_the_excerpt($jobs_id);
?>

<?php if( !empty($excerpt) ) : ?>
    <div class="jobs-excerpt">
        <p><?php echo wp_trim_words($excerpt); ?></p>
    </div>
<?php endif; ?>