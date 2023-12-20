<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">


                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="articleCategoryUpdate" multiple="multiple">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2" for="articleTitleUpdate">Title</label>
                                <input type="text" class="form-control" id="articleTitleUpdate">

                                <label class="form-label mt-2" for="articleContentUpdate">Content</label>
                                <textarea type="text" class="form-control" id="articleContentUpdate"></textarea>
                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>
                                <label class="form-label mt-2">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="articleImgUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">


                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>

        </div>
    </div>
</div>


<script>
 async function collectCategoryId(id){
        let res = await axios.post("/article-category-list",{id:id})
        $('#articleCategoryUpdate').val(res.data);
    }



    async function UpdateFillCategoryDropDown(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}" >${item['name']}</option>`
            $("#articleCategoryUpdate").append(option);
        })
    }


    async function FillUpUpdateForm(id,filePath){
       
        document.getElementById('updateID').value=id;
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;
        showLoader();
        $('#articleCategoryUpdate option').remove();
        await UpdateFillCategoryDropDown();
        await collectCategoryId(id);
        let res=await axios.post("/article-by-id",{id:id})
        hideLoader();
        document.getElementById('articleTitleUpdate').value=res.data['title'];
        document.getElementById('articleContentUpdate').value=res.data['content'];

    }



    async function update() {

        let articleCategoryUpdate=$('#articleCategoryUpdate').val();
        let articleTitleUpdate = document.getElementById('articleTitleUpdate').value;
        let articleContentUpdate = document.getElementById('articleContentUpdate').value;
        let updateID=document.getElementById('updateID').value;
        let filePath=document.getElementById('filePath').value;
        let articleImgUpdate = document.getElementById('articleImgUpdate').files[0];


        if (articleCategoryUpdate.length === 0) {
            errorToast("Category Required !")
        }
        else if(articleTitleUpdate.length===0){
            errorToast("Title Required !")
        }
        else if(articleContentUpdate.length===0){
            errorToast("Content Required !")
        }
       
        else {

            document.getElementById('update-modal-close').click();

            let formData=new FormData();
            formData.append('img',articleImgUpdate)
            formData.append('id',updateID)
            formData.append('title',articleTitleUpdate)
            formData.append('content',articleContentUpdate)
            formData.append('category_id',articleCategoryUpdate)
            formData.append('file_path',filePath)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/update-article",formData,config)
            hideLoader();

            if(res.status===200 && res.data===1){
                successToast('Request completed');
                document.getElementById("update-form").reset();
                $('#articleCategoryUpdate').val('');
                await getList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }
</script>
