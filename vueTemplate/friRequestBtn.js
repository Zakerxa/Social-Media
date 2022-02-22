Vue.component('request-btn',{
    data: function () {
      return {
        changeBtn       : true,
        allDynamicUsers : this.container,
        id              : this.id
      }
    },
    methods:{
        addFriReq(id){
            let vm = this;
            vm.changeBtn = false; 
            // vm.$emit('updated',{'addfri':null,'delete':id});  
            $.ajax({
             type: 'post',
             url: 'friend-Relation-Update/FriRequest.php',
             catch: false,
             data: {
                sender    : vm.id,
                receiver  : id,
                state   : 'addfri'
             },
             success:(res)=>{
             }
            });
        },
        requestCancle(id){
            let vm = this;
            // vm.$emit('updated',{'cancle':null,'delete':id}); 
            $.ajax({
             type: 'post',
             url: 'friend-Relation-Update/FriRequest.php',
             catch: false,
             data: {
               my_id    : vm.id,
               user_id  : id,
                state   : 'addcancle'
             },
              error     :(e)=>{
                console.log(e)
              },
              beforeSend:(res)=>{},
              success   :(res)=>{
                vm.changeBtn = true;
              }
            });
        },
        removeFriList(id){
          let vm = this;
          const delItem = this.allDynamicUsers.find(res=>{ return res.id == id });
          console.log(delItem.id)
          setTimeout(() => {
            $("#newuserslider"+delItem.id).fadeOut();
          }, 100);
          // vm.$emit('remove', delItem);
          setTimeout(() => {
             this.allDynamicUsers.remove(delItem);
          }, 300);
        }
    },
    props: [
        'users','container','id'
    ],
    template: `
    <div class="position-absolute " style="top:22px;left:100px;width:68%">
      <div v-if="changeBtn" class="row pt-3">
         <button @click="addFriReq(users.id)" style="font-weight: bold;" class="col-5 p-1 btn btn-primary"> Add Friend </button>
         <div class="col-1"></div>
         <button @click="removeFriList(users.id)" style="font-weight: bold;" class="col-5 p-1 btn btn-light"> Remove </button>
      </div>
      <div v-else class="row">
         <p class="text-muted mb-0 p-0">Request sent</p>
         <button @click="requestCancle(users.id)" style="font-weight: bold;" class="col-12 p-1 btn btn-light"> Cancel </button>
      </div>
    </div>`
  });
