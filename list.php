<?php include 'db_connect.php';

$qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['cid']}' ")->fetch_array();
foreach($qry as $k => $v){
    if(is_numeric($k))
    continue;
 $$k = $v;
}
?>
<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <h3><b><?php echo $category ?></b></h3>
            <hr>
            <div class="list-field card-group w-100">
                <center><i>Loading Data. Please wait...</i></center>
            </div>
        </div>
    </div>
</div>
<div id="clone_card" style="display:none">
    <div class="col-md-6 list-item">
        <a href="" class="item-link">
        <div class="card rounded">
            <img class="card-img-top img-field rounded" src="" alt="Card image cap" style="width:100%;object-fit:cover">
            <div class="card-body">
                <h5 class="card-title w-100"><b class="title-field"></b></h5>
                <h6 class="card-subtitle mb-2 text-muted w-100"> <i class="fa fa-comments"></i> <span class="comments"></span></span></h6>
                <p class="card-text truncate dfield"></p>
            </div>
        </div>
        </a>
    </div>
</div>
<script>
$(document).ready(function(){
    load_list()
    
})
function load_list(){
    var start = '<?php echo isset($_GET['s']) ? $_GET['s'] : 0 ?>'
    $.ajax({
        url:'ajax.php?action=load_list',
        method:'POST',
        data:{id:'<?php echo $_GET['cid'] ?>',start:start},
        error:err=>{
            console.log(err)
            alert_tast("An Error occured.","danger")
        },
        success:function(resp){
            if(resp && typeof (JSON.parse(resp)) === 'object'){
                resp = JSON.parse(resp)
                if(Object.keys(resp).length <= 0){
                    $('.list-field').html('<center><i>No Data.</i></center>')
                }else{
                    $('.list-field').html('')
                    Object.keys(resp).map(k=>{
                        var _card = $('#clone_card .list-item').clone()
                        _card.find('.img-field').attr('src','assets/uploads/'+resp[k].banner_img)
                        _card.find('.title-field').text(resp[k].title)
                        _card.find('.dfield').text(resp[k].description)
                        _card.find('.comments').text(resp[k].comments)
                        _card.find('a.item-link').attr('href','./index.php?page=view&cid='+resp[k].eid)
                        $('.list-field').append(_card)
                    })
                }
            }
        },
        complete:function(resp){
            $('.list-field .list-item,.list-field .list-item a').hover(function(){
                $(this).find('.card').addClass('border border-info')
            })
            $('.list-field .list-item,.list-field .list-item a').mouseout(function(){
                $(this).find('.card').removeClass('border border-info')
            })
        }
    })
}
</script>