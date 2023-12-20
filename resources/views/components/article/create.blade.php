<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Article</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label" for="articleCategory">Category</label>
                                <select type="text" class="form-control form-select" id="articleCategory" multiple="multiple">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2" for="articleTitle">Title</label>
                                <input type="text" class="form-control" id="articleTitle">

                                <label class="form-label mt-2" for="articleContent">Content</label>
                                <textarea type="text" class="form-control" id="articleContent"></textarea>

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label" for="articleImg">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="articleImg">

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>



    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#articleCategory").append(option);
        })
    }


    async function Save() {

        let articleCategory=$('#articleCategory').val();
        let articleTitle = document.getElementById('articleTitle').value;
        let articleContent = document.getElementById('articleContent').value;
        let articleImg = document.getElementById('articleImg').files[0];

        if (articleCategory.length === 0) {
            errorToast("Article Category Required !")
        }
        else if(articleTitle.length===0){
            errorToast("Article Title Required !")
        }
        else if(articleContent.length===0){
            errorToast("Article Content Required !")
        }
        else if(!articleImg){
            errorToast("Article Image Required !")
        }

        else {
           // alert(articleCategory);

            document.getElementById('modal-close').click();

            let formData=new FormData();
            formData.append('img',articleImg)
            formData.append('content',articleContent)
            formData.append('title',articleTitle)
            formData.append('category_id',articleCategory)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/create-article",formData,config)
            hideLoader();
                //console.log(res);
            if(res.status===201){
                successToast('Request completed');
                document.getElementById("save-form").reset();
                await getList();
            }
            else{
                
                errorToast("Request fail !")
            }
        }
    }
</script>
