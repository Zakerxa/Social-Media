Vue.component('accept-btn',{
    data: function () {
      return {
        allDynamicUsers : this.container,
        id              : this.id,
        changeBtn       : true,
        removefri       : false,
        nowfri          : false,
      }
    },
    methods:{
        acceptFriReq(id){
            let vm = this;
            vm.changeBtn = false; 
            vm.$emit('updated',{'accept':id,'delete':null});  
            $.ajax({
             type: 'post',
             url: 'friend-Relation-Update/FriRequest.php',
             data: {
                my_id    : vm.id,
                sender   : id,
                state   : 'accept'
             },
             success   :(res)=>{
               vm.nowfri = true;
              }
            });
            
        },
        deleteFriReq(id){
            let vm = this;
            vm.changeBtn = false;
            vm.$emit('updated',{'accept':null,'delete':id});  
            $.ajax({
             type: 'post',
             url: 'friend-Relation-Update/FriRequest.php',
             data: {
                my_id    : vm.id,
                user_id  : id,
                state    : 'delete'
             },
              error     :(res)=>{},
              beforeSend:(res)=>{},
              success   :(res)=>{
                vm.removefri = true;
              }
            });
        }
    },
    props: [
        'requser','container','id'
    ],
    template: `
    <div class="position-absolute " style="top:22px;left:100px;width:68%">
      <div v-if="changeBtn" class="row pt-3">
         <button  @click="acceptFriReq(requser.id)" style="font-weight: bold;" class="col-5 p-1 btn btn-primary"> Confirm </button>
           <div class="col-1"></div>
         <button @click="deleteFriReq(requser.id)" style="font-weight: bold;" class="col-5 p-1 btn btn-light"> Delete </button>
      </div>
       <div v-show="nowfri" class="row pt-2">
          <p class="text-muted mb-0 p-0">You are now friends</p>
       </div>
       <div v-show="removefri" class="row pt-2">
          <p class="text-muted mb-0 p-0">Request removed</p>
       </div>
    </div>`
  });


