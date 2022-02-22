Vue.component('addnew-post', {
    data: function() {
        return {
            // Add New Post Property
            reload: window.globalThis,
            highOrderRanking: [],
            category: 'Region',
            fpicon: 'fa-map',
            disPost: true,
            title: '',
            content: '',
            globalImages: [],
            imagesLivePreview: [],
            formData: '',
            checkPF: '',
            toastMsg: false,

            postProgress: false,
            P: false,
            progressNo: 0,

            pic: this.pic,
            name: this.name,
            id: this.id,
            global: this.global
        }
    },
    methods: {
        createBrowserHistory(e) {
            window.history.pushState(null, null, `#${e}`);
        },
        watchNewPost() {
            if (this.content == '') { this.disPost = true } else { this.disPost = false };
        },
        postCategorys() {
            this.createBrowserHistory('addNewPosts');
            this.postCategory.show();
        },
        fp(e) {
            if (e == 'friend') {
                this.category = "Friends";
                this.fpicon = 'fa-users';
                console.log('Friends');
            }
            if (e == 'region') {
                this.category = "Public";
                this.fpicon = 'fa-map';
                console.log('Region');
            }
            if (e == 'globle') {
                this.category = "Global";
                this.fpicon = 'fa-globe';
                console.log('Globle');
            }
        },
        uploadPost(e) {
            e.preventDefault();
            let vm = this;
            this.uploadImagePreview();
            let formData = new FormData();



            // Loop all ImgPreview to append formData
            for (var i = 0; i < this.globalImages.length; i++) {
                formData.append('images[]', this.globalImages[i]);
            }
            formData.append('content', this.content);
            formData.append('category', this.category);
            // console.log(category)
            $.ajax({
                //I use xhr to show upload progress
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            vm.progressNo = Math.floor((evt.loaded / evt.total) * 100);
                            var percentComplete = evt.loaded / evt.total;
                            $('#progress').css({
                                width: percentComplete * 100 + '%'
                            });
                            if (percentComplete === 1) {
                                vm.postProgress = true;
                            }
                        }
                    }, false);
                    //I use xhr to show upload progress
                    xhr.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            vm.progressNo = Math.floor((evt.loaded / evt.total) * 100);
                            var percentComplete = evt.loaded / evt.total;
                            $('#progress').css({
                                width: percentComplete * 100 + '%'
                            });
                            if (percentComplete === 1) {
                                vm.postProgress = true;
                            }
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: 'addNewPost.php',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(e) {
                    //  loading status
                    vm.postProgress = true;
                },
                error: function(res) {
                    // alert(res);
                    console.log(res);
                    vm.content = '';
                    vm.globalImages = [];
                    vm.imagesLivePreview = [];
                    // vm.createBrowserHistory('home');
                    vm.postProgress = false;
                    vm.$emit('updated', 'error');
                },
                success: function(res) {
                    // alert(res);
                    // console.log(res);
                    vm.content = '';
                    vm.globalImages = [];
                    vm.imagesLivePreview = [];
                    vm.postProgress = false;
                    vm.$emit('updated', 'success');
                    // location.reload();
                    // $('#addNewPostForm')[0].reset();
                }
            });



        },
        removeImgPreview(e) {
            const delItem = this.globalImages.find(res => { return res.name == e });
            this.imagesLivePreview.remove(delItem);
            this.globalImages.remove(delItem);
            console.log("Remove 1 photo => ", this.globalImages.length)
        },
        loadImagePreview() {
            let vm = this;
            if (this.imagesLivePreview.length > 0) {
                // Loop to show live Image Preview
                for (let i = 0; i < this.imagesLivePreview.length; i++) {
                    let imageReader = new FileReader();
                    imageReader.onload = ((e) => {
                        // Real Live Image Preview Data
                        // Use vue refs to show preveiw data to img src
                        vm.$refs['image' + `${vm.imagesLivePreview[i].name}`][0].src = imageReader.result;
                    });
                    imageReader.readAsDataURL(this.imagesLivePreview[i]);
                }
            }

        },
        uploadImagePreview() {
            // PostImgLoading Photo One
            let vm = this;
            if (this.imagesLivePreview.length > 0) {
                let postLoadingImg = new FileReader();
                postLoadingImg.onload = ((e) => {
                    vm.$refs['postImgLoading'].src = postLoadingImg.result;
                });
                postLoadingImg.readAsDataURL(this.imagesLivePreview[0]);
            }
        },
        changeInputImg(e) {

            if (window.File && window.FileList && window.FileReader) {

                // First times File Choose If globalImage Length is 0, Input Whatever files number 1, or 2 or . . .
                if (this.globalImages.length == 0) {

                    console.log("Case One");
                    // If total file is exceed show alert & stop under case
                    if (parseInt(e.target.files.length) >= 16) { // parseInt($fileUpload.get(0).files.length)
                        alert('The maximun number of photo limit is 15');
                        this.globalImages = [];
                        return true;
                    }
                    // if globalImages.length equal 0
                    this.globalImages = e.target.files || e.dataTransfer.files;
                    // Convert Object data to Array format
                    this.globalImages = Array.prototype.slice.call(this.globalImages);
                    // Check Invalid Image type
                    const imagesTypeInvalid = this.globalImages.filter(check => {
                        var match = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                        if (!((check.type == match[0]) || (check.type == match[1]) || (check.type == match[2]) || (check.type == match[3]))) {
                            return true;
                        }
                        return false;

                    });
                    //  If photo type is not valid
                    if (imagesTypeInvalid == undefined) {
                        // Loop & add globalImages data to imageLivePreview
                        this.globalImages.map(e => {
                            this.imagesLivePreview.push(e);
                        });
                    } else {
                        // Remove Invalid file from GlobalImages
                        for (let i = 0; i < imagesTypeInvalid.length; i++) {
                            this.globalImages.remove(imagesTypeInvalid[i]);
                        }
                        // Loop & add globalImages data to imageLivePreview
                        this.globalImages.map(e => {
                            this.imagesLivePreview.push(e);
                        });
                    }

                } else {
                    // Second times File Choose Input Whatever files number 1, or 2 or . . .
                    console.log("Case Two");

                    let addNewImg = e.target.files || e.dataTransfer.files;
                    // Convert Object data to Array format
                    addNewImg = Array.prototype.slice.call(addNewImg);

                    // Get SameFile From GlobalImages By name exist or not
                    const sameFile = this.globalImages.filter(e => {
                        for (var i = 0; i < addNewImg.length; i++) {
                            if (e.name == addNewImg[i].name) {
                                return true;
                            }
                        }
                        return null;
                    });
                    // If SameFile exist remove from globalimages
                    if (sameFile.length > 0) {
                        for (let i = 0; i < sameFile.length; i++) {
                            this.globalImages.remove(sameFile[i]);
                        }
                    }
                    // If total photo is exceed show alert & Stop the case
                    let totalFile = addNewImg.length + this.globalImages.length;
                    if (totalFile >= 16) {
                        addNewImg = [];
                        alert("The maximun number of photo limit is 15");
                        return true;
                    }
                    //  If total photo is not exceed check file type valid
                    const imagesTypeInvalid = addNewImg.filter(check => {
                        var match = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                        if (!((check.type == match[0]) || (check.type == match[1]) || (check.type == match[2]) || (check.type == match[3]))) {
                            return true;
                        }
                        return false;
                    });
                    //  If file is valid go under case
                    if (imagesTypeInvalid == undefined) {
                        // Loop & add globalImages data to imageLivePreview
                        addNewImg.filter(res => {
                            this.globalImages.push(res);
                        });
                        //  Image Preview = GlobaImage
                        this.imagesLivePreview = this.globalImages;
                    } else {
                        // If file is not valid go under case
                        // Remove Invalid file from GlobalImages
                        for (let i = 0; i < imagesTypeInvalid.length; i++) {
                            addNewImg.remove(imagesTypeInvalid[i]);
                        }
                        // Loop & add globalImages data to imageLivePreview
                        addNewImg.filter(res => {
                            this.globalImages.push(res);
                        });
                        this.imagesLivePreview = this.globalImages;
                    }
                }
                // Watching File Data
                console.log("Choose File ", this.globalImages.length);

            } else {
                console.log("Your browser is not supports files format.")
            }
        }
    },
    mounted() {
        let vm = this;


        // PostCategory Modal
        this.postCategory = new bootstrap.Modal(document.getElementById('postCategory'), {
            keyboard: false,
            backdrop: 'static'
        });


        $(window).on('popstate', function(e) {
            if (window.location.hash != '#addNewPosts') {
                vm.postCategory.hide();
            }
        });

    },
    props: [
        'pic', 'name', 'id', 'global', 'userrow'
    ],
    template: `

    <!-- Modal Path -->
    <div class="row justify-content-center">

    <!-- PostProogress -->
    <div v-if="postProgress" class="position-absolute pb-3 pt-2 pb-lg-5 w-100" :style="global" style="z-index:99999;top:50px;left:0;" >
     <div class="col-12 p-2">
       <img v-bind:ref="'postImgLoading'" style="width: 40px;height:40px;"  class="border-0"/> 
       <p class="d-inline-block m-0 text-center font-monospace" style="min-width: 130px;">Posting . . .</p>
     </div>
     <div class="progress p-0 col-12" style="height: 6px;">
       <div class="progress-bar" id="progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
     </div>
    </div>

       <!-- Modal AddNew Post -->
      <div class="modal fade  p-0 text-center"  id="addPostModal" :style="global" style="z-index: 99999;width:100vw;"  tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" >
        <div class="modal-dialog  modal-lg">

          <form id="addNewPostForm" method="POST" enctype="multipart/form-data" :onload="watchNewPost()">
            <div class="modal-content border-0 p-0" :style="global">

              <div class="modal-header p-2">
                 <b>
                    Create Post</b>

                <button @click="uploadPost" :disabled="disPost" data-bs-dismiss="modal" class="btn btn-primary"><b>Post</b></button>
              </div>

              <div class="modal-body d-inline-block pb-2 pt-3" :style="global">

                <!-- Add New Post Header -->
                <div class="row">
                    <div class="col-12 text-left d-inline-block position-relative p-0" style="min-height:50px;">
                           <img :src="pic"  class="position-absolute mb-0" style="border-radius: 50px;width:45px;top:0;left:0;" alt="">
                      <div style="top:0;left:55px;" class="position-absolute mb-0">
                        <p class="d-inline pb-1" style="font-size: 15px;font-weight:500;">{{name}}</p>
                         <div class="">
                         <small @click="postCategorys()" class="text-muted d-inline-block fa border p-1" :class="this.fpicon" style="font-size:10px;border-radius:3px;"> {{ category  }} &#x25BC;</small>
                         </div>
                      </div>
                    </div>
                    <!--  -->

                </div>

                <!-- Write Content -->
                <div class="row mb-0 pt-3">
                  <div class="mb-3 col-12 p-0">
                    <textarea v-model="content" name="content" spellcheck="false"
                      class="w-100 border-0" placeholder="What's on your mind?"
                      style="outline: none;" rows="7"></textarea>
                  </div>
                </div>

                <!-- Upload Images Btn -->
                <div class="file-upload pb-3 row">
                  <div class="file-select col-12 p-0">
                    <div class="file-select-button" id="fileName">Photo
                      <i class="fa fa-file-image position-absolute" style="font-size: 20px; top: 8px;right:8px;"></i>
                    </div>
                    <div @change="changeInputImg">
                      <input type="file" id="images" name="images[]" class="file-upload" accept="image/*" multiple>
                    </div>
                  </div>
                </div>

                <!-- Images Live Preview -->
                <div class="row mb-2" style="border-radius:5px;" id="imagePreview" :load="loadImagePreview()">
                  <div class="col-4 p-1" v-for="(img,key) in imagesLivePreview" :key="key">
                    <div class="position-relative d-inline-block">
                      <img @click="removeImgPreview(img.name)" v-bind:ref="'image'+img.name" :alt="img.name" class="imgPreview"/>
                      <i @click="removeImgPreview(img.name)"  class="fa fa-times-circle imgDelIcon"></i>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </form>

        </div>
      </div>

        <!--Modal Category -->
       <div class="modal fade p-0 text-center" id="postCategory" :style="global" style="z-index: 100000;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="postCategoryLabel" aria-hidden="true">
         <div class="modal-dialog  modal-lg ">
           <div class="modal-content  border-0 p-0 " :style="global">
                <!-- Modal Header -->
               <div class="modal-header p-3">
                    <i style="font-size:19px;" class="fa fa-star"><b>
                        Post Audience</b> </i>
               </div>
                <!-- Modal Header End -->
             <div class="modal-body row justify-content-left d-inline-block p-0 pt-3 pb-4" :style="global">


                 <div class="p-2 col-12" style="height:80px;">
                   <div class="position-absolute" style="left: 5px;top:8px;height:35px">
                      <small class="d-inline" style="font-weight: bold;">
                         Who can see your post?</small>
                   </div>
                   <div class="position-absolute" style="left: 10px;top:45px;height:35px">
                      <p style="font-size: 12px;">
                          Your post will show up in News Feed and on your profile.
                      </p>
                   </div>

                 </div>

                 <label v-if="userrow >= 2" @click="fp('globle')" class="col-12 text-left d-inline-block position-relative border-bottom" style="height:50px">
                    <div class="position-relative" >
                      <input class="form-check-input" style="position: absolute;left:0;" type="radio" name="flexRadioDefault" id="flexRadioDefault3">
                      <div style="top:0;left:0;width:120px" class="position-absolute mb-0">
                         <div class="form-check-label fa fa-globe" for="flexRadioDefault3">
                             Globle
                         </div>
                         <small class="text-muted d-block" style="font-size:12px;border-radius:3px;">Anyone</small>
                       </div>
                    </div>
                 </label>

                  <label @click="fp('region')" class="col-12 text-left d-inline-block position-relative border-bottom" style="height:50px">
                     <div class="position-relative" >
                       <input class="form-check-input" style="position: absolute;left:0;" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                       <div style="top:0;left:0;width:120px" class="position-absolute mb-0">
                          <div class="form-check-label fa fa-map" for="flexRadioDefault1">
                              Public
                          </div>
                          <small class="text-muted d-block" style="font-size:12px;border-radius:3px;">Region</small>
                        </div>
                     </div>
                  </label>

                  <label @click="fp('friend')" class="col-12 text-left d-inline-block position-relative border-bottom" style="height:50px">
                     <div class="position-relative" >
                       <input class="form-check-input" style="position: absolute;left:0;" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                       <div style="top:0;left:0;width:120px" class="position-absolute mb-0">
                          <div class="form-check-label fa fa-lock" for="flexRadioDefault2">
                             Friends
                          </div>
                          <small class="text-muted d-block" style="font-size:12px;border-radius:3px;">Friends Only</small>
                        </div>
                     </div>
                  </label>

                  


                  <div class="p-3 mt-4" style="width: 100vw;">
                     <div v-if="category == 'Anyone'" class="">
                        <b class="d-block pb-2"> {{category}}</b>
                        <p>
                           Anyone on Zakerxa can see your posts.
                        </p>
                     </div>

                     <div v-if="category == 'Region'" class="">
                        <b class="d-block pb-2"> {{category}}</b>
                        <p>
                           Anyone on your region can see your posts.
                        </p>
                     </div>

                     <div v-if="category == 'Friends'" class="">
                        <b class="d-block pb-2"> {{category}}</b>
                        <p>Your friends only can see your posts.</p>
                     </div>
                  </div>

             </div>

           </div>
         </div>
       </div>

    </div>
      `
});