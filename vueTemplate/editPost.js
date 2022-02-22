Vue.component('edit-post', {
    data: function () {
      return {
        // Add New Post Property
        category : 'Default',
        fpicon   : '',
        content  : this.editpost.content,

        pic      : this.pic,
        name     : this.name,
        id       : this.id,
        global   : this.global
      }
    },
    methods: {
      createBrowserHistory(e) {
        window.history.pushState(null, null, `#${e}`);
      },
      postCategorys() {
        this.createBrowserHistory('editPosts');
        this.profilePostCategory.show();
      },
      fp(e){
        if(e == 'friend'){
          this.category = "Friends";
          this.fpicon   = 'fa-users';
          console.log('Friends');
        }
        if(e == 'region'){
          this.category = "Region";
          this.fpicon   = 'fa-map';
          console.log('Region');
        }
        if(e == 'globle'){
          this.category = "Anyone";
          this.fpicon   = 'fa-globe';
          console.log('Globle');
        }
      },
      uploadPost(e) {
        e.preventDefault();
        this.$emit('edited',[this.category,this.editpost.content,this.editpost.id]);
      }
    },
    mounted() {
      let vm = this;
      this.profilePostCategory = new bootstrap.Modal(document.getElementById('editPostCategory'), {
        keyboard: false,
        backdrop: 'static'
      });

      $(window).on('popstate', function (e) {
        if (window.location.hash != '#editPosts') {
          vm.profilePostCategory.hide();
        }
      });
    },
    props: [
      'pic', 'id','global','name','userrow','editpost'
    ],
    template: `
  
      <!-- Modal Path -->
      <div class="row justify-content-center">
  
  
         <!-- Modal Edit Post -->
        <div class="modal fade  p-0 text-center"  id="profileEdit" :style="global" style="z-index: 99999;width:100vw;"  tabindex="-1"
          aria-labelledby="staticBackdropLabel" aria-hidden="true" >
          <div class="modal-dialog  modal-lg">
  
            <form id="" method="POST" enctype="multipart/form-data">
              <div class="modal-content border-0 p-0" :style="global">
  
                <div class="modal-header p-2">
                   <b>
                      Edit Post</b>
  
                  <button @click="uploadPost" data-bs-dismiss="modal" class="btn btn-primary"><b>Update</b></button>
                </div>
  
                <div class="modal-body d-inline-block pb-2 pt-3" :style="global">
  
                  <!-- Add New Post Header -->
                  <div class="row">
                      <div class="col-12 text-left d-inline-block position-relative p-0" style="min-height:50px;">
                             <img :src="pic"  class="position-absolute mb-0" style="border-radius: 50px;width:45px;top:0;left:0;" alt="">
                        <div style="top:0;left:55px;" class="position-absolute mb-0">
                          <p class="d-inline pb-1" style="font-size: 15px;font-weight:500;">{{name}}</p>
                           <div class="">
                           <small @click="postCategorys()" class="text-muted d-inline-block fa border p-1" :class="this.fpicon" style="font-size:10px;border-radius:3px;"> {{ category }} &#x25BC;</small>
                           </div>
                        </div>
                      </div>
                      <!--  -->
  
                  </div>
  
                  <!-- Write Content -->
                  <div class="row mb-0 pt-3">
                    <div class="mb-3 col-12 p-0">
                      <textarea v-model="editpost.content" name="content" spellcheck="false"
                        class="w-100 border-0" placeholder="What's on your mind?"
                        style="outline: none;" rows="7"></textarea>
                    </div>
                  </div>

  
                 
  
                </div>
  
              </div>
            </form>
  
          </div>
        </div>
  
        <!--Modal Category -->
       <div class="modal fade p-0 text-center" id="editPostCategory" :style="global" style="z-index: 100000;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="postCategoryLabel" aria-hidden="true">
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
  