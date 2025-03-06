<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<div class="container-fuid">
				<form action="" id="manage_home">
					<textarea name="content" id="content" cols="30" rows="10" class="form-control"><?php echo file_get_contents('../home.html') ?></textarea>
				</form>
			</div>
		</div>
		<div class="card-footer">
			<div class="d-flex justify-content-center w-100">
				<button class="btn btn-flat btn-primary bg-gradient-primary" form="manage_home">Save</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#content').summernote({
        height: "50vh",
        disableDragAndDrop:true,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'insert', [ 'link','picture' ] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ],
            ['mybutton', ['myVideo']]
        ],
        callbacks:{
	        onImageUpload: function(files) {
		      saveImg(files[0]);
		    }
        },
        buttons: {
		      myVideo: function(context) {
		        var ui = $.summernote.ui;
		        var button = ui.button({
		          contents: '<i class="fa fa-video"/>',
		          tooltip: 'video',
		          click: function() {
		            var div = document.createElement('div');
		            div.classList.add('embed-container');
		            var _url = prompt('Enter video url:')
		            if(_url == null || _url == '' ){
		            	return false;
		            }
		            div.innerHTML = _url;
		            console.log(div)
		            context.invoke('editor.insertNode', div);
		          }
		        });

		        return button.render();
		      }
		  }

    })
		function saveImg(_file){
		var data = new FormData();
    		data.append("file", _file);
			$.ajax({
		      data: data,
		      type: "POST",
		      url: "<?php echo APP_PATH ?>ajax.php?action=save_image",
		      cache: false,
		      contentType: false,
		      processData: false,
		      success: function(resp) {
		        var image = $('<img>').attr('src', resp);
           		 $('#content').summernote("insertNode", image[0]);
		      }
		    });
		}
	})
	$('#manage_home').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'<?php echo APP_PATH ?>ajax.php?action=save_home',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				alert_toast("An error occured.","error")
				end_load()
			},
			success:function(resp){
				if(resp == 1){
				alert_toast("Content successfully saved.","success")
					end_load();
				}
			}
		})
	})

</script>