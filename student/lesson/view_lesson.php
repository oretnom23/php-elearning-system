<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif; ?>
<?php
$id = isset($_GET['id']) ? $_GET['id']: '';
if(!empty($id)){
    $qry = $conn->query("SELECT l.*,CONCAT(f.firstname,' ',f.middlename,' ',f.lastname) as fname, CONCAT(s.subject_code,' - ',s.description) as subj FROM lessons l inner join faculty f on f.faculty_id = l.faculty_id inner join subjects s on s.id = l.subject_id where l.id = $id");
    foreach($qry->fetch_array() as $k =>$v){
        if(!is_numeric($k)){
            $$k = $v;
        }
    }
    $description = stripslashes($description);
}
?>
<style>
#carousel_holder{
display: inline-flex;
justify-content:center;
background: #2f2e2e;
}    
#lesson_slides{
    width:calc(50%);
}
.carousel-control-prev {
    left: calc(-30%);
}
.carousel-control-next {
    right: calc(-30%);
}
</style>
<div class="card card-outline cardprimary w-fluid">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($title) ? $title : '' ?></h3>
	</div>
	<div class="card-body">
        <div class="w-100">
            <div class="col-md-12">
                <span class="truncate float-right" style="max-width:calc(50%);font-size:13px !important;font-weight:bold">Subject: <?php echo $subj ?></span>
            </div>
        </div>
        <br>
        <div id="carousel_holder" class="w-100">
            <div id="lesson_slides" class="carousel slide" data-ride="carousel" data-interval="0">
                <div class="carousel-inner">
                    <?php 
                    $slides = scandir(base_app.'uploads/slides/lesson_'.$id);
                    foreach($slides as $k =>$v){
                        if(in_array($slides[$k],array('.','..')))
                        unset($slides[$k]);
                    }
                    $active ="active";
                    foreach($slides as $k =>$v):
                    ?>
                    <div class="carousel-item <?php echo $active; $active=""; ?>">
                    <img class="d-block w-100" src="<?php echo validate_image('uploads/slides/lesson_'.$id.'/'.$slides[$k]) ?>" alt="">
                    </div>
                    <?php endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#lesson_slides" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#lesson_slides" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <br>
        <div class="container-fluid">
        <h5>Description</h5>
        <hr>
        <div>
        <?php echo html_entity_decode($description) ?>
        </div>
        <hr>
        <div class="w-100">
            <div class="col-md-12">
            <span class="float-right"><b>Prepared By: </b><?php echo $fname ?></span>
            </div>
        </div>
        </div>
    </div>
</div>