<?php
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_content">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="title">Title</label>
						<input type="text" class="form-control form-control-sm" name="title" value="<?php echo isset($ctitle) ? $ctitle : '' ?>" required>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="category_id">Category</label>
						<select class="form-control form-control-sm select2" name="category_id" id="category_id" required>
							<option value=""></option>
							<?php 
							$categories = $conn->query("SELECT * FROM categories order by category asc");
							while($row=$categories->fetch_assoc()):
							?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['category'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10 form-group">
						<label for="content">Content</label>
						<textarea name="content" id="content" cols="30" rows="10" class="form-control"><?php echo isset($link) && is_file('../'.$link) ? file_get_contents('../'.$link) : '' ?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="" class="control-label">Banner/Cover Image</label>
						<div class="custom-file">
	                      <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
	                      <label class="custom-file-label" for="customFile">Choose file</label>
	                    </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<div class="form-group d-flex justify-content-center align-items-center">
							<img src="<?php echo isset($banner_img) ? '../assets/uploads/'.$banner_img :'' ?>" alt="Image" id="cimg" class="img-fluid img-thumbnail ">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="meta_tags">Tags</label>
						<div id="tfield" class="mb-1 ">
						<?php
						if(isset($meta_keywords)){
							foreach(explode(',', $meta_keywords) as $k => $v){
								echo '<span class="badge badge-info bg-gradient-info px-2 py2 tag-item mx-2 ">'.$v.' <input type="hidden" name="tags[]" value="'.$v.'"> <span class="rem-tag ml-2"><i class="fa fa-times"></i></span></span>';
							}
						}
						?>
						</div>
						<input type="text" id="tags" class="form-control form-control-sm">
						<small><i>Insert (,) "COMMA" to Insert Tag.</i></small>
					</div>
				</div>

				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=content_list'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg{
		max-width: 75%;
		max-height: 30vh;
	}
	.rem-tag{
		cursor: pointer;
	}
</style>
<script>
	function create_tags($tag){
		if($tag == '' || $tag == null)
			return false;
		$tag = $tag.replace(/,/g,'')
		var span = $('<span class="badge badge-info bg-gradient-info px-2 py2 tag-item mx-2 ">'+$tag+' <input type="hidden" name="tags[]" value="'+$tag+'"> <span class="rem-tag ml-2"><i class="fa fa-times"></i></span></span>')
		$('#tfield').append(span)
		rem_tag()
	}
	function rem_tag(){
		$('.rem-tag').click(function(){
			$(this).closest('.tag-item').remove()
		})
	}
	$('#tags').on('keyup keypress',function(e){
		// e.preventDefault()
		 var keyCode = e.keyCode || e.which;
		if(keyCode == 188 || keyCode == 13){
			create_tags($(this).val())
			$(this).val('')
			return false;
		}
	})
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
	
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_content').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if($('[name="tags[]"]').length <=0){
					alert_toast("Enter tag for atleast 1.","error")
					$('#tags').addClass("border-danger")
					end_load()
					return false;
		}
		$.ajax({
			url:'../ajax.php?action=save_content',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=content_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})

</script>